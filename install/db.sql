DROP TABLE actu_content;
DROP TABLE phrase_jour;
DROP TABLE actualite;
DROP TABLE produits_contenu;
DROP TABLE produits;
DROP TABLE lien_ext;
DROP TABLE revue_presse;
DROP TABLE texte;
DROP TABLE traduction;
DROP TABLE titre;
DROP TABLE livreor;
DROP TABLE voyage;
DROP TABLE planning;
DROP TABLE playlist;
DROP TABLE commentaire;
DROP TABLE tmembre_inscrit;
DROP TABLE photo;
DROP TABLE diaporama;
DROP TABLE coordonnees;
DROP TABLE compte_rendu;
DROP TABLE page;
DROP TABLE uploaded_file;
DROP TABLE lang;
DROP TABLE languages_world;
DROP TABLE countries;
DROP TABLE continent;
DROP TABLE video_link;
-- Table --
CREATE TABLE languages_world (
  id SERIAL PRIMARY KEY,
  nom_en varchar(100) NOT NULL,
  locale char(2) NOT NULL,
  nom_fr varchar(100)
);

-- languages_world --
INSERT INTO languages_world (nom_en, locale, nom_fr)VALUES( 'English', 'en', 'Anglais'),
( 'Afar', 'aa','Afar'),
( 'Abkhazian', 'ab',' Abkhaze'),
( 'Afrikaans', 'af',' Afrikaans'),   
( 'Amharic', 'am',' Amharique'),
( 'Arabic', 'ar','Arabe'),
( 'Assamese', 'as','Assamais '),
( 'Aymara', 'ay','Aymara'),
( 'Azerbaijani', 'az','Azerbaïdjanais '),
( 'Bashkir', 'ba','Bashkir'),
( 'Belarusian', 'be','Biélorusse'),
( 'Bulgarian', 'bg','Bulgare'),
( 'Bihari', 'bh','Bihari'),
( 'Bislama', 'bi','Bichlamar'),
( 'Bengali/Bangla', 'bn', 'Bengali/Bangla'),
( 'Tibetan', 'bo','Tibétain'),
( 'Breton', 'br','Breton'),
( 'Catalan', 'ca','Catalan'),
( 'Corsican', 'co','Corse'),
( 'Czech', 'cs','Tchèque'),
( 'Welsh', 'cy','Gallois'),
( 'Danish', 'da','Danois'),
( 'German', 'de','Allemand'),
( 'Bhutani', 'dz',' Dzongkha'),
( 'Greek', 'el','Grec'),
( 'Esperanto', 'eo','Esperanto'),
( 'Spanish', 'es','Espagnol'),
( 'Estonian', 'et','Estonien'),
( 'Basque', 'eu','Basque'),
( 'Persian', 'fa','Perse'),
( 'Finnish', 'fi','Finlandais'),
( 'Fiji', 'fj','Fidjien'),
( 'Faroese', 'fo',' Féroïen'),
( 'French', 'fr','Français'),
( 'Frisian', 'fy',' Frisons'),
( 'Irish', 'ga','Irlandais'),
( 'Gaelic', 'gd','Gaélique'),
( 'Galician', 'gl',' Galicien'),
( 'Guarani', 'gn',' Guarani'),
( 'Gujarati', 'gu',' Gujarati'),
( 'Hausa', 'ha','Haoussa'),
( 'Hindi', 'hi',' Hindi'),
( 'Croatian', 'hr','Croate'),
( 'Hungarian', 'hu','Hongrois'),
( 'Armenian', 'hy','Arménien'),
( 'Interlingua', 'ia',' Interlingua'),
( 'Interlingue', 'ie',' Interlingue'),
( 'Inupiak', 'ik',' Inupiaq'),
( 'Indonesian', 'in',' Indonésien'),
( 'Icelandic', 'is','Islandais'),
( 'Italian', 'it','Italien'),
( 'Hebrew', 'iw','H ébreu'),
( 'Japanese', 'ja','Japonnais'),
( 'Yiddish', 'ji','Yiddish'),
( 'Javanese', 'jw',' Javanais'),
( 'Georgian', 'ka','Géorgien'),
( 'Kazakh', 'kk',' Kazakh'),
( 'Greenlandic', 'kl','Groenlandais'),
( 'Cambodian', 'km','Cambodgien'),
( 'Kannada', 'kn',' Kannada'),
( 'Korean', 'ko','Coréen'),
( 'Kashmiri', 'ks',' Cachemiri'),
( 'Kurdish', 'ku','Kurde'),
( 'Kirghiz', 'ky',' kirghize'),
( 'Latin', 'la','Latin'),
( 'Lingala', 'ln',' Lingala'),
( 'Laothian', 'lo',' Laotien'),
( 'Lithuanian', 'lt','Lituanien'),
( 'Latvian/Lettish', 'lv','Letton'),
( 'Malagasy', 'mg',' Malgache'),
( 'Maori', 'mi',' Maori'),
( 'Macedonian', 'mk','Macédonien'),
( 'Malayalam', 'ml',' Malayalam'),
( 'Mongolian', 'mn','Mongol'),
( 'Moldavian', 'mo',' Moldave'),
( 'Marathi', 'mr',' Marathi'),
( 'Malay', 'ms','Malais'),
( 'Maltese', 'mt','Maltais'),
( 'Burmese', 'my','Birman'),
( 'Nauru', 'na',' Nauruan'),
( 'Nepali', 'ne','Népalais'),
( 'Dutch', 'nl','Hollandais'),
( 'Norwegian', 'no',' Norvégien'),
( 'Occitan', 'oc',' Occitan'),
( 'Oriya', 'om','Odia'),
( 'Punjabi', 'pa',' Pendjabi'),
( 'Polish', 'pl','Polonais'),
( 'Pashto/Pushto', 'ps','pachto'),
( 'Portuguese', 'pt','Portugais'),
( 'Quechua', 'qu',' Quechua'),
( 'Rhaeto-Romance', 'rm','Rhèto-roman'),
( 'Kirundi', 'rn',' Kirundi'),
( 'Romanian', 'ro','Roumain'),
( 'Russian', 'ru','Russe'),
( 'Kinyarwanda', 'rw',' Kinyarwanda'),
( 'Sanskrit', 'sa',' Sanskrit'),
( 'Sindhi', 'sd',' Sindhi'),
( ' Sango ', 'sg',' Sango'),
( 'Serbo-Croatian', 'sh','Serbo-croate'),
( 'Singhalese', 'si','Cingalais'),
( 'Slovak', 'sk','Slovaque'),
( 'Slovenian', 'sl',' Slovène'),
( 'Samoan', 'sm',' Samoan'),
( 'Shona', 'sn',' Shona'),
( 'Somali', 'so',' Somalien'),
( 'Albanian', 'sq','Albanais'),
( 'Serbian', 'sr','Serbe'),
( 'Siswati', 'ss',' swati'),
( 'Sesotho', 'st',' Sesotho'),
('Sundanese', 'su',' Soundanais'),
( 'Swedish', 'sv','Suédois'),
( 'Swahili', 'sw','Swahili'),
( 'Tamil', 'ta',' Tamil'),
( 'Telugu', 'te',' Télougou'),
( 'Tajik', 'tg',' Tadjik'),
( 'Thai', 'th','thaï'),
( 'Tigrinya', 'ti',' Tigrigna'),
( 'Turkmen', 'tk',' Turkmène'),
( 'Tagalog', 'tl',' Tagalog'),
( 'Setswana', 'tn',' Tswana'),
( 'Tonga', 'to','Tongien'),
( 'Turkish', 'tr','Turc'),
( 'Tsonga', 'ts',' Tsonga'),
( 'Tatar', 'tt',' Tatar'),
( 'Twi', 'tw',' Twi'),
( 'Ukrainian', 'uk',' Ukrainien'),
( 'Urdu', 'ur',' Ourdou'),
( 'Uzbek', 'uz','Ouzbek'),
( 'Vietnamese', 'vi',' Vietnamien'),
( 'Volapuk', 'vo',' Volapük'),
( 'Wolof', 'wo',' Wolof'),
( 'Xhosa', 'xh',' Xhosa'),
( 'Yoruba', 'yo',' Yoruba'),
( 'Chinese', 'zh','Chinois'),
( 'Zulu', 'zu','Zoulou');

CREATE TABLE continent (
  cont_id SERIAL PRIMARY KEY,
  cont_code char(2) UNIQUE NOT NULL,
  cont_name varchar(100)
	);
	
INSERT INTO continent (cont_code, cont_name) VALUES ('AS','Asie'),
		('EU','Europe'),
		('SA','Amérique du Sud'),
		('NA','Amérique du Nord'),
		('CA','Amérique centrale'),
		('AF','Afrique'),
		('OC','Océanie');

CREATE TABLE countries (
  id_pays SERIAL PRIMARY KEY,
  code char(2) UNIQUE NOT NULL,
  name_en varchar(100),
  name_fr varchar(100),
  code_continent integer REFERENCES continent(cont_id) NOT NULL
);

INSERT INTO countries (code, name_en, name_fr, code_continent) VALUES ('AD','Andorra','Andorre',2),
('AE','United Arab Emirates','Émirats arabes unis',1),
('AF','Afghanistan','Afghanistan',1),
('AG','Antigua and Barbuda','Antigua-et Barbuda',5),
('AI','Anguilla','Anguilla',5),
('AL','Albania','Albanie',2),
('AM','Armenia','Arménie',2),
('AO','Angola','Angola',6),
 ('AR','Argentina','Argentine',3),
