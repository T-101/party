####
#
# Botparty-flooder
#
# Requires the frontend from https://github.com/T-101/party
#
# TCL-packages required besides Eggdrop: http and json
# Get them from tcllib
#
# Usage: from the partyline do: .chanset #channel +party
# for the channels where you want this to be active
#
# Also change the variable ajaxURL to whereever you have the frontend installed
#
# Use this as you please and at own risk, I am not accountable to any damage you do while using this
#
# Version history
#
# 1.0  - Initial release
# 1.01 - Added support to only show on channels where flag is set
#
# T-101 / Darklite ^ Primitive
#

namespace eval ::party {

set partyVersion "v1.01"
set ajaxURL "yourserver/yourdir"

setudef flag party

bind pub - !party ::party::announce

package require http
package require json

  # MAPPING
set mappingArray {
	&nbsp; \x20 &quot; \x22 &amp; \x26 &apos; \x27 &ndash; \x2D
	&lt; \x3C &gt; \x3E &tilde; \x7E &euro; \x80 &iexcl; \xA1
	&cent; \xA2 &pound; \xA3 &curren; \xA4 &yen; \xA5 &brvbar; \xA6
	&sect; \xA7 &uml; \xA8 &copy; \xA9 &ordf; \xAA &laquo; \xAB
	&not; \xAC &shy; \xAD &reg; \xAE &hibar; \xAF &deg; \xB0
	&plusmn; \xB1 &sup2; \xB2 &sup3; \xB3 &acute; \xB4 &micro; \xB5
	&para; \xB6 &middot; \xB7 &cedil; \xB8 &sup1; \xB9 &ordm; \xBA
	&raquo; \xBB &frac14; \xBC &frac12; \xBD &frac34; \xBE &iquest; \xBF
	&Agrave; \xC0 &Aacute; \xC1 &Acirc; \xC2 &Atilde; \xC3 &Auml; \xC4
	&Aring; \xC5 &AElig; \xC6 &Ccedil; \xC7 &Egrave; \xC8 &Eacute; \xC9
	&Ecirc; \xCA &Euml; \xCB &Igrave; \xCC &Iacute; \xCD &Icirc; \xCE
	&Iuml; \xCF &ETH; \xD0 &Ntilde; \xD1 &Ograve; \xD2 &Oacute; \xD3
	&Ocirc; \xD4 &Otilde; \xD5 &Ouml; \xD6 &times; \xD7 &Oslash; \xD8
	&Ugrave; \xD9 &Uacute; \xDA &Ucirc; \xDB &Uuml; \xDC &Yacute; \xDD
	&THORN; \xDE &szlig; \xDF &agrave; \xE0 &aacute; \xE1 &acirc; \xE2
	&atilde; \xE3 &auml; \xE4 &aring; \xE5 &aelig; \xE6 &ccedil; \xE7
	&egrave; \xE8 &eacute; \xE9 &ecirc; \xEA &euml; \xEB &igrave; \xEC
	&iacute; \xED &icirc; \xEE &iuml; \xEF &eth; \xF0 &ntilde; \xF1
	&ograve; \xF2 &oacute; \xF3 &ocirc; \xF4 &otilde; \xF5 &ouml; \xF6
	&divide; \xF7 &oslash; \xF8 &ugrave; \xF9 &uacute; \xFA &ucirc; \xFB
	&uuml; \xFC &yacute; \xFD &thorn; \xFE &yuml; \xFF
}

proc getParties {} {
	variable ajaxURL
	set query [::http::formatQuery action getParties]
	set userAgent "Chrome 45.0.2454.101"
	::http::config -useragent $userAgent
	set httpHandler [::http::geturl $ajaxURL/ajax.php -query $query]
	set text [::http::data $httpHandler]
	::http::cleanup $httpHandler

	set partyData [json::json2dict $text]
	lappend output "Add/remove parties at own will: $ajaxURL  u/p: username/password"
	foreach party $partyData {
		set partyName [dict get $party name]
		set partyStart [dict get $party startdate]
		set partyEnd [dict get $party enddate]
		set partyPlace [dict get $party place]
		if {$partyStart == $partyEnd} {
			set partyTime [clock format [clock scan $partyStart] -format {%d.%m.%Y}]
		} else {
			set partyTime "[clock format [clock scan $partyStart] -format {%d.%m.%Y}]-[clock format [clock scan $partyEnd] -format {%d.%m.%Y}]"
		}
		lappend output "$partyName, $partyTime @ $partyPlace"
	}
	return $output
}

proc announce { nick mask hand channel arguments} {
	if {[channel get $channel party] && [onchan $nick $channel]} {
		set partyData [getParties]
		foreach party $partyData {
			putquick "NOTICE $nick :$party"
		}
	}
}

putlog "NEW party $partyVersion by T-101 loaded!"
}
