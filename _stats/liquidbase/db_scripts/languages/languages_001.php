<?php
/**
*
* File: _admin/_liquidbase/db_scripts/webdesign/webdesign_share_buttons.php
* Version 1.0.0
* Date 21:19 28.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

// Access check
if(isset($_SESSION['adm_user_id'])){


	$t_languages	= $dbPrefixSav . "languages";


	$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_languages") or die(mysqli_error($link)); 

	// Languages
	mysqli_query($link, "CREATE TABLE $t_languages(
	   language_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(language_id), 
	   language_name VARCHAR(250),
	   language_slug VARCHAR(250),
	   language_native_name VARCHAR(250),
	   language_iso_two VARCHAR(250),
	   language_iso_three VARCHAR(250),
	   language_iso_two_alt_a VARCHAR(20),
	   language_iso_two_alt_b VARCHAR(20),
	   language_flag_path_16x16 VARCHAR(250),
	   language_flag_16x16 VARCHAR(250),
	   language_flag_path_32x32 VARCHAR(250),
	   language_flag_32x32 VARCHAR(250),
	   language_charset VARCHAR(250))")
	   or die(mysqli_error($link));

	mysqli_query($link, "INSERT INTO $t_languages
	(`language_id`, `language_name`, `language_slug`, `language_native_name`, `language_iso_two`, `language_iso_three`, `language_iso_two_alt_a`, `language_iso_two_alt_b`, `language_flag_path_16x16`, `language_flag_16x16`, `language_flag_path_32x32`, `language_flag_32x32`, `language_charset`) VALUES
	(1, 'Abkhazian', 'abkhazian', '?????', 'ab', 'abk', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'eritrea.png', '_admin/_design/gfx/flags/32x32', 'eritrea.png', 'windows-1252'),
(2, 'Afar', 'afar', 'Qafara', 'aa', 'aar', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'eritrea.png', '_admin/_design/gfx/flags/32x32', 'eritrea.png', 'windows-1252'),
(3, 'Afrikaans', 'afrikaans', 'Afrikaans', 'af', 'afr', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'south_africa.png', '_admin/_design/gfx/flags/32x32', 'south_africa.png', 'windows-1252'),
(4, 'Akan', 'akan', 'macrolanguage', 'ak', 'aka', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'ghana.png', '_admin/_design/gfx/flags/32x32', 'ghana.png', 'windows-1252'),
(5, 'Albanian', 'albanian', 'Shqip', 'sq', 'alb/sqi', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'albania.png', '_admin/_design/gfx/flags/32x32', 'albania.png', 'windows-1252'),
(6, 'Amharic', 'amharic', '????', 'am', 'amh', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'ethiopia.png', '_admin/_design/gfx/flags/32x32', 'ethiopia.png', 'windows-1252'),
(7, 'Arabic', 'arabic', '???????', 'ar', 'ara', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'algeria.png', '_admin/_design/gfx/flags/32x32', 'algeria.png', 'windows-1252'),
(8, 'Aragonese', 'aragonese', 'Aragon?s', 'an', 'arg', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'spain.png', '_admin/_design/gfx/flags/32x32', 'spain.png', 'windows-1252'),
(9, 'Armenian', 'armenian', '??????? ?????', 'hy', 'arm/hye', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'armenia.png', '_admin/_design/gfx/flags/32x32', 'armenia.png', 'windows-1252'),
(10, 'Assamese', 'assamese', '???????', 'as', 'asm', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(11, 'Avaric', 'avaric', '???? ????, ???????? ????', 'av', 'ava', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'russian_federation.png', '_admin/_design/gfx/flags/32x32', 'russian_federation.png', 'windows-1252'),
(12, 'Avestan', 'avestan', 'avesta', 'ae', 'ave', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'russian_federation.png', '_admin/_design/gfx/flags/32x32', 'russian_federation.png', 'windows-1252'),
(13, 'Aymara', 'aymara', 'aymar aru', 'ay', 'aym', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'bolivia_plurinational_state_of.png', '_admin/_design/gfx/flags/32x32', 'bolivia_plurinational_state_of.png', 'windows-1252'),
(14, 'Azerbaijani', 'azerbaijani', 'Az?rbaycanca', 'az', 'aze', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'azerbaijan.png', '_admin/_design/gfx/flags/32x32', 'azerbaijan.png', 'windows-1252'),
(15, 'Bambara', 'bambara', 'bamanankan', 'bm', 'bam', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'mali.png', '_admin/_design/gfx/flags/32x32', 'mali.png', 'windows-1252'),
(16, 'Bashkir', 'bashkir', '??????? ????', 'ba', 'bak', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'russian_federation.png', '_admin/_design/gfx/flags/32x32', 'russian_federation.png', 'windows-1252'),
(17, 'Basque', 'basque', 'euskara', 'eu', 'baq/eus', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'spain.png', '_admin/_design/gfx/flags/32x32', 'spain.png', 'windows-1252'),
(18, 'Belarusian', 'belarusian', '?????????? ????', 'be', 'bel', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'poland.png', '_admin/_design/gfx/flags/32x32', 'poland.png', 'windows-1252'),
(19, 'Bengali', 'bengali', '?????', 'bn', 'ben', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'bangladesh.png', '_admin/_design/gfx/flags/32x32', 'bangladesh.png', 'windows-1252'),
(20, 'Bihari languages', 'bihari_languages', 'collection', 'bh', 'bih', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'fiji.png', '_admin/_design/gfx/flags/32x32', 'fiji.png', 'windows-1252'),
(21, 'Bislama', 'bislama', 'Bislama', 'bi', 'bis', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'vanuatu.png', '_admin/_design/gfx/flags/32x32', 'vanuatu.png', 'windows-1252'),
(22, 'Bosnian', 'bosnian', 'bosanski jezik', 'bs', 'bos', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'bosnia_and_herzegovina.png', '_admin/_design/gfx/flags/32x32', 'bosnia_and_herzegovina.png', 'windows-1252'),
(23, 'Breton', 'breton', 'brezhoneg', 'br', 'bre', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'france.png', '_admin/_design/gfx/flags/32x32', 'france.png', 'windows-1252'),
(24, 'Bulgarian', 'bulgarian', '????????? ????', 'bg', 'bul', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'bulgaria.png', '_admin/_design/gfx/flags/32x32', 'bulgaria.png', 'windows-1252'),
(25, 'Burmese', 'burmese', '????????', 'my', 'bur/mya', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'thailand.png', '_admin/_design/gfx/flags/32x32', 'thailand.png', 'windows-1252'),
(26, 'Catalan, Valencian', 'catalan__valencian', 'catal? / valenci?', 'ca', 'cat', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'spain.png', '_admin/_design/gfx/flags/32x32', 'spain.png', 'windows-1252'),
(27, 'Central Khmer', 'central_khmer', '?????????', 'km', 'khm', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'thailand.png', '_admin/_design/gfx/flags/32x32', 'thailand.png', 'windows-1252'),
(28, 'Chamorro', 'chamorro', 'Chamoru', 'ch', 'cha', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'guam.png', '_admin/_design/gfx/flags/32x32', 'guam.png', 'windows-1252'),
(29, 'Chechen', 'chechen', '??????? ????', 'ce', 'che', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'russian_federation.png', '_admin/_design/gfx/flags/32x32', 'russian_federation.png', 'windows-1252'),
(30, 'Chichewa, Chewa, Nyanja', 'chichewa__chewa__nyanja', 'chiChewa, chinyanja', 'ny', 'nya', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'zambia.png', '_admin/_design/gfx/flags/32x32', 'zambia.png', 'windows-1252'),
(31, 'Chinese', 'chinese', '?? (ZhongWen)', 'zh', 'chi/zho', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'china.png', '_admin/_design/gfx/flags/32x32', 'china.png', 'windows-1252'),
(32, 'Church Slavonic/Bulgarian', 'church_slavonic__church_slavic__old_church_slavonic__old_slavonic__old_bulgarian', '????? ??????????', 'cu', 'chu', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'russian_federation.png', '_admin/_design/gfx/flags/32x32', 'russian_federation.png', 'windows-1252'),
(33, 'Chuvash', 'chuvash', '????? ?????', 'cv', 'chv', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'russian_federation.png', '_admin/_design/gfx/flags/32x32', 'russian_federation.png', 'windows-1252'),
(34, 'Cornish', 'cornish', 'Kernewek', 'kw', 'cor', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'united_kingdom.png', '_admin/_design/gfx/flags/32x32', 'united_kingdom.png', 'windows-1252'),
(35, 'Corsican', 'corsican', 'corsu, lingua corsa', 'co', 'cos', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'france.png', '_admin/_design/gfx/flags/32x32', 'france.png', 'windows-1252'),
(36, 'Cree', 'cree', '???????', 'cr', 'cre', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'canada.png', '_admin/_design/gfx/flags/32x32', 'canada.png', 'windows-1252'),
(37, 'Croatian', 'croatian', 'hrvatski jezik', 'hr', 'hrv', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'croatia.png', '_admin/_design/gfx/flags/32x32', 'croatia.png', 'windows-1252'),
(38, 'Czech', 'czech', 'ce?tina (substantive), cesky (adverb)', 'cs', 'cze/ces', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'czech_republic.png', '_admin/_design/gfx/flags/32x32', 'czech_republic.png', 'windows-1252'),
(39, 'Danish', 'danish', 'dansk', 'da', 'dan', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'denmark.png', '_admin/_design/gfx/flags/32x32', 'denmark.png', 'windows-1252'),
(40, 'Divehi, Dhivehi, Maldivian', 'divehi__dhivehi__maldivian', '?????????', 'dv', 'div', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'maldives.png', '_admin/_design/gfx/flags/32x32', 'maldives.png', 'windows-1252'),
(41, 'Dutch, Flemish', 'dutch__flemish', 'Nederlands', 'nl', 'dut/nld', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'netherlands.png', '_admin/_design/gfx/flags/32x32', 'netherlands.png', 'windows-1252'),
(42, 'Dzongkha', 'dzongkha', '??????', 'dz', 'dzo', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'bhutan.png', '_admin/_design/gfx/flags/32x32', 'bhutan.png', 'windows-1252'),
(43, 'English', 'english', 'English', 'en', 'eng', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'united_kingdom.png', '_admin/_design/gfx/flags/32x32', 'united_kingdom.png', 'windows-1252'),
(44, 'Esperanto', 'esperanto', 'Esperanto', 'eo', 'epo', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'china.png', '_admin/_design/gfx/flags/32x32', 'china.png', 'windows-1252'),
(45, 'Estonian', 'estonian', 'eesti keel', 'et', 'est', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'estonia.png', '_admin/_design/gfx/flags/32x32', 'estonia.png', 'windows-1252'),
(46, 'Ewe', 'ewe', '???gb?', 'ee', 'ewe', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'ghana.png', '_admin/_design/gfx/flags/32x32', 'ghana.png', 'windows-1252'),
(47, 'Faroese', 'faroese', 'f?royskt', 'fo', 'fao', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'faroe_islands.png', '_admin/_design/gfx/flags/32x32', 'faroe_islands.png', 'windows-1252'),
(48, 'Fijian', 'fijian', 'vosa Vakaviti', 'fj', 'fij', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'fiji.png', '_admin/_design/gfx/flags/32x32', 'fiji.png', 'windows-1252'),
(49, 'Finnish', 'finnish', 'suomi, suomen kieli', 'fi', 'fin', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'finland.png', '_admin/_design/gfx/flags/32x32', 'finland.png', 'windows-1252'),
(50, 'French', 'french', 'fran?ais, langue fran?aise', 'fr', 'fre/fra', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'france.png', '_admin/_design/gfx/flags/32x32', 'france.png', 'windows-1252'),
(51, 'Fulah', 'fulah', 'Fulfulde, Pulaar, Pular', 'ff', 'ful', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'mauritania.png', '_admin/_design/gfx/flags/32x32', 'mauritania.png', 'windows-1252'),
(52, 'Galician', 'galician', 'Galego', 'gl', 'glg', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'galicia.png', '_admin/_design/gfx/flags/32x32', 'galicia.png', 'windows-1252'),
(53, 'Ganda', 'ganda', 'Luganda', 'lg', 'lug', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'uganda.png', '_admin/_design/gfx/flags/32x32', 'uganda.png', 'windows-1252'),
(54, 'Georgian', 'georgian', '??????? ??? (kartuli ena)', 'ka', 'geo/kat', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'georgia.png', '_admin/_design/gfx/flags/32x32', 'georgia.png', 'windows-1252'),
(55, 'German', 'german', 'Deutsch', 'de', 'ger/deu', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'germany.png', '_admin/_design/gfx/flags/32x32', 'germany.png', 'windows-1252'),
(56, 'Greenlandic, Kalaallisut', 'greenlandic__kalaallisut', 'kalaallisut, kalaallit oqaasii', 'kl', 'kal', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'greenland.png', '_admin/_design/gfx/flags/32x32', 'greenland.png', 'windows-1252'),
(57, 'Guarani', 'guarani', 'Ava?e?', 'gn', 'grn', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'argentina.png', '_admin/_design/gfx/flags/32x32', 'argentina.png', 'windows-1252'),
(58, 'Gujarati', 'gujarati', '???????', 'gu', 'guj', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(59, 'Haitian Creole, Haitian', 'haitian_creole__haitian', 'Krey?l ayisyen', 'ht', 'hat', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'haiti.png', '_admin/_design/gfx/flags/32x32', 'haiti.png', 'windows-1252'),
(60, 'Hausa', 'hausa', 'Hausanci, ??????', 'ha', 'hau', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'benin.png', '_admin/_design/gfx/flags/32x32', 'benin.png', 'windows-1252'),
(61, 'Hebrew', 'hebrew', '????????, ?????', 'he', 'heb', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'israel.png', '_admin/_design/gfx/flags/32x32', 'israel.png', 'windows-1252'),
(62, 'Herero', 'herero', 'Otjiherero', 'hz', 'her', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'namibia.png', '_admin/_design/gfx/flags/32x32', 'namibia.png', 'windows-1252'),
(63, 'Hindi', 'hindi', '??????', 'hi', 'hin', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(64, 'Hiri Motu', 'hiri_motu', 'Hiri Motu', 'ho', 'hmo', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'papua_new_guinea.png', '_admin/_design/gfx/flags/32x32', 'papua_new_guinea.png', 'windows-1252'),
(65, 'Hungarian', 'hungarian', 'magyar', 'hu', 'hun', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'hungary.png', '_admin/_design/gfx/flags/32x32', 'hungary.png', 'windows-1252'),
(66, 'Icelandic', 'icelandic', '?slenska', 'is', 'ice/isl', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'iceland.png', '_admin/_design/gfx/flags/32x32', 'iceland.png', 'windows-1252'),
(67, 'Ido', 'ido', 'Ido', 'io', 'ido', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'germany.png', '_admin/_design/gfx/flags/32x32', 'germany.png', 'windows-1252'),
(68, 'Igbo', 'igbo', 'Igbo', 'ig', 'ibo', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'nigeria.png', '_admin/_design/gfx/flags/32x32', 'nigeria.png', 'windows-1252'),
(69, 'Indonesian', 'indonesian', 'Bahasa Indonesia', 'id', 'ind', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'indonesia.png', '_admin/_design/gfx/flags/32x32', 'indonesia.png', 'windows-1252'),
(70, 'Interlingua', 'interlingua_international_auxiliary_language_association', 'interlingua', 'ia', 'ina', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'france.png', '_admin/_design/gfx/flags/32x32', 'france.png', 'windows-1252'),
(71, 'Interlingue, Occidental', 'interlingue__occidental', 'Interlingue', 'ie', 'ile', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'germany.png', '_admin/_design/gfx/flags/32x32', 'germany.png', 'windows-1252'),
(72, 'Inuktitut', 'inuktitut', '??????', 'iu', 'iku', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'canada.png', '_admin/_design/gfx/flags/32x32', 'canada.png', 'windows-1252'),
(73, 'Inupiaq', 'inupiaq', 'I?upiaq, I?upiatun', 'ik', 'ipk', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'united_states.png', '_admin/_design/gfx/flags/32x32', 'united_states.png', 'windows-1252'),
(74, 'Irish', 'irish', 'Gaeilge', 'ga', 'gle', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'ireland.png', '_admin/_design/gfx/flags/32x32', 'ireland.png', 'windows-1252'),
(75, 'Italian', 'italian', 'italiano', 'it', 'ita', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'italy.png', '_admin/_design/gfx/flags/32x32', 'italy.png', 'windows-1252'),
(76, 'Japanese', 'japanese', '??? (????)', 'ja', 'jpn', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'japan.png', '_admin/_design/gfx/flags/32x32', 'japan.png', 'windows-1252'),
(77, 'Javanese', 'javanese', 'basa Jawa (????)', 'jv', 'jav', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'indonesia.png', '_admin/_design/gfx/flags/32x32', 'indonesia.png', 'windows-1252'),
(78, 'Kannada', 'kannada', '?????', 'kn', 'kan', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(79, 'Kanuri', 'kanuri', 'macrolanguage', 'kr', 'kau', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'niger.png', '_admin/_design/gfx/flags/32x32', 'niger.png', 'windows-1252'),
(80, 'Kashmiri', 'kashmiri', '?????, ?????', 'ks', 'kas', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(81, 'Kazakh', 'kazakh', '????? ????', 'kk', 'kaz', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'kazakhstan.png', '_admin/_design/gfx/flags/32x32', 'kazakhstan.png', 'windows-1252'),
(82, 'Kikuyu, Gikuyu', 'kikuyu__gikuyu', 'Gikuyu', 'ki', 'kik', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'kenya.png', '_admin/_design/gfx/flags/32x32', 'kenya.png', 'windows-1252'),
(83, 'Kinyarwanda', 'kinyarwanda', 'Ikinyarwanda', 'rw', 'kin', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'rwanda.png', '_admin/_design/gfx/flags/32x32', 'rwanda.png', 'windows-1252'),
(84, 'Kirghiz, Kyrgyz', 'kirghiz__kyrgyz', '?????? ????', 'ky', 'kir', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'kyrgyzstan.png', '_admin/_design/gfx/flags/32x32', 'kyrgyzstan.png', 'windows-1252'),
(85, 'Komi', 'komi', '???? ???', 'kv', 'kom', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'russian_federation.png', '_admin/_design/gfx/flags/32x32', 'russian_federation.png', 'windows-1252'),
(86, 'Kongo', 'kongo', 'Kikongo', 'kg', 'kon', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'republic_of_the_congo.png', '_admin/_design/gfx/flags/32x32', 'republic_of_the_congo.png', 'windows-1252'),
(87, 'Korean', 'korean', '??? (???), ??? (???)', 'ko', 'kor', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'korea__republic_of.png', '_admin/_design/gfx/flags/32x32', 'korea__republic_of.png', 'windows-1252'),
(88, 'Kuanyama, Kwanyama', 'kuanyama__kwanyama', '', 'kj', 'kua', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'namibia.png', '_admin/_design/gfx/flags/32x32', 'namibia.png', 'windows-1252'),
(89, 'Kurdish', 'kurdish', 'Kurd?', 'ku', 'kur', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'turkey.png', '_admin/_design/gfx/flags/32x32', 'turkey.png', 'windows-1252'),
(90, 'Lao', 'lao', '???????', 'lo', 'lao', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'laos.png', '_admin/_design/gfx/flags/32x32', 'laos.png', 'windows-1252'),
(91, 'Latin', 'latin', 'latine, lingua Latina', 'la', 'lat', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'vatican_city.png', '_admin/_design/gfx/flags/32x32', 'vatican_city.png', 'windows-1252'),
(92, 'Latvian', 'latvian', 'latvie?u valoda', 'lv', 'lav', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'latvia.png', '_admin/_design/gfx/flags/32x32', 'latvia.png', 'windows-1252'),
(93, 'Limburgish, Limburger, Limburgan', 'limburgish__limburger__limburgan', 'Limburgs', 'li', 'lim', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'netherlands.png', '_admin/_design/gfx/flags/32x32', 'netherlands.png', 'windows-1252'),
(94, 'Lingala', 'lingala', 'lingala', 'ln', 'lin', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'congo__the_democratic_republic_of_the.png', '_admin/_design/gfx/flags/32x32', 'congo__the_democratic_republic_of_the.png', 'windows-1252'),
(95, 'Lithuanian', 'lithuanian', 'lietuviu kalba', 'lt', 'lit', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'lithuania.png', '_admin/_design/gfx/flags/32x32', 'lithuania.png', 'windows-1252'),
(96, 'Luba-Katanga', 'luba-katanga', '', 'lu', 'lub', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'congo__the_democratic_republic_of_the.png', '_admin/_design/gfx/flags/32x32', 'congo__the_democratic_republic_of_the.png', 'windows-1252'),
(97, 'Luxembourgish, Letzeburgesch', 'luxembourgish__letzeburgesch', 'L?tzebuergesch', 'lb', 'ltz', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'luxembourg.png', '_admin/_design/gfx/flags/32x32', 'luxembourg.png', 'windows-1252'),
(98, 'Macedonian', 'macedonian', '?????????? ?????', 'mk', 'mac/mkd', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'republic_of_macedonia.png', '_admin/_design/gfx/flags/32x32', 'republic_of_macedonia.png', 'windows-1252'),
(99, 'Malagasy', 'malagasy', 'Malagasy fiteny', 'mg', 'mlg', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'madagascar.png', '_admin/_design/gfx/flags/32x32', 'madagascar.png', 'windows-1252'),
(100, 'Malayalam', 'malayalam', '??????', 'ml', 'mal', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(101, 'Malay', 'malay', 'bahasa Melayu, ???? ?????', 'ms', 'may/msa', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'malaysia.png', '_admin/_design/gfx/flags/32x32', 'malaysia.png', 'windows-1252'),
(102, 'Maltese', 'maltese', 'Malti', 'mt', 'mlt', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'malta.png', '_admin/_design/gfx/flags/32x32', 'malta.png', 'windows-1252'),
(103, 'Manx', 'manx', 'Gaelg, Manninagh', 'gv', 'glv', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'isle_of_man.png', '_admin/_design/gfx/flags/32x32', 'isle_of_man.png', 'windows-1252'),
(104, 'Maori', 'maori', 'te reo Maori', 'mi', 'maomri', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'new_zealand.png', '_admin/_design/gfx/flags/32x32', 'new_zealand.png', 'windows-1252'),
(105, 'Marathi', 'marathi', '?????', 'mr', 'mar', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(106, 'Marshallese', 'marshallese', 'Kajin Majel', 'mh', 'mah', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'marshall_islands.png', '_admin/_design/gfx/flags/32x32', 'marshall_islands.png', 'windows-1252'),
(107, 'Modern Greek', 'modern_greek_1453', '', 'el', 'greell', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'greece.png', '_admin/_design/gfx/flags/32x32', 'greece.png', 'windows-1252'),
(108, 'Mongolian', 'mongolian', '', 'mn', 'mon', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'mongolia.png', '_admin/_design/gfx/flags/32x32', 'mongolia.png', 'windows-1252'),
(109, 'Nauruan', 'nauruan', 'Ekakairu Naoero', 'na', 'nau', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'nauru.png', '_admin/_design/gfx/flags/32x32', 'nauru.png', 'windows-1252'),
(110, 'Navajo, Navaho', 'navajonavaho', 'Din bizaad, Dinkehj', 'nv', 'nav', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'united_states.png', '_admin/_design/gfx/flags/32x32', 'united_states.png', 'windows-1252'),
(111, 'Ndonga', 'ndonga', 'Owambo', 'ng', 'ndo', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'namibia.png', '_admin/_design/gfx/flags/32x32', 'namibia.png', 'windows-1252'),
(112, 'Nepali', 'nepali', '', 'ne', 'nep', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'nepal.png', '_admin/_design/gfx/flags/32x32', 'nepal.png', 'windows-1252'),
(113, 'Northern Ndebele', 'northern_ndebele', 'isiNdebele', 'nd', 'nde', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'zimbabwe.png', '_admin/_design/gfx/flags/32x32', 'zimbabwe.png', 'windows-1252'),
(114, 'Northern Sami', 'northern_sami', 'sami, samegiella', 'se', 'sme', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'northern_sami.png', '_admin/_design/gfx/flags/32x32', 'northern_sami.png', 'windows-1252'),
(115, 'Norwegian Bokm&aring;l', 'norwegian_bokmaal', 'bokmal', 'nb', 'nob', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'norway.png', '_admin/_design/gfx/flags/32x32', 'norway.png', 'windows-1252'),
(116, 'Norwegian Nynorsk', 'norwegian_nynorsk', 'nynorsk', 'nn', 'nno', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'norway.png', '_admin/_design/gfx/flags/32x32', 'norway.png', 'windows-1252'),
(117, 'Norwegian', 'norwegian', 'norsk', 'no', 'nor', 'nb', 'nn', '_admin/_design/gfx/flags/16x16', 'norway.png', '_admin/_design/gfx/flags/32x32', 'norway.png', 'windows-1252'),
(118, 'Occitan', 'occitan_1500', 'Occitan', 'oc', 'oci', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'france.png', '_admin/_design/gfx/flags/32x32', 'france.png', 'windows-1252'),
(119, 'Ojibwa', 'ojibwa', 'Anishinaabemowin', 'oj', 'oji', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'canada.png', '_admin/_design/gfx/flags/32x32', 'canada.png', 'windows-1252'),
(120, 'Oriya', 'oriya', '', 'or', 'ori', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(121, 'Oromo', 'oromo', 'Afaan Oromoo', 'om', 'orm', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'ethiopia.png', '_admin/_design/gfx/flags/32x32', 'ethiopia.png', 'windows-1252'),
(122, 'Ossetian, Ossetic', 'ossetian ossetic', '', 'os', 'oss', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'russian_federation.png', '_admin/_design/gfx/flags/32x32', 'russian_federation.png', 'windows-1252'),
(123, 'Pali', 'pali', '', 'pi', 'pli', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'cambodia.png', '_admin/_design/gfx/flags/32x32', 'cambodia.png', 'windows-1252'),
(124, 'Pashto language, Pashto', 'pashto_language__pashto', '????', 'ps', 'pus', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'afghanistan.png', '_admin/_design/gfx/flags/32x32', 'afghanistan.png', 'windows-1252'),
(125, 'Persian', 'persian', '?????', 'fa', 'per/fas', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'iran__islamic_republic_of.png', '_admin/_design/gfx/flags/32x32', 'iran__islamic_republic_of.png', 'windows-1252'),
(126, 'Polish', 'polish', 'polski', 'pl', 'pol', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'poland.png', '_admin/_design/gfx/flags/32x32', 'poland.png', 'windows-1252'),
(127, 'Portuguese', 'portuguese', 'portugu?s', 'pt', 'por', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'portugal.png', '_admin/_design/gfx/flags/32x32', 'portugal.png', 'windows-1252'),
(128, 'Punjabi, Panjabi', 'punjabi__panjabi', '??????, ??????', 'pa', 'pan', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(129, 'Quechua', 'quechua', 'Runa Simi, Kichwa', 'qu', 'que', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'peru.png', '_admin/_design/gfx/flags/32x32', 'peru.png', 'windows-1252'),
(130, 'Romanian', 'romanian', 'rom?na', 'ro', 'rum/ron', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'romania.png', '_admin/_design/gfx/flags/32x32', 'romania.png', 'windows-1252'),
(131, 'Romansh', 'romansh', 'rumantsch grischun', 'rm', 'roh', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'switzerland.png', '_admin/_design/gfx/flags/32x32', 'switzerland.png', 'windows-1252'),
(132, 'Rundi', 'rundi', 'Rundi', 'rn', 'run', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'burundi.png', '_admin/_design/gfx/flags/32x32', 'burundi.png', 'windows-1252'),
(133, 'Russian', 'russian', '??????? ????', 'ru', 'rus', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'russian_federation.png', '_admin/_design/gfx/flags/32x32', 'russian_federation.png', 'windows-1252'),
(134, 'Samoan', 'samoan', 'gagana faa Samoa', 'sm', 'smo', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'samoa.png', '_admin/_design/gfx/flags/32x32', 'samoa.png', 'windows-1252'),
(135, 'Sango', 'sango', 'y?ng? t? s?ng?', 'sg', 'sag', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'chad.png', '_admin/_design/gfx/flags/32x32', 'chad.png', 'windows-1252'),
(136, 'Sanskrit', 'sanskrit', '?????????', 'sa', 'san', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(137, 'Sardinian', 'sardinian', 'sardu', 'sc', 'srd', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'italy.png', '_admin/_design/gfx/flags/32x32', 'italy.png', 'windows-1252'),
(138, 'Scottish Gaelic, Gaelic', 'scottish_gaelic__gaelic', 'G?idhlig', 'gd', 'gla', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'united_kingdom.png', '_admin/_design/gfx/flags/32x32', 'united_kingdom.png', 'windows-1252'),
(139, 'Serbian', 'serbian', '?????? ?????, srpski jezik', 'sr', 'srp', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'serbia.png', '_admin/_design/gfx/flags/32x32', 'serbia.png', 'windows-1252'),
(140, 'Shona', 'shona', 'chiShona', 'sn', 'sna', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'zimbabwe.png', '_admin/_design/gfx/flags/32x32', 'zimbabwe.png', 'windows-1252'),
(141, 'Sichuan Yi, Nuosu', 'sichuan_yi__nuosu', '??', 'ii', 'iii', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'china.png', '_admin/_design/gfx/flags/32x32', 'china.png', 'windows-1252'),
(142, 'Sindhi', 'sindhi', '????? ?????, ??????', 'sd', 'snd', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'pakistan.png', '_admin/_design/gfx/flags/32x32', 'pakistan.png', 'windows-1252'),
(143, 'Sinhalese, Sinhala', 'sinhalese__sinhala', '?????', 'si', 'sin', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'sri_lanka.png', '_admin/_design/gfx/flags/32x32', 'sri_lanka.png', 'windows-1252'),
(144, 'Slovak', 'slovak', 'slovencina', 'sk', 'slo/slk', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'slovakia.png', '_admin/_design/gfx/flags/32x32', 'slovakia.png', 'windows-1252'),
(145, 'Slovenian', 'slovenian', 'sloven?cina', 'sl', 'slv', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'slovenia.png', '_admin/_design/gfx/flags/32x32', 'slovenia.png', 'windows-1252'),
(146, 'Somali', 'somali', 'Soomaaliga, af Soomaali', 'so', 'som', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'somalia.png', '_admin/_design/gfx/flags/32x32', 'somalia.png', 'windows-1252'),
(147, 'Southern Ndebele', 'southern_ndebele', 'isiNdebele', 'nr', 'nbl', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'south_africa.png', '_admin/_design/gfx/flags/32x32', 'south_africa.png', 'windows-1252'),
(148, 'Southern Sotho', 'southern_sotho', 'Sesotho', 'st', 'sot', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'lesotho.png', '_admin/_design/gfx/flags/32x32', 'lesotho.png', 'windows-1252'),
(149, 'Spanish', 'spanish', 'espanol', 'es', 'spa', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'spain.png', '_admin/_design/gfx/flags/32x32', 'spain.png', 'windows-1252'),
(150, 'Sundanese', 'sundanese', 'basa Sunda', 'su', 'sun', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'indonesia.png', '_admin/_design/gfx/flags/32x32', 'indonesia.png', 'windows-1252'),
(151, 'Swahili', 'swahili', 'Kiswahili', 'sw', 'swa', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'burundi.png', '_admin/_design/gfx/flags/32x32', 'burundi.png', 'windows-1252'),
(152, 'Swati', 'swati', 'siSwati', 'ss', 'ssw', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'swaziland.png', '_admin/_design/gfx/flags/32x32', 'swaziland.png', 'windows-1252'),
(153, 'Swedish', 'swedish', 'svenska', 'sv', 'swe', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'sweden.png', '_admin/_design/gfx/flags/32x32', 'sweden.png', 'windows-1252'),
(154, 'Tagalog', 'tagalog', 'Wikang Tagalog, ????? ??????', 'tl', 'tgl', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'philippines.png', '_admin/_design/gfx/flags/32x32', 'philippines.png', 'windows-1252'),
(155, 'Tahitian', 'tahitian', 'te reo Tahiti, te reo Maohi', 'ty', 'tah', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'french_polynesia.png', '_admin/_design/gfx/flags/32x32', 'french_polynesia.png', 'windows-1252'),
(156, 'Tajik', 'tajik', '??????, ??????', 'tg', 'tgk', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'tajikistan.png', '_admin/_design/gfx/flags/32x32', 'tajikistan.png', 'windows-1252'),
(157, 'Tamil', 'tamil', '?????', 'ta', 'tam', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(158, 'Tatar', 'tatar', '???????, tatar?a, ???????', 'tt', 'tat', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'russian_federation.png', '_admin/_design/gfx/flags/32x32', 'russian_federation.png', 'windows-1252'),
(159, 'Telugu', 'telugu', '??????', 'te', 'tel', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'india.png', '_admin/_design/gfx/flags/32x32', 'india.png', 'windows-1252'),
(160, 'Thai', 'thai', '???????', 'th', 'tha', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'thailand.png', '_admin/_design/gfx/flags/32x32', 'thailand.png', 'windows-1252'),
(161, 'Tibetan', 'tibetan', '???????', 'bo', 'tib/bod', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'china.png', '_admin/_design/gfx/flags/32x32', 'china.png', 'windows-1252'),
(162, 'Tigrinya', 'tigrinya', '????', 'ti', 'tir', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'eritrea.png', '_admin/_design/gfx/flags/32x32', 'eritrea.png', 'windows-1252'),
(163, 'Tonga (Tonga Islands)', 'tonga_tonga_islands', 'faka-Tonga', 'to', 'ton', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'tonga.png', '_admin/_design/gfx/flags/32x32', 'tonga.png', 'windows-1252'),
(164, 'Tsonga', 'tsonga', 'Xitsonga', 'ts', 'tso', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'mozambique.png', '_admin/_design/gfx/flags/32x32', 'mozambique.png', 'windows-1252'),
(165, 'Tswana', 'tswana', 'Setswana', 'tn', 'tsn', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'botswana.png', '_admin/_design/gfx/flags/32x32', 'botswana.png', 'windows-1252'),
(166, 'Turkish', 'turkish', 'T?rk?e', 'tr', 'tur', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'turkey.png', '_admin/_design/gfx/flags/32x32', 'turkey.png', 'windows-1252'),
(167, 'Turkmen', 'turkmen', '???????', 'tk', 'tuk', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'turkmenistan.png', '_admin/_design/gfx/flags/32x32', 'turkmenistan.png', 'windows-1252'),
(168, 'Twi', 'twi', '', 'tw', 'twi', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'ghana.png', '_admin/_design/gfx/flags/32x32', 'ghana.png', 'windows-1252'),
(169, 'Uighur, Uyghur', 'uighur__uyghur', 'Uy?urq?, Uygur?e, ???????', 'ug', 'uig', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'china.png', '_admin/_design/gfx/flags/32x32', 'china.png', 'windows-1252'),
(170, 'Ukrainian', 'ukrainian', '?????????? ????', 'uk', 'ukr', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'ukraine.png', '_admin/_design/gfx/flags/32x32', 'ukraine.png', 'windows-1252'),
(171, 'Urdu', 'urdu', '????', 'ur', 'urd', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'pakistan.png', '_admin/_design/gfx/flags/32x32', 'pakistan.png', 'windows-1252'),
(172, 'Uzbek', 'uzbek', 'Ozbek, ?????, ??????', 'uz', 'uzb', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'uzbekistan.png', '_admin/_design/gfx/flags/32x32', 'uzbekistan.png', 'windows-1252'),
(173, 'Venda', 'venda', 'Tshiven?a', 've', 'ven', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'south_africa.png', '_admin/_design/gfx/flags/32x32', 'south_africa.png', 'windows-1252'),
(174, 'Vietnamese', 'vietnamese', 'Ti?ng Vi?t', 'vi', 'vie', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'viet_nam.png', '_admin/_design/gfx/flags/32x32', 'viet_nam.png', 'windows-1252'),
(175, 'Volap?k', 'volap?k', 'Volap?k', 'vo', 'vol', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'germany.png', '_admin/_design/gfx/flags/32x32', 'germany.png', 'windows-1252'),
(176, 'Walloon', 'walloon', 'walon', 'wa', 'wln', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'belgium.png', '_admin/_design/gfx/flags/32x32', 'belgium.png', 'windows-1252'),
(177, 'Welsh', 'welsh', 'Cymraeg', 'cy', 'wel/cym', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'wales.png', '_admin/_design/gfx/flags/32x32', 'wales.png', 'windows-1252'),
(178, 'Western Frisian', 'western_frisian', 'frysk', 'fy', 'fry', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'netherlands.png', '_admin/_design/gfx/flags/32x32', 'netherlands.png', 'windows-1252'),
(179, 'Wolof', 'wolof', 'Wolof', 'wo', 'wol', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'senegal.png', '_admin/_design/gfx/flags/32x32', 'senegal.png', 'windows-1252'),
(180, 'Xhosa', 'xhosa', 'isiXhosa', 'xh', 'xho', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'south_africa.png', '_admin/_design/gfx/flags/32x32', 'south_africa.png', 'windows-1252'),
(181, 'Yiddish', 'yiddish', '??????', 'yi', 'yid', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'united_states.png', '_admin/_design/gfx/flags/32x32', 'united_states.png', 'windows-1252'),
(182, 'Yoruba', 'yoruba', 'Yor?b?', 'yo', 'yor', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'nigeria.png', '_admin/_design/gfx/flags/32x32', 'nigeria.png', 'windows-1252'),
(183, 'Zhuang, Chuang', 'zhuang__chuang', 'Sa? cue??, Saw cuengh', 'za', 'zha', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'china.png', '_admin/_design/gfx/flags/32x32', 'china.png', 'windows-1252'),
(184, 'Zulu', 'zulu', 'isiZulu', 'zu', 'zul', NULL, NULL, '_admin/_design/gfx/flags/16x16', 'south_africa.png', '_admin/_design/gfx/flags/32x32', 'south_africa.png', 'windows-1252')
") or die(mysqli_error($link));

} // access
?>