('AS','American Samoa','Samoa américaine',7),
('AT','Austria','Autriche',2),
('AU','Australia','Australie',7),
('AW','Aruba','Aruba',5),
('AX','Åland Islands','Îles d''Åland',2),
('AZ','Azerbaijan','Azerbaïdjan',1),
('BA','Bosnia and Herzegovina','Bosnie-Herzégovine',2),
('BB','Barbados','Barbade',5),
('BD','Bangladesh','Bangladesh',1),
('BE','Belgium','Belgique',2),
('BF','Burkina Faso','Burkina Faso',6),
('BG','Bulgaria','Bulgarie',2),
('BH','Bahrain','Bahreïn',1),
('BI','Burundi','Burundi',6),
('BJ','Benin','Bénin',6),
('BL','Saint Barthélemy','Saint-Barthélemy',5),
('BM','Bermuda','Bermudes',5),
('BN','Brunei Darussalam','Brunei Darussalam',1),
('BO','Bolivia','Bolivie',3),
('BQ','Caribbean Netherlands ','Pays-Bas caribéens',5),
('BR','Brazil','Brésil',3),
('BS','Bahamas','Bahamas',5),
('BT','Bhutan','Bhoutan',1),
 ('BW','Botswana','Botswana',6),
('BY','Belarus','Bélarus',2),
('BZ','Belize','Belize',5),
('CA','Canada','Canada',4),
('CC','Cocos (Keeling) Islands','Îles Cocos (Keeling)',7),
('CD','Congo, Democratic Republic of','Congo, République démocratique du',6),
('CF','Central African Republic','République centrafricaine',6),
('CG','Congo','Congo',6),
('CH','Switzerland','Suisse',2),
('CI','Côte d''Ivoire','Côte d''Ivoire',6),
('CK','Cook Islands','Îles Cook',7),
('CL','Chile','Chili',3),
('CM','Cameroon','Cameroun',6),
('CN','China','Chine',1),
('CO','Colombia','Colombie',3),
('CR','Costa Rica','Costa Rica',5),
('CU','Cuba','Cuba',5),
('CV','Cape Verde','Cap-Vert',6),
('CW','Curaçao','Curaçao',5),
('CX','Christmas Island','Île Christmas',7),
('CY','Cyprus','Chypre',2),
('CZ','Czech Republic','République tchèque',2),
('DE','Germany','Allemagne',2),
('DJ','Djibouti','Djibouti',6),
('DK','Denmark','Danemark',2),
('DM','Dominica','Dominique',5),
('DO','Dominican Republic','République dominicaine',5),
('DZ','Algeria','Algérie',6),
('EC','Ecuador','Équateur',3),
('EE','Estonia','Estonie',2),
('EG','Egypt','Égypte',6),
('EH','Western Sahara','Sahara Occidental',6),
('ER','Eritrea','Érythrée',6),
('ES','Spain','Espagne',2),
('ET','Ethiopia','Éthiopie',6),
('FI','Finland','Finlande',2),
('FJ','Fiji','Fidji',7),
('FK','Falkland Islands','Îles Malouines',3),
('FM','Micronesia, Federated States of','Micronésie, États fédérés de',7),
('FO','Faroe Islands','Îles Féroé',2),
('FR','France','France',2),
('GA','Gabon','Gabon',6),
('GB','United Kingdom','Royaume-Uni',2),
('GD','Grenada','Grenade',5),
('GE','Georgia','Géorgie',2),
('GF','French Guiana','Guyane française',3),
('GG','Guernsey','Guernesey',2),
('GH','Ghana','Ghana',6),
('GI','Gibraltar','Gibraltar',2),
('GL','Greenland','Groenland',4),
('GM','Gambia','Gambie',6),
('GN','Guinea','Guinée',6),
('GP','Guadeloupe','Guadeloupe',5),
('GQ','Equatorial Guinea','Guinée équatoriale',6),
('GR','Greece','Grèce',2),
('GS','South Georgia and the South Sandwich Islands','Géorgie du Sud et les îles Sandwich du Sud',3),
('GT','Guatemala','Guatemala',5),
('GU','Guam','Guam',7),
('GW','Guinea-Bissau','Guinée-Bissau',6),
('GY','Guyana','Guyana',3),
('HK','Hong Kong','Hong Kong',1),
('HM','Heard and McDonald Islands','Îles Heard et McDonald',7),
('HN','Honduras','Honduras',5),
('HR','Croatia','Croatie',2),
('HT','Haiti','Haïti',5),
('HU','Hungary','Hongrie',2),
('ID','Indonesia','Indonésie',1),
('IE','Ireland','Irlande',2),
('IL','Israel','Israël',1),
('IM','Isle of Man','Île de Man',2),
('IN','India','Inde',1),
('IO','British Indian Ocean Territory','Territoire britannique de l''océan Indien',1),
('IQ','Iraq','Irak',1),
('IR','Iran','Iran',1),
('IS','Iceland','Islande',2),
('IT','Italy','Italie',2),
('JE','Jersey','Jersey',2),
('JM','Jamaica','Jamaïque',5),
('JO','Jordan','Jordanie',1),
('JP','Japan','Japon',1),
('KE','Kenya','Kenya',6),
('KG','Kyrgyzstan','Kirghizistan',1),
('KH','Cambodia','Cambodge',1),
('KI','Kiribati','Kiribati',7),
('KM','Comoros','Comores',6),
('KN','Saint Kitts and Nevis','Saint-Kitts-et-Nevis',5),
('KP','North Korea','Corée du Nord',1),
('KR','South Korea','Corée du Sud',1),
('KW','Kuwait','Koweït',1),
('KY','Cayman Islands','Îles Caïmans',5),
('KZ','Kazakhstan','Kazakhstan',1),
('LA','Lao People''s Democratic Republic','Laos',1),
('LB','Lebanon','Liban',1),
('LC','Saint Lucia','Sainte-Lucie',5),
('LI','Liechtenstein','Liechtenstein',2),
('LK','Sri Lanka','Sri Lanka',1),
('LR','Liberia','Libéria',6),
('LS','Lesotho','Lesotho',6),
('LT','Lithuania','Lituanie',2),
('LU','Luxembourg','Luxembourg',2),
('LV','Latvia','Lettonie',2),
('LY','Libya','Libye',6),
('MA','Morocco','Maroc',6),
('MC','Monaco','Monaco',2),
('MD','Moldova','Moldavie',2),
('ME','Montenegro','Monténégro',2),
('MF','Saint-Martin (France)','Saint-Martin (France)',5),
('MG','Madagascar','Madagascar',6),
('MH','Marshall Islands','Îles Marshall',7),
('MK','Macedonia','Macédoine',2),
('ML','Mali','Mali',6),
('MM','Myanmar','Myanmar',1),
('MN','Mongolia','Mongolie',1),
('MO','Macau','Macao',1),
('MP','Northern Mariana Islands','Mariannes du Nord',7),
('MQ','Martinique','Martinique',5),
('MR','Mauritania','Mauritanie',6),
('MS','Montserrat','Montserrat',5),
('MT','Malta','Malte',2),
('MU','Mauritius','Maurice',6),
('MV','Maldives','Maldives',1),
('MW','Malawi','Malawi',6),
('MX','Mexico','Mexique',5),
('MY','Malaysia','Malaisie',1),
('MZ','Mozambique','Mozambique',6),
('NA','Namibia','Namibie',6),
('NC','New Caledonia','Nouvelle-Calédonie',7),
('NE','Niger','Niger',6),
('NF','Norfolk Island','Île Norfolk',7),
('NG','Nigeria','Nigeria',6),
('NI','Nicaragua','Nicaragua',5),
('NL','The Netherlands','Pays-Bas',2),
('NO','Norway','Norvège',2),
('NP','Nepal','Népal',1),
('NR','Nauru','Nauru',7),
('NU','Niue','Niue',7),
('NZ','New Zealand','Nouvelle-Zélande',7),
('OM','Oman','Oman',1),
('PA','Panama','Panama',5),
('PE','Peru','Pérou',3),
('PF','French Polynesia','Polynésie française',7),
('PG','Papua New Guinea','Papouasie-Nouvelle-Guinée',7),
('PH','Philippines','Philippines',1),
('PK','Pakistan','Pakistan',1),
('PL','Poland','Pologne',2),
('PM','St. Pierre and Miquelon','Saint-Pierre-et-Miquelon',4),
('PN','Pitcairn','Pitcairn',7),
('PR','Puerto Rico','Puerto Rico',5),
('PS','Palestine, State of','Palestine',1),
('PT','Portugal','Portugal',2),
('PW','Palau','Palau',7),
('PY','Paraguay','Paraguay',3),
('QA','Qatar','Qatar',1),
('RE','Réunion','Réunion',6),
('RO','Romania','Roumanie',2),
('RS','Serbia','Serbie',2),
('RU','Russian Federation','Russie',2),
('RW','Rwanda','Rwanda',6),
('SA','Saudi Arabia','Arabie saoudite',1),
('SB','Solomon Islands','Îles Salomon',7),
('SC','Seychelles','Seychelles',6),
('SD','Sudan','Soudan',6),
('SE','Sweden','Suède',2),
('SG','Singapore','Singapour',1),
('SH','Saint Helena','Sainte-Hélène',6),
('SI','Slovenia','Slovénie',2),
('SJ','Svalbard and Jan Mayen Islands','Svalbard et île de Jan Mayen',2),
('SK','Slovakia','Slovaquie',2),
('SL','Sierra Leone','Sierra Leone',6),
('SM','San Marino','Saint-Marin',2),
('SN','Senegal','Sénégal',6),
('SO','Somalia','Somalie',6),
('SR','Suriname','Suriname',3),
('SS','South Sudan','Soudan du Sud',6),
('ST','Sao Tome and Principe','Sao Tomé-et-Principe',5),
('SV','El Salvador','El Salvador',5),
('SX','Sint Maarten (Dutch part)','Saint-Martin (Pays-Bas)',5),
('SY','Syria','Syrie',1),
('SZ','Swaziland','Swaziland',6),
('TC','Turks and Caicos Islands','Îles Turks et Caicos',5),
('TD','Chad','Tchad',6),
('TF','French Southern Territories','Terres australes françaises',2),
('TG','Togo','Togo',6),
('TH','Thailand','Thaïlande',1),
('TJ','Tajikistan','Tadjikistan',1),
('TK','Tokelau','Tokelau',7),
('TL','Timor-Leste','Timor-Leste',1),
('TM','Turkmenistan','Turkménistan',1),
('TN','Tunisia','Tunisie',6),
('TO','Tonga','Tonga',7),
('TR','Turkey','Turquie',1),
('TT','Trinidad and Tobago','Trinité-et-Tobago',5),
('TV','Tuvalu','Tuvalu',7),
('TW','Taiwan','Taïwan',1),
('TZ','Tanzania','Tanzanie',6),
('UA','Ukraine','Ukraine',2),
('UG','Uganda','Ouganda',6),
('UM','United States Minor Outlying Islands','Îles mineures éloignées des États-Unis',7),
('US','United States','États-Unis',4),
('UY','Uruguay','Uruguay',3),
('UZ','Uzbekistan','Ouzbékistan',1),
('VA','Vatican','Vatican',2),
('VC','Saint Vincent and the Grenadines','Saint-Vincent-et-les-Grenadines',5),
('VE','Venezuela','Venezuela',3),
('VG','Virgin Islands (British)','Îles Vierges britanniques',5),
('VI','Virgin Islands (U.S.)','Îles Vierges américaines',5),
('VN','Vietnam','Vietnam',1),
('VU','Vanuatu','Vanuatu',7),
('WF','Wallis and Futuna Islands','Îles Wallis-et-Futuna',7),
('WS','Samoa','Samoa',7),
('YE','Yemen','Yémen',1),
('YT','Mayotte','Mayotte',6),
('ZA','South Africa','Afrique du Sud',6),
('ZM','Zambia','Zambie',6),
('ZW','Zimbabwe','Zimbabwe',6);
-- Base de données: 'pastourebd1'
-- Base de données: 'pastourebd1'
--

