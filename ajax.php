<?php
header('Content-type: application/json');
header("Cache-Control: no-cache");
header("Pragma: no-cache");

mb_internal_encoding("UTF-8");

$databaseFile = 'partydeebee.db';

function connectDB() {
	global $databaseFile;
	$dbconnection = new PDO('sqlite:'.$databaseFile);

	if ($dbconnection) {
		$stmt = $dbconnection->prepare("CREATE TABLE IF NOT EXISTS parties(
                id INTEGER PRIMARY KEY,
                name varchar(255),
                startdate text,
                enddate text,
                place text)");
		$result = $stmt->execute();
		return $dbconnection;
	} else { return false; }
}

function disconnectDB($dbconn) {
	$dbconn = null;
}

function getParties($dbConnection) {
	$stmt = $dbConnection->prepare('SELECT * FROM parties ORDER BY startdate ASC');
	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function deleteParty( $dbConnection, $partyId ) {
	$stmt = $dbConnection->prepare('DELETE FROM parties WHERE id = :query');
	$stmt->bindValue(":query", $partyId, PDO::PARAM_INT);
	$result = $stmt->execute();
	return $result;
}

function addParty( $dbConnection, $name, $start, $end, $where ) {
	$stmt = $dbConnection->prepare("INSERT INTO parties(name, startdate, enddate, place) VALUES (?, ?, ?, ?)"); 
	$stmt->bindValue(1, htmlspecialchars($name), SQLITE3_TEXT);
	$stmt->bindValue(2, htmlspecialchars($start), SQLITE3_TEXT);
	$stmt->bindValue(3, htmlspecialchars($end), SQLITE3_TEXT);
	$stmt->bindValue(4, htmlspecialchars($where), SQLITE3_TEXT);
	$result = $stmt->execute();
	return $result;
}

if (isset($_POST) && isset($_POST['action'])) {
	$dbConnection = connectDB();
	$action = $_POST['action'];
	if ($dbConnection) {
		switch ($action) {
			case 'getParties':
				$retarr = getParties($dbConnection);
				break;
			case 'deleteParty':
				$retarr = deleteParty($dbConnection, $_POST['party']);
				break;
			case 'addParty':
				$retarr = addParty($dbConnection, $_POST['partyname'], $_POST['partystart'], $_POST['partyend'], $_POST['partyplace']);
				break;
			default:
				$retarr['error'] = 'Unknown action';
				break;
		}
		disconnectDB($dbConnection);
	} else {
		$retarr = getErrorArray("Couldn't connect database");
	}
} else {
	$retarr['error'] = 'Unknown method';
}

	echo json_encode($retarr);
?>
