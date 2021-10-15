<?php
/**
*
* File: _admin/_functions/output_html.php
* Version 2 - Updated 19:31 06.03.2015
* Copyright (c) 2008-2015 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*
*
* -----> Please also see: encode_national_letters.php <-----
* encode_national_letters.php are used when this class cannot be used, because
* this class also removes html entities. Example SQL with links, bold text etc
*
*
*/
function output_html($value){
	// Trim and line space
	$value = trim($value);

	// Check last, if it is backslash, then replace it...
	$check  = substr($value, -1);
	$check  =  "^" . $check . "^";
	if($check == "^\^"){
		$new_value = substr($value, 0, -1);
		$value	 = $new_value . "&#92";
	}
	
	// 1. Characpters that needs to be converted

	// 1. A
	$value = str_replace('�', '&aelig;', $value);
	$value = str_replace("æ", "&aelig;", $value);
	$value = str_replace("&amp;aelig;", "&aelig;", $value);
	$value = str_replace('ø', '&oslash;', $value);
	$value = str_replace('&amp;oslash;', '&oslash;', $value);
	$value = str_replace("�", "&aring;", $value);
	$value = str_replace("å", "&aring;", $value);
	$value = str_replace("&amp;aring;", "&aring;", $value);
	$value = str_replace('�', '&AElig;', $value);
	$value = str_replace('Æ', '&AElig;', $value);
	$value = str_replace('&amp;AElig;', '&AElig;', $value);
	$value = str_replace('�', '&Aring;', $value);
	$value = str_replace('Å', '&Aring;', $value);
	$value = str_replace('&amp;Aring;', '&Aring;', $value);

	$value = str_replace('�', '&aacute;', $value);
	$value = str_replace('�', '&agrave;', $value);
	$value = str_replace('�', '&Agrave;', $value);
	$value = str_replace('�', '&acirc;', $value);
	$value = str_replace('�', '&Acirc;', $value);
	$value = str_replace('�', '&Aacute;', $value);

	$value = str_replace('�', '&#192;', $value);
	$value = str_replace('�', '&#193;', $value);
	$value = str_replace('�', '&#196;', $value);
	$value = str_replace('�', '&#224;', $value);
	$value = str_replace('�', '&#225;', $value);
	$value = str_replace('�', '&#226;', $value);
	$value = str_replace('�', '&#227;', $value);
	$value = str_replace('�', '&#228;', $value);

	// 1. C
	$value = str_replace('�', '&#199;', $value);
	$value = str_replace('�', '&#231;', $value);


	// 1. E
	$value = str_replace('�', '&egrave;', $value);
	$value = str_replace('�', '&Egrave;', $value);
	$value = str_replace('�', '&eacute;', $value);
	$value = str_replace('�', '&Eacute;', $value);
	$value = str_replace('�', '&ecirc;', $value);
	$value = str_replace('�', '&Ecirc;', $value);
	$value = str_replace('�', '&euml;', $value);
	$value = str_replace('�', '&Euml;', $value);
	$value = str_replace('�', '&#200;', $value);
	$value = str_replace('�', '&#201;', $value);
	$value = str_replace('�', '&#202;', $value);
	$value = str_replace('�', '&#203;', $value);
	$value = str_replace('�', '&#232;', $value);
	$value = str_replace('�', '&#233;', $value);
	$value = str_replace('�', '&#234;', $value);
	$value = str_replace('�', '&#235;', $value);

	// 1. I
	$value = str_replace('�', '&icirc;', $value);
	$value = str_replace('�', '&Icirc;', $value);
	$value = str_replace('�', '&iuml;', $value);
	$value = str_replace('�', '&Iuml;', $value);
	$value = str_replace('�', '&Iacute;', $value);
	$value = str_replace('�', '&iacute;', $value);
	$value = str_replace('�', '&iquest;', $value);
	$value = str_replace('�', '&iexcl;', $value);
	$value = str_replace('�', '&#204;', $value);
	$value = str_replace('�', '&#205;', $value);
	$value = str_replace('�', '&#206;', $value);
	$value = str_replace('�', '&#207;', $value);
	$value = str_replace('�', '&#236;', $value);
	$value = str_replace('�', '&#237;', $value);
	$value = str_replace('�', '&#238;', $value);
	$value = str_replace('�', '&#239;', $value);

	// 1. D
	$value = str_replace('�', '&#208;', $value);

	// 1. N
	$value = str_replace('�', '&Ntilde;', $value);
	$value = str_replace('�', '&ntilde;', $value);
	$value = str_replace('�', '&#209;', $value);

	// 1. O
	$value = str_replace('�', '&Oslash;', $value);
	$value = str_replace('Ø', '&Oslash;', $value);
	$value = str_replace('&amp;Oslash;', '&Oslash;', $value);
	$value = str_replace('�', '&ocirc;', $value);
	$value = str_replace('�', '&Ocirc;', $value);
	$value = str_replace('�', '&Oacute;', $value);
	$value = str_replace('�', '&oacute;', $value);
	$value = str_replace('�', '&ordm;', $value);
	$value = str_replace('�', '&ordf;', $value);
	$value = str_replace('�', '&Ouml;', $value);
	$value = str_replace('�', '&ouml;', $value);
	$value = str_replace('�', '&#210;', $value);
	$value = str_replace('�', '&#211;', $value);
	$value = str_replace('�', '&#212;', $value);
	$value = str_replace('�', '&#213;', $value);
	$value = str_replace('�', '&#214;', $value);
	$value = str_replace('�', '&#240;', $value);
	$value = str_replace('�', '&#241;', $value);
	$value = str_replace('�', '&#242;', $value);
	$value = str_replace('�', '&#243;', $value);
	$value = str_replace('�', '&#244;', $value);
	$value = str_replace('�', '&#245;', $value);
	$value = str_replace('�', '&#246;', $value);

	// 1. P
	$value = str_replace('�', '&#222;', $value);
	$value = str_replace('�', '&#254;', $value);

	// 1. S
	$value = str_replace('�', '&#223;', $value);

	// 1. U
	$value = str_replace('�', '&ugrave;', $value);
	$value = str_replace('�', '&Ugrave;', $value);
	$value = str_replace('�', '&ucirc;', $value);
	$value = str_replace('�', '&Ucirc;', $value);
	$value = str_replace('�', '&uuml;', $value);
	$value = str_replace('�', '&Uuml;', $value);
	$value = str_replace('�', '&Uacute;', $value);
	$value = str_replace('�', '&uacute;', $value);
	$value = str_replace('�', '&uuml;', $value);
	$value = str_replace('�', '&#217;', $value);
	$value = str_replace('�', '&#218;', $value);
	$value = str_replace('�', '&#219;', $value);
	$value = str_replace('�', '&#220;', $value);
	$value = str_replace('�', '&#249;', $value);
	$value = str_replace('�', '&#250;', $value);
	$value = str_replace('�', '&#251;', $value);
	$value = str_replace('�', '&#252;', $value);

	// 1. Y
	$value = str_replace('�', '&yuml;', $value);
	$value = str_replace('�', '&Yuml;', $value);
	$value = str_replace('�', '&#221;', $value);
	$value = str_replace('�', '&#253;', $value);
	$value = str_replace('�', '&#255;', $value);
 
	// 1. X
	$value = str_replace('�', '&#215;', $value);  // Yeah, I know.  But otherwise the gap is confusing.  --Kris

	// 1. Other
	$value = str_replace('�', '&ccedil;', $value);
	$value = str_replace('�', '&Ccedil;', $value);
	$value = str_replace('�', '&oelig;', $value);
	$value = str_replace('�', '&OElig;', $value);

	// 1. Misc signs
	$value = str_replace('"',"&quot;","$value");
	$value = str_replace("'","&#039;","$value");
	$value = str_replace("<", "&lt;", "$value"); // less than
	$value = str_replace(">", "&gt;", "$value"); // greater than
	
	// 1. Punctuation
	$value = str_replace('�', '&laquo;', $value);
	$value = str_replace('�', '&raquo;', $value);
	$value = str_replace('�', '&lsaquo;', $value);
	$value = str_replace('�', '&rsaquo;', $value);
	$value = str_replace('�', '&ldquo;', $value);
	$value = str_replace('�', '&rdquo;', $value);
	$value = str_replace('�', '&lsquo;', $value);
	$value = str_replace('�', '&rsquo;', $value);
	$value = str_replace('�', '&mdash;', $value);
	$value = str_replace('�', '&ndash;', $value);

	// 1. Money
	$value = str_replace('�', '&euro;', $value);

	// 1. Degree
	$value = str_replace('°', '&deg;', $value);


	// 2. Remove rest of HTML tags
	// Remove HTML tags
	$value = htmlentities($value, ENT_COMPAT, "UTF-8");


	// 3. Replace double & for characters that needs to be converted
	// A
	$value = str_replace('&amp;aelig;', '&aelig;', $value); // �
	$value = str_replace("&amp;aring;", "&aring;", $value); // �
	$value = str_replace('&amp;AElig;', '&AElig;', $value); // �
	$value = str_replace('&amp;Aring;', '&Aring;', $value); // �

	$value = str_replace('&amp;aacute;', '&aacute;', $value); // �
	$value = str_replace('&amp;agrave;', '&agrave;', $value); // �
	$value = str_replace('&amp;Agrave;', '&Agrave;', $value); // �
	$value = str_replace('&amp;acirc;', '&acirc;', $value); // �
	$value = str_replace('&amp;Acirc;', '&Acirc;', $value); // �
	$value = str_replace('&amp;Aacute;', '&Aacute;', $value); // �

	$value = str_replace('&amp;#192;', '&#192;', $value); // �
	$value = str_replace('&amp;#193;', '&#193;', $value); // �
	$value = str_replace('&amp;#196;', '&#196;', $value); // �
	$value = str_replace('&amp;#224;', '&#224;', $value); // �
	$value = str_replace('&amp;#225;', '&#225;', $value); // �
	$value = str_replace('&amp;#226;', '&#226;', $value); // �
	$value = str_replace('&amp;#227;', '&#227;', $value); // �
	$value = str_replace('&amp;#228;', '&#228;', $value); // �

	// C
	$value = str_replace('&amp;#199;', '&#199;', $value); // �
	$value = str_replace('&amp;#231;', '&#231;', $value); // �

	// E
	$value = str_replace('&amp;egrave;', '&egrave;', $value); // �
	$value = str_replace('&amp;Egrave;', '&Egrave;', $value); // �
	$value = str_replace('&amp;eacute;', '&eacute;', $value); // �
	$value = str_replace('&amp;Eacute;', '&Eacute;', $value); // �
	$value = str_replace('&amp;ecirc;', '&ecirc;', $value); // �
	$value = str_replace('&amp;Ecirc;', '&Ecirc;', $value); // �
	$value = str_replace('&amp;euml;', '&euml;', $value); // �
	$value = str_replace('&amp;Euml;', '&Euml;', $value); // �
	$value = str_replace('&amp;#200;', '&#200;', $value); // �
	$value = str_replace('&amp;#201;', '&#201;', $value); // �
	$value = str_replace('&amp;#202;', '&#202;', $value); // �
	$value = str_replace('&amp;#203;', '&#203;', $value); // �
	$value = str_replace('&amp;#232;', '&#232;', $value); // �
	$value = str_replace('&amp;#233;', '&#233;', $value); // �
	$value = str_replace('&amp;#234;', '&#234;', $value); // �
	$value = str_replace('&amp;#235;', '&#235;', $value); // �

	// I
	$value = str_replace('&amp;icirc;', '&icirc;', $value); // �
	$value = str_replace('&amp;Icirc;', '&Icirc;', $value); // �
	$value = str_replace('&amp;iuml;', '&iuml;', $value); // �
	$value = str_replace('&amp;Iuml;', '&Iuml;', $value); // �
	$value = str_replace('&amp;Iacute;', '&Iacute;', $value); // �
	$value = str_replace('&amp;iacute;', '&iacute;', $value); // �
	$value = str_replace('&amp;iquest;', '&iquest;', $value); // �
	$value = str_replace('&amp;iexcl;', '&iexcl;', $value); // �
	$value = str_replace('&amp;#204;', '&#204;', $value); // �
	$value = str_replace('&amp;#205;', '&#205;', $value); // �
	$value = str_replace('&amp;#206;', '&#206;', $value); // �
	$value = str_replace('&amp;#207;', '&#207;', $value); // �
	$value = str_replace('&amp;#236;', '&#236;', $value); // �
	$value = str_replace('&amp;#237;', '&#237;', $value); // �
	$value = str_replace('&amp;#238;', '&#238;', $value); // �
	$value = str_replace('&amp;#239;', '&#239;', $value); // �

	// D
	$value = str_replace('&amp;#208;', '&#208;', $value); // �

	// N
	$value = str_replace('&amp;Ntilde;', '&Ntilde;', $value); // �
	$value = str_replace('&amp;ntilde;', '&ntilde;', $value); // �
	$value = str_replace('&amp;#209;', '&#209;', $value); // �

	// O
	$value = str_replace('&amp;Oslash;', '&Oslash;', $value); // �
	$value = str_replace('&amp;oslash;', '&oslash;', $value); // �
	$value = str_replace('&amp;ocirc;', '&ocirc;', $value); // �
	$value = str_replace('&amp;Ocirc;', '&Ocirc;', $value); // �
	$value = str_replace('&amp;Oacute;', '&Oacute;', $value); // �
	$value = str_replace('&amp;oacute;', '&oacute;', $value); // �
	$value = str_replace('&amp;ordm;', '&ordm;', $value); // �
	$value = str_replace('&amp;ordf;', '&ordf;', $value); // �
	$value = str_replace('&amp;Ouml;', '&Ouml;', $value); // �
	$value = str_replace('&amp;ouml;', '&ouml;', $value); // �
	$value = str_replace('&amp;#210;', '&#210;', $value); // �
	$value = str_replace('&amp;#211;', '&#211;', $value); // �
	$value = str_replace('&amp;#212;', '&#212;', $value); // �
	$value = str_replace('&amp;#213;', '&#213;', $value); // �
	$value = str_replace('&amp;#214;', '&#214;', $value); // �
	$value = str_replace('&amp;#240;', '&#240;', $value); // �
	$value = str_replace('&amp;#241;', '&#241;', $value); // �
	$value = str_replace('&amp;#242;', '&#242;', $value); // �
	$value = str_replace('&amp;#243;', '&#243;', $value); // �
	$value = str_replace('&amp;#244;', '&#244;', $value); // �
	$value = str_replace('&amp;#245;', '&#245;', $value); // �
	$value = str_replace('&amp;#246;', '&#246;', $value); // �

	// P
	$value = str_replace('&amp;#222;', '&#222;', $value); // �
	$value = str_replace('&amp;#254;', '&#254;', $value); // �

	// S
	$value = str_replace('&amp;#223;', '&#223;', $value); // �

	// U
	$value = str_replace('&amp;ugrave;', '&ugrave;', $value); // �
	$value = str_replace('&amp;Ugrave;', '&Ugrave;', $value); // �
	$value = str_replace('&amp;ucirc;', '&ucirc;', $value); // �
	$value = str_replace('&amp;Ucirc;', '&Ucirc;', $value); // �
	$value = str_replace('&amp;uuml;', '&uuml;', $value); // �
	$value = str_replace('&amp;Uuml;', '&Uuml;', $value); // �
	$value = str_replace('&amp;Uacute;', '&Uacute;', $value); // �
	$value = str_replace('&amp;uacute;', '&uacute;', $value); // �
	$value = str_replace('&amp;uuml;', '&uuml;', $value); // �
	$value = str_replace('&amp;#217;', '&#217;', $value); // �
	$value = str_replace('&amp;#218;', '&#218;', $value); // �
	$value = str_replace('&amp;#219;', '&#219;', $value); // �
	$value = str_replace('&amp;#220;', '&#220;', $value); // �
	$value = str_replace('&amp;#249;', '&#249;', $value); // �
	$value = str_replace('&amp;#250;', '&#250;', $value); // �
	$value = str_replace('&amp;#251;', '&#251;', $value); // �
	$value = str_replace('&amp;#252;', '&#252;', $value); // �

	// Y
	$value = str_replace('&amp;yuml;', '&yuml;', $value); // �
	$value = str_replace('&amp;Yuml;', '&Yuml;', $value); // �
	$value = str_replace('&amp;#221;', '&#221;', $value); // �
	$value = str_replace('&amp;#253;', '&#253;', $value); // �
	$value = str_replace('&#255;', '&#255;', $value); // �

	// X
	$value = str_replace('&amp;#215;', '&#215;', $value);  // �

	// Other
	$value = str_replace('&amp;ccedil;', '&ccedil;', $value); // �
	$value = str_replace('&amp;Ccedil;', '&Ccedil;', $value); // �
	$value = str_replace('&amp;oelig;', '&oelig;', $value); // �
	$value = str_replace('&amp;OElig;', '&OElig;', $value); // �

	// Misc signs
	$value = str_replace('&amp;quot;', "&quot;","$value"); 
	$value = str_replace("&amp;#039;","&#039;","$value"); 
	$value = str_replace("&amp;gt;", "&gt;", "$value"); 
	$value = str_replace("&amp;lt;", "&lt;", $value); 
	
	//Punctuation
	$value = str_replace('&amp;laquo;', '&laquo;', $value); // �
	$value = str_replace('&amp;raquo;', '&raquo;', $value); // �
	$value = str_replace('&amp;lsaquo;', '&lsaquo;', $value); // �
	$value = str_replace('&amp;rsaquo;', '&rsaquo;', $value); // �
	$value = str_replace('&amp;ldquo;', '&ldquo;', $value); // �
	$value = str_replace('&amp;rdquo;', '&rdquo;', $value); // �
	$value = str_replace('&amp;lsquo;', '&lsquo;', $value); // �
	$value = str_replace('&amp;rsquo;', '&rsquo;', $value); // �
	$value = str_replace('&amp;mdash;', '&mdash;', $value); // �
	$value = str_replace('&amp;ndash;', '&ndash;', $value); // �

	// Money
	$value = str_replace('&amp;euro;', '&euro;', $value); // �

	// Degree
	$value = str_replace('&amp;deg;', '&deg;', $value); // �


	// &
	$value = str_replace('&amp;amp;', '&amp;', $value); // &

	// 4. Misc sings
	$value = str_replace("\n","<br />", "$value");

	// Return
	return $value;
}
?>