-- --------------------------------------------------------
--
-- Structure de la table 'lang'
--

CREATE TABLE lang (
  lang_id SERIAL PRIMARY KEY,
  lang_code integer NOT NULL UNIQUE REFERENCES languages_world(id),
  lang_img varchar(255) NOT NULL
);

--
-- Contenu de la table 'lang'
--

INSERT INTO lang (lang_code, lang_img) VALUES
(34, 'image/lang/fr.png'),
(27, 'image/lang/es.png');

-- --------------------------------------------------------
--
-- Structure de la table 'lang'
--

CREATE TABLE page (
  page_id SERIAL PRIMARY KEY,
  page_code varchar(30)  NOT NULL UNIQUE,
  page_nom varchar(100) NOT NULL
);

INSERT INTO page (page_code, page_nom) VALUES
('danse', 'Les danses'),
('ecole', 'Ecole'),
('historique', 'Historique'),
('theatre', 'Théâtre');


CREATE TABLE phrase_jour (
	phrase_id SERIAL PRIMARY KEY,
	phrase_content text,
	phrase_lang integer NOT NULL REFERENCES lang(lang_id) ON DELETE CASCADE
);

INSERT INTO phrase_jour (phrase_lang, phrase_content) VALUES 
(1, 'Quand lo fum es per la comba, prend la forca e vai-t-en a l''ombra, quand es pel puèg, vai al suspuèg'),
(2, 'Quand lo fum es per la comba, prend la forca e vai-t-en a l''ombra, quand es pel puèg, vai al suspuèg');


--
-- Structure de la table 'actualite'
--

CREATE TABLE actualite (
  act_id SERIAL PRIMARY KEY,
  act_type varchar(30) NOT NULL UNIQUE,
  act_img varchar(255) DEFAULT NULL,
  act_nom varchar(100) NOT NULL
);

--
-- Contenu de la table 'actualite'
--

INSERT INTO actualite (act_type, act_img, act_nom) VALUES
('danse', 'image/actualite/danse.jpg', 'Danse'),
('theatre', 'image/actualite/theatre.jpg', 'Théâtre');

-- --------------------------------------------------------

--
-- Structure de la table 'actu_content'
--

CREATE TABLE actu_content (
  id SERIAL UNIQUE NOT NULL,
  lang integer NOT NULL REFERENCES lang(lang_id) ON DELETE CASCADE,
  actu integer NOT NULL REFERENCES actualite(act_id) ON DELETE CASCADE,
  content text NOT NULL,
  PRIMARY KEY(lang, actu)
);

--
-- Contenu de la table 'actu_content'
--

