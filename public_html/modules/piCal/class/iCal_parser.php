<?php

// iCalendar parser class iCal_parser
// iCal_parser.php
// by GIJ=CHECKMATE (PEAK Corp. http://www.peak.ne.jp/)

// ORIGINAL: PHP iCalendar  (http://phpicalendar.sourceforge.net/)
// PROJECT ADMINS
// --------------
// Chad Little    <chad@chadsdomain.com>
// Jared Wangen   <jared@silter.org>
//
// DEVELOPERS
// ----------
// Patrick Berry  <pberry@mac.com>
// Bill Fenner    <fenner@research.att.com>
// David Reindl   <dre@andare.ch>
//
// CODE CONTRIBUTORS
// -----------------
// Greg Westin    <greg@gregwestin.com>
// Blaine Cook    <lattice@resist.ca>


// mb_internal_encodingのエミュレート (常にASCIIを返す)
if( ! function_exists( 'mb_internal_encoding' ) ) {
	function mb_internal_encoding() {
		return "ASCII" ;
	}
}


class iCal_parser
{
	var $week_start_day = 'Sunday' ;
	var $timezone = '+0900' ;
	var $events = array() ;
	var $language = 'japanese' ;

	// From timezones.php
	var $tz_array = array(
		'GMT' => array('+0000', '+0000'),
		'Africa/Addis_Ababa' => array('+0300', '+0300'),
		'Africa/Algiers' => array('+0100', '+0100'),
		'Africa/Asmera' => array('+0300', '+0300'),
		'Africa/Bangui' => array('+0100', '+0100'),
		'Africa/Blantyre' => array('+0200', '+0200'),
		'Africa/Brazzaville' => array('+0100', '+0100'),
		'Africa/Bujumbura' => array('+0200', '+0200'),
		'Africa/Cairo' => array('+0200', '+0300'),
		'Africa/Ceuta' => array('+0100', '+0200'),
		'Africa/Dar_es_Salaam' => array('+0300', '+0300'),
		'Africa/Djibouti' => array('+0300', '+0300'),
		'Africa/Douala' => array('+0100', '+0100'),
		'Africa/Gaborone' => array('+0200', '+0200'),
		'Africa/Harare' => array('+0200', '+0200'),
		'Africa/Johannesburg' => array('+0200', '+0200'),
		'Africa/Kampala' => array('+0300', '+0300'),
		'Africa/Khartoum' => array('+0300', '+0300'),
		'Africa/Kigali' => array('+0200', '+0200'),
		'Africa/Kinshasa' => array('+0100', '+0100'),
		'Africa/Lagos' => array('+0100', '+0100'),
		'Africa/Libreville' => array('+0100', '+0100'),
		'Africa/Luanda' => array('+0100', '+0100'),
		'Africa/Lubumbashi' => array('+0200', '+0200'),
		'Africa/Lusaka' => array('+0200', '+0200'),
		'Africa/Malabo' => array('+0100', '+0100'),
		'Africa/Maputo' => array('+0200', '+0200'),
		'Africa/Maseru' => array('+0200', '+0200'),
		'Africa/Mbabane' => array('+0200', '+0200'),
		'Africa/Mogadishu' => array('+0300', '+0300'),
		'Africa/Nairobi' => array('+0300', '+0300'),
		'Africa/Ndjamena' => array('+0100', '+0100'),
		'Africa/Niamey' => array('+0100', '+0100'),
		'Africa/Porto-Novo' => array('+0100', '+0100'),
		'Africa/Tripoli' => array('+0200', '+0200'),
		'Africa/Tunis' => array('+0100', '+0100'),
		'Africa/Windhoek' => array('+0200', '+0100'),
		'America/Adak' => array('-1000', '-0900'),
		'America/Anchorage' => array('-0900', '-0800'),
		'America/Anguilla' => array('-0400', '-0400'),
		'America/Antigua' => array('-0400', '-0400'),
		'America/Araguaina' => array('-0200', '-0300'),
		'America/Aruba' => array('-0400', '-0400'),
		'America/Asuncion' => array('-0300', '-0400'),
		'America/Atka' => array('-1000', '-0900'),
		'America/Barbados' => array('-0400', '-0400'),
		'America/Belem' => array('-0300', '-0300'),
		'America/Belize' => array('-0600', '-0600'),
		'America/Boa_Vista' => array('-0400', '-0400'),
		'America/Bogota' => array('-0500', '-0500'),
		'America/Boise' => array('-0700', '-0600'),
		'America/Buenos_Aires' => array('-0300', '-0300'),
		'America/Cambridge_Bay' => array('-0700', '-0600'),
		'America/Cancun' => array('-0600', '-0500'),
		'America/Caracas' => array('-0400', '-0400'),
		'America/Catamarca' => array('-0300', '-0300'),
		'America/Cayenne' => array('-0300', '-0300'),
		'America/Cayman' => array('-0500', '-0500'),
		'America/Chicago' => array('-0600', '-0500'),
		'America/Chihuahua' => array('-0700', '-0600'),
		'America/Cordoba' => array('-0300', '-0300'),
		'America/Costa_Rica' => array('-0600', '-0600'),
		'America/Cuiaba' => array('-0300', '-0400'),
		'America/Curacao' => array('-0400', '-0400'),
		'America/Dawson' => array('-0800', '-0700'),
		'America/Dawson_Creek' => array('-0700', '-0700'),
		'America/Denver' => array('-0700', '-0600'),
		'America/Detroit' => array('-0500', '-0400'),
		'America/Dominica' => array('-0400', '-0400'),
		'America/Edmonton' => array('-0700', '-0600'),
		'America/Eirunepe' => array('-0500', '-0500'),
		'America/El_Salvador' => array('-0600', '-0600'),
		'America/Ensenada' => array('-0800', '-0700'),
		'America/Fort_Wayne' => array('-0500', '-0500'),
		'America/Fortaleza' => array('-0300', '-0300'),
		'America/Glace_Bay' => array('-0400', '-0300'),
		'America/Godthab' => array('-0300', '-0200'),
		'America/Goose_Bay' => array('-0400', '-0300'),
		'America/Grand_Turk' => array('-0500', '-0400'),
		'America/Grenada' => array('-0400', '-0400'),
		'America/Guadeloupe' => array('-0400', '-0400'),
		'America/Guatemala' => array('-0600', '-0600'),
		'America/Guayaquil' => array('-0500', '-0500'),
		'America/Guyana' => array('-0400', '-0400'),
		'America/Halifax' => array('-0400', '-0300'),
		'America/Havana' => array('-0500', '-0400'),
		'America/Hermosillo' => array('-0700', '-0700'),
		'America/Indiana/Indianapolis' => array('-0500', '-0500'),
		'America/Indiana/Knox' => array('-0500', '-0500'),
		'America/Indiana/Marengo' => array('-0500', '-0500'),
		'America/Indiana/Vevay' => array('-0500', '-0500'),
		'America/Indianapolis' => array('-0500', '-0500'),
		'America/Inuvik' => array('-0700', '-0600'),
		'America/Iqaluit' => array('-0500', '-0400'),
		'America/Jamaica' => array('-0500', '-0500'),
		'America/Jujuy' => array('-0300', '-0300'),
		'America/Juneau' => array('-0900', '-0800'),
		'America/Kentucky/Louisville' => array('-0500', '-0400'),
		'America/Kentucky/Monticello' => array('-0500', '-0400'),
		'America/Knox_IN' => array('-0500', '-0500'),
		'America/La_Paz' => array('-0400', '-0400'),
		'America/Lima' => array('-0500', '-0500'),
		'America/Los_Angeles' => array('-0800', '-0700'),
		'America/Louisville' => array('-0500', '-0400'),
		'America/Maceio' => array('-0300', '-0300'),
		'America/Managua' => array('-0600', '-0600'),
		'America/Manaus' => array('-0400', '-0400'),
		'America/Martinique' => array('-0400', '-0400'),
		'America/Mazatlan' => array('-0700', '-0600'),
		'America/Mendoza' => array('-0300', '-0300'),
		'America/Menominee' => array('-0600', '-0500'),
		'America/Merida' => array('-0600', '-0500'),
		'America/Mexico_City' => array('-0600', '-0500'),
		'America/Miquelon' => array('-0300', '-0200'),
		'America/Monterrey' => array('-0600', '-0500'),
		'America/Montevideo' => array('-0300', '-0300'),
		'America/Montreal' => array('-0500', '-0400'),
		'America/Montserrat' => array('-0400', '-0400'),
		'America/Nassau' => array('-0500', '-0400'),
		'America/New_York' => array('-0500', '-0400'),
		'America/Nipigon' => array('-0500', '-0400'),
		'America/Nome' => array('-0900', '-0800'),
		'America/Noronha' => array('-0200', '-0200'),
		'America/Panama' => array('-0500', '-0500'),
		'America/Pangnirtung' => array('-0500', '-0400'),
		'America/Paramaribo' => array('-0300', '-0300'),
		'America/Phoenix' => array('-0700', '-0700'),
		'America/Port-au-Prince' => array('-0500', '-0500'),
		'America/Port_of_Spain' => array('-0400', '-0400'),
		'America/Porto_Acre' => array('-0500', '-0500'),
		'America/Porto_Velho' => array('-0400', '-0400'),
		'America/Puerto_Rico' => array('-0400', '-0400'),
		'America/Rainy_River' => array('-0600', '-0500'),
		'America/Rankin_Inlet' => array('-0600', '-0500'),
		'America/Recife' => array('-0300', '-0300'),
		'America/Regina' => array('-0600', '-0600'),
		'America/Rio_Branco' => array('-0500', '-0500'),
		'America/Rosario' => array('-0300', '-0300'),
		'America/Santiago' => array('-0300', '-0400'),
		'America/Santo_Domingo' => array('-0400', '-0400'),
		'America/Sao_Paulo' => array('-0200', '-0300'),
		'America/Scoresbysund' => array('-0100', '+0000'),
		'America/Shiprock' => array('-0700', '-0600'),
		'America/St_Johns' => array('-031800', '-021800'),
		'America/St_Kitts' => array('-0400', '-0400'),
		'America/St_Lucia' => array('-0400', '-0400'),
		'America/St_Thomas' => array('-0400', '-0400'),
		'America/St_Vincent' => array('-0400', '-0400'),
		'America/Swift_Current' => array('-0600', '-0600'),
		'America/Tegucigalpa' => array('-0600', '-0600'),
		'America/Thule' => array('-0400', '-0300'),
		'America/Thunder_Bay' => array('-0500', '-0400'),
		'America/Tijuana' => array('-0800', '-0700'),
		'America/Tortola' => array('-0400', '-0400'),
		'America/Vancouver' => array('-0800', '-0700'),
		'America/Virgin' => array('-0400', '-0400'),
		'America/Whitehorse' => array('-0800', '-0700'),
		'America/Winnipeg' => array('-0600', '-0500'),
		'America/Yakutat' => array('-0900', '-0800'),
		'America/Yellowknife' => array('-0700', '-0600'),
		'Antarctica/Casey' => array('+0800', '+0800'),
		'Antarctica/Davis' => array('+0700', '+0700'),
		'Antarctica/DumontDUrville' => array('+1000', '+1000'),
		'Antarctica/Mawson' => array('+0600', '+0600'),
		'Antarctica/McMurdo' => array('+1300', '+1200'),
		'Antarctica/Palmer' => array('-0300', '-0400'),
		'Antarctica/South_Pole' => array('+1300', '+1200'),
		'Antarctica/Syowa' => array('+0300', '+0300'),
		'Antarctica/Vostok' => array('+0600', '+0600'),
		'Arctic/Longyearbyen' => array('+0100', '+0200'),
		'Asia/Aden' => array('+0300', '+0300'),
		'Asia/Almaty' => array('+0600', '+0700'),
		'Asia/Amman' => array('+0200', '+0300'),
		'Asia/Anadyr' => array('+1200', '+1300'),
		'Asia/Aqtau' => array('+0400', '+0500'),
		'Asia/Aqtobe' => array('+0500', '+0600'),
		'Asia/Ashgabat' => array('+0500', '+0500'),
		'Asia/Ashkhabad' => array('+0500', '+0500'),
		'Asia/Baghdad' => array('+0300', '+0400'),
		'Asia/Bahrain' => array('+0300', '+0300'),
		'Asia/Baku' => array('+0400', '+0500'),
		'Asia/Bangkok' => array('+0700', '+0700'),
		'Asia/Beirut' => array('+0200', '+0300'),
		'Asia/Bishkek' => array('+0500', '+0600'),
		'Asia/Brunei' => array('+0800', '+0800'),
		'Asia/Calcutta' => array('+051800', '+051800'),
		'Asia/Chungking' => array('+0800', '+0800'),
		'Asia/Colombo' => array('+0600', '+0600'),
		'Asia/Dacca' => array('+0600', '+0600'),
		'Asia/Damascus' => array('+0200', '+0300'),
		'Asia/Dhaka' => array('+0600', '+0600'),
		'Asia/Dili' => array('+0900', '+0900'),
		'Asia/Dubai' => array('+0400', '+0400'),
		'Asia/Dushanbe' => array('+0500', '+0500'),
		'Asia/Gaza' => array('+0200', '+0300'),
		'Asia/Harbin' => array('+0800', '+0800'),
		'Asia/Hong_Kong' => array('+0800', '+0800'),
		'Asia/Hovd' => array('+0700', '+0700'),
		'Asia/Irkutsk' => array('+0800', '+0900'),
		'Asia/Istanbul' => array('+0200', '+0300'),
		'Asia/Jakarta' => array('+0700', '+0700'),
		'Asia/Jayapura' => array('+0900', '+0900'),
		'Asia/Jerusalem' => array('+0200', '+0300'),
		'Asia/Kabul' => array('+041800', '+041800'),
		'Asia/Kamchatka' => array('+1200', '+1300'),
		'Asia/Karachi' => array('+0500', '+0500'),
		'Asia/Kashgar' => array('+0800', '+0800'),
		'Asia/Katmandu' => array('+052700', '+052700'),
		'Asia/Krasnoyarsk' => array('+0700', '+0800'),
		'Asia/Kuala_Lumpur' => array('+0800', '+0800'),
		'Asia/Kuching' => array('+0800', '+0800'),
		'Asia/Kuwait' => array('+0300', '+0300'),
		'Asia/Macao' => array('+0800', '+0800'),
		'Asia/Magadan' => array('+1100', '+1200'),
		'Asia/Manila' => array('+0800', '+0800'),
		'Asia/Muscat' => array('+0400', '+0400'),
		'Asia/Nicosia' => array('+0200', '+0300'),
		'Asia/Novosibirsk' => array('+0600', '+0700'),
		'Asia/Omsk' => array('+0600', '+0700'),
		'Asia/Phnom_Penh' => array('+0700', '+0700'),
		'Asia/Pyongyang' => array('+0900', '+0900'),
		'Asia/Qatar' => array('+0300', '+0300'),
		'Asia/Rangoon' => array('+061800', '+061800'),
		'Asia/Riyadh' => array('+0300', '+0300'),
		'Asia/Riyadh87' => array('+03424', '+03424'),
		'Asia/Riyadh88' => array('+03424', '+03424'),
		'Asia/Riyadh89' => array('+03424', '+03424'),
		'Asia/Saigon' => array('+0700', '+0700'),
		'Asia/Samarkand' => array('+0500', '+0500'),
		'Asia/Seoul' => array('+0900', '+0900'),
		'Asia/Shanghai' => array('+0800', '+0800'),
		'Asia/Singapore' => array('+0800', '+0800'),
		'Asia/Taipei' => array('+0800', '+0800'),
		'Asia/Tashkent' => array('+0500', '+0500'),
		'Asia/Tbilisi' => array('+0400', '+0500'),
		'Asia/Tehran' => array('+031800', '+041800'),
		'Asia/Tel_Aviv' => array('+0200', '+0300'),
		'Asia/Thimbu' => array('+0600', '+0600'),
		'Asia/Thimphu' => array('+0600', '+0600'),
		'Asia/Tokyo' => array('+0900', '+0900'),
		'Asia/Ujung_Pandang' => array('+0800', '+0800'),
		'Asia/Ulaanbaatar' => array('+0800', '+0800'),
		'Asia/Ulan_Bator' => array('+0800', '+0800'),
		'Asia/Urumqi' => array('+0800', '+0800'),
		'Asia/Vientiane' => array('+0700', '+0700'),
		'Asia/Vladivostok' => array('+1000', '+1100'),
		'Asia/Yakutsk' => array('+0900', '+1000'),
		'Asia/Yekaterinburg' => array('+0500', '+0600'),
		'Asia/Yerevan' => array('+0400', '+0500'),
		'Atlantic/Azores' => array('-0100', '+0000'),
		'Atlantic/Bermuda' => array('-0400', '-0300'),
		'Atlantic/Canary' => array('+0000', '+0100'),
		'Atlantic/Cape_Verde' => array('-0100', '-0100'),
		'Atlantic/Faeroe' => array('+0000', '+0100'),
		'Atlantic/Jan_Mayen' => array('-0100', '-0100'),
		'Atlantic/Madeira' => array('+0000', '+0100'),
		'Atlantic/South_Georgia' => array('-0200', '-0200'),
		'Atlantic/Stanley' => array('-0300', '-0400'),
		'Australia/ACT' => array('+1100', '+1000'),
		'Australia/Adelaide' => array('+101800', '+091800'),
		'Australia/Brisbane' => array('+1000', '+1000'),
		'Australia/Broken_Hill' => array('+101800', '+091800'),
		'Australia/Canberra' => array('+1100', '+1000'),
		'Australia/Darwin' => array('+091800', '+091800'),
		'Australia/Hobart' => array('+1100', '+1000'),
		'Australia/LHI' => array('+1100', '+101800'),
		'Australia/Lindeman' => array('+1000', '+1000'),
		'Australia/Lord_Howe' => array('+1100', '+101800'),
		'Australia/Melbourne' => array('+1100', '+1000'),
		'Australia/NSW' => array('+1100', '+1000'),
		'Australia/North' => array('+091800', '+091800'),
		'Australia/Perth' => array('+0800', '+0800'),
		'Australia/Queensland' => array('+1000', '+1000'),
		'Australia/South' => array('+101800', '+091800'),
		'Australia/Sydney' => array('+1100', '+1000'),
		'Australia/Tasmania' => array('+1100', '+1000'),
		'Australia/Victoria' => array('+1100', '+1000'),
		'Australia/West' => array('+0800', '+0800'),
		'Australia/Yancowinna' => array('+101800', '+091800'),
		'Brazil/Acre' => array('-0500', '-0500'),
		'Brazil/DeNoronha' => array('-0200', '-0200'),
		'Brazil/East' => array('-0200', '-0300'),
		'Brazil/West' => array('-0400', '-0400'),
		'CET' => array('+0100', '+0200'),
		'CST6CDT' => array('-0600', '-0500'),
		'Canada/Atlantic' => array('-0400', '-0300'),
		'Canada/Central' => array('-0600', '-0500'),
		'Canada/East-Saskatchewan' => array('-0600', '-0600'),
		'Canada/Eastern' => array('-0500', '-0400'),
		'Canada/Mountain' => array('-0700', '-0600'),
		'Canada/Newfoundland' => array('-031800', '-021800'),
		'Canada/Pacific' => array('-0800', '-0700'),
		'Canada/Saskatchewan' => array('-0600', '-0600'),
		'Canada/Yukon' => array('-0800', '-0700'),
		'Chile/Continental' => array('-0300', '-0400'),
		'Chile/EasterIsland' => array('-0500', '-0600'),
		'Cuba' => array('-0500', '-0400'),
		'EET' => array('+0200', '+0300'),
		'EST' => array('-0500', '-0500'),
		'EST5EDT' => array('-0500', '-0400'),
		'Egypt' => array('+0200', '+0300'),
		'Eire' => array('+0000', '+0100'),
		'Etc/GMT+1' => array('-0100', '-0100'),
		'Etc/GMT+10' => array('-1000', '-1000'),
		'Etc/GMT+11' => array('-1100', '-1100'),
		'Etc/GMT+12' => array('-1200', '-1200'),
		'Etc/GMT+2' => array('-0200', '-0200'),
		'Etc/GMT+3' => array('-0300', '-0300'),
		'Etc/GMT+4' => array('-0400', '-0400'),
		'Etc/GMT+5' => array('-0500', '-0500'),
		'Etc/GMT+6' => array('-0600', '-0600'),
		'Etc/GMT+7' => array('-0700', '-0700'),
		'Etc/GMT+8' => array('-0800', '-0800'),
		'Etc/GMT+9' => array('-0900', '-0900'),
		'Etc/GMT-1' => array('+0100', '+0100'),
		'Etc/GMT-10' => array('+1000', '+1000'),
		'Etc/GMT-11' => array('+1100', '+1100'),
		'Etc/GMT-12' => array('+1200', '+1200'),
		'Etc/GMT-13' => array('+1300', '+1300'),
		'Etc/GMT-14' => array('+1400', '+1400'),
		'Etc/GMT-2' => array('+0200', '+0200'),
		'Etc/GMT-3' => array('+0300', '+0300'),
		'Etc/GMT-4' => array('+0400', '+0400'),
		'Etc/GMT-5' => array('+0500', '+0500'),
		'Etc/GMT-6' => array('+0600', '+0600'),
		'Etc/GMT-7' => array('+0700', '+0700'),
		'Etc/GMT-8' => array('+0800', '+0800'),
		'Etc/GMT-9' => array('+0900', '+0900'),
		'Europe/Amsterdam' => array('+0100', '+0200'),
		'Europe/Andorra' => array('+0100', '+0200'),
		'Europe/Athens' => array('+0200', '+0300'),
		'Europe/Belfast' => array('+0000', '+0100'),
		'Europe/Belgrade' => array('+0100', '+0200'),
		'Europe/Berlin' => array('+0100', '+0200'),
		'Europe/Bratislava' => array('+0100', '+0200'),
		'Europe/Brussels' => array('+0100', '+0200'),
		'Europe/Bucharest' => array('+0200', '+0300'),
		'Europe/Budapest' => array('+0100', '+0200'),
		'Europe/Chisinau' => array('+0200', '+0300'),
		'Europe/Copenhagen' => array('+0100', '+0200'),
		'Europe/Dublin' => array('+0000', '+0100'),
		'Europe/Gibraltar' => array('+0100', '+0200'),
		'Europe/Helsinki' => array('+0200', '+0300'),
		'Europe/Istanbul' => array('+0200', '+0300'),
		'Europe/Kaliningrad' => array('+0200', '+0300'),
		'Europe/Kiev' => array('+0200', '+0300'),
		'Europe/Lisbon' => array('+0000', '+0100'),
		'Europe/Ljubljana' => array('+0100', '+0200'),
		'Europe/London' => array('+0000', '+0100'),
		'Europe/Luxembourg' => array('+0100', '+0200'),
		'Europe/Madrid' => array('+0100', '+0200'),
		'Europe/Malta' => array('+0100', '+0200'),
		'Europe/Minsk' => array('+0200', '+0300'),
		'Europe/Monaco' => array('+0100', '+0200'),
		'Europe/Moscow' => array('+0300', '+0400'),
		'Europe/Nicosia' => array('+0200', '+0300'),
		'Europe/Oslo' => array('+0100', '+0200'),
		'Europe/Paris' => array('+0100', '+0200'),
		'Europe/Prague' => array('+0100', '+0200'),
		'Europe/Riga' => array('+0200', '+0300'),
		'Europe/Rome' => array('+0100', '+0200'),
		'Europe/Samara' => array('+0400', '+0500'),
		'Europe/San_Marino' => array('+0100', '+0200'),
		'Europe/Sarajevo' => array('+0100', '+0200'),
		'Europe/Simferopol' => array('+0200', '+0300'),
		'Europe/Skopje' => array('+0100', '+0200'),
		'Europe/Sofia' => array('+0200', '+0300'),
		'Europe/Stockholm' => array('+0100', '+0200'),
		'Europe/Tallinn' => array('+0200', '+0200'),
		'Europe/Tirane' => array('+0100', '+0200'),
		'Europe/Tiraspol' => array('+0200', '+0300'),
		'Europe/Uzhgorod' => array('+0200', '+0300'),
		'Europe/Vaduz' => array('+0100', '+0200'),
		'Europe/Vatican' => array('+0100', '+0200'),
		'Europe/Vienna' => array('+0100', '+0200'),
		'Europe/Vilnius' => array('+0200', '+0200'),
		'Europe/Warsaw' => array('+0100', '+0200'),
		'Europe/Zagreb' => array('+0100', '+0200'),
		'Europe/Zaporozhye' => array('+0200', '+0300'),
		'Europe/Zurich' => array('+0100', '+0200'),
		'GB' => array('+0000', '+0100'),
		'GB-Eire' => array('+0000', '+0100'),
		'HST' => array('-1000', '-1000'),
		'Hongkong' => array('+0800', '+0800'),
		'Indian/Antananarivo' => array('+0300', '+0300'),
		'Indian/Chagos' => array('+0500', '+0500'),
		'Indian/Christmas' => array('+0700', '+0700'),
		'Indian/Cocos' => array('+061800', '+061800'),
		'Indian/Comoro' => array('+0300', '+0300'),
		'Indian/Kerguelen' => array('+0500', '+0500'),
		'Indian/Mahe' => array('+0400', '+0400'),
		'Indian/Maldives' => array('+0500', '+0500'),
		'Indian/Mauritius' => array('+0400', '+0400'),
		'Indian/Mayotte' => array('+0300', '+0300'),
		'Indian/Reunion' => array('+0400', '+0400'),
		'Iran' => array('+031800', '+041800'),
		'Israel' => array('+0200', '+0300'),
		'Jamaica' => array('-0500', '-0500'),
		'Japan' => array('+0900', '+0900'),
		'Kwajalein' => array('+1200', '+1200'),
		'Libya' => array('+0200', '+0200'),
		'MET' => array('+0100', '+0200'),
		'MST' => array('-0700', '-0700'),
		'MST7MDT' => array('-0700', '-0600'),
		'Mexico/BajaNorte' => array('-0800', '-0700'),
		'Mexico/BajaSur' => array('-0700', '-0600'),
		'Mexico/General' => array('-0600', '-0500'),
		'Mideast/Riyadh87' => array('+03424', '+03424'),
		'Mideast/Riyadh88' => array('+03424', '+03424'),
		'Mideast/Riyadh89' => array('+03424', '+03424'),
		'NZ' => array('+1300', '+1200'),
		'NZ-CHAT' => array('+132700', '+122700'),
		'Navajo' => array('-0700', '-0600'),
		'PRC' => array('+0800', '+0800'),
		'PST8PDT' => array('-0800', '-0700'),
		'Pacific/Apia' => array('-1100', '-1100'),
		'Pacific/Auckland' => array('+1300', '+1200'),
		'Pacific/Chatham' => array('+132700', '+122700'),
		'Pacific/Easter' => array('-0500', '-0600'),
		'Pacific/Efate' => array('+1100', '+1100'),
		'Pacific/Enderbury' => array('+1300', '+1300'),
		'Pacific/Fakaofo' => array('-1000', '-1000'),
		'Pacific/Fiji' => array('+1200', '+1200'),
		'Pacific/Funafuti' => array('+1200', '+1200'),
		'Pacific/Galapagos' => array('-0600', '-0600'),
		'Pacific/Gambier' => array('-0900', '-0900'),
		'Pacific/Guadalcanal' => array('+1100', '+1100'),
		'Pacific/Guam' => array('+1000', '+1000'),
		'Pacific/Honolulu' => array('-1000', '-1000'),
		'Pacific/Johnston' => array('-1000', '-1000'),
		'Pacific/Kiritimati' => array('+1400', '+1400'),
		'Pacific/Kosrae' => array('+1100', '+1100'),
		'Pacific/Kwajalein' => array('+1200', '+1200'),
		'Pacific/Majuro' => array('+1200', '+1200'),
		'Pacific/Marquesas' => array('-091800', '-091800'),
		'Pacific/Midway' => array('-1100', '-1100'),
		'Pacific/Nauru' => array('+1200', '+1200'),
		'Pacific/Niue' => array('-1100', '-1100'),
		'Pacific/Norfolk' => array('+111800', '+111800'),
		'Pacific/Noumea' => array('+1100', '+1100'),
		'Pacific/Pago_Pago' => array('-1100', '-1100'),
		'Pacific/Palau' => array('+0900', '+0900'),
		'Pacific/Pitcairn' => array('-0800', '-0800'),
		'Pacific/Ponape' => array('+1100', '+1100'),
		'Pacific/Port_Moresby' => array('+1000', '+1000'),
		'Pacific/Rarotonga' => array('-1000', '-1000'),
		'Pacific/Saipan' => array('+1000', '+1000'),
		'Pacific/Samoa' => array('-1100', '-1100'),
		'Pacific/Tahiti' => array('-1000', '-1000'),
		'Pacific/Tarawa' => array('+1200', '+1200'),
		'Pacific/Tongatapu' => array('+1300', '+1300'),
		'Pacific/Truk' => array('+1000', '+1000'),
		'Pacific/Wake' => array('+1200', '+1200'),
		'Pacific/Wallis' => array('+1200', '+1200'),
		'Pacific/Yap' => array('+1000', '+1000'),
		'Poland' => array('+0100', '+0200'),
		'Portugal' => array('+0000', '+0100'),
		'ROC' => array('+0800', '+0800'),
		'ROK' => array('+0900', '+0900'),
		'Singapore' => array('+0800', '+0800'),
		'SystemV/AST4' => array('-0400', '-0400'),
		'SystemV/AST4ADT' => array('-0400', '-0300'),
		'SystemV/CST6' => array('-0600', '-0600'),
		'SystemV/CST6CDT' => array('-0600', '-0500'),
		'SystemV/EST5' => array('-0500', '-0500'),
		'SystemV/EST5EDT' => array('-0500', '-0400'),
		'SystemV/HST10' => array('-1000', '-1000'),
		'SystemV/MST7' => array('-0700', '-0700'),
		'SystemV/MST7MDT' => array('-0700', '-0600'),
		'SystemV/PST8' => array('-0800', '-0800'),
		'SystemV/PST8PDT' => array('-0800', '-0700'),
		'SystemV/YST9' => array('-0900', '-0900'),
		'SystemV/YST9YDT' => array('-0900', '-0800'),
		'Turkey' => array('+0200', '+0300'),
		'US/Alaska' => array('-0900', '-0800'),
		'US/Aleutian' => array('-1000', '-0900'),
		'US/Arizona' => array('-0700', '-0700'),
		'US/Central' => array('-0600', '-0500'),
		'US/East-Indiana' => array('-0500', '-0500'),
		'US/Eastern' => array('-0500', '-0400'),
		'US/Hawaii' => array('-1000', '-1000'),
		'US/Indiana-Starke' => array('-0500', '-0500'),
		'US/Michigan' => array('-0500', '-0400'),
		'US/Mountain' => array('-0700', '-0600'),
		'US/Pacific' => array('-0800', '-0700'),
		'US/Samoa' => array('-1100', '-1100'),
		'W-SU' => array('+0300', '+0400'),
		'WET' => array('+0000', '+0100')
	) ;

// From date_functions.php

// takes iCalendar 2 day format and makes it into 3 characters
// if $txt is true, it returns the 3 letters, otherwise it returns the
// integer of that day; 0=Sun, 1=Mon, etc.
function two2threeCharDays($day, $txt=true) {
	switch($day) {
		case 'SU': return ($txt ? 'sun' : '0');
		case 'MO': return ($txt ? 'mon' : '1');
		case 'TU': return ($txt ? 'tue' : '2');
		case 'WE': return ($txt ? 'wed' : '3');
		case 'TH': return ($txt ? 'thu' : '4');
		case 'FR': return ($txt ? 'fri' : '5');
		case 'SA': return ($txt ? 'sat' : '6');
	}
}

// dateOfWeek() takes a date in Ymd and a day of week in 3 letters or more
// and returns the date of that day. (ie: "sun" or "sunday" would be acceptable values of $day but not "su")
function dateOfWeek($Ymd, $day) {
	if (!isset($this->week_start_day)) $this->week_start_day = 'Sunday';
	$timestamp = strtotime($Ymd);
	$num = date('w', strtotime($this->week_start_day));
	$start_day_time = strtotime((date('w',$timestamp)==$num ? "$this->week_start_day" : "last $this->week_start_day"), $timestamp);
	$ret_unixtime = strtotime($day,$start_day_time);
	$ret_unixtime = strtotime('+12 hours', $ret_unixtime);
	$ret = date('Ymd',$ret_unixtime);
	return $ret;
}

// function to compare to dates in Ymd and return the number of weeks
// that differ between them. requires dateOfWeek()
function weekCompare($now, $then) {
	$sun_now = $this->dateOfWeek($now, $this->week_start_day);
	$sun_then = $this->dateOfWeek($then, $this->week_start_day);
	$seconds_now = strtotime($sun_now);
	$seconds_then =  strtotime($sun_then);
	$diff_seconds = $seconds_now - $seconds_then;
	$diff_minutes = $diff_seconds/60;
	$diff_hours = $diff_minutes/60;
	$diff_days = round($diff_hours/24);
	$diff_weeks = $diff_days/7;

	return $diff_weeks;
}

// function to compare to dates in Ymd and return the number of days
// that differ between them.
function dayCompare($now, $then) {
	$seconds_now = strtotime($now);
	$seconds_then =  strtotime($then);
	$diff_seconds = $seconds_now - $seconds_then;
	$diff_minutes = $diff_seconds/60;
	$diff_hours = $diff_minutes/60;
	$diff_days = round($diff_hours/24);

	return $diff_days;
}

// function to compare to dates in Ymd and return the number of months
// that differ between them.
function monthCompare($now, $then) {
//HACK by domifara for php5.3+
//	ereg ("([0-9]{4})([0-9]{2})([0-9]{2})", $now, $date_now);
//	ereg ("([0-9]{4})([0-9]{2})([0-9]{2})", $then, $date_then);
	preg_match ("/([0-9]{4})([0-9]{2})([0-9]{2})/", $now, $date_now);
	preg_match ("/([0-9]{4})([0-9]{2})([0-9]{2})/", $then, $date_then);
	$diff_years = $date_now[1] - $date_then[1];
	$diff_months = $date_now[2] - $date_then[2];
	if ($date_now[2] < $date_then[2]) {
		$diff_years -= 1;
		$diff_months = ($diff_months + 12) % 12;
	}
	$diff_months = ($diff_years * 12) + $diff_months;

	return $diff_months;
}

function yearCompare($now, $then) {
//HACK by domifara for php5.3+
//	ereg ("([0-9]{4})([0-9]{2})([0-9]{2})", $now, $date_now);
//	ereg ("([0-9]{4})([0-9]{2})([0-9]{2})", $then, $date_then);
	preg_match ("/([0-9]{4})([0-9]{2})([0-9]{2})/", $now, $date_now);
	preg_match ("/([0-9]{4})([0-9]{2})([0-9]{2})/", $then, $date_then);
	$diff_years = $date_now[1] - $date_then[1];
	return $diff_years;
}

// localizeDate() - similar to strftime but uses our preset arrays of localized
// months and week days and only supports %A, %a, %B, %b, %e, and %Y
// more can be added as needed but trying to keep it small while we can
/*function localizeDate($format, $timestamp) {
	global $daysofweek_lang, $daysofweekshort_lang, $daysofweekreallyshort_lang, $monthsofyear_lang, $monthsofyear_lang, $monthsofyearshort_lang;
	$year = date("Y", $timestamp);
	$month = date("n", $timestamp)-1;
	$day = date("j", $timestamp);
	$dayofweek = date("w", $timestamp);

	$date = str_replace('%Y', $year, $format);
	$date = str_replace('%e', $day, $date);
	$date = str_replace('%B', $monthsofyear_lang[$month], $date);
	$date = str_replace('%b', $monthsofyearshort_lang[$month], $date);
	$date = str_replace('%A', $daysofweek_lang[$dayofweek], $date);
	$date = str_replace('%a', $daysofweekshort_lang[$dayofweek], $date);

	return $date;

}*/
// calcOffset takes an offset (ie, -0500) and returns it in the number of seconds
function calcOffset($offset_str) {
	$sign = substr($offset_str, 0, 1);
	$hours = substr($offset_str, 1, 2);
	$mins = substr($offset_str, 3, 2);
	$secs = ((int)$hours * 3600) + ((int)$mins * 60);
	if ($sign == '-') $secs = 0 - $secs;
	return $secs;
}

// calcTime calculates the unixtime of a new offset by comparing it to the current offset
// $have is the current offset (ie, '-0500')
// $want is the wanted offset (ie, '-0700')
// $time is the unixtime relative to $have
function calcTime($have, $want, $time) {
	if ($have == 'none' || $want == 'none') return $time;
	$have_secs = $this->calcOffset($have);
	$want_secs = $this->calcOffset($want);
	$diff = $want_secs - $have_secs;
	$time += $diff;
	return $time;
}

function chooseOffset($time) {

	return $this->timezone ;
/* サマータイムの処理をやっているのだろうけど、とりあえずコメントアウト
	if (!isset($this->timezone)) $this->timezone = '';
	switch ($this->timezone) {
		case '':
			$offset = 'none';
			break;
		case 'Same as Server':
			$offset = date('O', $time);
			break;
		default:
			if (is_array($this->tz_array) && array_key_exists($this->timezone, $this->tz_array)) {
				$dlst = date('I', $time);
				$offset = $this->tz_array[$this->timezone][$dlst];
			} else {
				$offset = '+0000';
			}
	}
	return $offset;
*/
}





// コンストラクタ
public function __construct()
{
}


// ファイルをパースして、内部変数に取り込む
function parse( $filename , $calendar_name )
{
	$ifile = @fopen($filename, "r");
	if ($ifile == FALSE) return "-1: File cannot open. filename: $filename" ;
	$nextline = fgets($ifile, 1024);
	if (trim($nextline) != 'BEGIN:VCALENDAR') return "-2: This file is not iCalendar(RFC2445). filename: $filename" ;

	// Set a value so we can check to make sure $master_array contains valid data
	// $master_array['-1'] = 'valid cal file';

	// Set default calendar name - can be overridden by X-WR-CALNAME
	// $calendar_name = $filename;
	// $master_array['calendar_name'] = $filename;

	// auxiliary array for determining overlaps of events
//	$overlap_array = array ();

	// using $uid to set specific points in array, if $uid is not in the
	// .ics file, we need to have some unique place in the array
	$uid_counter = 0;

// read file in line by line
// XXX end line is skipped because of the 1-line readahead
	while (!feof($ifile)) {
		$line = $nextline;
		$nextline = fgets($ifile, 1024);
//HACK  by domifara for php5.3+
//		$nextline = ereg_replace("[\r\n]", "", $nextline);
		$nextline = preg_replace("/[\r\n]/", "", $nextline);
		while (substr($nextline, 0, 1) == " ") {
			$line = $line . substr($nextline, 1);
			$nextline = fgets($ifile, 1024);
//HACK  by domifara for php5.3+
//			$nextline = ereg_replace("[\r\n]", "", $nextline);
			$nextline = preg_replace("/[\r\n]/", "", $nextline);
		}
		$line = trim($line);
		if ($line == 'BEGIN:VEVENT') {
			// each of these vars were being set to an empty string
			unset (
				$start_time, $end_time, $start_date, $end_date, $summary,
				$allday_start, $allday_end, $start, $end, $the_duration,
				$beginning, $rrule, $start_of_vevent, $description,
				$status, $class, $categories, $contact,
				$location, $dtstamp, $sequence,
				$tz_dtstart, $tz_dtend, $event_tz,
				$valarm_description, $start_unixtime, $end_unixtime,
				$recurrence_id, $uid, $uid_valid
			);

			$except_dates = array();
			$except_times = array();
			$first_duration = TRUE;
			$count = 1000000;
			$valarm_set = FALSE;

		} elseif ($line == 'END:VEVENT') {
			// make sure we have some value for $uid
			if (!isset($uid)) {
				$uid = $uid_counter;
				$uid_counter++;
				$uid_valid = false;
			} else {
				$uid_valid = true;
			}

			if (empty($summary)) $summary = '';
			if (empty($description)) $description = '';
			if (empty($location)) $location = '';
			if (empty($contact)) $contact = '';
			if (empty($sequence)) $sequence = 0;
			if (empty($rrule)) $rrule = '';

			// Handling of the all day events（全日イベント）
			if ((isset($allday_start) && $allday_start != '')) {
				$start_unixtime = strtotime($allday_start);
				if (isset($allday_end) && $allday_end != '' ) {
					$end_unixtime = strtotime($allday_end);
					if( $start_unixtime == $end_unixtime ) $end_unixtime = $start_unixtime + 86400 ;
				} else {
					// allday_end の指定がなければ一日のみと見なす
					$end_unixtime = $start_unixtime + 86400 ;
				}
			}

			$this->events[$uid] = compact( 'start_unixtime' , 'end_unixtime' , 'summary' , 'description' , 'status' , 'class' , 'categories' , 'contact' , 'location' , 'dtstamp' , 'sequence' , 'allday_start' , 'allday_end' , 'tz_dtstart' , 'tz_dtend' , 'event_tz' , 'rrule' , 'uid_valid' ) ;	// GIJ added 03/05/27

		// Begin VTODO Support
/*		} elseif ($line == 'END:VTODO') {
			if ((!$vtodo_priority) && ($status == 'COMPLETED')) {
				$vtodo_sort = 11;
			} elseif (!$vtodo_priority) {
				$vtodo_sort = 10;
			} else {
				$vtodo_sort = $vtodo_priority;
			}
			$master_array['-2']["$vtodo_sort"]["$uid"] = array ('start_date' => $start_date, 'start_time' => $start_time, 'vtodo_text' => $summary, 'due_date'=> $due_date, 'due_time'=> $due_time, 'completed_date' => $completed_date, 'completed_time' => $completed_time, 'priority' => $vtodo_priority, 'status' => $status, 'class' => $class, 'categories' => $vtodo_categories);
			unset ($due_date, $due_time, $completed_date, $completed_time, $vtodo_priority, $status, $class, $vtodo_categories, $summary);
			$vtodo_set = FALSE;
		} elseif ($line == 'BEGIN:VTODO') {
			$vtodo_set = TRUE;
		} elseif ($line == 'BEGIN:VALARM') {
			$valarm_set = TRUE;
		} elseif ($line == 'END:VALARM') {
			$valarm_set = FALSE;
*/		} else {

			unset ($field, $data, $prop_pos, $property);
//HACK by domifara for php5.3+
//			ereg ("([^:]+):(.*)", $line, $line);
			preg_match ("/([^:]+):(.*)/", $line, $line);
			$field = $line[1];
			$data = $line[2];

			$property = $field;
			$prop_pos = strpos($property,';');
			if ($prop_pos !== false) $property = substr($property,0,$prop_pos);
			$property = strtoupper($property);

			switch ($property) {

				// Start VTODO Parsing
				//
/*				case 'DUE':
					$zulu_time = false;
					if (substr($data,-1) == 'Z') $zulu_time = true;
					$data = ereg_replace('T', '', $data);
					$data = ereg_replace('Z', '', $data);
					if (preg_match("/^DUE;VALUE=DATE/i", $field))  {
						$allday_start = $data;
						$start_date = $allday_start;
					} else {
						if (preg_match("/^DUE;TZID=/i", $field)) {
							$tz_tmp = explode('=', $field);
							$tz_due = $tz_tmp[1];
							unset($tz_tmp);
						} elseif ($zulu_time) {
							$tz_due = 'GMT';
						}

						ereg ('([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{0,2})([0-9]{0,2})', $data, $regs);
						$start_date = $regs[1] . $regs[2] . $regs[3];
						$start_time = $regs[4] . $regs[5];
						$start_unixtime = mktime($regs[4], $regs[5], 0, $regs[2], $regs[3], $regs[1]);

						$dlst = date('I', $start_unixtime);
						$server_offset_tmp = $this->chooseOffset($start_unixtime);
						if (isset($tz_due)) {
							if (array_key_exists($tz_due, $this->tz_array)) {
								$offset_tmp = $this->tz_array[$tz_due][$dlst];
							} else {
								$offset_tmp = '+0000';
							}
						} elseif (isset($calendar_tz)) {
							if (array_key_exists($calendar_tz, $this->tz_array)) {
								$offset_tmp = $this->tz_array[$calendar_tz][$dlst];
							} else {
								$offset_tmp = '+0000';
							}
						} else {
							$offset_tmp = $server_offset_tmp;
						}
						$start_unixtime = $this->calcTime($offset_tmp, $server_offset_tmp, $start_unixtime);
						$due_date = date('Ymd', $start_unixtime);
						$due_time = date('Hi', $start_unixtime);
						unset($server_offset_tmp);
					}
					break;
*/
/*				case 'COMPLETED':
					$zulu_time = false;
					if (substr($data,-1) == 'Z') $zulu_time = true;
					$data = ereg_replace('T', '', $data);
					$data = ereg_replace('Z', '', $data);
					if (preg_match("/^COMPLETED;VALUE=DATE/i", $field))  {
						$allday_start = $data;
						$start_date = $allday_start;
					} else {
						if (preg_match("/^COMPLETED;TZID=/i", $field)) {
							$tz_tmp = explode('=', $field);
							$tz_completed = $tz_tmp[1];
							unset($tz_tmp);
						} elseif ($zulu_time) {
							$tz_completed = 'GMT';
						}

						ereg ('([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{0,2})([0-9]{0,2})', $data, $regs);
						$start_date = $regs[1] . $regs[2] . $regs[3];
						$start_time = $regs[4] . $regs[5];
						$start_unixtime = mktime($regs[4], $regs[5], 0, $regs[2], $regs[3], $regs[1]);

						$dlst = date('I', $start_unixtime);
						$server_offset_tmp = $this->chooseOffset($start_unixtime);
						if (isset($tz_completed)) {
							if (array_key_exists($tz_completed, $this->tz_array)) {
								$offset_tmp = $this->tz_array[$tz_completed][$dlst];
							} else {
								$offset_tmp = '+0000';
							}
						} elseif (isset($calendar_tz)) {
							if (array_key_exists($calendar_tz, $this->tz_array)) {
								$offset_tmp = $this->tz_array[$calendar_tz][$dlst];
							} else {
								$offset_tmp = '+0000';
							}
						} else {
							$offset_tmp = $server_offset_tmp;
						}
						$start_unixtime = $this->calcTime($offset_tmp, $server_offset_tmp, $start_unixtime);
						$completed_date = date('Ymd', $start_unixtime);
						$completed_time = date('Hi', $start_unixtime);
						unset($server_offset_tmp);
					}
					break;

				case 'PRIORITY':
					$vtodo_priority = "$data";
					break;
*/
				case 'STATUS':
					// VEVENT: TENTATIVE, CONFIRMED, CANCELLED
					// VTODO: NEEDS-ACTION, COMPLETED, IN-PROCESS, CANCELLED
					$status = "$data";
					break;

				case 'CLASS':
					// VEVENT, VTODO: PUBLIC, PRIVATE, CONFIDENTIAL
					$class = "$data";
					break;

				case 'CATEGORIES':
					$categories = mb_convert_encoding( $data , mb_internal_encoding() , "UTF-8" ) ;
					break;
				//
				// End VTODO Parsing

				case 'DTSTART':
					$zulu_time = false;
					if (substr($data,-1) == 'Z') $zulu_time = true;
//HACK  by domifara for php5.3+
//					$data = ereg_replace('T', '', $data);
//					$data = ereg_replace('Z', '', $data);
//					$field = ereg_replace(';VALUE=DATE-TIME', '', $field);
					$data = preg_replace('/T/', '', $data);
					$data = preg_replace('/Z/', '', $data);
					$field = preg_replace('/;VALUE=DATE-TIME/', '', $field);
					if (preg_match("/^DTSTART;VALUE=DATE/", $field))  {
						$allday_start = $data;
						$start_date = $allday_start;
					} else {
						if (preg_match("/^DTSTART;TZID=/i", $field)) {
							$tz_tmp = explode('=', $field);
							$tz_dtstart = $tz_tmp[1];
							unset($tz_tmp);
						} elseif ($zulu_time) {
							$tz_dtstart = 'GMT';
						}

//HACK  by domifara for php5.3+
//						ereg ('([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{0,2})([0-9]{0,2})', $data, $regs);
						preg_match ('/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{0,2})([0-9]{0,2})/', $data, $regs);
						$start_date = $regs[1] . $regs[2] . $regs[3];
						$start_time = $regs[4] . $regs[5];
						$start_unixtime = mktime($regs[4], $regs[5], 0, $regs[2], $regs[3], $regs[1]);

						$dlst = date('I', $start_unixtime);
						$server_offset_tmp = $this->chooseOffset($start_unixtime);
						if (isset($tz_dtstart)) {
							if (array_key_exists($tz_dtstart, $this->tz_array)) {
								$offset_tmp = $this->tz_array[$tz_dtstart][$dlst];
							} else {
								$offset_tmp = '+0000';
							}
						} elseif (isset($calendar_tz)) {
							if (array_key_exists($calendar_tz, $this->tz_array)) {
								$offset_tmp = $this->tz_array[$calendar_tz][$dlst];
							} else {
								$offset_tmp = '+0000';
							}
							$tz_dtstart = $calendar_tz ; // GIJ added
						} else {
							$offset_tmp = $server_offset_tmp;
						}
						$start_unixtime = $this->calcTime($offset_tmp, $server_offset_tmp, $start_unixtime);
						$event_tz = $this->calcOffset( $offset_tmp ) / 3600 ;
						$start_date = date('Ymd', $start_unixtime);
						$start_time = date('Hi', $start_unixtime);
						unset($server_offset_tmp);
					}
					break;

				case 'DTEND':
					$zulu_time = false;
					if (substr($data,-1) == 'Z') $zulu_time = true;
//HACK  by domifara for php5.3+
//					$data = ereg_replace('T', '', $data);
//					$data = ereg_replace('Z', '', $data);
//					$field = ereg_replace(';VALUE=DATE-TIME', '', $field);
					$data = preg_replace('/T/', '', $data);
					$data = preg_replace('/Z/', '', $data);
					$field = preg_replace('/;VALUE=DATE-TIME/i', '', $field);
					if (preg_match("/^DTEND;VALUE=DATE/i", $field))  {
						$allday_end = $data;
					} else {
						if (preg_match("/^DTEND;TZID=/i", $field)) {
							$tz_tmp = explode('=', $field);
							$tz_dtend = $tz_tmp[1];
							unset($tz_tmp);
						} elseif ($zulu_time) {
							$tz_dtend = 'GMT';
						}

//HACK by domifara for php5.3+
//						ereg ('([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{0,2})([0-9]{0,2})', $data, $regs);
						preg_match ('/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{0,2})([0-9]{0,2})/', $data, $regs);
						$end_date = $regs[1] . $regs[2] . $regs[3];
						$end_time = $regs[4] . $regs[5];
						$end_unixtime = mktime($regs[4], $regs[5], 0, $regs[2], $regs[3], $regs[1]);

						$dlst = date('I', $end_unixtime);
						$server_offset_tmp = $this->chooseOffset($end_unixtime);
						if (isset($tz_dtend)) {
							$offset_tmp = $this->tz_array[$tz_dtend][$dlst];
						} elseif (isset($calendar_tz)) {
							$offset_tmp = $this->tz_array[$calendar_tz][$dlst];
							$tz_dtend = $calendar_tz ; // GIJ added
						} else {
							$offset_tmp = $server_offset_tmp;
						}
						$end_unixtime = $this->calcTime($offset_tmp, $server_offset_tmp, $end_unixtime);
						if( ! isset( $event_tz ) ) $event_tz = $this->calcOffset( $offset_tmp ) / 3600 ;
						$end_date = date('Ymd', $end_unixtime);
						$end_time = date('Hi', $end_unixtime);
						unset($server_offset_tmp);

					}
					break;

/*				case 'EXDATE':
					$data = split(",", $data);
					foreach ($data as $exdata) {
						$exdata = ereg_replace('T', '', $exdata);
						$exdata = ereg_replace('Z', '', $exdata);
						ereg ('([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{0,2})([0-9]{0,2})', $exdata, $regs);
						$except_dates[] = $regs[1] . $regs[2] . $regs[3];
						$except_times[] = $regs[4] . $regs[5];
					}
					break;
*/
				case 'SUMMARY':
					$summary = mb_convert_encoding( $data , mb_internal_encoding() , "UTF-8" ) ;
					break;

				case 'DESCRIPTION':
					$description = mb_convert_encoding( $data , mb_internal_encoding() , "UTF-8" ) ;
					break;

				case 'CONTACT':
					// RFC2445 4.8.4.2  GIJ added
					$contact = mb_convert_encoding( $data , mb_internal_encoding() , "UTF-8" ) ;
					break;

				case 'LOCATION':
					// RFC2445 4.8.1.7  GIJ added
					$location = mb_convert_encoding( $data , mb_internal_encoding() , "UTF-8" ) ;
					break;

				case 'DTSTAMP':
					// RFC2445 4.8.7.2  GIJ added
					$data = str_replace('T', '', $data);
					$dtstamp = str_replace('Z', '', $data);
					break;

				case 'SEQUENCE':
					// RFC2445 4.8.7.4  GIJ added
					$sequence = intval($data);
					break;

				case 'UID':
					$uid = $data;
					break;

				case 'X-WR-CALNAME':
					$calendar_name = mb_convert_encoding( $data , mb_internal_encoding() , "UTF-8" ) ;
					break;

				case 'X-WR-TIMEZONE':
					$calendar_tz = $data;
					break;

/*				case 'DURATION':
					if (($first_duration == TRUE) && (!stristr($field, '=DURATION'))) {
						ereg ('^P([0-9]{1,2})?([W,D]{0,1}[T])?([0-9]{1,2}[H])?([0-9]{1,2}[M])?([0-9]{1,2}[S])?', $data, $duration);
						if ($duration[2] = 'W') {
							$weeks = $duration[1];
							$days = 0;
						} else {
							$days = $duration[1];
							$weeks = 0;
						}
						$hours = ereg_replace('H', '', $duration[3]);
						$minutes = ereg_replace('M', '', $duration[4]);
						$seconds = ereg_replace('S', '', $duration[5]);
						$the_duration = ($weeks * 60 * 60 * 24 * 7) + ($days * 60 * 60 * 24) + ($hours * 60 * 60) + ($minutes * 60) + ($seconds);
						$end_unixtime = $start_unixtime + $the_duration;
						$end_time = date ('Hi', $end_unixtime);
						$first_duration = FALSE;
					}
					break;
*/
				case 'RRULE':
					$rrule = strtoupper( $data ) ;
					break;

/*				case 'ATTENDEE':
					$attendee = $data;
					break;
*/
			}
		}
	}

	//If you want to see the values in the arrays, uncomment below.
	//print '<pre>';
	//print_r($this->events);
	//print_r($rrule);
	//print '</pre>';

	return "0: $calendar_name :" ;
}



// パースしたiCalendarデータから、INSERT,UPDATE用のSET文配列を生成する関数
function output_setsqls()
{
	$rets = array() ;

	foreach( $this->events as $uid => $event ) {
		$ret = "" ;

		// $event[] をローカル変数に展開
		unset( $start_unixtime, $end_unixtime, $summary, $description, $status, $class, $categories, $contact, $location, $dtstamp, $sequence, $allday_start, $allday_end, $tz_dtstart, $tz_dtend , $event_tz , $uid_valid ) ;
		extract( $event ) ;

		// Unique-ID (自動付加番号の場合は、それっぽく生成する)
		if( ! $uid_valid ) {
			$unique_id = 'pical060-' . md5( "{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}") . "-$uid" ;
		} else $unique_id = $uid ;
		$ret .= "unique_id='" . addslashes( $unique_id ) . "'," ;

		// DTENDの記述がないデータへの対策
		if( ! isset( $end_unixtime ) ) $end_unixtime = $start_unixtime + 300 ;

		// startとendが反転しているデータへの対策
		if( $start_unixtime > $end_unixtime ) list( $start_unixtime , $end_unixtime ) = array( $end_unixtime , $start_unixtime ) ;

		// 5分単位に揃える
		$start_unixtime = intval( $start_unixtime / 300 ) * 300 ;
		$end_unixtime = intval( $end_unixtime / 300 ) * 300 ;

		// 時間のセット
		$ret .= "start='$start_unixtime',end='$end_unixtime'," ;
		if( isset( $allday_start ) && $allday_start != '') {
			// 全日イベント
			$ret .= "allday='1'," ;
		} else {
			// 通常イベント
			$ret .= "allday='0'," ;
		}

		// tzid の記録（一応）
		if( isset( $tz_dtstart ) && $tz_dtstart != "" ) $ret .= "tzid='$tz_dtstart'," ;
		else if( isset( $tz_dtend ) && $tz_dtend != "" ) $ret .= "tzid='$tz_dtend'," ;

		// event_tz の記録
		if( isset( $event_tz ) ) $ret .= "event_tz='$event_tz'," ;

		// summaryのチェック（未記入ならその旨を追加）
		if( empty( $summary ) || $summary == "" ) $event[ 'summary' ] = '（件名なし）' ;

		// その他のカラム (dtstamp はあえて外す)
		$cols = array( "summary" => "255:J:1" , "location" => "255:J:0" , "contact" => "255:J:0" , "categories" => "255:J:0" , "rrule" => "255:E:0" , /* "dtstamp" => "14:E:0" ,*/ "sequence" => "I:N:0" , "description" => "A:J:0" ) ;
		$ret .= $this->get_sql_set( $event , $cols ) ;

		$rets[] = $ret ;
	}

	return $rets ;
}


// 連想配列を引数に取り、$eventからINSERT,UPDATE用のSET文を生成するクラス関数
function get_sql_set( $event , $cols )
{
	$ret = "" ;

	foreach( $cols as $col => $types ) {

		list( $field , $lang , $essential ) = explode( ':' , $types ) ;

		$data = empty( $event[ $col ] ) ? '' : $event[ $col ] ;

		// 言語・数字などの別による処理
		switch( $lang ) {
			case 'N' :	// 数値 (桁取りの , を取る)
				$data = str_replace( "," , "" , $data ) ;
				break ;
			case 'J' :	// 日本語テキスト (半角カナ→全角かな)
				$data = $this->mb_convert_kana( $data , "KV" ) ;
				break ;
			case 'E' :	// 半角英数字のみ (全角英数→半角英数)
				$data = $this->mb_convert_kana( $data , "as" ) ;
				break ;
		}

		// フィールドの型による処理
		switch( $field ) {
			case 'A' :	// textarea
				$data = $this->textarea_sanitizer_for_sql( $data ) ;
				break ;
			case 'I' :	// integer
				$data = intval( $data ) ;
				break ;
			default :	// varchar(デフォルト)は数値による文字数指定
				$data = $this->text_sanitizer_for_sql( $data ) ;
				if( $field < 1 ) $field = 255 ;
				$data = mb_strcut( $data , 0 , $field ) ;
		}

		// 最後にaddslashes
		$data = addslashes( $data ) ;

		$ret .= "$col='$data'," ;
	}

	// 最後の , を削除
	$ret = substr( $ret , 0 , -1 ) ;

	return $ret ;
}



// mb_convert_kanaの処理
function mb_convert_kana( $str , $option )
{
	// convert_kana の処理は、日本語でのみ行う
	if( $this->language != 'japanese' || ! function_exists( 'mb_convert_kana' ) ) {
		return $str ;
	} else {
		return mb_convert_kana( $str , $option ) ;
	}
}



// サニタイズ関連の関数 (サブクラスを作成する時のOverride対象)

function textarea_sanitizer_for_sql( $data )
{
	// '\n' を "\n" にする
	$data = str_replace( '\n' , "\n" , $data ) ;

	if( class_exists( 'MyTextSanitizer' ) ) {
		// XOOPSのサニタイザクラスがあれば、個別にbb codeタグへの変換をしてみる
		$search = array (
			"/mailto:(\S+)(\s)/i" ,
			"/http:\/\/(\S+)(\s)/i"
		) ;
		$replace = array (
			"[email]\\1[/email]\\2" ,
			"[url=\\1]\\1[/url]\\2"
		) ;
		$data = preg_replace( $search , $replace , $data ) ;
		return strip_tags( $data ) ;
	} else {
		// なければ、単に全タグを無効とする
		return strip_tags( $data ) ;
	}
}

function text_sanitizer_for_sql( $data )
{
	// 全タグを無効とするsanitize
	// 実際には、Outlookなどではタグを直書きするので、画面出力のサニタイズさえ
	// きちんと行われているのであれば、ここでのstrip_tags は消しても良いはず
	return strip_tags( $data ) ;

}










// The End of Class
}
?>