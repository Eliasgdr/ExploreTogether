-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 07 juin 2024 à 05:55
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `id22104896_jsp`
--
CREATE DATABASE IF NOT EXISTS `id22104896_jsp` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci;
USE `id22104896_jsp`;

-- --------------------------------------------------------

--
-- Structure de la table `bannedemail`
--

DROP TABLE IF EXISTS `bannedemail`;
CREATE TABLE IF NOT EXISTS `bannedemail` (
  `emaillD` int NOT NULL AUTO_INCREMENT,
  `email` varchar(535) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`emaillD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `blockedusers`
--

DROP TABLE IF EXISTS `blockedusers`;
CREATE TABLE IF NOT EXISTS `blockedusers` (
  `blockID` int NOT NULL AUTO_INCREMENT,
  `userID` int DEFAULT NULL,
  `blockedUserID` int DEFAULT NULL,
  PRIMARY KEY (`blockID`),
  UNIQUE KEY `userID` (`userID`) USING BTREE,
  UNIQUE KEY `userBlockedID` (`blockedUserID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `blockedusers`
--

INSERT INTO `blockedusers` (`blockID`, `userID`, `blockedUserID`) VALUES
(2, 5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` int NOT NULL,
  `alpha2` varchar(2) NOT NULL,
  `alpha3` varchar(3) NOT NULL,
  `nom_en_gb` varchar(45) NOT NULL,
  `nom_fr_fr` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alpha2` (`alpha2`),
  UNIQUE KEY `alpha3` (`alpha3`),
  UNIQUE KEY `code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `countries`
--

INSERT INTO `countries` (`id`, `code`, `alpha2`, `alpha3`, `nom_en_gb`, `nom_fr_fr`) VALUES
(1, 4, 'AF', 'AFG', 'Afghanistan', 'Afghanistan'),
(2, 8, 'AL', 'ALB', 'Albania', 'Albanie'),
(3, 10, 'AQ', 'ATA', 'Antarctica', 'Antarctique'),
(4, 12, 'DZ', 'DZA', 'Algeria', 'Algérie'),
(5, 16, 'AS', 'ASM', 'American Samoa', 'Samoa Américaines'),
(6, 20, 'AD', 'AND', 'Andorra', 'Andorre'),
(7, 24, 'AO', 'AGO', 'Angola', 'Angola'),
(8, 28, 'AG', 'ATG', 'Antigua and Barbuda', 'Antigua-et-Barbuda'),
(9, 31, 'AZ', 'AZE', 'Azerbaijan', 'Azerbaïdjan'),
(10, 32, 'AR', 'ARG', 'Argentina', 'Argentine'),
(11, 36, 'AU', 'AUS', 'Australia', 'Australie'),
(12, 40, 'AT', 'AUT', 'Austria', 'Autriche'),
(13, 44, 'BS', 'BHS', 'Bahamas', 'Bahamas'),
(14, 48, 'BH', 'BHR', 'Bahrain', 'Bahreïn'),
(15, 50, 'BD', 'BGD', 'Bangladesh', 'Bangladesh'),
(16, 51, 'AM', 'ARM', 'Armenia', 'Arménie'),
(17, 52, 'BB', 'BRB', 'Barbados', 'Barbade'),
(18, 56, 'BE', 'BEL', 'Belgium', 'Belgique'),
(19, 60, 'BM', 'BMU', 'Bermuda', 'Bermudes'),
(20, 64, 'BT', 'BTN', 'Bhutan', 'Bhoutan'),
(21, 68, 'BO', 'BOL', 'Bolivia', 'Bolivie'),
(22, 70, 'BA', 'BIH', 'Bosnia and Herzegovina', 'Bosnie-Herzégovine'),
(23, 72, 'BW', 'BWA', 'Botswana', 'Botswana'),
(24, 74, 'BV', 'BVT', 'Bouvet Island', 'Île Bouvet'),
(25, 76, 'BR', 'BRA', 'Brazil', 'Brésil'),
(26, 84, 'BZ', 'BLZ', 'Belize', 'Belize'),
(27, 86, 'IO', 'IOT', 'British Indian Ocean Territory', 'Territoire Britannique de l\'Océan Indien'),
(28, 90, 'SB', 'SLB', 'Solomon Islands', 'Îles Salomon'),
(29, 92, 'VG', 'VGB', 'British Virgin Islands', 'Îles Vierges Britanniques'),
(30, 96, 'BN', 'BRN', 'Brunei Darussalam', 'Brunéi Darussalam'),
(31, 100, 'BG', 'BGR', 'Bulgaria', 'Bulgarie'),
(32, 104, 'MM', 'MMR', 'Myanmar', 'Myanmar'),
(33, 108, 'BI', 'BDI', 'Burundi', 'Burundi'),
(34, 112, 'BY', 'BLR', 'Belarus', 'Bélarus'),
(35, 116, 'KH', 'KHM', 'Cambodia', 'Cambodge'),
(36, 120, 'CM', 'CMR', 'Cameroon', 'Cameroun'),
(37, 124, 'CA', 'CAN', 'Canada', 'Canada'),
(38, 132, 'CV', 'CPV', 'Cape Verde', 'Cap-vert'),
(39, 136, 'KY', 'CYM', 'Cayman Islands', 'Îles Caïmanes'),
(40, 140, 'CF', 'CAF', 'Central African', 'République Centrafricaine'),
(41, 144, 'LK', 'LKA', 'Sri Lanka', 'Sri Lanka'),
(42, 148, 'TD', 'TCD', 'Chad', 'Tchad'),
(43, 152, 'CL', 'CHL', 'Chile', 'Chili'),
(44, 156, 'CN', 'CHN', 'China', 'Chine'),
(45, 158, 'TW', 'TWN', 'Taiwan', 'Taïwan'),
(46, 162, 'CX', 'CXR', 'Christmas Island', 'Île Christmas'),
(47, 166, 'CC', 'CCK', 'Cocos (Keeling) Islands', 'Îles Cocos (Keeling)'),
(48, 170, 'CO', 'COL', 'Colombia', 'Colombie'),
(49, 174, 'KM', 'COM', 'Comoros', 'Comores'),
(50, 175, 'YT', 'MYT', 'Mayotte', 'Mayotte'),
(51, 178, 'CG', 'COG', 'Republic of the Congo', 'République du Congo'),
(52, 180, 'CD', 'COD', 'The Democratic Republic Of The Congo', 'République Démocratique du Congo'),
(53, 184, 'CK', 'COK', 'Cook Islands', 'Îles Cook'),
(54, 188, 'CR', 'CRI', 'Costa Rica', 'Costa Rica'),
(55, 191, 'HR', 'HRV', 'Croatia', 'Croatie'),
(56, 192, 'CU', 'CUB', 'Cuba', 'Cuba'),
(57, 196, 'CY', 'CYP', 'Cyprus', 'Chypre'),
(58, 203, 'CZ', 'CZE', 'Czech Republic', 'République Tchèque'),
(59, 204, 'BJ', 'BEN', 'Benin', 'Bénin'),
(60, 208, 'DK', 'DNK', 'Denmark', 'Danemark'),
(61, 212, 'DM', 'DMA', 'Dominica', 'Dominique'),
(62, 214, 'DO', 'DOM', 'Dominican Republic', 'République Dominicaine'),
(63, 218, 'EC', 'ECU', 'Ecuador', 'Équateur'),
(64, 222, 'SV', 'SLV', 'El Salvador', 'El Salvador'),
(65, 226, 'GQ', 'GNQ', 'Equatorial Guinea', 'Guinée Équatoriale'),
(66, 231, 'ET', 'ETH', 'Ethiopia', 'Éthiopie'),
(67, 232, 'ER', 'ERI', 'Eritrea', 'Érythrée'),
(68, 233, 'EE', 'EST', 'Estonia', 'Estonie'),
(69, 234, 'FO', 'FRO', 'Faroe Islands', 'Îles Féroé'),
(70, 238, 'FK', 'FLK', 'Falkland Islands', 'Îles (malvinas) Falkland'),
(71, 239, 'GS', 'SGS', 'South Georgia and the South Sandwich Islands', 'Géorgie du Sud et les Îles Sandwich du Sud'),
(72, 242, 'FJ', 'FJI', 'Fiji', 'Fidji'),
(73, 246, 'FI', 'FIN', 'Finland', 'Finlande'),
(74, 248, 'AX', 'ALA', 'Åland Islands', 'Îles Åland'),
(75, 250, 'FR', 'FRA', 'France', 'France'),
(76, 254, 'GF', 'GUF', 'French Guiana', 'Guyane Française'),
(77, 258, 'PF', 'PYF', 'French Polynesia', 'Polynésie Française'),
(78, 260, 'TF', 'ATF', 'French Southern Territories', 'Terres Australes Françaises'),
(79, 262, 'DJ', 'DJI', 'Djibouti', 'Djibouti'),
(80, 266, 'GA', 'GAB', 'Gabon', 'Gabon'),
(81, 268, 'GE', 'GEO', 'Georgia', 'Géorgie'),
(82, 270, 'GM', 'GMB', 'Gambia', 'Gambie'),
(83, 275, 'PS', 'PSE', 'Occupied Palestinian Territory', 'Territoire Palestinien Occupé'),
(84, 276, 'DE', 'DEU', 'Germany', 'Allemagne'),
(85, 288, 'GH', 'GHA', 'Ghana', 'Ghana'),
(86, 292, 'GI', 'GIB', 'Gibraltar', 'Gibraltar'),
(87, 296, 'KI', 'KIR', 'Kiribati', 'Kiribati'),
(88, 300, 'GR', 'GRC', 'Greece', 'Grèce'),
(89, 304, 'GL', 'GRL', 'Greenland', 'Groenland'),
(90, 308, 'GD', 'GRD', 'Grenada', 'Grenade'),
(91, 312, 'GP', 'GLP', 'Guadeloupe', 'Guadeloupe'),
(92, 316, 'GU', 'GUM', 'Guam', 'Guam'),
(93, 320, 'GT', 'GTM', 'Guatemala', 'Guatemala'),
(94, 324, 'GN', 'GIN', 'Guinea', 'Guinée'),
(95, 328, 'GY', 'GUY', 'Guyana', 'Guyana'),
(96, 332, 'HT', 'HTI', 'Haiti', 'Haïti'),
(97, 334, 'HM', 'HMD', 'Heard Island and McDonald Islands', 'Îles Heard et Mcdonald'),
(98, 336, 'VA', 'VAT', 'Vatican City State', 'Saint-Siège (état de la Cité du Vatican)'),
(99, 340, 'HN', 'HND', 'Honduras', 'Honduras'),
(100, 344, 'HK', 'HKG', 'Hong Kong', 'Hong-Kong'),
(101, 348, 'HU', 'HUN', 'Hungary', 'Hongrie'),
(102, 352, 'IS', 'ISL', 'Iceland', 'Islande'),
(103, 356, 'IN', 'IND', 'India', 'Inde'),
(104, 360, 'ID', 'IDN', 'Indonesia', 'Indonésie'),
(105, 364, 'IR', 'IRN', 'Islamic Republic of Iran', 'République Islamique d\'Iran'),
(106, 368, 'IQ', 'IRQ', 'Iraq', 'Iraq'),
(107, 372, 'IE', 'IRL', 'Ireland', 'Irlande'),
(108, 376, 'IL', 'ISR', 'Israel', 'Israël'),
(109, 380, 'IT', 'ITA', 'Italy', 'Italie'),
(110, 384, 'CI', 'CIV', 'Côte d\'Ivoire', 'Côte d\'Ivoire'),
(111, 388, 'JM', 'JAM', 'Jamaica', 'Jamaïque'),
(112, 392, 'JP', 'JPN', 'Japan', 'Japon'),
(113, 398, 'KZ', 'KAZ', 'Kazakhstan', 'Kazakhstan'),
(114, 400, 'JO', 'JOR', 'Jordan', 'Jordanie'),
(115, 404, 'KE', 'KEN', 'Kenya', 'Kenya'),
(116, 408, 'KP', 'PRK', 'Democratic People\'s Republic of Korea', 'République Populaire Démocratique de Corée'),
(117, 410, 'KR', 'KOR', 'Republic of Korea', 'République de Corée'),
(118, 414, 'KW', 'KWT', 'Kuwait', 'Koweït'),
(119, 417, 'KG', 'KGZ', 'Kyrgyzstan', 'Kirghizistan'),
(120, 418, 'LA', 'LAO', 'Lao People\'s Democratic Republic', 'République Démocratique Populaire Lao'),
(121, 422, 'LB', 'LBN', 'Lebanon', 'Liban'),
(122, 426, 'LS', 'LSO', 'Lesotho', 'Lesotho'),
(123, 428, 'LV', 'LVA', 'Latvia', 'Lettonie'),
(124, 430, 'LR', 'LBR', 'Liberia', 'Libéria'),
(125, 434, 'LY', 'LBY', 'Libyan Arab Jamahiriya', 'Jamahiriya Arabe Libyenne'),
(126, 438, 'LI', 'LIE', 'Liechtenstein', 'Liechtenstein'),
(127, 440, 'LT', 'LTU', 'Lithuania', 'Lituanie'),
(128, 442, 'LU', 'LUX', 'Luxembourg', 'Luxembourg'),
(129, 446, 'MO', 'MAC', 'Macao', 'Macao'),
(130, 450, 'MG', 'MDG', 'Madagascar', 'Madagascar'),
(131, 454, 'MW', 'MWI', 'Malawi', 'Malawi'),
(132, 458, 'MY', 'MYS', 'Malaysia', 'Malaisie'),
(133, 462, 'MV', 'MDV', 'Maldives', 'Maldives'),
(134, 466, 'ML', 'MLI', 'Mali', 'Mali'),
(135, 470, 'MT', 'MLT', 'Malta', 'Malte'),
(136, 474, 'MQ', 'MTQ', 'Martinique', 'Martinique'),
(137, 478, 'MR', 'MRT', 'Mauritania', 'Mauritanie'),
(138, 480, 'MU', 'MUS', 'Mauritius', 'Maurice'),
(139, 484, 'MX', 'MEX', 'Mexico', 'Mexique'),
(140, 492, 'MC', 'MCO', 'Monaco', 'Monaco'),
(141, 496, 'MN', 'MNG', 'Mongolia', 'Mongolie'),
(142, 498, 'MD', 'MDA', 'Republic of Moldova', 'République de Moldova'),
(143, 500, 'MS', 'MSR', 'Montserrat', 'Montserrat'),
(144, 504, 'MA', 'MAR', 'Morocco', 'Maroc'),
(145, 508, 'MZ', 'MOZ', 'Mozambique', 'Mozambique'),
(146, 512, 'OM', 'OMN', 'Oman', 'Oman'),
(147, 516, 'NA', 'NAM', 'Namibia', 'Namibie'),
(148, 520, 'NR', 'NRU', 'Nauru', 'Nauru'),
(149, 524, 'NP', 'NPL', 'Nepal', 'Népal'),
(150, 528, 'NL', 'NLD', 'Netherlands', 'Pays-Bas'),
(151, 530, 'AN', 'ANT', 'Netherlands Antilles', 'Antilles Néerlandaises'),
(152, 533, 'AW', 'ABW', 'Aruba', 'Aruba'),
(153, 540, 'NC', 'NCL', 'New Caledonia', 'Nouvelle-Calédonie'),
(154, 548, 'VU', 'VUT', 'Vanuatu', 'Vanuatu'),
(155, 554, 'NZ', 'NZL', 'New Zealand', 'Nouvelle-Zélande'),
(156, 558, 'NI', 'NIC', 'Nicaragua', 'Nicaragua'),
(157, 562, 'NE', 'NER', 'Niger', 'Niger'),
(158, 566, 'NG', 'NGA', 'Nigeria', 'Nigéria'),
(159, 570, 'NU', 'NIU', 'Niue', 'Niué'),
(160, 574, 'NF', 'NFK', 'Norfolk Island', 'Île Norfolk'),
(161, 578, 'NO', 'NOR', 'Norway', 'Norvège'),
(162, 580, 'MP', 'MNP', 'Northern Mariana Islands', 'Îles Mariannes du Nord'),
(163, 581, 'UM', 'UMI', 'United States Minor Outlying Islands', 'Îles Mineures Éloignées des États-Unis'),
(164, 583, 'FM', 'FSM', 'Federated States of Micronesia', 'États Fédérés de Micronésie'),
(165, 584, 'MH', 'MHL', 'Marshall Islands', 'Îles Marshall'),
(166, 585, 'PW', 'PLW', 'Palau', 'Palaos'),
(167, 586, 'PK', 'PAK', 'Pakistan', 'Pakistan'),
(168, 591, 'PA', 'PAN', 'Panama', 'Panama'),
(169, 598, 'PG', 'PNG', 'Papua New Guinea', 'Papouasie-Nouvelle-Guinée'),
(170, 600, 'PY', 'PRY', 'Paraguay', 'Paraguay'),
(171, 604, 'PE', 'PER', 'Peru', 'Pérou'),
(172, 608, 'PH', 'PHL', 'Philippines', 'Philippines'),
(173, 612, 'PN', 'PCN', 'Pitcairn', 'Pitcairn'),
(174, 616, 'PL', 'POL', 'Poland', 'Pologne'),
(175, 620, 'PT', 'PRT', 'Portugal', 'Portugal'),
(176, 624, 'GW', 'GNB', 'Guinea-Bissau', 'Guinée-Bissau'),
(177, 626, 'TL', 'TLS', 'Timor-Leste', 'Timor-Leste'),
(178, 630, 'PR', 'PRI', 'Puerto Rico', 'Porto Rico'),
(179, 634, 'QA', 'QAT', 'Qatar', 'Qatar'),
(180, 638, 'RE', 'REU', 'Réunion', 'Réunion'),
(181, 642, 'RO', 'ROU', 'Romania', 'Roumanie'),
(182, 643, 'RU', 'RUS', 'Russian Federation', 'Fédération de Russie'),
(183, 646, 'RW', 'RWA', 'Rwanda', 'Rwanda'),
(184, 654, 'SH', 'SHN', 'Saint Helena', 'Sainte-Hélène'),
(185, 659, 'KN', 'KNA', 'Saint Kitts and Nevis', 'Saint-Kitts-et-Nevis'),
(186, 660, 'AI', 'AIA', 'Anguilla', 'Anguilla'),
(187, 662, 'LC', 'LCA', 'Saint Lucia', 'Sainte-Lucie'),
(188, 666, 'PM', 'SPM', 'Saint-Pierre and Miquelon', 'Saint-Pierre-et-Miquelon'),
(189, 670, 'VC', 'VCT', 'Saint Vincent and the Grenadines', 'Saint-Vincent-et-les Grenadines'),
(190, 674, 'SM', 'SMR', 'San Marino', 'Saint-Marin'),
(191, 678, 'ST', 'STP', 'Sao Tome and Principe', 'Sao Tomé-et-Principe'),
(192, 682, 'SA', 'SAU', 'Saudi Arabia', 'Arabie Saoudite'),
(193, 686, 'SN', 'SEN', 'Senegal', 'Sénégal'),
(194, 690, 'SC', 'SYC', 'Seychelles', 'Seychelles'),
(195, 694, 'SL', 'SLE', 'Sierra Leone', 'Sierra Leone'),
(196, 702, 'SG', 'SGP', 'Singapore', 'Singapour'),
(197, 703, 'SK', 'SVK', 'Slovakia', 'Slovaquie'),
(198, 704, 'VN', 'VNM', 'Vietnam', 'Viet Nam'),
(199, 705, 'SI', 'SVN', 'Slovenia', 'Slovénie'),
(200, 706, 'SO', 'SOM', 'Somalia', 'Somalie'),
(201, 710, 'ZA', 'ZAF', 'South Africa', 'Afrique du Sud'),
(202, 716, 'ZW', 'ZWE', 'Zimbabwe', 'Zimbabwe'),
(203, 724, 'ES', 'ESP', 'Spain', 'Espagne'),
(204, 732, 'EH', 'ESH', 'Western Sahara', 'Sahara Occidental'),
(205, 736, 'SD', 'SDN', 'Sudan', 'Soudan'),
(206, 740, 'SR', 'SUR', 'Suriname', 'Suriname'),
(207, 744, 'SJ', 'SJM', 'Svalbard and Jan Mayen', 'Svalbard etÎle Jan Mayen'),
(208, 748, 'SZ', 'SWZ', 'Swaziland', 'Swaziland'),
(209, 752, 'SE', 'SWE', 'Sweden', 'Suède'),
(210, 756, 'CH', 'CHE', 'Switzerland', 'Suisse'),
(211, 760, 'SY', 'SYR', 'Syrian Arab Republic', 'République Arabe Syrienne'),
(212, 762, 'TJ', 'TJK', 'Tajikistan', 'Tadjikistan'),
(213, 764, 'TH', 'THA', 'Thailand', 'Thaïlande'),
(214, 768, 'TG', 'TGO', 'Togo', 'Togo'),
(215, 772, 'TK', 'TKL', 'Tokelau', 'Tokelau'),
(216, 776, 'TO', 'TON', 'Tonga', 'Tonga'),
(217, 780, 'TT', 'TTO', 'Trinidad and Tobago', 'Trinité-et-Tobago'),
(218, 784, 'AE', 'ARE', 'United Arab Emirates', 'Émirats Arabes Unis'),
(219, 788, 'TN', 'TUN', 'Tunisia', 'Tunisie'),
(220, 792, 'TR', 'TUR', 'Turkey', 'Turquie'),
(221, 795, 'TM', 'TKM', 'Turkmenistan', 'Turkménistan'),
(222, 796, 'TC', 'TCA', 'Turks and Caicos Islands', 'Îles Turks et Caïques'),
(223, 798, 'TV', 'TUV', 'Tuvalu', 'Tuvalu'),
(224, 800, 'UG', 'UGA', 'Uganda', 'Ouganda'),
(225, 804, 'UA', 'UKR', 'Ukraine', 'Ukraine'),
(226, 807, 'MK', 'MKD', 'The Former Yugoslav Republic of Macedonia', 'L\'ex-République Yougoslave de Macédoine'),
(227, 818, 'EG', 'EGY', 'Egypt', 'Égypte'),
(228, 826, 'GB', 'GBR', 'United Kingdom', 'Royaume-Uni'),
(229, 833, 'IM', 'IMN', 'Isle of Man', 'Île de Man'),
(230, 834, 'TZ', 'TZA', 'United Republic Of Tanzania', 'République-Unie de Tanzanie'),
(231, 840, 'US', 'USA', 'United States', 'États-Unis'),
(232, 850, 'VI', 'VIR', 'U.S. Virgin Islands', 'Îles Vierges des États-Unis'),
(233, 854, 'BF', 'BFA', 'Burkina Faso', 'Burkina Faso'),
(234, 858, 'UY', 'URY', 'Uruguay', 'Uruguay'),
(235, 860, 'UZ', 'UZB', 'Uzbekistan', 'Ouzbékistan'),
(236, 862, 'VE', 'VEN', 'Venezuela', 'Venezuela'),
(237, 876, 'WF', 'WLF', 'Wallis and Futuna', 'Wallis et Futuna'),
(238, 882, 'WS', 'WSM', 'Samoa', 'Samoa'),
(239, 887, 'YE', 'YEM', 'Yemen', 'Yémen'),
(240, 891, 'CS', 'SCG', 'Serbia and Montenegro', 'Serbie-et-Monténégro'),
(241, 894, 'ZM', 'ZMB', 'Zambia', 'Zambie');

-- --------------------------------------------------------

--
-- Structure de la table `friendship`
--

DROP TABLE IF EXISTS `friendship`;
CREATE TABLE IF NOT EXISTS `friendship` (
  `friendshipID` int NOT NULL AUTO_INCREMENT,
  `user1` int DEFAULT NULL,
  `user2` int DEFAULT NULL,
  PRIMARY KEY (`friendshipID`),
  KEY `user1` (`user1`),
  KEY `user2` (`user2`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `friendship`
--

INSERT INTO `friendship` (`friendshipID`, `user1`, `user2`) VALUES
(1, 5, 5),
(2, 5, 10),
(3, 5, 11),
(4, 5, 31),
(5, 5, 32);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `messageID` int NOT NULL AUTO_INCREMENT,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `body` varchar(535) COLLATE utf8mb3_unicode_ci NOT NULL,
  `authorID` int DEFAULT NULL,
  `threadID` int NOT NULL,
  PRIMARY KEY (`messageID`),
  KEY `authorID` (`authorID`),
  KEY `threadID` (`threadID`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`messageID`, `Date`, `body`, `authorID`, `threadID`) VALUES
(159, '2024-05-28 18:23:21', 'Hi, I just created a new Thread named test', 5, 52),
(160, '2024-05-28 18:23:29', 'hi', 5, 52),
(168, '2024-05-28 20:28:57', 'Hi, I just created a new Thread named test', 10, 57),
(169, '2024-05-28 20:40:59', 'Hi, I just created a new Thread named test', 10, 58),
(170, '2024-05-28 20:41:11', 'hi', 10, 56),
(171, '2024-05-28 20:42:11', 'Hi, I just created a new Thread named test', 30, 59),
(178, '2024-05-29 11:49:36', 'hi', 5, 52),
(179, '2024-06-06 10:19:27', 'Hi, I just created a new Thread named test', 5, 60),
(180, '2024-06-06 11:37:32', 'Hi, I just created a new Thread named test', 5, 61),
(181, '2024-06-06 11:38:27', 'Hi, I just created a new Thread named test', 5, 62),
(182, '2024-06-06 11:39:04', 'Hi, I just created a new Thread named a', 5, 63),
(183, '2024-06-06 16:51:10', 'Hi, I just created a new Thread named afafaf', 5, 64),
(185, '2024-06-06 22:25:27', 'hi', 47, 65),
(186, '2024-06-06 22:25:31', 'test', 47, 65),
(187, '2024-06-07 05:28:34', 'test', 5, 41);

-- --------------------------------------------------------

--
-- Structure de la table `notifs`
--

DROP TABLE IF EXISTS `notifs`;
CREATE TABLE IF NOT EXISTS `notifs` (
  `notifID` int NOT NULL AUTO_INCREMENT,
  `userID` int DEFAULT NULL,
  `senderID` int DEFAULT NULL,
  `content` varchar(535) COLLATE utf8mb3_unicode_ci NOT NULL,
  `link` varchar(535) COLLATE utf8mb3_unicode_ci NOT NULL,
  `notifCode` int NOT NULL,
  `isSeen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`notifID`),
  KEY `user` (`userID`),
  KEY `senderID` (`senderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `reportID` int NOT NULL AUTO_INCREMENT,
  `fromUserID` int DEFAULT NULL,
  `aboutUserID` int DEFAULT NULL,
  `threadID` int DEFAULT NULL,
  `messageID` int DEFAULT NULL,
  `content` varchar(535) COLLATE utf8mb3_unicode_ci NOT NULL,
  `isDone` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reportID`),
  KEY `threadID` (`threadID`) USING BTREE,
  KEY `aboutUserID` (`aboutUserID`) USING BTREE,
  KEY `messageID` (`messageID`) USING BTREE,
  KEY `from` (`fromUserID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `reports`
--

INSERT INTO `reports` (`reportID`, `fromUserID`, `aboutUserID`, `threadID`, `messageID`, `content`, `isDone`) VALUES
(1, 5, NULL, 41, NULL, 'Spam', 0),
(17, 5, NULL, 41, NULL, 'Spam', 0),
(18, 5, NULL, 41, NULL, 'Spam', 0),
(19, 5, NULL, 41, NULL, 'Spam', 0),
(20, 5, NULL, 41, NULL, 'Spam', 0),
(21, 5, NULL, 41, NULL, 'Spam', 0),
(22, 5, NULL, 41, NULL, 'Spam', 0),
(23, 5, NULL, 41, NULL, 'Spam', 0),
(24, 5, NULL, 41, NULL, 'Spam', 0),
(25, 5, NULL, 41, NULL, 'Spam', 0),
(26, 5, NULL, 41, NULL, 'Spam', 0),
(27, 5, NULL, 41, NULL, 'Spam', 0),
(28, 5, NULL, 41, NULL, 'Spam', 0),
(29, 5, NULL, 41, NULL, 'Violence', 0),
(30, 5, NULL, 41, NULL, 'Violence', 0),
(31, 5, NULL, 41, NULL, 'Violence', 0),
(32, 5, NULL, 41, NULL, 'Violence', 0),
(33, 5, NULL, 41, NULL, 'Nudity', 0),
(34, 5, NULL, 41, NULL, 'Nudity', 0),
(35, 5, NULL, 41, NULL, 'Nudity', 0),
(36, 5, NULL, 41, NULL, 'Harrasment', 0),
(37, 5, NULL, 41, NULL, 'Harrasment', 0),
(38, 5, NULL, 41, NULL, 'Harrasment', 0),
(39, 5, NULL, 41, NULL, 'Harrasment', 0);

-- --------------------------------------------------------

--
-- Structure de la table `threads`
--

DROP TABLE IF EXISTS `threads`;
CREATE TABLE IF NOT EXISTS `threads` (
  `threadID` int NOT NULL AUTO_INCREMENT,
  `lastMessageID` int DEFAULT NULL,
  `title` varchar(535) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `isDM` tinyint(1) NOT NULL DEFAULT '0',
  `ownerID` int DEFAULT NULL,
  `isPublic` tinyint(1) NOT NULL DEFAULT '0',
  `threadImage` longblob NOT NULL,
  PRIMARY KEY (`threadID`),
  KEY `owner` (`ownerID`),
  KEY `lastMessage` (`lastMessageID`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `threads`
--

INSERT INTO `threads` (`threadID`, `lastMessageID`, `title`, `description`, `isDM`, `ownerID`, `isPublic`, `threadImage`) VALUES
(41, 187, 'test', 'test', 0, 5, 0, ''),
(52, 178, 'test', 'test', 0, 5, 0, ''),
(56, 170, 'test', 'test', 0, 10, 0, ''),
(57, 168, 'test', 'test', 0, 10, 0, ''),
(58, 169, 'test', 'test', 0, 10, 0, ''),
(59, 171, 'test', 'test', 0, 30, 0, ''),
(60, 179, 'test', 'testetststets', 0, 5, 0, ''),
(61, 180, 'test', 'test', 0, 5, 0, ''),
(62, 181, 'test', 'test', 0, 5, 0, ''),
(63, 182, 'a', 'a', 0, 5, 0, ''),
(64, 183, 'afafaf', 'afafaf', 0, 5, 0, ''),
(65, 186, 'test', 'test', 0, 47, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `threadsubscriptions`
--

DROP TABLE IF EXISTS `threadsubscriptions`;
CREATE TABLE IF NOT EXISTS `threadsubscriptions` (
  `threadSubscriptionID` int NOT NULL AUTO_INCREMENT,
  `userID` int DEFAULT NULL,
  `threadID` int DEFAULT NULL,
  PRIMARY KEY (`threadSubscriptionID`),
  KEY `userID` (`userID`),
  KEY `threadID` (`threadID`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `threadsubscriptions`
--

INSERT INTO `threadsubscriptions` (`threadSubscriptionID`, `userID`, `threadID`) VALUES
(24, 5, 41),
(35, 5, 52),
(39, 10, 56),
(40, 10, 57),
(41, 10, 58),
(42, 30, 59),
(43, 5, 60),
(44, 5, 61),
(45, 5, 62),
(46, 5, 63),
(47, 5, 64),
(48, 47, 65);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(535) COLLATE utf8mb3_unicode_ci NOT NULL,
  `gender` enum('M','F','O') COLLATE utf8mb3_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `password` varchar(535) COLLATE utf8mb3_unicode_ci NOT NULL,
  `registrationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profileImage` longblob NOT NULL,
  `description` varchar(535) COLLATE utf8mb3_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `isPrenium` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(535) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID`, `username`, `gender`, `birthdate`, `password`, `registrationDate`, `profileImage`, `description`, `isAdmin`, `isPrenium`, `email`) VALUES
(5, 'test', 'M', '0020-02-20', '$2y$10$6P/U0CbFg9LQ7k4LSAddEet2D7N7sSwJXslH3EC2y9eBd634QI7f.', '2024-05-02 00:00:00', '', 'test', 0, 0, 'do@do'),
(7, 'D', 'M', '2020-02-20', '$2y$10$BwSjlb9F33n7HA7Wg5byGe5VU.7J2ysPgmPPtwkghDtgsgPJ4rpfW', '2024-05-02 00:00:00', '', '', 0, 0, ''),
(8, 'John Wick', 'F', '1978-04-01', '$2y$10$It6iujIe7d.m7z/Pgl3v4eUNhzvVjpQCsfaT0kloQTVrFRYL8hWFm', '2024-05-03 00:00:00', '', '', 0, 0, ''),
(9, 'Toto', 'M', '2001-01-01', '$2y$10$tlstgkkQQeaXs4rX3ht3SeUWeh.gMjzhoWCG8y64mM.jd9DtyTOpS', '2024-05-03 00:00:00', '', '', 0, 0, ''),
(10, 'test2', 'M', '2020-02-20', '$2y$10$72xJya76jD5p9rRt7KM25uHf7bsKWI6V.C3M25b/YyifIRIS5shMG', '2024-05-03 00:00:00', '', '', 0, 0, ''),
(11, 'test3', 'M', '0200-02-20', '$2y$10$Mxemorws7aW0E2ZeoFP3D.vqKKE7zr4LtjI743h/.7bIpuai.gk/W', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(12, 't', 'M', '0002-02-20', '$2y$10$v2be6JNti/g2CrJiJjX0Cupqq5dNoMByL.NODjq7EV.rcBu77Yq5u', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(13, 'e', 'M', '0010-10-10', '$2y$10$5kyO9/mW1gReE3G8SibDOeCr/xyfWVs3GOcefdbuOhEYCQqIRwEEi', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(14, '', 'M', '0025-02-10', '$2y$10$iYPjhhlqeF7kGg8Igb9CeOLrDob3GruyaolhuXhZcliDJdEcZhEbC', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(15, '', 'F', '0010-10-10', '$2y$10$vNznhAjxHyDvJ9DZA3tSbeAx16bUnbHxeWZEjqIBF/a3DGMSLfhmO', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(16, '', 'O', '0101-10-10', '$2y$10$PCys4Ep0SOz0E0X2GW6une53.MGt1BGsvNtTlVVZm7rlsRCzIk0/e', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(17, '', 'O', '0001-01-01', '$2y$10$x6BVesnY6SXDO0SnueLhUu.NdW0W8Sm6cZZ7etIBrv6hRpvEv8SwW', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(18, '', 'O', '0001-01-01', '$2y$10$XxJbe8pW.jFRTfo30DDsiu6yJajaeyJE2K6X1aTKn5WRmIOd7csUS', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(19, '', 'O', '0001-01-01', '$2y$10$kCtQWigMBGJbZRW68b6vv.8TjxzHVC/Eo8K6GQwjBg9jhoCAuedrm', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(20, '', 'O', '0001-01-01', '$2y$10$5qY4j1M1PHePmtPphuACEOZ8vjDUnV9j6iZSy88oIYhnWr8uEM1Dy', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(21, '', 'O', '0001-01-01', '$2y$10$EX/V7tNmnvxzs/45Ib.N4uatAl91.q5snTY.di.oLG/j2AISl3sg.', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(22, '', 'O', '0001-01-01', '$2y$10$5ZwFK072JHIa4mzt.l.8lOPoHh.AEUqvAmhjBJdvPniPSHmUnpT6i', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(23, '', 'O', '0001-01-01', '$2y$10$rZUXuKEKBNK2Z9EzTPIMdesSFCx/oBPKkTg6JKD8cdgHnQ0mX5Wbq', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(24, '', 'O', '0001-01-01', '$2y$10$zEe97fsSwpbLVHj8j61OYuyz2482VuE658u.UekR2up4a2M5N/vLy', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(25, '', 'O', '0001-01-01', '$2y$10$ZoQPYywobGnbX3AbJo267eiyrXtT1EnAJTHi34X.bW/N2fAFKDBLO', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(26, '', 'O', '0001-01-01', '$2y$10$XBjjoyeocxkKl/DqORfkWepRvMiZv4NMKYLtXh6w6BNrBi6ukySjW', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(27, 'ae', 'F', '0010-10-10', '$2y$10$n2A7dxHI0b6IxltdmgchzOXBXfsPUzq3.hFXm34ea5kVTnomSR4Iq', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(28, 'erezrze', 'F', '0100-10-10', '$2y$10$fRo8c2/..YrnBhYWZCPfOuuyplTPnnJJMmy1.Z/Aia65oy3CW3DVW', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(29, 'ERZ', 'F', '0010-10-10', '$2y$10$ctCu05dk0Vl1Y8V1VF.5beUphfkUZ1NX5V1jnXvNX3izBA0YYyYaW', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(30, 'test4', 'M', '1010-10-10', '$2y$10$411LoGFlwmX3LLtl9udZluCupaINY3U6zZ6voCoi6NfBxMel1CW4S', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(31, 'test6', 'O', '0001-10-10', '$2y$10$2Z3.cwB.QVcJEf3RJ1EY2.ngNPJDOLH8BBaTtfzoZcDBzgfayofku', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(32, 'test5', 'M', '0010-10-10', '$2y$10$fgnQTQRWTr5IGS.eVckf5.gRCkf/hawQZ.ZZOzAV8HnDaW2X4ehpK', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(33, 'test7', 'M', '0010-10-10', '$2y$10$UeyPylH4psQGGkr0G7/wx.wWn32lLfc6GperCwhzxNswFGdWtKSMW', '2024-05-10 00:00:00', '', '', 0, 0, ''),
(34, 'testuser', '', '1990-01-01', '$2y$10$YMDh8NALSbjQ7El/utyT4eTkMAxg.pGauRUr6s3ke0CVmTGmwi55i', '2024-05-17 18:36:18', '', '', 0, 0, ''),
(35, 'testuser', 'M', '1990-01-01', '$2y$10$wJadTzRz5H9XsxB09j8/Y.j7T2Bnw9.oTSwCxBFb6gjrgwVCPAuDG', '2024-05-17 18:40:51', '', '', 0, 0, ''),
(36, 'testuser', 'M', '1990-01-01', '$2y$10$r7b31Ae8bKmHw85OzG.0wevqsxQJy51bgxOypLC6EjxV9/ErXTbyi', '2024-05-17 18:42:28', '', '', 0, 0, ''),
(37, 'testuser', 'M', '1990-01-01', '$2y$10$NXDq6tNcCN0zK9RUuJPZ2.BdChpWXbQ6YHBd0R5A/dSmSfZo/ap06', '2024-05-17 18:43:20', '', '', 0, 0, ''),
(38, 'testuser', 'M', '1990-01-01', '$2y$10$hdinBfWyH1aAnLkmg1vRl.MgZTGo2B0lH0jqqAJkkKphVzL6SzR1G', '2024-05-17 18:43:26', '', '', 0, 0, ''),
(39, 'testuser', 'M', '1990-01-01', '$2y$10$ZQtXF4mfvQ.YGgyTQDRi2uV6GpyZPSv.uwRMsN7jbyXvn28bMUKyq', '2024-05-17 18:45:47', '', '', 0, 0, ''),
(40, 'testuser', 'M', '1990-01-01', '$2y$10$7iDdBXzLY10s4CR00rXVn.U6KWrAbbI/k4pH.AlgLJEXesvhZmQ3.', '2024-05-17 18:46:26', '', '', 0, 0, ''),
(41, 'testuser', 'M', '1990-01-01', '$2y$10$8RC5hRay6vlamus2c95jMe.LXTb5pmHUY7OqSoxnOEz7LhclAP646', '2024-05-17 18:47:10', '', '', 0, 0, ''),
(42, 'testuser', 'M', '1990-01-01', '$2y$10$usux/DgmDJa7U2o484qTd.oSkSPW.y0wpuulqUjto6T2AMguipOna', '2024-05-17 18:48:08', '', '', 0, 0, ''),
(43, 'testuser', 'M', '1990-01-01', '$2y$10$AcjusjVAuAQAqiIHk/Lm1uQdSdShLODMmmE5nLDzyG3QYSDJ4Oehm', '2024-05-17 18:49:20', '', '', 0, 0, ''),
(44, 'testuser', 'M', '1990-01-01', '$2y$10$JuFvu4TJFuGVH1ZINK0ZB.6vO.eaaAIsSycn9TUZUYty5aojD8kN.', '2024-05-17 18:52:02', '', '', 0, 0, ''),
(45, 'testuser', 'M', '1990-01-01', '$2y$10$2qO9ySL0X683/2iL5CD5BOULy1.xaeBDqvy0rUGS7mtE0jvg5yIJi', '2024-05-17 18:56:05', '', '', 0, 0, ''),
(46, 'ert', 'M', '0010-10-10', '$2y$10$hN/MaQj5bi2z3gy1l76FwOs6yS1mrIGwy5bBO9Kud0aBAXoVtwy.S', '2024-06-06 22:24:01', '', '', 0, 0, 'er@er'),
(47, 'test12', 'F', '1010-10-10', '$2y$10$MVru3WfSuF6EyOiJjNFlHe6yxdiFohnZ94XKOvizrfCKeFDyKozIq', '2024-06-06 22:24:34', '', '', 0, 0, 'test12@12.12'),
(48, 'ttest', 'M', '0101-02-10', '$2y$10$bS5aLUta.DGQtU715pPlI.RfxBdMuUwgGmm/8qRCo5Fc/oOO1Ubtm', '2024-06-06 22:31:20', '', '', 0, 0, 'test@ty');

-- --------------------------------------------------------

--
-- Structure de la table `uservisitedcountries`
--

DROP TABLE IF EXISTS `uservisitedcountries`;
CREATE TABLE IF NOT EXISTS `uservisitedcountries` (
  `UserVisitedCountriesID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `countryID` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`UserVisitedCountriesID`),
  UNIQUE KEY `userID` (`userID`),
  UNIQUE KEY `countyID` (`countryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `userwishlistcountries`
--

DROP TABLE IF EXISTS `userwishlistcountries`;
CREATE TABLE IF NOT EXISTS `userwishlistcountries` (
  `UserVisitedCountriesID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `countryID` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`UserVisitedCountriesID`),
  UNIQUE KEY `userID` (`userID`),
  UNIQUE KEY `countyID` (`countryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `blockedusers`
--
ALTER TABLE `blockedusers`
  ADD CONSTRAINT `blockedUsersID` FOREIGN KEY (`blockedUserID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usersID` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `friendship`
--
ALTER TABLE `friendship`
  ADD CONSTRAINT `user1` FOREIGN KEY (`user1`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user2` FOREIGN KEY (`user2`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `authorID` FOREIGN KEY (`authorID`) REFERENCES `users` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `threadID` FOREIGN KEY (`threadID`) REFERENCES `threads` (`threadID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notifs`
--
ALTER TABLE `notifs`
  ADD CONSTRAINT `notifs_ibfk_1` FOREIGN KEY (`senderID`) REFERENCES `users` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`fromUserID`) REFERENCES `users` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`aboutUserID`) REFERENCES `users` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_ibfk_3` FOREIGN KEY (`threadID`) REFERENCES `threads` (`threadID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_ibfk_4` FOREIGN KEY (`messageID`) REFERENCES `message` (`messageID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `lastMessage` FOREIGN KEY (`lastMessageID`) REFERENCES `message` (`messageID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `owner` FOREIGN KEY (`ownerID`) REFERENCES `users` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `threadsubscriptions`
--
ALTER TABLE `threadsubscriptions`
  ADD CONSTRAINT `threadSubscriptions_ibfk_1` FOREIGN KEY (`threadID`) REFERENCES `threads` (`threadID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `uservisitedcountries`
--
ALTER TABLE `uservisitedcountries`
  ADD CONSTRAINT `uservisitedcountries_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uservisitedcountries_ibfk_2` FOREIGN KEY (`countryID`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `userwishlistcountries`
--
ALTER TABLE `userwishlistcountries`
  ADD CONSTRAINT `userwishlistcountries_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userwishlistcountries_ibfk_2` FOREIGN KEY (`countryID`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