INSERT INTO actu_content (lang, actu, content) VALUES
(1, 1, 'AGEN D''AVEYRON le 19 déc 2015'),
(1, 2, 'NOAILHAC le 29 nov. 2015
AGEN D''AVEYRON le 19 dec. 2015
CASTELNAU DE MANDAILLES le 09 janvier 2016');

--
-- Structure de la table 'coordonnees'
--

CREATE TABLE coordonnees (
  coord_adr text,
  coord_mail varchar(100) NOT NULL,
  coord_tel varchar(10) NOT NULL,
  coord_lat real NOT NULL,
  coord_long real NOT NULL,
  coord_num SERIAL PRIMARY KEY
);

--
-- Contenu de la table 'coordonnees'
--

INSERT INTO coordonnees (coord_adr, coord_mail, coord_tel, coord_lat, coord_long) VALUES
('Groupe Folklorique La Pastourelle de Rodez
Immeuble des Sociétés Musicales - Avenue de l''Europe - 12000 RODEZ ', 'pastourelle.rodez@yahoo.fr', '0565759528', 44.354018, 2.563295);

-- --------------------------------------------------------

--
-- Structure de la table 'boutique'
--

CREATE TABLE produits(
  pd_num SERIAL PRIMARY KEY,
  pd_prix real NOT NULL,
  pd_img varchar(255) UNIQUE,
  pd_nom_prive varchar(30) NOT NULL UNIQUE, 
  pd_nom_admin varchar(100) NOT NULL,
  CHECK (pd_prix > 0)
);

--
-- Contenu de la table 'boutique'
--
INSERT INTO produits (pd_prix, pd_img, pd_nom_prive, pd_nom_admin) VALUES
(10.00, 'image/boutique/48760_cd.JPG', 'cd', 'CD de musique'),
(2.00,  'image/boutique/36407_regle boutique2.jpg', 'regle', 'Règle'),
(2.00, 'image/boutique/43723_magnet pastourelle.jpg', 'magnet', 'Magnet Pastourelle'),
(2.00, 'image/boutique/45807_porte cle.jpg', 'pc', 'Porte-Clé Pastourelle'),
(3.00, 'image/boutique/40071_grosstylonoir.jpg', 'stylogros', 'Stylo gros'),
(2.00, 'image/boutique/38548_stylofin3couleurs.jpg', 'stylofin', 'Stylo fin'),
(1.00, 'image/boutique/16183_crayonpapier.jpg', 'crayon', 'Crayon à papier'),
(5.00, 'image/boutique/32532_lotstylo.jpg', 'lot', 'Lot'),
(6.00, 'image/boutique/23549_mug.jpg', 'mug', 'Mug'),
(6.00, 'image/boutique/33485_sacadosrouge.jpg', 'sac', 'Sac à dos');

CREATE TABLE produits_contenu (
  bt_num SERIAL UNIQUE NOT NULL,
  bt_lang integer NOT NULL REFERENCES lang(lang_id) ON DELETE CASCADE,
  bt_prod integer NOT NULL REFERENCES produits(pd_num) ON DELETE CASCADE,
  bt_content text,
  bt_nom_public varchar(100) NOT NULL,
  PRIMARY KEY(bt_lang, bt_prod)
);


INSERT INTO produits_contenu (bt_lang, bt_prod, bt_content,  bt_nom_public) VALUES
(2, 1, '19 titulos : musicas y cantos', 'CD de musica'),
(1, 1, '19 titres en musiques et chants au son du Rouergue', 'CD de musique'),
(2, 2, 'Regla de plastico flexible', 'Regla'),
(1, 2, 'Règle en plastique souple aux couleurs de la Pastourelle', 'Règle'),
(2, 3, null, 'Pastilla magnetica'),
(1, 3, 'Pastille aimantée', 'Magnet Pastourelle'),
(2, 4, null, 'Llavero'),
(1, 4, 'Porte-Clé aux couleurs de la Pastourelle
Une face Pastourelle, une face aux couleurs de laFrance', 'Porte-Clé Pastourelle'),
(1, 5, 'Couleurs Pastourelle', 'Stylo gros'),
(1, 6, 'Couleurs Pastourelle', 'Stylo fin'),
(1, 7, 'Blanc et noir', 'Crayon à papier'),
(1, 8, 'Un stylo fin, un stylo gros, un crayon à papier', 'Lot'),
(1, 9, null, 'Mug'),
(1, 10, 'Sac en tissu.  Existe en deux couleurs : rouge et blanc - noir et blanc', 'Sac à dos');

-- --------------------------------------------------------

--
-- Structure de la table 'user'
--

CREATE TABLE tmembre_inscrit (
  id_membre SERIAL PRIMARY KEY,
  pseudo varchar(30) NOT NULL,
  pass_secure varchar(255) NOT NULL,
  niveau integer NOT NULL CHECK (niveau IN (0, 1)),
  email varchar(100) DEFAULT NULL,
  etat_validation integer NOT NULL CHECK (etat_validation IN (0,1)),
  telephone varchar(10) DEFAULT NULL,
  nom varchar(50) NOT NULL,
  prenom varchar(50) NOT NULL,
  adresse text NOT NULL,
  etat_annuaire integer NOT NULL CHECK (etat_annuaire IN (0,1)),
  UNIQUE(pseudo, email)
);

--
-- Contenu de la table 'user'
--

INSERT INTO tmembre_inscrit ( pseudo, pass_secure, niveau, email, etat_validation, telephone, nom, prenom, adresse, etat_annuaire) VALUES
( 'admin', '04f9835b456c8f5b42ad3611f1a8f68cbd09ddf9', 1, 'toto@hotmail.fr', 1, '0000000000', 'Fraysse', 'Toto', '10 rue de l''Aligot 12000 RODEZ', 1);

--
-- Structure de la table 'photo'
--

CREATE TABLE photo (
  id_photo SERIAL PRIMARY KEY,
  adr_photo varchar(255) NOT NULL UNIQUE,
  date_photo timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  description text DEFAULT NULL
);

--
-- Contenu de la table 'photo'
--

INSERT INTO photo (adr_photo, date_photo) VALUES
('image/blog/19492_DSCF8049.JPG', '2015-04-01 22:20:08');

--
-- Structure de la table 'commentaire'
--

CREATE TABLE commentaire (
  id_commentaire SERIAL PRIMARY KEY,
  texte text NOT NULL,
  num_photo integer NOT NULL REFERENCES photo(id_photo) ON DELETE CASCADE,
  auteur integer NOT NULL REFERENCES tmembre_inscrit(id_membre) ON DELETE CASCADE
);

--
-- Contenu de la table 'commentaire'
--

INSERT INTO commentaire (texte, num_photo, auteur) VALUES
('sample', 1, 1);


-- --------------------------------------------------------

--
-- Structure de la table 'diaporama'
--

CREATE TABLE diaporama (
  diapo_id SERIAL PRIMARY KEY,
  diapo_lien varchar(255)  NOT NULL UNIQUE,
  diapo_active char(1) NOT NULL CHECK (diapo_active IN ('A','F'))
);

--
-- Contenu de la table 'diaporama'
--

INSERT INTO diaporama (diapo_lien, diapo_active) VALUES
('diaporama/marche rodez.jpg', 'A'),
('diaporama/Photo Pastourelle Pontivy.jpg', 'A'),
('diaporama/ffir4 2012.jpg', 'A'),
('diaporama/f-te-des-brayauds-ch-telguyon_1141716.jpeg', 'A'),
('diaporama/ambert.jpg', 'A'),
('diaporama/begaar 096.jpg', 'A'),
('diaporama/crouzade 2013.jpeg', 'A'),
('diaporama/FFIR 2012 .jpg', 'A'),
('diaporama/perou.jpg', 'A'),
('diaporama/pastourelle3_mars_2015.jpg', 'A'),
('diaporama/olympia3.jpg', 'A'),
('diaporama/olympia8.jpg', 'A'),
('diaporama/olympia9.jpg', 'A'),
('diaporama/musee-soulages-rodez.jpg', 'A');

-- --------------------------------------------------------

--
-- Structure de la table 'image'
--

CREATE TABLE uploaded_file (
  file_num SERIAL PRIMARY KEY ,
  file_adr varchar(255) NOT NULL UNIQUE
);

--
-- Contenu de la table 'image'
--

INSERT INTO uploaded_file (file_adr) VALUES
('image/danse1.jpg'),
('image/ecole1.jpg'),
('image/histo1.jpg'),
('image/theatre1.jpg'),
('image/danse2.jpg'),
('image/ecole2.jpg'),
('image/histo2.jpg'),
('image/theatre2.jpg'),
('image/danse3.jpg'),
('image/ecole3.jpg'),
('image/histo3.jpg'),
('image/theatre3.jpg'),
('image/danse4.jpg'),
('image/ecole4.jpg'),
('image/histo4.jpg'),
('image/theatre4.jpg'),
('image/danse5.jpg'),
('image/histo5.jpg'),
('image/theatre5.jpg'),
('image/danse6.jpg'),
('image/theatre6.jpg'),
('image/185-441-SA.jpg'),
('image/193-425-SA.jpg'),
('image/199-542-SA.jpg'),
('image/206-773-EU.jpg'),
('image/215-768-EU.jpg'),
('image/225-527-EU.jpg'),
('image/234-525-EU.jpg'),
('image/240-513-EU.jpg'),
('image/263-560-SA.jpg'),
('image/266-445-SA.jpg'),
('image/294-646-EU.jpg'),
('image/301-534-EU.jpg'),
('image/303-538-EU.jpg'),
('image/303-573-EU.jpg'),
('image/311-535-EU.jpg'),
('image/320-530-EU.jpg'),
('image/425-88-SA.jpg'),
('image/445-100-SA.jpg'),
('image/452-529-EU.jpg'),
('image/455-560-EU.jpg'),
('image/461-810-EU.jpg'),
('image/472-529-EU.jpg'),
('image/475-557-EU.jpg'),
('image/481-806-EU.jpg'),
('image/527-554-EU.jpg'),
('image/531-538-EU.jpg'),
('image/537-535-EU.jpg'),
('image/583-526-EU.jpg'),
('image/615-778-EU.jpg'),
('image/640-778-EU.jpg'),
('image/744-782-EU.jpg'),
('image/759-535-AS.jpg'),
('image/764-782-EU.jpg'),
('image/768-690-AS.jpg'),
('image/780-766-EU.jpg');
-- --------------------------------------------------------


-- --------------------------------------------------------

CREATE TABLE lien_ext(
  lien_num SERIAL PRIMARY KEY,
  lien_url varchar(255) NOT NULL UNIQUE,
  lien_img varchar(255) UNIQUE,
  lien_nom varchar(100) NOT NULL
);

--
-- Contenu de la table 'boutique'
--
INSERT INTO lien_ext(lien_url, lien_img, lien_nom) VALUES
('http://www.grand-rodez.com/', 'image/lien/10876_logo grand rodez.jpg', 'Le Grand Rodez'),
('http://www.hotel-les-peyrieres.com/',  'image/lien/20772_les peyrieres.jpg','Hotel Les Peyrières'),
('http://www.festival-rouergue.com/', 'image/lien/43828_FFIR.jpg', 'F.F.I.R'),
('http://www.fatp-cmc.com/intro.html', 'image/lien/29402_FATPCMF.jpg',  'FATP-CMC'),
('http://www.iut-rodez.fr/', 'image/lien/20352_logo iut.jpg', 'IUT Rodez'),
('http://www.sylviepulles.com/', 'image/lien/27297_sylvie-pulles_zf9.jpg', 'Sylvie Pulles'),
('http://www.mairie-rodez.fr/', 'image/lien/37221_logoRodez.gif', 'Mairie de Rodez');
-- --------------------------------------------------------

--
-- Structure de la table 'livreor'
--

CREATE TABLE livreor (
  id SERIAL PRIMARY KEY,
  "date" date NOT NULL,
  nom varchar(50) NOT NULL,
  message text NOT NULL,
  validation integer NOT NULL CHECK (validation IN (0,1))
);

--
-- Contenu de la table 'livreor'
--

INSERT INTO livreor ("date", nom, message, validation) VALUES
('2014-08-24', 'serraillon', 'Bravo pour votre site web et merci ! Contactez moi pour plus d''infos : ', 1);

-- --------------------------------------------------------

--
-- Structure de la table 'voyage'
--

CREATE TABLE voyage (
  id_voy SERIAL PRIMARY KEY,
  pays integer NOT NULL REFERENCES countries(id_pays),
  titre varchar(100) NOT NULL,
  texte text
);

--
-- Contenu de la table 'voyage'
--

INSERT INTO voyage (pays,  titre, texte) VALUES
 (73, 'ST ARNOULD  (juillet 2011)', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/234-525-EU.jpg&#34; alt=&#34;Image St Arnould&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;F&#38;ecirc;tes de Noyal Pontivy&#60;br /&#62; Chapelle de St ARNOULD&#60;/p&#62;'),
 (73, 'ST MALO (2009)', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/240-513-EU.jpg&#34; alt=&#34;Image St Malo&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;'),
 (223, 'IZMIR   - Turquie ', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/744-782-EU.jpg&#34; alt=&#34;Image de Izmir&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;Voyage du 19 au 20 mai 1990&#60;/p&#62;'),
 (73, 'PARIS - 1996', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/301-534-EU.jpg&#34; alt=&#34;Image Paris 1996&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;Participation &#38;agrave; l&#39;&#38;eacute;mission LA CHANCE AUX CHANSONS&#60;/p&#62;'),
 (73, 'PARIS - 1995', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/320-530-EU.jpg&#34; alt=&#34;Image de Paris 1995&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;Participation &#38;agrave; l&#39;&#38;eacute;mission COUCOU C&#39;EST NOUS&#60;br /&#62; avec Christophe DECHAVANNE et Patrice CARMOUZE&#60;/p&#62;'),
 (73, 'TOULOUSE', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/294-646-EU.jpg&#34; alt=&#34;Image de Toulouse&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;Animation du March&#38;eacute; de pays Aveyronnais le 21 mars 2009&#60;/p&#62;'),
 (66, 'MURCIA', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/215-768-EU.jpg&#34; alt=&#34;Image de Murcia&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;Ao&#38;ucirc;t 1996&#60;/p&#62;'),
 (108, 'MARSALA - Sicile', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/481-806-EU.jpg&#34; alt=&#34;Image de Marsala&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;Voyage du 18 au 28 juillet 1986&#60;/p&#62;'),
 (55, 'BAMBERG (juillet 2010)', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/472-529-EU.jpg&#34; alt=&#34;Image de Bamberg&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;20 ans du jumelage Rodez - Bamberg&#60;/p&#62;'),
 (55, 'MUNICH - Allemagne', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/475-557-EU.jpg&#34; alt=&#34;Image de la f&#38;ecirc;te de la bi&#38;egrave;re&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;F&#38;ecirc;te de la bi&#38;egrave;re - septembre 1997&#60;/p&#62;'),
 (54, 'BRNO - République Tchèque', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/527-554-EU.jpg&#34; alt=&#34;Image de BRNO&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;Voyage en Tch&#38;egrave;quie en septembre 1993&#60;/p&#62;'),
 (177, 'ZAKOPANE - Pologne', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/583-526-EU.jpg&#34; alt=&#34;Image de Zakopane&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;Festival Folklorique International de Zakopane&#60;br /&#62; du 30 ao&#38;ucirc;t au 10 septembre 1985&#60;/p&#62;'),
 (120, 'COREE DU SUD (Sept.1998)', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/759-535-AS.jpg&#34; alt=&#34;Image de Cor&#38;eacute;e du Sud&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;'),
 (87, 'ILE DE LEFKAS - Grêce', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/615-778-EU.jpg&#34; alt=&#34;Image de l&#39;&#38;iuml;le de Lefkas&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;Voyage du 16 au 26 ao&#38;ucirc;t 87&#60;/p&#62;'),
 (73, 'MARTINIQUE - Mai 1999', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/445-100-SA.jpg&#34; alt=&#34;Image de la Martinique&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;'),
 (172, 'LIMA (mars 2011)', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/199-542-SA.jpg&#34; alt=&#34;Image de Lima&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;&#13;&#10;&#60;p style=&#34;text-align: center;&#34;&#62;Visite d&#39;un orphelinat&#60;/p&#62;'),
 (172, 'Macchu Pichu (mars 2011)', '&#60;p&#62;&#60;img style=&#34;display: block; margin-left: auto; margin-right: auto;&#34; src=&#34;image/263-560-SA.jpg&#34; alt=&#34;Image Macchu Pichu&#34; width=&#34;500&#34; height=&#34;400&#34; /&#62;&#60;/p&#62;');


-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Structure de la table 'planning'
--

CREATE TABLE planning (
  id_planning SERIAL PRIMARY KEY,
  pl_jour varchar(10) NOT NULL,
  pl_date date NOT NULL,
  pl_lieu varchar(100) NOT NULL,
  pl_musiciens varchar(150) NOT NULL
);

--
-- Contenu de la table 'planning'
--

INSERT INTO planning (pl_jour, pl_date, pl_lieu, pl_musiciens) VALUES
('Dimanche', '2014-04-18', 'REQUISTA Danses et Théâtre', '-----------------------'),
('Samedi', '2015-10-24', 'Répétition', 'Joël et Michel POUGET'),
('Dimanche', '2015-10-25', 'THEGRA (Padirac) Danses', '--------------------------'),
('Dimanche', '2015-11-08', 'Assemblée Générale', '----------------'),
('Mardi', '2015-11-10', 'Répétition Nuit Rouergate', '---------------------'),
('Samedi', '2015-11-14', 'Nuit Rouergate', '-------------------'),
('Samedi', '2015-11-28', 'Répétition avec ados', '?'),
('Samedi', '2015-12-12', 'Répétition', 'Guillaume et Zoé'),
( 'Samedi', '2015-12-19', 'D et T à AGEN D''AVEYRON', '-------------------------'),
('Samedi', '2016-01-09', 'Répétition avec ados', 'Didier et Michel POUGET'),
( 'Samedi', '2016-01-23', 'Répétition', 'Joël et Claude'),
('Samedi', '2016-03-19', 'Théâtre à CAMJAC', '-----------------');
-- --------------------------------------------------------

--
-- Structure de la table 'playlist'
--

CREATE TABLE playlist (
  music_id SERIAL PRIMARY KEY,
  music_lien varchar(255)  NOT NULL UNIQUE,
  music_nom varchar(100)  NOT NULL,
  music_active char(1)  NOT NULL CHECK (music_active IN ('A','F')),
  music_groupe varchar(100) DEFAULT NULL,
  UNIQUE (music_lien)
);
--
-- Contenu de la table 'playlist'
--

INSERT INTO playlist (music_lien, music_nom, music_active, music_groupe) VALUES
( 'musics/01 - Touredjaire - Pasudo.mp3', '01-Tournedjaire-Pasudo', 'A', 'Pastourelle'),
( 'musics/03 - Artiste inconnu - Titre inconnu.mp3', '03-Pot pourri de bourrees', 'A', ''),
( 'musics/04 - Artiste inconnu - Titre inconnu.mp3', '04-Pot pourri de branlous', 'A', ''),
( 'musics/05 - Artiste inconnu - Titre inconnu.mp3', '05-Regret de Lisou', 'A', ''),
( 'musics/06 - Artiste inconnu - Titre inconnu.mp3', '06- La Pradinoise', 'A', ''),
( 'musics/07 - Artiste inconnu - Titre inconnu.mp3', '07-Vieilles marches', 'A', ''),
( 'musics/08 - Artiste inconnu - Titre inconnu.mp3', '08-Le pont de Mirabel', 'A', ''),
( 'musics/09 - Artiste inconnu - Titre inconnu.mp3', '09-Aben un gal - La roda', 'A', ''),
( 'musics/10 - Artiste inconnu - Titre inconnu.mp3', '10-Los esclops', 'A', ''),
( 'musics/11 - Artiste inconnu - Titre inconnu.mp3', '11-Pot pourri de marches', 'A', ''),
( 'musics/12 - Artiste inconnu - Titre inconnu.mp3', '12-Bourree des genets-Bourree del pastre', 'A', ''),
( 'musics/13 - Artiste inconnu - Titre inconnu.mp3', '13-Pot pourri de scottischs', 'A', ''),
( 'musics/14 - Artiste inconnu - Titre inconnu.mp3', '14-Nadal del Rouergue (regrets)', 'A', ''),
( 'musics/15 - Artiste inconnu - Titre inconnu.mp3', '15-Cantalese-Pourtatz Chaupina (bourree)', 'A', ''),
( 'musics/16 - Artiste inconnu - Titre inconnu.mp3', '16-Polkas', 'A', ''),
( 'musics/17 - Artiste inconnu - Titre inconnu.mp3', '17-Lo bel fraire (conte)', 'A', ''),
( 'musics/18 - Artiste inconnu - Titre inconnu.mp3', '18-Los ventres negres- Belle bergere (valses)', 'A', ''),
( 'musics/19 - Artiste inconnu - Titre inconnu.mp3', '19-La crozado', 'A', ''),
( 'musics/02-Valses.mp3', '02 - Valses.mp3', 'A', 'Pastourelle');

-- --------------------------------------------------------

--
-- Structure de la table 'revue_presse'
--

CREATE TABLE revue_presse (
  presse_num SERIAL PRIMARY KEY,
  presse_img varchar(255) NOT NULL,
  presse_titre varchar(100) NOT NULL
);


--
-- Contenu de la table 'revue_presse'
--

INSERT INTO revue_presse (presse_img, presse_titre) VALUES
( 'image/revue_presse/11665_ag pastou 03-02-14.jpeg', 'Centre Presse du 03 février 2014'),
('image/revue_presse/10446_Midi Libre 31 07 14.JPG', 'MIDI LIBRE du 31 juillet 2014'),
( 'image/revue_presse/49793_Midi Libre 02 01 15.jpg', 'MIDI LIBRE du 02 janvier 2015');
-- --------------------------------------------------------

--
-- Structure de la table 'texte'
--

CREATE TABLE texte (
    txt_num SERIAL UNIQUE NOT NULL,
  txt_page integer NOT NULL REFERENCES page(page_id) ON DELETE CASCADE,
  txt_titre varchar(100) NOT NULL,
  lang integer NOT NULL REFERENCES lang(lang_id) ON DELETE CASCADE,
  texte text NOT NULL,
  PRIMARY KEY (txt_page,lang)
);
CREATE TABLE video_link (
	vid_id SERIAL PRIMARY KEY,
	vid_url varchar(255) NOT NULL UNIQUE,
	vid_titre varchar(100) NOT NULL
);

--
-- Contenu de la table 'texte'
--

INSERT INTO texte (txt_page, lang, txt_titre, texte) VALUES
(1, 2, 'Las bailes',  'El grupo folklòrico de la Pastourelle de Rodez, fundido en 1947 por los señores Fernand BENOIT y  Edouard CHAPOT, tiene por meta, buscar y conservar todo lo que toca al folklore rouergat : mùsicas, bailes, cantos, vestidos y costumbres.

	En su repertorio, la Pastourelle comprende la mayor parte de bailes antigos del Rouergue, de los cuales ciertos entre los màs sencillos se bailan a oun en las fiestas de los pueblos : polkas, scottishs, vals y claro “la bourrée” (baile campesino tipico de los pueblos averoneses).

	Casi todos estos bailes consisten en un juego de seducciòn. El bailador sigue a la bailadora en unos movimientos rapidos y cruzados, y a veces le da la mano o la enlaza para hacer una ronda.
 Para bailar la “bourrée”, lo necesario es tener mucha agilidad, el ritmo y las sonrisas de las bailadoras a las cuales contestan los “Ohues” de los bailadores.

	Hoy dia, el grupo se compone de 44 balaidores mayors, 4 musicos y 18 niños, todos son benevoles.
	Siempre se baila el mismo ritmo en 3 tiempos, acordéon y “cabrette” les acompañan. La “cabrette” es un instrumento de musica  tipicamente regional. Esta hecha de un saco de  piel de cabra, cubierto de terciopelo. “Cabrette” quiere decir cabrita. Esta se relleña de aire, gracias a un fuelle que el cabretaire (el musico de la cabrette), mantiene bajo el brazo derecho. Con su brazo izquierdo, el mùsico comprime la entrada de aire de la cabrette. La mùsica es producida por una flauta con siete agujeros.
	Los vestidos del grupo son los que llevaban los domingos y dias de fiesta los campesinos en los años 1860-1880.
	
	Las mujeres llevan una gorrita de puntilla cubierta con un sombrero de paja. Llevan tambièn  una blusa con faldon, mangas cortas y puntilla. La falda levantada en el lado izquierdo deja aparecer las enaguas blancas
que esconden un “panty” largo. Las medias son blancas y los zapatos negros. Para terminar en las espaldas llevan un manton de puntilla fina.
	
	

	Los hombres llevan un sombrero de fieltro negro, sombrero de grandes alas. Llevan tambien una blusa negra bordada,  un pantalon de rayas en paño del pais, calcetines blancos y zapatos negros. Para acabar llevan un pañuelo de colores vivos atado en el cuello.
	
	Los vestidos de los niños son diferentes de los padres. Las mozitas llevan un lazo blanco en los cabellos, un vestido con mangas largas y un ancho cinturon botonado y anudado por detràs. El fondo del vestido lleva piegues que se sueltan a cada crecida de la jovencita. Por fin, llevan un “panty”, calcetines blancos y zapatos negros cerrados.
Los chicos llevan una blusa negra o una camisa blanca de mangas largas con un chaleco. El pantalon negro bombacho, calcetines blancos  y zapatos negros.


Nuestras representaciones : 

Espectàculo de bailes (de 1 h00 à 1 h 15)
Animacion (40 minutos maximum)
Desfile
Espectàculo de bailes y teatro (de 2 h00 à 2 h 30)

Para hace un presupuesto, podeis contactarnos en la rubrica : Contact

'),
(1, 1, 'Les danses', 'Le groupe folklorique LA PASTOURELLE DE RODEZ fondé en 1947 par Messieurs Fernand BENOIT, Edouard CHAPOT et Jean GUITARD a pour but de rechercher et de conserver tout ce qui touche au folklore rouergat : musiques, chants, danses, costumes et coutumes.


«LA PASTOURELLE» a inscrit a son répertoire la plupart des vieilles danses du Rouergue dont un certain nombre parmi les plus simples sont encore pratiquées au cours des fêtes villageoises : les polkas, les scottishs, la valse vienne, les valses et bien sûr la  bourrée.


La plupart des danses effectuées consistent en un jeu de séduction où le cavalier poursuit sa cavalière dans de rapides mouvements croisés et parfois lui donne la main ou l’enlace pour un mouvement en ronde. La bourrée demande aux danseurs beaucoup de souplesse, un sens du rythme et un joli entrain par les sourires des cavalières auxquels répondent les vibrants «OHUES» des cavaliers.

A ce jour le groupe compte 44 danseurs adultes, 4 musiciens et 18 enfants,tous bénévoles.   


Toujours le même pas sur une mesure à trois temps, la danse est accompagnée de l’accordéon et de la cabrette.

La Cabrette est un instrument de musique typiquement régional. Elle est composée d’un sac fait en peau de chèvre et recouvert de velours, qui est à l’origine de son nom (cabrette : petite chèvre). Cette poche est alimentée en air par un soufflet que «le cabrétaïre» tient sous son bras droit. Par pression de son bras gauche, le musicien comprime l’entrée. Le son est produit par une flûte à sept trous.


Le costume est celui des dimanches et fêtes, porté vers 1860 – 1880.

Les femmes sont coiffées d’une bonnette en dentelle recouvert d’un chapeau de paille. Elles portent un corsage à basque, manches courtes avec dentelle. Une jupe relevée sur le côté gauche laisse entrevoir un large jupon blanc qui cache le long panty. Les bas sont blancs, les souliers noirs. Pour finir elles ont sur les épaules une pointe en fine dentelle.


Les hommes sont coiffés du chapeau de feutre noir à large bord. Ils portent une blouse noire brodée, un pantalon rayé en drap de pays, les chaussettes sont blanches et les souliers noirs. Pour finir un foulard aux couleurs vives se noue autour du cou.


Le costume des enfants est différent de celui de leurs parents.
Les jeunes filles ont un noeud blanc dans les cheveux. Elles portent une robe manches longues et une large ceinture boutonnée et nouée dans le dos. Le fond de la robe est constitué de plis qui sont lachés au fur et à mesure que l''enfant grandit.
Pour compléter la tenue, les filles mettent un panty, des chaussettes blanches et une paire de chaussures noires fermées.


Les garçons sont vêtus d''une blouse noire ou d''un gilet sur une chemise blanche à manches longues. Un pantalon noir bouffant aux genoux, des chaussettes blanches et des chaussures noires complètent le costume.






Nos prestations sont les suivantes : 

-	Spectacle danses (de 1h00 à 1h15)
-	Animation (40 min maximum)
-	Défilé
-	Spectacle danses et théâtre (de 2h00 à 2h30)

Pour une demande de devis vous pouvez nous contacter en allant à la rubrique : CONTACT – Nos coordonnées.
'),
(2, 2, 'Las escuelas', '
	La Pastourelle de Rodez, dirige dos escuelas de bailes : la escuela de los niños y la escuela para mayores.

	La escuela de niños acoje a los pequeños a los 6 años. Una hora por semana, 30 jovencitos aprenden los pasos  y despues unas “bourrées” elaboradas. Afines de año, segun los bailes aprendidos, los niños presentan un espectaculo de bailes en la Casa de la Juventud y de la Cultura de Rodez. Esta tarde tradicional acaba el año de escuela y muestra los progresos de los alumnos.
Para algunos, serà el primer contacto con la escena y sobretodo con el publico : momento importante, lleno de emociones para los niños, padres y tambien para los responsables que gozan del trabajo cumplido durante el año de escuela.
(Cursos de setiembre a junio, todos los viernes por la tarde a partir de 20 h 30) .

	El primer martes de octubre, empieza la escuela de bailes para mayores (a partir de 21 h 00 todos los martes). Jòvenes y menos j{ovenes, debutantes o confirmados, vienen para aprender los pasos bàsicos, el vals  y los numerosas “bourrées”, acompañadas por los mùsicos benévoles deseosos de compartir el mismo placer, la mùsica. La escuela de baile de los mayores està animada por unos dinamicos “Pastoureaux” siempre pendientes de transmitir los bailes, con gran respecto de la tradiciòn del folklore rouergat.
 
Para acabar comparten un momento caluroso.

'),
(3, 2, 'Historiquo', 'Por una tarde de marzo de 1947, el señor Fernand BENOIT y su amigo Edouard CHAPOT se encuentran en la plaza de la Cité en RODEZ.

	El primero le dice las ganas que tenia de fundar un grupo folklòrico en su ciudad. El señor Edouard CHAPOT se entusiasma. Estamos después de la libéraciòn de la Francia. hay que buscarlo todo, encontrar y componer para poder  crear. Poco importa, gracias al dinamismo y la voluntad de los dos amigos, se cumpliò una acciòn magistral. Por otra parte, en este momento preciso llega el tercer actor : el senõr Jean GUITARD, acordeonista de talento y apasionado de folklore.

	Fue asi como crearon el trio “B.C.G.”. Sus esposas, las senõras Mauricette CHAPOT y Huguette GUITARD, amigas desde siempre, van a menearse para contratar chicas y chicos a quienes les guste el folklore.

	Al silbar el aire de una cancion “rouergate”, apareciò como evidente el nombre del grupo, serà : “la Pastourelle de Rodez”.(Pastourelle : joven pastora en langua occitana)
 Despues de dar dos representaciones en Rodez, y una mas en un pueblo averones, los estatutos fueron depositados en la “Préfectura” en 1948.

	Asi el grupo fue reconocido oficialmente. Fue a principio de los años 1950, despues de mucha reflexion, que dieron un nuevo impulso à la Pastourelle de Rodez. En efecto, es con la llegada del señor Adrien VEZINET que nacio la seccion de teatro. Va a dirigir los bailes mientras escribe piezas teatrales con la colaboracion de los señores Henri MOULY y Jean-Marie LACOMBE.

	Apasionados de folklore y con las ganas de pasar las fronteras, el médico Jean AMANS, alcalde de PONT DE SALARS, y el señor Fernand BENOIT, van a crear en 1954, el “Festival Folklorico de Pont de Salars” que hoy dia es conocido como el Festival Folklorico Internacional del Rouergue (F.F.I.R.)

	Con sus 63 años el grupo de la Pastourelle de Rodez sigue entusiasmandose en mantener las tradiciones del Folklore y de la lengua occitana. Desde el Aubrac hasta el Larzac, desde el Quercy hasta la Lozère, sigue interesando a un publico amante de su tiera.




'),
(3, 1,'Historique',  'Un Soir de mars 1947, Monsieur Fernand BENOIT et son ami Edouard CHAPOT se rencontrent place de la Cité à RODEZ.

Le Premier fait part de son désir de fonder un groupe folklorique sur sa ville. Monsieur Edouard CHAPOT est emballé. Nous sommes au lendemain de la libération, il faut tout chercher, trouver, composer. Peu importe grâce au dynamisme et à la volonté des deux confidents ce véritable tour de maître est accompli. C’est d’ailleurs à ce moment là qu’un troisième acteur arrive à point nommé : Monsieur Jean GUITARD, accordéoniste de talent et passionné de folklore.

Ainsi fut crée le trio «B.C.G.». Ce sont leurs épouses, Mesdames Mauricette CHAPOT et Huguette GUITARD, amies d’enfance, qui vont se démener pour recruter filles et garçons passionnés de folklore.

Sifflotant l’air d’une chanson rouergate le nom du groupe est apparu comme une évidence, ce sera : LA PASTOURELLE DE RODEZ  (pastourelle : jeune bergère en occitan).

Après deux manifestations sur RODEZ et une suivante dans un village aveyronnais les statuts seront déposés en Préfecture en 1948. Le groupe est donc officiellement lancé.

C’est au début des années 1950, après mûre réflexion, qu’un nouvel élan est donné à la PASTOURELLE DE RODEZ. En effet, c’est avec l’arrivé de Monsieur Adrien VEZINET que la section théâtre voit le jour. Il va diriger les danses tout en écrivant des pièces de théâtre avec la collaboration de Messieurs Henri MOULY et Jean-Marie LACOMBE.

Poussés par l’amour  du folklore et le désir de franchir les frontières, le Docteur Jean AMANS, Maire de PONT DE SALARS, et Monsieur Fernand BENOIT, vont créer en 1954 le Festival Folklorique de PONT DE SALARS devenu aujourd’hui le Festival Folklorique International du Rouergue (F.F.I.R.).

A 63 ans d’âge la PASTOURELLE DE RODEZ a toujours autant d’enthousiasme à perpétuer les traditions du folklore et de la langue d’oc. De l’Aubrac au Larzac, du Quercy au couffin de la Lozère, elle sait toujours intéresser un public aimant son terroir.


'),
(4, 2, 'Theatro', 'La secciòn teatro cuenta una decena de actores benévoles que no son profesionales. Todas las obras son en lengua occitana.

	Desde los años 1950, diez obras constituyen el repertorio de la Pastourelle. Actualmente, cinco obras son propuestas y una sexta en preparacion :





. LA BASTARDA :

Comedia en un acto de Adrien VEZINET (1 h 30 aproximamente)

	El cuento se desarolla a principios del ùltimo siglo, en la cocina de una casa de campo, en la Gineste, propiedad de Tonéo  y de su esposa Irma.
Irma, sòlo piensa en una cosa, que su hija Luceta, debe casarse con Pierre, criado principal. Pero este, esta enamorado de Roseta, la criada, que es una bastarda.  ¡ Imagìnese cuando la madre y la hija se dan cuenta de las relaciones entre Pierre y Roseta !. ¡ Imaginese la cara de Tonéo, que sòlo piensa en hacer fructificar su finca, sin preocuparse de todo esto !... ¿ Còmo van a areglarselas el ama de casa  y su hija para levantar esta afrenta ?..


. LA SOPA D’ALHS : (Sopa de ajos)

Obra de autor desconocido y reestrenada por Jean Marie LACOMBE (1 h 30 aproximamente)

	Estamos en una casa de campo, despues de la cena, Berthe, la dueña de casa, mujer bigotuda, mangas remangadas, frega los platos en el barreño. Milien, con cara de enfermo, palido, flaco, se le ve que no esta acostumbrado a mandar sino a sufrir. Fuera, se oye en la cercania  a Gustou, el herrero, martillo en la mano, pegando en el yunque.

Vivireis las peripecias de un hombre valiente, casado con una mujer con mucho genio y particularmente avara, lo que descubireis a traves de una sopa extraña que no se parece mucho à las otras…


. VISTALHAS :
Comedia en un acto de Adrien VEZINET (1 h 20)

	La historia pasa a eso de los años 1920, en casa de Artemòn de Gisquet, rico proprietario de la finca de la Grifoliera. Su hija, Lineta, acaba de casarse con Gaston. Palmira, hermana de Artemòn, siempre a vivido en la finca. Victor, tio de Gaston empleado en la “préfectura”. Los dos han pasado ya los cuarenta años y son solteros. Lineta y Gaston, piensan en casarlos y van a obrar para acertarlo. ¿ Còmo van a hacer para que Artemòn y su esposa Justine consientan a esa union ?…Imaginese el cuadro : el marido, campesino apegado a sus costumbres y odiando a todos estos chupastintas de la cuidad, mientras que Justine siempre ha soñado ir a vivir a la ciudad.
 

. L’AUBERGE DE LAS TRES CATTOS : La posada de los tres gatas
 Obra de Jean-Marie LACOMBE (1 h 30)

	Todo pasa en una posada de uno de los pueblos del Aveyron, en los años 1920 – 1930. Las dueñas de la posada, son tres solteronas : Philomène, Julie y Marinou, llamadas “los tres cattos”, teniendo cada una su particularidad.


. LA TATA DE BORNIQUET :  La tia de Borniquet
Comedia en un acto de Henry MOULY y Adrien VEZINET (1 h 20)

	El cuento pasa en la cocina de una finca en 1900. Jeanine, hija de Borniquet, esta enamorada de Robert. Borniquet y su esposa no quieren de ese amor. ¡ Dése cuenta, Robert, sòlo un criado !..  ¿ Còmo puede esperar que los Borniquet lo quieran como yerno ?   El señor Borniquet, rico proprietario que sòlo vive por el dinero. Pero ninguno piensa en la tia que va a menearse para ayudar a los enamorados. ¿ Como va areglarselas ,lograra cambiar la situacion ? 


'),
(4, 1, 'Théâtre', 'La section théatre est composée d''une dizaine d''acteurs amateurs et bénévoles. Toutes les pièces sont jouées en langue d''Oc.

Depuis les années 1950 dix pièces constituent le répertoire de La Pastourelle. Actuellement, six pièces vous sont proposées.





- L''ESCAMPAT (Comédie en deux actes d’Henri MOULY d''Adrien VEZINET - durée : 1h40 environ)
L’histoire se déroule dans une cuisine de campagne, au début du siècle dernier. Josèp, patron de la ferme, est veuf. Il n’a eu qu’un fils, Ferdi. 
Marinou, nièce de Josèp, a été recueilli par ce dernier au décès de ses parents. Manneta, mère de Joseph vit avec eux. Elle fait preuve de beaucoup de sagesse, de clairvoyance.
Joseph, épuisé par une vie de labeur et de soucis, envisage de laisser la ferme à Ferdi et serait ravi que son fils épouse Marinou.
Mais Ferdi n’est pas du tout le fils idéal ou l’amant idéal. Il va partir à Paris profiter de la « belle vie parisienne et de ses nuits » sans se soucier d’autre chose. Il sera surnommé l’Escampat d’où le nom de la pièce.
Lors du retour de Ferdi, Josèp, homme borné, qui en veut au ciel et à la terre, va-t-il lui pardonner ses « escapades » ? Ferdi va-t-il devenir enfin le fils et l’amoureux idéal ? Quel rôle va jouer Félipou, amoureux de Marinou et prêt à tout pour obtenir cet amour ? 
Intervient tout le long de la pièce, l’Espatula, personnage un peu simplet, qui se mêle de tout mais qui comprend la situation.


 - LA BASTARDA (Comédie en un acte d''Adrien VEZINET - durée : 1h30 environ)
L''histoire se déroule au début du siècle dernier dans une cuisine de campagne, à la Gineste, propriété de Toéno et de sa femme, Irma. 
Irma n''a qu''une seule idée en tête, Lucéta, sa fille, doit épouser Pierre, le maître valet. Mais ce dernier est amoureux de Roséta, la servante : c''est une "bastarde". Imaginez un instant le moment où la mère et la fille vont apprendre la relation entre Pierre et Roséta, imaginez la tête de Toéno qui n''a qu''un seul souci : faire fructifier la ferme sans s''occuper de toutes ces histoires. Comment la maîtresse de maison et Palmira vont-elles s''y prendre pour relever cet affront ?


- LA SOPA D''ALHS (pièce en "Lengua nostro" - auteur inconnu, reprise par Jean-Marie LACOMBE - durée 1h30 environ)
Nous sommes dans une maison paysanne après dîner. Berthe, maîtresse de maison, femme moustachue, a retroussé les manches , lave la vaisselle dans une bassine. Milien... la mine malade, est pâle, maigre. On voit qu''il est habitué...à pâtir et... à ne pas commander. Dehors, on entend dans le voisinage, Gustou, forgeron, le marteau à la main qui frappe sur l''enclume.
Vous allez vivre les péripéties d''un brave homme marié à une femme de caractère et particulièrement avare.
Ce que vous allez découvrir à travers une drôle de soupe, pas vraiment comme les autres...


- VISTALHAS (comedie en un acte d''Adrien VEZINET - durée 1h20 environ)
L''histoire se déroule vers les années 1920, chez Artémon de Gisquet, riche propriétaire de la ferme de la Grifolièra. Sa fille, Lineta, vient de se marier avec Gaston.
Palmira, soeur d''Artémon, est toujours restée à la ferme. Victor, oncle de Gaston, est employé à la préfecture. Tous les deux ont déjà passé la quarantaine et sont célibataires. Linéta et Gaston songent à un possible mariage... et vont tout faire pour y parvenir.
Comment vont-ils s''y prendre pour faire accepter cette possible union à Artémon et à sa femme, Justine ? Imaginez la scène : le mari, paysan accroché aux vieux principes et détestant tous ces gratte-papiers de la ville, alors que Justine a toujours rêvé d''aller habiter en ville.


- L''AUBERGE DE LAS TRES CATTOS (pièce en "Lengua nostro" de Jean-Marie LACOMBE - durée 1h30)
L''action se passe dans une auberge de l''un de nos villages de l''Aveyron vers les années 1920 - 1930. Elle est tenue par trois vieilles filles : Philomène, Julie et Marinou, surnommées "Los Très Cattos", ayant chacune leur particularité...


- LA TATA DE BORNIQUET (comédie en un acte de Henry MOULY et Adrien VEZINET - durée 1h20)
L''histoire se passe dans une cuisine de campagne vers 1900. Jeanine, fille de Borniquet, est amoureuse de Robert.
Borniquet et sa femme rejettent cette liaison. Pensez-donc ! Robert, un simple maître valet peut-il prétendre être accepté par ce couple, riche propriétaire terrien, qui ne vit que pour l''argent ? C''est sans compter sur un personnage clé : la Tata, qui ne va pas ménager ses efforts pour aider nos deux amoureux. Comment va-t-elle s''y prendre ? Réussira-t-elle à renverser la situation ?');


--
-- Structure de la table 'texte'
--

CREATE TABLE compte_rendu (
  cr_num SERIAL PRIMARY KEY,
  cr_text text NOT NULL,
  cr_date date NOT NULL
);

INSERT INTO compte_rendu(cr_text, cr_date) VALUES
('Réunion du bureau du 07 octobre 2015

Présents : Dorian, Tofe, Monique, Joël, Sophie, Marie-Paule, Huguette, Karine
Sortie :
-	11 octobre : Camjac, théâtre
-	25 Octobre : Thegra (à côté de Padirac), danses
-	Le 28 ou 29 Novembre, Noilhac pour le téléthon, théâtre
-	Le 19 décembre, Agen, danses et théâtre
-	Le 17 janvier 2016, Réquista, danses et théâtre
-	Le 30 et 31 janvier, Saintes (en attente de confirmation)

Fédération :
Pour le festival des Ados, la fédération aidera un peu financièrement le groupe organisateur (soit La Pastou), il faut qu’on leur fasse passer un budget prévisionnel.
Yvonne d’un nouveau groupe du Puy en Velay est secrétaire de la fédération.
Assemblée générale se fait à Vichy les 24 et 25 octobre.
Festival des Ados
1 réponse du lycée Monteil pour l’hébergement, 8,10€ la nuit avec petit déjeuner, 0,80€ de supplément par l’alèse.
Il faut voir avec les responsables des Ados, ce qui pourrait être fait durant le week-end et après on verra pour l’organisation des repas.
Site Internet :
Tofe a contacté l’info com de l’Iut de Rodez pour le site internet.  Pour le moment une colaboration ne peut pas se faire mais on garde le projet pour l’année prochaine. 
Cependant Tofe a contacté l’IUT pour se mettre en relation avec des jeunes comme les années passées, et c’est ok.
Nuit Rouergate :
On a reçu les cartes à vendre. On demande à ce que chaque talon des cartes soient bien identifiés par personnes (c’est plus facile pour pointer les gens quand ils arrivent).
Les palettes se feront le samedi 24 octobre après-midi.
Publicité dans le journal sera faite pour la 1ère semaine de novembre.
Des tracts vont être faits pour faire la distribution dans les thés dansants.

Assemblée Générale :
8 personnes vont recevoir le courrier cette année.
En attente des propositions des menus pour le moment et des tarifs.

Réunion des responsables de danses adultes et enfants :
Tous les responsables de danses étaient présents. Un compromis a été trouvé pour que les ados soient présents à toutes les répétitions.

Tracts Ecole de danses :
Suite à l’envoi des tracts, l’école de Moyrazes nous a contactés pour organiser un spectacle de fin d’année avec les classes. Pour le moment rien n’a été fixé, mais si cela se fait le tarif sera dans les environs de 1000 à 1500€.

Pastourpicha :
Un contact a été fait pour aller au Nayrac. Marie-Paule doit rappeler la dame et va voir pour fixer une date.

			Prochaine Réunion le jeudi 29 octobre', '2015-10-07'),
('Réunion de bureau du 23 novembre 2015

Présents : Domi, Anaïs, Tofe, Monique, Yoann, Joël, Monique, Marie-Paule, Sophie, Karine, Huguette
Sorties : 
-	29 novembre , Noilhac, Théâtre 
-	05 décembre, Durenque, Théâtre
-	19 décembre, Agen, Danses et théâtre
-	01 janvier, Peyrières, Danses
-	09 janvier, Castelnau de Mandailles, Théâtre
-	17 janvier, Requista, danses et théâtre
-	21 février, Espalion, Théâtre
-	19 mars, Camjac, Théâtre
-	Mai, Trémouilles, Théâtre
Bilan Nuit Rouergate
Pas mieux que l’an passé. L’orchestre a coûté 470€ de plus que l’an passé. Le repas a coûté 50cts de plus, l’imprimeur, le guso, la publicité ont augmenté, La nuit nous a coûté 935€ en plus que l’an passé.
Bénéfice sur la soirée 1376€.
De très bon échos sur le repas malgré un service long (plat), certaines personnes se sont pleins de ne pas avoir assez dansé pendant le repas, pas mal de personnes  ce sont plein d’avoir froid également.
Joël fait un remerciement pour tout, la préparation avant le jour, la préparation de la salle, la décoration, le service, la préparation des spectacles, le rangement. En gros la réussite de la soirée, c’est grâce à nous tous.
L’année prochaine la Nuit Rouergate aura lieu le 12 novembre. Pour l’organisation, on va s’en tenir à 550 repas.
Bilan Assemblée Générale
Joël a essayé de joindre Didier Delmas pour voir quelle position il prenait par rapport  au groupe, mais il n’a pas réussi à le joindre.
Grosse déception pour le repas du midi.
 Election du bureau
Tirage au sort : 1 an pour Yohan, 3 ans pour Anaïs
Président : Joël Regourd
Vice Président : Domi Vergnet
Trésorier : Sophie Bodio
Trésorier adjoint : Anaïs Coulon
Secrétaire : Karine Alcouffe
Secrétaire Adjoint : Christophe Pages
Commissions :
-	Danses : Anaïs, Sophie, 
-	Théâtre : Monique
-	Fédération : Huguette
-	Festival : Huguette, Joël,
-	Costumes: Michèle et Christine 
-	Matériel : Yoann
-	Ecole de danses : Karine
-	Site Internet : Tofe
-	Animation : Marie-Paule, Domi
Groupe de travail :
Costumes : Michèle, Domi, Sophie, Karine, Christine
Label SCCIOF : Tofe, Huguette,  Anaïs
PastoUrpicha : Marie-Paule, Monique, Yoann
Festival des Ados :
-	Pour les repas, possibilité de faire Aligot/Saucisse – Lasagnes ; Glaces/Fruits
-	Voir pour les activités du samedi après-midi (spectacle dans les maisons de retraite, défilé…)
-	Dimanche matin, jeu dans Rodez.
Questions diverses :
-	Voir pour refaire des chemises, ou des polos à réfléchir. Par contre une participation risque d’être demandé par personne.


Prochaine réunion de bureau le 28 Décembre', '2015-11-23');

-- --------------------------------------------------------

			--
-- Structure de la table 'tradannexe'
--

CREATE TABLE titre (
  titre_num SERIAL PRIMARY KEY,
  titre_nom varchar(30) NOT NULL, 
  titre_link varchar(30) UNIQUE NOT NULL
);

INSERT INTO titre (titre_nom, titre_link) VALUES
('Accueil', 'accueil'),
('Actualite', 'actu'),
('Contact', 'contact'),
('Liens', 'lien'),
('Avis', 'avis'),
('Présentation', 'pres'),
('Musiques', 'music'),
('Voyages', 'voyage'),
('Coordonnées', 'coord'),
('Boutique','boutique'),
('Revue de presse','revue'),
('Livre d''or','livre'),
('Médias','media'),
('Videos','video');


--
-- Structure de la table 'tradannexe'
--

CREATE TABLE traduction (
  trad_num SERIAL NOT NULL UNIQUE,
  code_lang integer NOT NULL REFERENCES lang(lang_id) ON DELETE CASCADE,
  code_titre integer NOT NULL REFERENCES titre(titre_num) ON DELETE CASCADE,
  content varchar(100) NOT NULL,
  PRIMARY KEY (code_lang,code_titre)
);

INSERT INTO traduction (code_lang, code_titre, content) VALUES
(1,1,'Accueil'),
(1,2,'Actualite'),
(1,3, 'Contact'),
(1,4,'Nos partenaires'),
(1,5,'Votre avis'),
(1,6,'Présentation'),
(1,7,'Nos musiques'),
(1,8,'Nos voyages'),
(1,9,'Nos coordonnées'),
(1,10,'Boutique'),
(1,11,'Revue de presse'),
(1,12,'Livre d''or'),
(1,13,'Nos médias'),
(1,14,'Nos vidéos'),
(2,1,'Inicio'),
(2,2,'Noticias'),
(2,3, 'Contacta'),
(2,4,'Nuestros socios'),
(2,5,'Su opinión'),
(2,6,'Presentación'),
(2,7,'Nuestra musica'),
(2,8,'Nos viajes'),
(2,9,'Nuestra coordinada'),
(2,10,'Tienda'),
(2,11,'Revista de prensa'),
(2,12,'Libro de visitas');

-- --------------------------------------------------------


GRANT ALL ON TABLE actu_content TO pastourebd2;
GRANT ALL ON TABLE actualite TO pastourebd2;
GRANT ALL ON TABLE produits TO pastourebd2;
GRANT ALL ON TABLE produits_contenu TO pastourebd2;
GRANT ALL ON TABLE commentaire TO pastourebd2;
GRANT ALL ON TABLE diaporama TO pastourebd2;
GRANT ALL ON TABLE uploaded_file TO pastourebd2;
GRANT ALL ON TABLE lang TO pastourebd2;
GRANT ALL ON TABLE photo TO pastourebd2;
GRANT ALL ON TABLE lien_ext TO pastourebd2;
GRANT ALL ON TABLE livreor TO pastourebd2;
GRANT ALL ON TABLE voyage TO pastourebd2;
GRANT ALL ON TABLE planning TO pastourebd2;
GRANT ALL ON TABLE playlist TO pastourebd2;
GRANT ALL ON TABLE revue_presse TO pastourebd2;
GRANT ALL ON TABLE texte TO pastourebd2;
GRANT ALL ON TABLE traduction TO pastourebd2;
GRANT ALL ON TABLE titre TO pastourebd2;
GRANT ALL ON TABLE tmembre_inscrit TO pastourebd2;
GRANT ALL ON TABLE coordonnees TO pastourebd2;
GRANT ALL ON TABLE compte_rendu TO pastourebd2;
GRANT ALL ON TABLE page TO pastourebd2;
GRANT ALL ON TABLE countries TO pastourebd2;
GRANT ALL ON TABLE languages_world TO pastourebd2;
GRANT ALL ON TABLE phrase_jour TO pastourebd2;
GRANT ALL ON TABLE continent TO pastourebd2;
GRANT ALL ON TABLE video_link TO pastourebd2;
