
CREATE TABLE `about_us` (
  `content_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `language_id` varchar(255) NOT NULL,
  `headline` text NOT NULL,
  `icon` text NOT NULL,
  `details` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` varchar(220) NOT NULL,
  `account_table_name` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `adv_id` varchar(100) NOT NULL,
  `add_page` varchar(100) DEFAULT NULL,
  `adv_position` int(11) NOT NULL,
  `adv_code` text NOT NULL,
  `adv_code2` text,
  `adv_code3` text,
  `adv_url` varchar(200) DEFAULT NULL,
  `adv_url2` varchar(200) DEFAULT NULL,
  `adv_url3` varchar(200) DEFAULT NULL,
  `adv_type` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bank_add`
--

CREATE TABLE `bank_add` (
  `bank_id` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `ac_name` varchar(250) DEFAULT NULL,
  `ac_number` varchar(250) DEFAULT NULL,
  `branch` varchar(250) DEFAULT NULL,
  `signature_pic` varchar(250) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `default_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE `block` (
  `block_id` varchar(100) NOT NULL,
  `block_cat_id` varchar(100) DEFAULT NULL,
  `block_css` text,
  `block_position` int(11) DEFAULT NULL,
  `block_image` varchar(255) DEFAULT NULL,
  `block_style` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `block`
--

INSERT INTO `block` (`block_id`, `block_cat_id`, `block_css`, `block_position`, `block_image`, `block_style`, `status`) VALUES
('FJQH2QJ2D43JIJ4', 'F9GNCBBPCOIEN67', 'null', 2, 'my-assets/image/block_image/ff3e3a547a2526c7af4d4c7dd711a34d.jpg', 1, 1),
('LL21UR7PWOZTRAC', 'F9GNCBBPCOIEN67', 'null', 1, 'my-assets/image/block_image/677297d226d79be0d2c5a5b3933d985d.jpg', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_image` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`, `brand_image`, `website`, `status`) VALUES
('1JDEMJYYXH1K7UQ', 'Brand_2', 'my-assets/image/brand_image/c43ee753324226b03a3747cdfaa532cf.jpg', 'https://demo453464315.com', 0),
('7XX8FG7MH7FGS87', 'Brand_6', 'my-assets/image/brand_image/e45791b012411f8d128814857e90e95b.jpg', 'https://demo453464315.com', 0),
('R77CKBVFCB76UO9', 'Brand_4', 'my-assets/image/brand_image/0e64deaec1f10c3961fec5323a3bd20d.jpg', 'https://demo453464315.com', 0),
('T36ZSIXTRZVPVEM', 'Brand_3', 'my-assets/image/brand_image/c85ecaefe52828ab5c7d7a92c31029ac.jpg', 'https://demo453464315.com', 0),
('W6TGN2N16JUL5XA', 'Brand_1', 'my-assets/image/brand_image/f5c2659b1a25dd156c874a75fe2736a6.jpg', 'https://demo453464315.com', 0),
('Y9T6ZN4HRILB75N', 'Brand_5', 'my-assets/image/brand_image/bd32a563fca8302abecfc71eb936a3cb.jpg', 'https://demo453464315.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cardpayment`
--

CREATE TABLE `cardpayment` (
  `cardpayment_id` varchar(100) NOT NULL,
  `invoice_id` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `terminal_id` varchar(100) NOT NULL,
  `card_type` varchar(255) NOT NULL,
  `card_no` varchar(100) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category_variant`
--

CREATE TABLE `category_variant` (
  `id` int(11) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `variant_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_variant`
--

INSERT INTO `category_variant` (`id`, `category_id`, `variant_id`, `created_at`, `updated_at`) VALUES
(1, 'F9GNCBBPCOIEN67', 'DBQD7B1AGBAUZSS', '2020-09-06 23:58:10', '2020-09-06 23:58:10'),
(2, 'F9GNCBBPCOIEN67', 'MMYXJ4FWYXAHXPJ', '2020-09-06 23:58:28', '2020-09-06 23:58:28'),
(5, 'F9GNCBBPCOIEN67', '3JJRT8TG11VD1FY', '2021-02-25 04:29:38', '2021-02-25 04:29:38'),
(8, 'F9GNCBBPCOIEN67', 'W1YXEI3VIYW85KA', '2021-02-25 04:35:03', '2021-02-25 04:35:03'),
(10, 'OER22ASL88IWCCI', 'TJ8IK6SW9RHT443', '2021-02-25 04:40:37', '2021-02-25 04:40:37'),
(11, 'OER22ASL88IWCCI', 'F6Q9ERLBZTUPJH7', '2021-02-28 00:02:16', '2021-02-28 00:02:16'),
(12, 'WLFACXRF6T3U3UV', 'HCI7GK7I8CT46E6', '2021-02-28 00:02:58', '2021-02-28 00:02:58');

-- --------------------------------------------------------

--
-- Table structure for table `check_out`
--

CREATE TABLE `check_out` (
  `check_out_id` varchar(100) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `variant_id` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `total_price` float NOT NULL,
  `ip` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cheque_manger`
--

CREATE TABLE `cheque_manger` (
  `cheque_id` varchar(100) NOT NULL,
  `transection_id` varchar(100) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `bank_id` varchar(100) NOT NULL,
  `store_id` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) NOT NULL,
  `cheque_no` varchar(100) NOT NULL,
  `date` varchar(100) DEFAULT NULL,
  `transection_type` varchar(100) NOT NULL,
  `cheque_status` int(2) NOT NULL,
  `amount` float NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `color_backends`
--

CREATE TABLE `color_backends` (
  `id` int(11) NOT NULL,
  `color1` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color2` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color3` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color4` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color5` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `color_backends`
--

INSERT INTO `color_backends` (`id`, `color1`, `color2`, `color3`, `color4`, `color5`) VALUES
(1, '#072040', '#ffffff', '#efefef', '#0066ff', '#ffffff');

-- --------------------------------------------------------

--
-- Table structure for table `color_frontends`
--

CREATE TABLE `color_frontends` (
  `id` int(11) NOT NULL,
  `theme` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `color1` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color2` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color3` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color4` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color5` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color1_font` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color2_font` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color3_font` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color4_font` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color5_font` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `color_frontends`
--

INSERT INTO `color_frontends` (`id`, `theme`, `color1`, `color2`, `color3`, `color4`, `color5`, `color1_font`, `color2_font`, `color3_font`, `color4_font`, `color5_font`) VALUES
(1, 'default', '#8450af', '#a82e9e', '#842d8f', '#b92db4', '#9d1ab7', NULL, NULL, NULL, NULL, NULL),
(2, 'isshue_classic', '#262626 ', '#273d54', '#f03636', '#ef3636', '#f03636', NULL, NULL, NULL, NULL, NULL),
(3, 'shatu', '#ffffff', '#121521', '#0c3150', '#03870c', '#ffffff', NULL, NULL, NULL, NULL, NULL),
(4, 'martbd', '#4baebe', '#273d54', '#0054d1', '#0066ff', '#ffffff', NULL, NULL, NULL, NULL, NULL),
(5, 'zaima', '#ffffff', '#ffffff', '#ffffff', '#008000', '#008000', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_information`
--

CREATE TABLE `company_information` (
  `company_id` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `website` text NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_information`
--

INSERT INTO `company_information` (`company_id`, `company_name`, `email`, `address`, `mobile`, `website`, `status`) VALUES
('NOILG8EGCRXXBWUEUQBM', 'ABC', 'abc@gmail.com', 'New York, USA', '+00-000-00000', 'https://abc.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `sortname` varchar(3) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phonecode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `sortname`, `name`, `phonecode`) VALUES
(1, 'AF', 'Afghanistan', 93),
(2, 'AL', 'Albania', 355),
(3, 'DZ', 'Algeria', 213),
(4, 'AS', 'American Samoa', 1684),
(5, 'AD', 'Andorra', 376),
(6, 'AO', 'Angola', 244),
(7, 'AI', 'Anguilla', 1264),
(8, 'AQ', 'Antarctica', 0),
(9, 'AG', 'Antigua And Barbuda', 1268),
(10, 'AR', 'Argentina', 54),
(11, 'AM', 'Armenia', 374),
(12, 'AW', 'Aruba', 297),
(13, 'AU', 'Australia', 61),
(14, 'AT', 'Austria', 43),
(15, 'AZ', 'Azerbaijan', 994),
(16, 'BS', 'Bahamas The', 1242),
(17, 'BH', 'Bahrain', 973),
(18, 'BD', 'Bangladesh', 880),
(19, 'BB', 'Barbados', 1246),
(20, 'BY', 'Belarus', 375),
(21, 'BE', 'Belgium', 32),
(22, 'BZ', 'Belize', 501),
(23, 'BJ', 'Benin', 229),
(24, 'BM', 'Bermuda', 1441),
(25, 'BT', 'Bhutan', 975),
(26, 'BO', 'Bolivia', 591),
(27, 'BA', 'Bosnia and Herzegovina', 387),
(28, 'BW', 'Botswana', 267),
(29, 'BV', 'Bouvet Island', 0),
(30, 'BR', 'Brazil', 55),
(31, 'IO', 'British Indian Ocean Territory', 246),
(32, 'BN', 'Brunei', 673),
(33, 'BG', 'Bulgaria', 359),
(34, 'BF', 'Burkina Faso', 226),
(35, 'BI', 'Burundi', 257),
(36, 'KH', 'Cambodia', 855),
(37, 'CM', 'Cameroon', 237),
(38, 'CA', 'Canada', 1),
(39, 'CV', 'Cape Verde', 238),
(40, 'KY', 'Cayman Islands', 1345),
(41, 'CF', 'Central African Republic', 236),
(42, 'TD', 'Chad', 235),
(43, 'CL', 'Chile', 56),
(44, 'CN', 'China', 86),
(45, 'CX', 'Christmas Island', 61),
(46, 'CC', 'Cocos (Keeling) Islands', 672),
(47, 'CO', 'Colombia', 57),
(48, 'KM', 'Comoros', 269),
(49, 'CG', 'Republic Of The Congo', 242),
(50, 'CD', 'Democratic Republic Of The Congo', 242),
(51, 'CK', 'Cook Islands', 682),
(52, 'CR', 'Costa Rica', 506),
(53, 'CI', 'Cote D\'Ivoire (Ivory Coast)', 225),
(54, 'HR', 'Croatia (Hrvatska)', 385),
(55, 'CU', 'Cuba', 53),
(56, 'CY', 'Cyprus', 357),
(57, 'CZ', 'Czech Republic', 420),
(58, 'DK', 'Denmark', 45),
(59, 'DJ', 'Djibouti', 253),
(60, 'DM', 'Dominica', 1767),
(61, 'DO', 'Dominican Republic', 1809),
(62, 'TP', 'East Timor', 670),
(63, 'EC', 'Ecuador', 593),
(64, 'EG', 'Egypt', 20),
(65, 'SV', 'El Salvador', 503),
(66, 'GQ', 'Equatorial Guinea', 240),
(67, 'ER', 'Eritrea', 291),
(68, 'EE', 'Estonia', 372),
(69, 'ET', 'Ethiopia', 251),
(70, 'XA', 'External Territories of Australia', 61),
(71, 'FK', 'Falkland Islands', 500),
(72, 'FO', 'Faroe Islands', 298),
(73, 'FJ', 'Fiji Islands', 679),
(74, 'FI', 'Finland', 358),
(75, 'FR', 'France', 33),
(76, 'GF', 'French Guiana', 594),
(77, 'PF', 'French Polynesia', 689),
(78, 'TF', 'French Southern Territories', 0),
(79, 'GA', 'Gabon', 241),
(80, 'GM', 'Gambia The', 220),
(81, 'GE', 'Georgia', 995),
(82, 'DE', 'Germany', 49),
(83, 'GH', 'Ghana', 233),
(84, 'GI', 'Gibraltar', 350),
(85, 'GR', 'Greece', 30),
(86, 'GL', 'Greenland', 299),
(87, 'GD', 'Grenada', 1473),
(88, 'GP', 'Guadeloupe', 590),
(89, 'GU', 'Guam', 1671),
(90, 'GT', 'Guatemala', 502),
(91, 'XU', 'Guernsey and Alderney', 44),
(92, 'GN', 'Guinea', 224),
(93, 'GW', 'Guinea-Bissau', 245),
(94, 'GY', 'Guyana', 592),
(95, 'HT', 'Haiti', 509),
(96, 'HM', 'Heard and McDonald Islands', 0),
(97, 'HN', 'Honduras', 504),
(98, 'HK', 'Hong Kong S.A.R.', 852),
(99, 'HU', 'Hungary', 36),
(100, 'IS', 'Iceland', 354),
(101, 'IN', 'India', 91),
(102, 'ID', 'Indonesia', 62),
(103, 'IR', 'Iran', 98),
(104, 'IQ', 'Iraq', 964),
(105, 'IE', 'Ireland', 353),
(106, 'IL', 'Israel', 972),
(107, 'IT', 'Italy', 39),
(108, 'JM', 'Jamaica', 1876),
(109, 'JP', 'Japan', 81),
(110, 'XJ', 'Jersey', 44),
(111, 'JO', 'Jordan', 962),
(112, 'KZ', 'Kazakhstan', 7),
(113, 'KE', 'Kenya', 254),
(114, 'KI', 'Kiribati', 686),
(115, 'KP', 'Korea North', 850),
(116, 'KR', 'Korea South', 82),
(117, 'KW', 'Kuwait', 965),
(118, 'KG', 'Kyrgyzstan', 996),
(119, 'LA', 'Laos', 856),
(120, 'LV', 'Latvia', 371),
(121, 'LB', 'Lebanon', 961),
(122, 'LS', 'Lesotho', 266),
(123, 'LR', 'Liberia', 231),
(124, 'LY', 'Libya', 218),
(125, 'LI', 'Liechtenstein', 423),
(126, 'LT', 'Lithuania', 370),
(127, 'LU', 'Luxembourg', 352),
(128, 'MO', 'Macau S.A.R.', 853),
(129, 'MK', 'Macedonia', 389),
(130, 'MG', 'Madagascar', 261),
(131, 'MW', 'Malawi', 265),
(132, 'MY', 'Malaysia', 60),
(133, 'MV', 'Maldives', 960),
(134, 'ML', 'Mali', 223),
(135, 'MT', 'Malta', 356),
(136, 'XM', 'Man (Isle of)', 44),
(137, 'MH', 'Marshall Islands', 692),
(138, 'MQ', 'Martinique', 596),
(139, 'MR', 'Mauritania', 222),
(140, 'MU', 'Mauritius', 230),
(141, 'YT', 'Mayotte', 269),
(142, 'MX', 'Mexico', 52),
(143, 'FM', 'Micronesia', 691),
(144, 'MD', 'Moldova', 373),
(145, 'MC', 'Monaco', 377),
(146, 'MN', 'Mongolia', 976),
(147, 'MS', 'Montserrat', 1664),
(148, 'MA', 'Morocco', 212),
(149, 'MZ', 'Mozambique', 258),
(150, 'MM', 'Myanmar', 95),
(151, 'NA', 'Namibia', 264),
(152, 'NR', 'Nauru', 674),
(153, 'NP', 'Nepal', 977),
(154, 'AN', 'Netherlands Antilles', 599),
(155, 'NL', 'Netherlands The', 31),
(156, 'NC', 'New Caledonia', 687),
(157, 'NZ', 'New Zealand', 64),
(158, 'NI', 'Nicaragua', 505),
(159, 'NE', 'Niger', 227),
(160, 'NG', 'Nigeria', 234),
(161, 'NU', 'Niue', 683),
(162, 'NF', 'Norfolk Island', 672),
(163, 'MP', 'Northern Mariana Islands', 1670),
(164, 'NO', 'Norway', 47),
(165, 'OM', 'Oman', 968),
(166, 'PK', 'Pakistan', 92),
(167, 'PW', 'Palau', 680),
(168, 'PS', 'Palestinian Territory Occupied', 970),
(169, 'PA', 'Panama', 507),
(170, 'PG', 'Papua new Guinea', 675),
(171, 'PY', 'Paraguay', 595),
(172, 'PE', 'Peru', 51),
(173, 'PH', 'Philippines', 63),
(174, 'PN', 'Pitcairn Island', 0),
(175, 'PL', 'Poland', 48),
(176, 'PT', 'Portugal', 351),
(177, 'PR', 'Puerto Rico', 1787),
(178, 'QA', 'Qatar', 974),
(179, 'RE', 'Reunion', 262),
(180, 'RO', 'Romania', 40),
(181, 'RU', 'Russia', 70),
(182, 'RW', 'Rwanda', 250),
(183, 'SH', 'Saint Helena', 290),
(184, 'KN', 'Saint Kitts And Nevis', 1869),
(185, 'LC', 'Saint Lucia', 1758),
(186, 'PM', 'Saint Pierre and Miquelon', 508),
(187, 'VC', 'Saint Vincent And The Grenadines', 1784),
(188, 'WS', 'Samoa', 684),
(189, 'SM', 'San Marino', 378),
(190, 'ST', 'Sao Tome and Principe', 239),
(191, 'SA', 'Saudi Arabia', 966),
(192, 'SN', 'Senegal', 221),
(193, 'RS', 'Serbia', 381),
(194, 'SC', 'Seychelles', 248),
(195, 'SL', 'Sierra Leone', 232),
(196, 'SG', 'Singapore', 65),
(197, 'SK', 'Slovakia', 421),
(198, 'SI', 'Slovenia', 386),
(199, 'XG', 'Smaller Territories of the UK', 44),
(200, 'SB', 'Solomon Islands', 677),
(201, 'SO', 'Somalia', 252),
(202, 'ZA', 'South Africa', 27),
(203, 'GS', 'South Georgia', 0),
(204, 'SS', 'South Sudan', 211),
(205, 'ES', 'Spain', 34),
(206, 'LK', 'Sri Lanka', 94),
(207, 'SD', 'Sudan', 249),
(208, 'SR', 'Suriname', 597),
(209, 'SJ', 'Svalbard And Jan Mayen Islands', 47),
(210, 'SZ', 'Swaziland', 268),
(211, 'SE', 'Sweden', 46),
(212, 'CH', 'Switzerland', 41),
(213, 'SY', 'Syria', 963),
(214, 'TW', 'Taiwan', 886),
(215, 'TJ', 'Tajikistan', 992),
(216, 'TZ', 'Tanzania', 255),
(217, 'TH', 'Thailand', 66),
(218, 'TG', 'Togo', 228),
(219, 'TK', 'Tokelau', 690),
(220, 'TO', 'Tonga', 676),
(221, 'TT', 'Trinidad And Tobago', 1868),
(222, 'TN', 'Tunisia', 216),
(223, 'TR', 'Turkey', 90),
(224, 'TM', 'Turkmenistan', 7370),
(225, 'TC', 'Turks And Caicos Islands', 1649),
(226, 'TV', 'Tuvalu', 688),
(227, 'UG', 'Uganda', 256),
(228, 'UA', 'Ukraine', 380),
(229, 'AE', 'United Arab Emirates', 971),
(230, 'GB', 'United Kingdom', 44),
(231, 'US', 'United States', 1),
(232, 'UM', 'United States Minor Outlying Islands', 1),
(233, 'UY', 'Uruguay', 598),
(234, 'UZ', 'Uzbekistan', 998),
(235, 'VU', 'Vanuatu', 678),
(236, 'VA', 'Vatican City State (Holy See)', 39),
(237, 'VE', 'Venezuela', 58),
(238, 'VN', 'Vietnam', 84),
(239, 'VG', 'Virgin Islands (British)', 1284),
(240, 'VI', 'Virgin Islands (US)', 1340),
(241, 'WF', 'Wallis And Futuna Islands', 681),
(242, 'EH', 'Western Sahara', 212),
(243, 'YE', 'Yemen', 967),
(244, 'YU', 'Yugoslavia', 38),
(245, 'ZM', 'Zambia', 260),
(246, 'ZW', 'Zimbabwe', 263);

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `coupon_id` varchar(100) NOT NULL,
  `coupon_name` varchar(100) NOT NULL,
  `coupon_discount_code` varchar(100) NOT NULL,
  `discount_amount` float DEFAULT NULL,
  `discount_percentage` varchar(20) DEFAULT NULL,
  `start_date` varchar(100) NOT NULL,
  `end_date` varchar(100) NOT NULL,
  `discount_type` int(11) DEFAULT NULL COMMENT '1=Taka,2=Percentage',
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_invoice`
--

CREATE TABLE `coupon_invoice` (
  `coupon_invoice_id` varchar(100) NOT NULL,
  `invoice_id` varchar(100) NOT NULL,
  `coupon_code` varchar(100) NOT NULL,
  `date_of_apply` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `crypto_payments`
--

CREATE TABLE `crypto_payments` (
  `paymentID` int(11) UNSIGNED NOT NULL,
  `boxID` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `boxType` enum('paymentbox','captchabox') NOT NULL,
  `orderID` varchar(50) NOT NULL DEFAULT '',
  `userID` varchar(50) NOT NULL DEFAULT '',
  `countryID` varchar(3) NOT NULL DEFAULT '',
  `coinLabel` varchar(6) NOT NULL DEFAULT '',
  `amount` double(20,8) NOT NULL DEFAULT '0.00000000',
  `amountUSD` double(20,8) NOT NULL DEFAULT '0.00000000',
  `unrecognised` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `addr` varchar(34) NOT NULL DEFAULT '',
  `txID` char(64) NOT NULL DEFAULT '',
  `txDate` datetime DEFAULT NULL,
  `txConfirmed` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `txCheckDate` datetime DEFAULT NULL,
  `processed` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `processedDate` datetime DEFAULT NULL,
  `recordCreated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `currency_info`
--

CREATE TABLE `currency_info` (
  `currency_id` varchar(255) NOT NULL,
  `currency_name` varchar(255) NOT NULL,
  `currency_icon` text NOT NULL,
  `currency_position` int(11) NOT NULL DEFAULT '0',
  `convertion_rate` float NOT NULL,
  `default_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currency_info`
--

INSERT INTO `currency_info` (`currency_id`, `currency_name`, `currency_icon`, `currency_position`, `convertion_rate`, `default_status`) VALUES
('ZFUXHWW83EM6QGP', 'USD', '$', 0, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `customer_activities`
--

CREATE TABLE `customer_activities` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(50) DEFAULT NULL,
  `login_count` int(11) DEFAULT NULL,
  `last_login` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer_information`
--

CREATE TABLE `customer_information` (
  `customer_id` varchar(250) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `customer_short_address` text NOT NULL,
  `customer_address_1` text NOT NULL,
  `customer_address_2` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `customer_mobile` varchar(100) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `image` text,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL COMMENT '1=paid,2=credit',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_information`
--

INSERT INTO `customer_information` (`customer_id`, `customer_name`, `first_name`, `last_name`, `customer_short_address`, `customer_address_1`, `customer_address_2`, `city`, `state`, `country`, `zip`, `customer_mobile`, `customer_email`, `image`, `password`, `token`, `company`, `status`, `created_at`) VALUES
('Q2F8JTKZLICO4LE', 'Mr. Customer', NULL, '', '', '', '', 'Mumbai', 'Maharashtra', '101', '', '1234567890', 'customer@customer.com', NULL, '', '', NULL, 1, '2021-04-15 16:09:50');

-- --------------------------------------------------------

--
-- Table structure for table `customer_ledger`
--

CREATE TABLE `customer_ledger` (
  `transaction_id` varchar(100) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `quotation_no` varchar(100) DEFAULT NULL,
  `order_no` varchar(100) NOT NULL,
  `receipt_no` varchar(100) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `description` text NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `date` varchar(100) DEFAULT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `customer_order_id` varchar(100) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `shiping_id` varchar(100) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `payment_method` varchar(100) NOT NULL,
  `total_bill` float NOT NULL,
  `order_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_details`
--

CREATE TABLE `customer_order_details` (
  `c_o_d_id` varchar(100) NOT NULL,
  `customer_order_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `variant_id` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` float NOT NULL,
  `tax` float NOT NULL,
  `vat` float NOT NULL,
  `sell_price` float NOT NULL,
  `supplier_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily_closing`
--

CREATE TABLE `daily_closing` (
  `closing_id` varchar(255) NOT NULL,
  `store_id` varchar(255) NOT NULL,
  `last_day_closing` float NOT NULL,
  `cash_in` float NOT NULL,
  `cash_out` float NOT NULL,
  `date` varchar(250) NOT NULL,
  `amount` float NOT NULL,
  `adjustment` float NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_assign`
--

CREATE TABLE `delivery_assign` (
  `delivery_id` int(11) NOT NULL,
  `delivery_boy_id` int(11) DEFAULT NULL,
  `time_slot_id` int(11) DEFAULT NULL,
  `delivery_zone_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `completed_at` varchar(50) DEFAULT NULL,
  `note` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boy`
--

CREATE TABLE `delivery_boy` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `address` text,
  `bonus` int(11) DEFAULT NULL,
  `driving_license` varchar(255) DEFAULT NULL,
  `national_id` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_no` varchar(100) DEFAULT NULL,
  `account_name` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_orders`
--

CREATE TABLE `delivery_orders` (
  `delivery_id` int(11) DEFAULT NULL,
  `order_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_time_slot`
--

CREATE TABLE `delivery_time_slot` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `from_time` time DEFAULT NULL,
  `to_time` time DEFAULT NULL,
  `last_order_time` time DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_zone`
--

CREATE TABLE `delivery_zone` (
  `id` int(11) NOT NULL,
  `delivery_zone` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `email_configuration`
--

CREATE TABLE `email_configuration` (
  `email_id` varchar(100) NOT NULL,
  `protocol` varchar(100) DEFAULT NULL,
  `mailtype` varchar(100) NOT NULL,
  `smtp_host` varchar(100) DEFAULT NULL,
  `smtp_port` int(11) NOT NULL,
  `sender_email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_configuration`
--

INSERT INTO `email_configuration` (`email_id`, `protocol`, `mailtype`, `smtp_host`, `smtp_port`, `sender_email`, `password`) VALUES
('1', 'smtp', 'html', 'ssl://smtp.googlemail.com', 465, 'bdinfoo.biz@gmail.com', 'bdinfo710785');

-- --------------------------------------------------------

--
-- Table structure for table `image_gallery`
--

CREATE TABLE `image_gallery` (
  `image_gallery_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `img_thumb` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` varchar(100) NOT NULL,
  `quotation_id` varchar(100) DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `customer_id` varchar(100) NOT NULL,
  `store_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `total_amount` float NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `total_discount` float DEFAULT NULL,
  `invoice_discount` float DEFAULT NULL COMMENT 'total_discount + invoice_discount',
  `service_charge` float DEFAULT NULL,
  `shipping_charge` tinyint(4) NOT NULL DEFAULT '0',
  `shipping_method` varchar(255) DEFAULT NULL,
  `paid_amount` float NOT NULL,
  `due_amount` float NOT NULL,
  `invoice_details` text,
  `status` int(2) NOT NULL,
  `invoice_status` int(11) NOT NULL COMMENT '1=shipped,2=cancel,3=pending,4=complete,5=processing,6=return'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `invoice_details_id` varchar(100) NOT NULL,
  `invoice_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `variant_id` varchar(100) NOT NULL,
  `variant_color` varchar(30) DEFAULT NULL,
  `store_id` varchar(100) NOT NULL,
  `quantity` int(8) NOT NULL,
  `rate` float NOT NULL,
  `supplier_rate` float DEFAULT NULL,
  `total_price` float NOT NULL,
  `discount` float DEFAULT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `phrase` text NOT NULL,
  `english` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `phrase`, `english`) VALUES
(1, 'user_profile', 'User Profile'),
(2, 'setting', 'Setting'),
(3, 'language', 'Language'),
(4, 'manage_users', 'Manage Users'),
(5, 'add_user', 'Add User'),
(6, 'manage_company', 'Manage Company'),
(7, 'web_settings', 'Web Settings'),
(8, 'manage_accounts', 'Manage Accounts'),
(9, 'create_accounts', 'Create Accounts'),
(10, 'manage_bank', 'Manage Bank'),
(11, 'add_new_bank', 'Add New Bank'),
(12, 'settings', 'Settings'),
(13, 'closing_report', 'Closing Report'),
(14, 'closing', 'Closing'),
(15, 'cheque_manager', 'Cheque Manager'),
(16, 'accounts_summary', 'Accounts Summary'),
(17, 'payment', 'Payment'),
(18, 'received', 'Received'),
(19, 'accounts', 'Accounts'),
(20, 'stock_report', 'Stock Report'),
(21, 'stock', 'Stock'),
(22, 'pos_invoice', 'POS Invoice'),
(23, 'manage_invoice', 'Manage Invoice '),
(24, 'new_invoice', 'New Invoice'),
(25, 'invoice', 'Invoice'),
(26, 'manage_purchase', 'Manage Purchase'),
(27, 'add_purchase', 'Add Purchase'),
(28, 'purchase', 'Purchase'),
(29, 'paid_customer', 'Paid Customer'),
(30, 'manage_customer', 'Manage Customer'),
(31, 'add_customer', 'Add Customer'),
(32, 'customer', 'Customer'),
(33, 'supplier_ledger', 'Supplier Ledger'),
(34, 'manage_supplier', 'Manage Supplier'),
(35, 'add_supplier', 'Add Supplier'),
(36, 'supplier', 'Supplier'),
(37, 'manage_product', 'Manage Product'),
(38, 'add_product', 'Add Product'),
(39, 'product', 'Product'),
(40, 'manage_category', 'Manage Category'),
(41, 'add_category', 'Add Category'),
(42, 'category', 'Category'),
(43, 'sales_report_product_wise', 'Sales Report (Product Wise)'),
(44, 'purchase_report', 'Purchase Report'),
(45, 'sales_report', 'Sales Report'),
(46, 'todays_report', 'Todays Report'),
(47, 'report', 'Report'),
(48, 'dashboard', 'Dashboard'),
(49, 'online', 'Online'),
(50, 'logout', 'Logout'),
(51, 'change_password', 'Change Password'),
(52, 'total_purchase', 'Total Purchase'),
(53, 'total_amount', 'Total Amount'),
(54, 'supplier_name', 'Supplier Name'),
(55, 'invoice_no', 'Invoice No'),
(56, 'purchase_date', 'Purchase Date'),
(57, 'todays_purchase_report', 'Todays Purchase Report'),
(58, 'total_sales', 'Total Sales'),
(59, 'customer_name', 'Customer Name'),
(60, 'sales_date', 'Sales Date'),
(61, 'todays_sales_report', 'Todays Sales Report'),
(62, 'home', 'Home'),
(63, 'todays_sales_and_purchase_report', 'Todays sales and purchase report'),
(64, 'total_ammount', 'Total Amount'),
(65, 'rate', 'Rate'),
(66, 'product_model', 'Product Model'),
(67, 'search', 'Search'),
(68, 'end_date', 'End Date'),
(69, 'start_date', 'Start Date'),
(70, 'total_purchase_report', 'Total Purchase Report'),
(71, 'total_sales_report', 'Total Sales Report'),
(72, 'total_seles', 'Total Sales'),
(73, 'all_stock_report', 'All Stock Report'),
(74, 'search_by_product', 'Search By Product'),
(75, 'date', 'Date'),
(76, 'print', 'Print'),
(77, 'stock_date', 'Stock Date'),
(78, 'print_date', 'Print Date'),
(79, 'sales', 'Sales'),
(80, 'price', 'Price'),
(81, 'sl', 'SL.'),
(82, 'add_new_category', 'Add new category'),
(83, 'category_name', 'Category Name'),
(84, 'save', 'Save'),
(85, 'delete', 'Delete'),
(86, 'update', 'Update'),
(87, 'action', 'Action'),
(88, 'manage_your_category', 'Manage your category '),
(89, 'category_edit', 'Category Edit'),
(90, 'status', 'Status'),
(91, 'active', 'Active'),
(92, 'inactive', 'Inactive'),
(93, 'save_changes', 'Save Changes'),
(94, 'save_and_add_another', 'Save And Add Another'),
(95, 'model', 'Model'),
(96, 'supplier_price', 'Supplier Price'),
(97, 'sell_price', 'Sell Price'),
(98, 'image', 'Image'),
(99, 'select_one', 'Select One'),
(100, 'details', 'Details'),
(101, 'new_product', 'New Product'),
(102, 'add_new_product', 'Add new product'),
(103, 'barcode', 'Barcode'),
(104, 'qr_code', 'Qr-Code'),
(105, 'product_details', 'Product Details'),
(106, 'manage_your_product', 'Manage your product'),
(107, 'product_edit', 'Product Edit'),
(108, 'edit_your_product', 'Edit your product'),
(109, 'cancel', 'Cancel'),
(110, 'excl_vat', 'Excl. Vat'),
(111, 'money', 'TK'),
(112, 'grand_total', 'Grand Total'),
(113, 'quantity', 'Qnty'),
(114, 'product_report', 'Product Report'),
(115, 'product_sales_and_purchase_report', 'Product sales and purchase report'),
(116, 'previous_stock', 'Previous Stock'),
(117, 'out', 'Out'),
(118, 'in', 'In'),
(119, 'to', 'To'),
(120, 'previous_balance', 'Previous Balance'),
(121, 'customer_address', 'Customer Address'),
(122, 'customer_mobile', 'Customer Mobile'),
(123, 'customer_email', 'Customer Email'),
(124, 'add_new_customer', 'Add new customer'),
(125, 'balance', 'Balance'),
(126, 'mobile', 'Mobile'),
(127, 'address', 'Address'),
(128, 'manage_your_customer', 'Manage your customer'),
(129, 'customer_edit', 'Customer Edit'),
(130, 'paid_customer_list', 'Manage your paid customer'),
(131, 'ammount', 'Amount'),
(132, 'customer_ledger', 'Customer Ledger'),
(133, 'manage_customer_ledger', 'Manage Customer Ledger'),
(134, 'customer_information', 'Customer Information'),
(135, 'debit_ammount', 'Debit Amount'),
(136, 'credit_ammount', 'Credit Amount'),
(137, 'balance_ammount', 'Balance Amount'),
(138, 'receipt_no', 'Receipt NO'),
(139, 'description', 'Description'),
(140, 'debit', 'Debit'),
(141, 'credit', 'Credit'),
(142, 'item_information', 'Item Information'),
(143, 'total', 'Total'),
(144, 'please_select_supplier', 'Please Select Supplier'),
(145, 'submit', 'Submit'),
(146, 'submit_and_add_another', 'Submit And Add Another One'),
(147, 'add_new_item', 'Add New Item'),
(148, 'manage_your_purchase', 'Manage your purchase'),
(149, 'purchase_edit', 'Purchase Edit'),
(150, 'purchase_ledger', 'Purchase Ledger'),
(151, 'invoice_information', 'Invoice Information'),
(152, 'paid_ammount', 'Paid'),
(153, 'discount', 'Dis/ Pcs'),
(154, 'save_and_paid', 'Save And Paid'),
(155, 'payee_name', 'Payee Name'),
(156, 'manage_your_invoice', 'Manage your invoice'),
(157, 'invoice_edit', 'Invoice Edit'),
(158, 'new_pos_invoice', 'New POS invoice'),
(159, 'add_new_pos_invoice', 'Add new pos invoice'),
(160, 'product_id', 'Product ID'),
(161, 'paid_amount', 'Paid'),
(162, 'authorised_by', 'Authorised By'),
(163, 'checked_by', 'Checked By'),
(164, 'received_by', 'Received By'),
(165, 'prepared_by', 'Prepared By'),
(166, 'memo_no', 'Memo No'),
(167, 'website', 'Website'),
(168, 'email', 'Email'),
(169, 'invoice_details', 'Invoice Details'),
(170, 'reset', 'Reset'),
(171, 'payment_account', 'Payment Account'),
(172, 'bank_name', 'Bank Name'),
(173, 'cheque_or_pay_order_no', 'Cheque/Pay Order No'),
(174, 'payment_type', 'Payment Type'),
(175, 'payment_from', 'Payment From'),
(176, 'payment_date', 'Payment Date'),
(177, 'add_received', 'Add Received'),
(178, 'cash', 'Cash'),
(179, 'cheque', 'Cheque'),
(180, 'pay_order', 'Pay Order'),
(181, 'payment_to', 'Payment To'),
(182, 'total_payment_ammount', 'Total Payment Report '),
(183, 'transections', 'Transections'),
(184, 'accounts_name', 'Accounts Name'),
(185, 'payment_report', 'Payment Report'),
(186, 'received_report', 'Income Report'),
(187, 'all', 'All'),
(188, 'account', 'Account'),
(189, 'from', 'From'),
(190, 'account_summary_report', 'Account Summary Report'),
(191, 'search_by_date', 'Search By Date'),
(192, 'cheque_no', 'Cheque No'),
(193, 'name', 'Name'),
(194, 'closing_account', 'Closing Account'),
(195, 'close_your_account', 'Close your account'),
(196, 'last_day_closing', 'Last Day Closing'),
(197, 'cash_in', 'Cash In'),
(198, 'cash_out', 'Cash Out'),
(199, 'cash_in_hand', 'Cash In Hand'),
(200, 'add_new_bank', 'Add New Bank'),
(201, 'day_closing', 'Day Closing'),
(202, 'account_closing_report', 'Account Closing Report'),
(203, 'last_day_ammount', 'Last Day Amount'),
(204, 'adjustment', 'Adjustment'),
(205, 'pay_type', 'Pay Type'),
(206, 'customer_or_supplier', 'Customer , Supplier Or Others'),
(207, 'transection_id', 'Transections ID'),
(208, 'accounts_summary_report', 'Accounts Summary Report'),
(209, 'bank_list', 'Bank List'),
(210, 'bank_edit', 'Bank Edit'),
(211, 'debit_plus', 'Debit (+)'),
(212, 'credit_minus', 'Credit (-)'),
(213, 'account_name', 'Account Name'),
(214, 'account_type', 'Account Type'),
(215, 'account_real_name', 'Account Real Name'),
(216, 'manage_account', 'Manage Account'),
(217, 'company_name', 'Company Name'),
(218, 'edit_your_company_information', 'Edit your company information'),
(219, 'company_edit', 'Company Edit'),
(220, 'admin', 'Admin'),
(221, 'user', 'User'),
(222, 'password', 'Password'),
(223, 'last_name', 'Last Name'),
(224, 'first_name', 'First Name'),
(225, 'add_new_user_information', 'Add new user information'),
(226, 'user_type', 'User Type'),
(227, 'user_edit', 'User Edit'),
(228, 'rtr', 'Right To Left -RTL'),
(229, 'ltr', 'Left To Right -LTR'),
(230, 'ltr_or_rtr', 'LTR/RTL'),
(231, 'footer_text', 'Footer Text'),
(232, 'favicon', 'Favicon'),
(233, 'logo', 'Logo'),
(234, 'update_setting', 'Update Setting'),
(235, 'update_your_web_setting', 'Update your web setting'),
(236, 'login', 'Login'),
(237, 'your_strong_password', 'Your strong password'),
(238, 'your_unique_email', 'Your unique email'),
(239, 'please_enter_your_login_information', 'Please enter your login information.'),
(240, 'update_profile', 'Update Profile'),
(241, 'your_profile', 'Your Profile'),
(242, 're_type_password', 'Re-Type Password'),
(243, 'new_password', 'New Password'),
(244, 'old_password', 'Old Password'),
(245, 'new_information', 'New Information'),
(246, 'old_information', 'Old Information'),
(247, 'change_your_information', 'Change your information'),
(248, 'change_your_profile', 'Change your profile'),
(249, 'profile', 'Profile'),
(250, 'wrong_username_or_password', 'Wrong User Name Or Password !'),
(251, 'successfully_updated', 'Successfully Updated.'),
(252, 'blank_field_does_not_accept', 'Blank Field Does Not Accept !'),
(253, 'successfully_changed_password', 'Successfully changed password.'),
(254, 'you_are_not_authorised_person', 'You are not authorised person !'),
(255, 'password_and_repassword_does_not_match', 'Passwor and re-password does not match !'),
(256, 'new_password_at_least_six_character', 'New Password At Least 6 Character.'),
(257, 'you_put_wrong_email_address', 'You put wrong email address !'),
(258, 'cheque_ammount_asjusted', 'Cheque amount adjusted. '),
(259, 'successfully_payment_paid', 'Successfully Payment Paid.'),
(260, 'successfully_added', 'Successfully Added.'),
(261, 'successfully_updated_2_closing_ammount_not_changeale', 'Successfully Updated -2. Note: Closing Amount Not Changeable.'),
(262, 'successfully_payment_received', 'Successfully Payment Received.'),
(263, 'already_inserted', 'Already Inserted !'),
(264, 'successfully_delete', 'Successfully Delete.'),
(265, 'successfully_created', 'Successfully Created.'),
(266, 'logo_not_uploaded', 'Logo not uploaded !'),
(267, 'favicon_not_uploaded', 'Favicon not uploaded !'),
(268, 'supplier_mobile', 'Supplier Mobile'),
(269, 'supplier_address', 'Supplier Address'),
(270, 'supplier_details', 'Supplier Details'),
(271, 'add_new_supplier', 'Add New Supplier'),
(272, 'manage_suppiler', 'Manage Supplier'),
(273, 'manage_your_supplier', 'Manage your supplier'),
(274, 'manage_supplier_ledger', 'Manage supplier ledger'),
(275, 'invoice_id', 'Invoice ID'),
(276, 'deposit_id', 'Deposite ID'),
(277, 'supplier_actual_ledger', 'Supplier Actual Ledger'),
(278, 'supplier_information', 'Supplier Information'),
(279, 'event', 'Event'),
(280, 'add_new_received', 'Add New Income'),
(281, 'add_payment', 'Add Payment'),
(282, 'add_new_payment', 'Add New Payment'),
(283, 'total_received_ammount', 'Total Received Amount'),
(284, 'create_new_invoice', 'Create New Invoice'),
(285, 'create_pos_invoice', 'Create POS Invoice'),
(286, 'total_profit', 'Total Profit'),
(287, 'monthly_progress_report', 'Monthly Progress Report'),
(288, 'total_invoice', 'Total Invoice'),
(289, 'account_summary', 'Account Summary'),
(290, 'total_supplier', 'Total Supplier'),
(291, 'total_product', 'Total Product'),
(292, 'total_customer', 'Total Customer'),
(293, 'supplier_edit', 'Supplier Edit'),
(294, 'add_new_invoice', 'Add New Invoice'),
(295, 'add_new_purchase', 'Add new purchase'),
(296, 'currency', 'Currency'),
(297, 'currency_position', 'Currency Position'),
(298, 'left', 'Left'),
(299, 'right', 'Right'),
(300, 'add_tax', 'Add Tax'),
(301, 'manage_tax', 'Manage Tax'),
(302, 'add_new_tax', 'Add new tax'),
(303, 'enter_tax', 'Enter Tax'),
(304, 'already_exists', 'Already Exists !'),
(305, 'successfully_inserted', 'Successfully Inserted.'),
(306, 'tax', 'Tax'),
(307, 'tax_edit', 'Tax Edit'),
(308, 'product_not_added', 'Product not added !'),
(309, 'total_tax', 'Total Tax'),
(310, 'manage_your_supplier_details', 'Manage your supplier details.'),
(311, 'invoice_description', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s                                       standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'),
(312, 'thank_you_for_choosing_us', 'Thank you very much for choosing us.'),
(313, 'billing_date', 'Billing Date'),
(314, 'billing_to', 'Billing To'),
(315, 'billing_from', 'Billing From'),
(316, 'you_cant_delete_this_product', 'Sorry !!  You can\'t delete this product.This product already used in calculation system!'),
(317, 'old_customer', 'Old Customer'),
(318, 'new_customer', 'New Customer'),
(319, 'new_supplier', 'New Supplier'),
(320, 'old_supplier', 'Old Supplier'),
(321, 'credit_customer', 'Credit Customer'),
(322, 'account_already_exists', 'This Account Already Exists !'),
(323, 'edit_received', 'Edit Received'),
(324, 'you_are_not_access_this_part', 'You can not access this part !'),
(325, 'account_edit', 'Account Edit'),
(326, 'due', 'Due'),
(327, 'payment_edit', 'Payment Edit'),
(328, 'please_select_customer', 'Please select customer !'),
(329, 'profit_report', 'Profit Report (Invoice Wise)'),
(330, 'total_profit_report', 'Total profit report'),
(331, 'please_enter_valid_captcha', 'Please enter valid captcha.'),
(332, 'category_not_selected', 'Category not selected.'),
(333, 'supplier_not_selected', 'Supplier not selected.'),
(334, 'please_select_product', 'Please select product.'),
(335, 'product_model_already_exist', 'Product model already exist or file format is not correct !'),
(336, 'invoice_logo', 'Invoice Logo'),
(337, 'available_quantity', 'Ava. Qnty'),
(338, 'customer_details', 'Customer details'),
(339, 'manage_customer_details', 'Manage customer details.'),
(340, 'site_key', 'Captcha Site Key'),
(341, 'secret_key', 'Secret Key'),
(342, 'captcha', 'Captcha'),
(343, 'manage_your_credit_customer', 'Manage your credit  customer'),
(344, 'barcode_qrcode', 'Barcode/Qrcode'),
(345, 'barcode_qrcode_scan_here', 'Barcode OR QR code scan here '),
(346, 'please_add_walking_customer_for_default_customer', 'You are delete walking customer.Please add walking customer for default customer.'),
(347, 'stock_report_supplier_wise', 'Stock Report (Supplier Wise)'),
(348, 'stock_report_product_wise', 'Stock Report (Product Wise)'),
(349, 'in_ctn', 'In Ctn.'),
(350, 'out_ctn', 'Out Ctn.'),
(351, 'select_supplier', 'Select Supplier'),
(352, 'in_quantity', 'In Qnty'),
(353, 'out_quantity', 'Out Qnty'),
(354, 'in_taka', 'In Taka'),
(355, 'out_taka', 'Out Taka'),
(356, 'select_product', 'Select Product'),
(357, 'data_synchronizer', 'Data Synchronizer'),
(358, 'synchronize', 'Synchronizer'),
(359, 'backup_restore', 'Backup Restore'),
(360, 'synchronizer_setting', 'Synchronizer Setting'),
(361, 'hostname', 'Hostname'),
(362, 'user_name', 'User Name'),
(363, 'ftp_port', 'FTP Port'),
(364, 'ftp_debug', 'FTP Debug'),
(365, 'project_root', 'Project Root'),
(366, 'internet_connection', 'Internet connection'),
(367, 'outgoing_file', 'Outgoing file'),
(368, 'incoming_file', 'Incoming file'),
(369, 'available', 'Available'),
(370, 'not_available', 'Not Available'),
(371, 'data_upload_to_server', 'Data upload to server'),
(372, 'download_data_from_server', 'Download data from server'),
(373, 'data_import_to_database', 'Data import to database'),
(374, 'please_wait', 'Please wait'),
(375, 'ooops_something_went_wrong', 'Ooops something went wrong.'),
(376, 'ftp_setting', 'FTP setting'),
(377, 'please_try_again', 'Please try again'),
(378, 'save_successfully', 'Save successfully'),
(379, 'upload_successfully', 'Upload successfully'),
(380, 'unable_to_upload_file_please_check_configuration', 'Unable to upload file.Please check configuration.'),
(381, 'please_configure_synchronizer_settings', 'Please configure synchronizer settings'),
(382, 'download_successfully', 'Download successfully'),
(383, 'unable_to_download_file_please_check_configuration', 'Unable to download file.Please check configuration.'),
(384, 'data_import_first', 'Data import first.'),
(385, 'data_import_successfully', 'Data import successfully'),
(386, 'unable_to_import_data_please_check_config_or_sql_file', 'Unable to import data.Please check config or sql file.'),
(387, 'database_backup', 'Database backup'),
(388, 'file_information', 'File information'),
(389, 'filename', 'Filename'),
(390, 'size', 'Size'),
(391, 'backup_date', 'Backup date'),
(392, 'backup_now', 'Backup now'),
(393, 'restore_now', 'Restore now'),
(394, 'are_you_sure', 'Are you sure ?'),
(395, 'download', 'Download'),
(396, 'backup_successfully', 'Backup successfully'),
(397, 'restore_successfully', 'Restore successfully'),
(398, 'delete_successfully', 'Delete successfully'),
(399, 'backup_and_restore', 'Backup and Restore'),
(400, 'close', 'Close'),
(401, 'import_product_csv', 'Import Product (CSV)'),
(402, 'upload_csv_file', 'Upload CSV File'),
(403, 'supplier_id', 'Supplier ID'),
(404, 'category_id', 'Category ID'),
(405, 'file_data_format_is_not_correct', 'File format or data is not correct ! Please flollow the instruction.'),
(406, 'add_unit', 'Add Unit'),
(407, 'manage_unit', 'Manage Unit'),
(408, 'unit', 'Unit'),
(409, 'meter_m', 'Meter (M)'),
(410, 'piece_pc', 'Piece (Pc)'),
(411, 'kilogram_kg', 'Kilogram (Kg)'),
(412, 'select_unit', 'Select Unit'),
(413, 'no_tax', 'No Tax'),
(414, 'suppler_email', 'Supplier Email'),
(415, 'csv_file_informaion', 'CSV File Information'),
(416, 'stock_quantity', 'Stock'),
(417, 'out_of_stock', 'Out Of Stock'),
(418, 'phone', 'Phone'),
(419, 'you_can_not_buy_greater_than_available_cartoon', 'You can not sell greater than available quantity.'),
(420, 'total_discount', 'Total Discount'),
(421, 'if_you_update_purchase_first_select_supplier_then_product_and_then_quantity', 'If you update purchase.First select supplier then product and quantity.'),
(422, 'others', 'Others'),
(423, 'accounts_details_data', 'Accounts Details Data'),
(424, 'add_brand', 'Add Brand'),
(425, 'add_new_brand', 'Add new brand'),
(426, 'brand', 'Brand'),
(427, 'brand_image', 'Brand Image'),
(428, 'brand_name', 'Brand Name'),
(429, 'manage_brand', 'Manage Brand'),
(430, 'brand_edit', 'Brand Edit'),
(431, 'manage_your_brand', 'Manage your brand'),
(432, 'are_you_sure_want_to_delete', 'Are you sure want to delete ?'),
(433, 'variant', 'Variant'),
(434, 'add_variant', 'Add Variant'),
(435, 'manage_variant', 'Manage Variant'),
(436, 'add_new_variant', 'Add New Variant'),
(437, 'variant_name', 'Variant Name'),
(438, 'variant_edit', 'Variant Edit'),
(439, 'type', 'Type'),
(440, 'image_large', 'Image Large'),
(441, 'onsale', 'Offer'),
(442, 'yes', 'Yes'),
(443, 'no', 'No'),
(444, 'featured', 'Featured'),
(445, 'store_set', 'Store Set'),
(446, 'store_add', 'Store Add'),
(447, 'store_product', 'Store Product'),
(448, 'manage_store', 'Manage Store'),
(449, 'add_store', 'Add Store'),
(450, 'add_new_store', 'Add New Store'),
(451, 'store_name', 'Store Name'),
(452, 'store_address', 'Store Address'),
(453, 'manage_your_store', 'Manage your store'),
(454, 'store_edit', 'Store Edit'),
(455, 'store_product_transfer', 'Store Product Transfer'),
(456, 'manage_store_product', 'Manage Store Product'),
(457, 'manage_your_store_product', 'Manage your store product'),
(458, 'store_product_edit', 'Store Product Edit'),
(459, 'wearhouse_add', 'Warehouse Add'),
(460, 'wearhouse_transfer', 'Warehouse Transfer'),
(461, 'manage_wearhouse', 'Manage Warehouse'),
(462, 'wearhouse_set', 'Warehouse Set'),
(463, 'add_wearhouse', 'Add Warehouse'),
(464, 'add_new_wearhouse', 'Add New Warehouse'),
(465, 'wearhouse_name', 'Warehouse Name'),
(466, 'wearhouse_address', 'Warehouse Address'),
(467, 'manage_your_wearhouse', 'Manage your warehouse'),
(468, 'wearhouse_edit', 'Warehouse Edit'),
(469, 'transfer_wearhouse_product', 'Transfer warehouse product'),
(470, 'transfer_to', 'Transfer To'),
(471, 'wearhouse', 'Warehouse'),
(472, 'store', 'Store'),
(473, 'purchase_to', 'Purchase To'),
(474, 'product_and_supplier_did_not_match', 'Product and supplier did not match.'),
(475, 'please_select_wearhouse', 'Please select warehouse !'),
(476, 'product_is_not_available_please_purchase_product', 'Product not available.Please purchase product.'),
(477, 'please_select_store', 'Please select store'),
(478, 'store_transfer', 'Store Transfer'),
(479, 'add_new_unit', 'Add new unit'),
(480, 'unit_name', 'Unit Name'),
(481, 'unit_short_name', 'Unit Short Name'),
(482, 'manage_your_unit', 'Manage your unit'),
(483, 'unit_edit', 'Unit Edit'),
(484, 'gallery', 'Gallery'),
(485, 'add_image', 'Add Image'),
(486, 'manage_image', 'Manage Image'),
(487, 'add_new_image', 'Add new image'),
(488, 'manage_gallery_image', 'Manage gallery image'),
(489, 'image_edit', 'Image Edit'),
(490, 'tax_name', 'Tax Name'),
(491, 'manage_your_tax', 'Manage your tax'),
(492, 'tax_product_service', 'Tax Product Service'),
(493, 'add_tax_product_service', 'Add tax product service'),
(494, 'tax_percentage', 'Tax Percentage'),
(495, 'total_cgst', 'CGST'),
(496, 'total_sgst', 'SGST'),
(497, 'total_igst', 'IGST'),
(498, 'cat_image', 'Category Image'),
(499, 'parent_category', 'Parent category'),
(500, 'top_menu', 'Top Menu'),
(501, 'menu_position', 'Menu Position'),
(502, 'add_pos_invoice', 'Add POS Invoice'),
(503, 'customer_address_1', 'Address 1'),
(504, 'customer_address_2', 'Address 2'),
(505, 'city', 'City'),
(506, 'state', 'State'),
(507, 'country', 'Country'),
(508, 'zip', 'Zip'),
(509, 'transection_type', 'Transection Type'),
(510, 'product_ledger', 'Product Ledger'),
(511, 'transfer_report', 'Transfer Report'),
(512, 'store_to_store_transfer', 'Store To Store Transfer'),
(513, 'to_store', 'To Store'),
(514, 'store_to_warehouse_transfer', 'Store To Warehouse Transfer'),
(515, 'warehouse_to_store_transfer', 'Warehouse To Store Transfer'),
(516, 't_wearhouse', 'To Wearhouse'),
(517, 'warehouse_to_warehouse_transfer', 'Warehouse To Warehouse Transfer'),
(518, 'shop_manager', 'Shop Manager'),
(519, 'sales_man', 'Sales Man'),
(520, 'store_keeper', 'Store Keeper'),
(521, 'item', 'Item'),
(522, 'qnty', 'Qnty'),
(523, 'first', 'First'),
(524, 'last', 'Last'),
(525, 'next', 'Next'),
(526, 'prev', 'Previous'),
(527, '1', '1'),
(528, '2', '2'),
(529, '3', '3'),
(530, 'web_store', 'Web Store'),
(531, 'brand_id', 'Brand ID'),
(532, 'variant_id', 'Variant ID'),
(533, 'items', 'Items'),
(534, 'print_order', 'Print Order'),
(535, 'print_bill', 'Print Bill'),
(536, 'unpaid', 'Unpaid'),
(537, 'paid', 'Paid'),
(538, 'product_discount', 'Product Discount'),
(539, 'invoice_discount', 'Invoice Discount'),
(540, 'terminal', 'Terminal'),
(541, 'manage_terminal', 'Manage Terminal'),
(542, 'add_terminal', 'Add Terminal'),
(543, 'add_new_terminal', 'Add new terminal'),
(544, 'customer_care_phone_no', 'Customer Care Phone No'),
(545, 'terminal_bank_account', 'Terminal Bank Account'),
(546, 'terminal_company', 'Terminal Company'),
(547, 'terminal_name', 'Terminal Name'),
(548, 'manage_your_terminal', 'Manage your terminal'),
(549, 'terminal_edit', 'Terminal Edit'),
(550, 'full_paid', 'Full Paid'),
(551, 'card_no', 'Card NO'),
(552, 'card_type', 'Card Type'),
(553, 'tax_report_product_wise', 'Tax Report (Product Wise)'),
(554, 'tax_report_invoice_wise', 'Tax Report (Invoice Wise)'),
(555, 'software_settings', 'Software Settings'),
(556, 'social_link', 'Social Link'),
(557, 'advertisement', 'Advertisement'),
(558, 'contact_form', 'Contact Form'),
(559, 'update_your_social_link', 'Update your social link'),
(560, 'facebook', 'Facebook'),
(561, 'instagram', 'Instagram'),
(562, 'linkedin', 'Linkedin'),
(563, 'twitter', 'Twitter'),
(564, 'youtube', 'Youtube'),
(565, 'message', 'Message'),
(566, 'manage_contact', 'Manage contact'),
(567, 'manage_your_contact', 'Manage your contact'),
(568, 'update_contact_form', 'Update contact form'),
(569, 'update_your_contact_form', 'Update your contact form'),
(570, 'update_your_web_settings', 'Update your web setting'),
(571, 'google_map', 'Google Map'),
(572, 'about_us', 'About Us'),
(573, 'privacy_policy', 'Privacy Policy'),
(574, 'terms_condition', 'Terms and condition'),
(575, 'cat_icon', 'Category Icon'),
(576, 'add_slider', 'Add Slider'),
(577, 'manage_slider', 'Manage Slider'),
(578, 'update_your_slider', 'Update your slider'),
(579, 'slider_link', 'Slider Link'),
(580, 'slider_image', 'Slider Image'),
(581, 'slider_position', 'Slider Position'),
(582, 'update_slider', 'Update Slider'),
(583, 'manage_your_slider', 'Manage your slider'),
(584, 'successfully_inactive', 'Successfully Inactive'),
(585, 'successfully_active', 'Successfully active'),
(586, 'embed_code', 'Embed Code'),
(587, 'image_ads', 'Image Ads'),
(588, 'url', 'URL'),
(589, 'add_advertise', 'Add Advertisement'),
(590, 'add_new_advertise', 'Add new advertisement'),
(591, 'add_type', 'Ads Type'),
(592, 'ads_position', 'Ads Position'),
(593, 'add_page', 'Add Page'),
(594, 'ads_position_already_exists', 'Ads position already exists!'),
(595, 'manage_advertise', 'Manage Advertise'),
(596, 'manage_advertise_information', 'Manage advertise information'),
(597, 'update_advertise', 'Update Advertise'),
(598, 'add_block', 'Add Block'),
(599, 'manage_block', 'Manage Block'),
(600, 'block_position', 'Block Position'),
(601, 'block_style', 'Block Style'),
(602, 'block_css', 'Block Css'),
(603, 'add_new_block', 'Add new block'),
(604, 'block', 'Block'),
(605, 'manage_your_block', 'Manage your block'),
(606, 'block_edit', 'Block Edit'),
(607, 'add_product_review', 'Add Product Review'),
(608, 'manage_product_review', 'Manage Product Review'),
(609, 'product_review', 'Product Review'),
(610, 'comments', 'Comments'),
(611, 'reviewer_name', 'Reviewer Name'),
(612, 'product_review_edit', 'Product Review Edit'),
(613, 'add_subscriber', 'Add Subscriber'),
(614, 'add_new_subscriber', 'Add new subscriber'),
(615, 'subscriber', 'Subscriber'),
(616, 'manage_subscriber', 'Manage Subscriber'),
(617, 'manage_your_subscriber', 'Manage your subscriber'),
(618, 'subscriber_update', 'Subscriber Update'),
(619, 'apply_ip', 'Apply IP'),
(620, 'add_wishlist', 'Add Wishlist'),
(621, 'add_new_wishlist', 'Add new wishlist'),
(622, 'wishlist', 'Wishlist'),
(623, 'manage_wishlist', 'Manage Wishlist'),
(624, 'manage_your_wishlist', 'Manage your wishlist'),
(625, 'add_web_footer', 'Add Web Footer'),
(626, 'manage_web_footer', 'Manage Web Footer'),
(627, 'headlines', 'Headlines'),
(628, 'position', 'Position'),
(629, 'add_new_web_footer', 'Add new footer'),
(630, 'web_footer', 'Web Footer'),
(631, 'web_footer_update', 'Web Footer Update'),
(632, 'manage_your_web_footer', 'Manage your web footer.'),
(633, 'add_link_page', 'Add Link Page'),
(634, 'manage_link_page', 'Manage Link Page'),
(635, 'add_new_link_page', 'Add new link page'),
(636, 'link_page_update', 'Link Page Update'),
(637, 'manage_your_link_page', 'Manage your link page'),
(638, 'link_page', 'Link Page'),
(639, 'add_coupon', 'Add Coupon'),
(640, 'manage_coupon', 'Manage Coupon'),
(641, 'coupon_name', 'Coupon Name'),
(642, 'coupon_discount_code', 'Coupon Discount Code'),
(643, 'discount_amount', 'Discount Amount'),
(644, 'discount_percentage', 'Discount Percentage'),
(645, 'coupon', 'Coupon'),
(646, 'add_new_coupon', 'Add new coupon'),
(647, 'discount_type', 'Discount Type'),
(648, 'coupon_update', 'Coupon Update'),
(649, 'manage_your_coupon', 'Manage your coupon'),
(650, 'onsale_price', 'Offer Price'),
(651, 'download_sample_file', 'Download sample file'),
(652, 'quotation', 'Quotation'),
(653, 'new_quotation', 'New Quotation'),
(654, 'manage_quotation', 'Manage Quotation'),
(655, 'add_new_quotation', 'Add new quotation'),
(656, 'quotation_no', 'Quotation No'),
(657, 'manage_your_quotation', 'Manage your quotation'),
(658, 'quotation_update', 'Quotation Update'),
(659, 'quotation_details', 'Quotation Details'),
(660, 'quotation_from', 'Quotation Form'),
(661, 'quotation_date', 'Quotation Date'),
(662, 'quotation_to', 'Quotation To'),
(663, 'invoiced', 'Invoiced'),
(664, 'order', 'Order'),
(665, 'new_order', 'New Order'),
(666, 'manage_order', 'Manage Order'),
(667, 'order_no', 'Order No'),
(668, 'order_date', 'Order Date'),
(669, 'order_to', 'Order To'),
(670, 'order_from', 'Order From'),
(671, 'order_details', 'Order Details'),
(672, 'order_update', 'Order Update'),
(673, 'best_sale', 'Best Sale'),
(674, 'call_us', 'CALL US'),
(675, 'sign_up', 'Sign Up'),
(676, 'contact_us', 'Contact Us'),
(677, 'category_product_not_found', 'Opps !!!  product not found !'),
(678, 'sign_up_for_news_and', 'Sign up for news and '),
(679, 'offers', 'Offers'),
(680, 'you_may_unsubscribe_at_any_time', 'You may unsubscribe at any time'),
(681, 'enter_your_email', 'Enter your email.'),
(682, 'product_size', 'Product Size'),
(683, 'product_type', 'Product Type'),
(684, 'availability', 'Availability'),
(685, 'price_of_product', 'Price Of Product'),
(686, 'in_stock', 'In Stock'),
(687, 'related_products', 'Related Products'),
(688, 'review', 'Review'),
(689, 'tag', 'Tag'),
(690, 'specification', 'Specifications'),
(691, 'search_product_name_here', 'Search product name here...'),
(692, 'all_categories', 'All Categories'),
(693, 'best_sales', 'Best Sales'),
(694, 'price_range', 'Price Range'),
(695, 'see_more', 'See More'),
(696, 'add_to_cart', 'Add To Cart'),
(697, 'create_your_account', 'Create Your Account'),
(698, 'create_account', 'Create Account'),
(699, 'you_have_successfully_signup', 'You have successfully sign up.'),
(700, 'you_have_not_sign_up', 'You have not sign up.'),
(701, 'i_have_forgotten_my_password', 'I Have Forgotten My Password'),
(702, 'login_successfully', 'Login Successfully'),
(703, 'you_are_not_authorised', 'You are not authorised Person !'),
(704, 'customer_profile', 'Customer Profile'),
(705, 'total_order', 'Total Order'),
(706, 'add_currency', 'Add Currency'),
(707, 'manage_currency', 'Manage Currency'),
(708, 'add_new_currency', 'Add new currency'),
(709, 'currency_name', 'Currency Name'),
(710, 'currency_icon', 'Currency Icon'),
(711, 'conversion_rate', 'Conversion Rate'),
(712, 'default_status', 'Default Status'),
(713, 'default_store_already_exists', 'Default store already exists !'),
(714, 'currency_edit', 'Currency Edit'),
(715, 'manage_your_currency', 'Manage your currency'),
(716, 'review_this_product', 'Review This Product'),
(717, 'page', 'Page'),
(718, 'delivery_info', 'Delivery Info'),
(719, 'terms_and_condition', 'Terms And Condition'),
(720, 'help', 'Help'),
(721, 'get_in_touch', 'Get In Touch'),
(722, 'write_your_msg_here', 'Write your msg here'),
(723, 'add_about_us', 'Add About Us'),
(724, 'add_new_about_us', 'Add new about us'),
(725, 'manage_about_us', 'Manage About Us'),
(726, 'manage_your_about_us', 'Manage your about us'),
(727, 'about_us_update', 'About Us Update'),
(728, 'position_already_exists', 'Position Already Exists !'),
(729, 'why_choose_us', 'Why Choose US'),
(730, 'our_location', 'Our Location'),
(731, 'add_our_location', 'Add Our Location'),
(732, 'add_new_our_location', 'Add new our location'),
(733, 'manage_our_location', 'Manage Our Location'),
(734, 'our_location_update', 'Our Location Update'),
(735, 'map_api_key', 'Map API Key'),
(736, 'map_latitude', 'Map Latitude'),
(737, 'map_longitude', 'Map Longitude'),
(738, 'checkout_options', 'Checkout Options'),
(739, 'register_account', 'Register Account'),
(740, 'guest_checkout', 'Guest Checkout'),
(741, 'returning_customer', 'Returning Customer'),
(742, 'personal_details', 'Personal Details'),
(743, 'billing_details', 'Billing Details'),
(744, 'delivery_details', 'Delivery Details'),
(745, 'delivery_method', 'Delivery Method'),
(746, 'payment_method', 'Payment Method'),
(747, 'confirm_order', 'Confirm Order'),
(748, 'company', 'Company'),
(749, 'region_state', 'Region / State'),
(750, 'post_code', 'Post Code'),
(751, 'slider', 'Slider'),
(752, 'subscriver', 'Subscriver'),
(753, 'shipping_method', 'Shipping Method'),
(754, 'add_shipping_method', 'Add Shipping Method'),
(755, 'manage_shipping_method', 'Manage Shipping Method'),
(756, 'shipping_method_edit', 'Shipping Method Edit'),
(757, 'bank_transfer', 'Bank Transfer'),
(758, 'cash_on_delivery', 'Cash On Delivery'),
(759, 'sub_total', 'Sub Total'),
(760, 'product_successfully_order', 'Product Successfully Ordered'),
(761, 'checkout', 'Checkout'),
(762, 'share', 'Share'),
(763, 'are_you_sure_want_to_order', 'Are you sure want to order ?'),
(764, 'optional', 'This is optional'),
(765, 'manage_wearhouse_product', 'Manage Wearhouse Product'),
(766, 'you_cant_delete_this_is_in_calculate_system', 'You can\'t delete. This is in calculate system.'),
(767, 'you_can_add_only_one_product_at_a_time', 'You can add only one product at at a time !'),
(768, 'stock_report_store_wise', 'Stock Report (Store Wise)'),
(769, 'invoice_search_item', 'Invoice search item'),
(770, 'default_store', 'Default Store'),
(771, 'total_price', 'Total Price'),
(772, 'use_coupon_code', 'Use coupon code'),
(773, 'enter_your_coupon_here', 'Enter your coupon here'),
(774, 'apply_coupon', 'Apply Coupon'),
(775, 'coupon_code', 'Coupon Code'),
(776, 'cart', 'Cart'),
(777, 'your_coupon_is_used', 'Your coupon is used !'),
(778, 'coupon_is_expired', 'Your coupon is expired !'),
(779, 'coupon_discount', 'Coupon Discount'),
(780, 'oops_your_cart_is_empty', 'OOPS !!! Your Cart is Empty'),
(781, 'got_to_shop_now', 'Go to shop Now'),
(782, 'by_creating_an_account_you_will_able_to_shop_faster', 'By creating an account you will be able to shop faster, be up to date on an order\'s status, and keep track of the orders you have previously made.'),
(783, 'select_category', 'Select Category'),
(784, 'select_state', 'Select State'),
(785, 'my_delivery_and_billing_addresses_are_the_same', 'My delivery and billing addresses are the same.'),
(786, 'i_have_read_and_agree_to_the_privacy_policy', 'I have read and agree to the'),
(787, 'select_country', 'Select Country'),
(788, 'kindly_select_the_preferred_shipping_method_to_use_on_this_order', 'Kindly Select the preferred shipping method to use on this order.'),
(789, 'view_cart', 'View Cart'),
(790, 'category_wise_product', 'Category Wise Product.'),
(791, 'stock_not_available', 'Stock not available !'),
(792, 'print_barcode', 'Print Barcode'),
(793, 'print_qrcode', 'Print QR Code'),
(794, 'product_is_not_available_in_this_store', 'Product is not available in this store !'),
(795, 'category_product_search', 'Category Product Search.'),
(796, 'partial_paid', 'Partial Paid'),
(797, 'manage_product_tax', 'Manage Product Tax'),
(798, 'tax_setting', 'Tax Setting'),
(799, 'tax_name_1', 'Tax 1 Name '),
(800, 'tax_name_2', 'Tax 2 Name'),
(801, 'tax_name_3', 'Tax 3 Name'),
(802, 'quotation_discount', 'Quotation Discount'),
(803, 'select_variant', 'Select Variant'),
(804, 'already_a_member', 'Already a member ?'),
(805, 'not_a_member_yet', 'No a member yet ?'),
(806, 'store_or_wearhouse', 'Store or Wearhouse'),
(807, 'import_category_csv', 'Import Category (CSV)'),
(808, 'import_store_csv', 'Import Store (CSV)'),
(809, 'import_wearhouse_csv', 'Import Wearhouse (CSV)'),
(810, 'image_field_is_required', 'Image field is required !'),
(811, 'email_configuration', 'Email Configuration'),
(812, 'protocol', 'Protocol'),
(813, 'mailtype', 'Mail Type'),
(814, 'smtp_host', 'SMTP Host'),
(815, 'smtp_port', 'SMTP Port'),
(816, 'sender_email', 'Sender Email'),
(817, 'html', 'Html'),
(818, 'text', 'Text'),
(819, 'add_note', 'Add Note'),
(820, 'shipped', 'Shipped'),
(821, 'return', 'Return'),
(822, 'processing', 'Processing'),
(823, 'complete', 'Complete'),
(824, 'pending', 'Pending'),
(825, 'please_add_note', 'Please add note !'),
(826, 'email_send_to_customer', 'Email send to customer'),
(827, 'items_in_your_cart', 'Items In Your Cart.'),
(828, 'you_have', 'You Have'),
(829, 'add_coment_about_your_order', 'Add Comment About Your Order.'),
(830, 'add_coment_about_your_payment', 'Add Comment About Your Order.'),
(831, 'you_have_receive_a_email_please_check_your_email', 'You have received a email.Please check your email.'),
(832, 'invoice_status', 'Invoice Status'),
(833, 'order_information', 'Order Information'),
(834, 'order_info_details', 'Attached below is order. If you have any questions or there are any issues please let us know. Have a great day. '),
(835, 'bank_transfer_instruction', 'Bank Transfer Instruction'),
(836, 'pleasse_transfer_the_total_amount_to_the_following_bank_account', 'Please Transfer The Total Amount To The Following Bank Account.'),
(837, 'account_no', 'Account No'),
(838, 'branch', 'Branch'),
(839, 'add_to_wishlist', 'Add To Wishlist'),
(840, 'quick_view', 'Quick View.'),
(841, 'service_charge', 'Service Charge'),
(842, 'credit_card', 'Credit Card'),
(843, 'debit_card', 'Debit Card'),
(844, 'master_card', 'Master Card'),
(845, 'amex', 'Amex'),
(846, 'visa', 'Visa'),
(847, 'paypal', 'Paypal'),
(848, 'you_cant_delete_this_customer', 'You can\'t delete this customer ! This is in calculating system.'),
(849, 'you_cant_delete_this_supplier', 'You can\'t delete this supplier ! This is in calculating system.'),
(850, 'quotation_information', 'Quotation Information'),
(851, 'quotation_info_details', 'Attached below is quotation. If you have any questions or there are any issues please let us know. Have a great day. '),
(852, 'variant_is_required', 'Variant is required !'),
(853, 'bitcoin', 'Bitcoin'),
(854, 'order_cancel', 'Order cancel'),
(855, 'payeer_payment', 'Payeer Payment'),
(856, 'bitcoin_payment', 'Bitcoin Payment'),
(857, 'customer_id', 'Customer ID'),
(858, 'payeer', 'Payeer'),
(859, 'payment_gateway_setting', 'Payment Gateway Setting'),
(860, 'public_key', 'Public Key'),
(861, 'private_key', 'Private Key'),
(862, 'shop_id', 'Shop ID'),
(863, 'paypal_email', 'Paypal Email'),
(864, 'transaction_faild', 'Transaction Failed !'),
(865, 'footer_logo', 'Footer Logo'),
(866, 'footer_details', 'Footer Details'),
(867, 'default_status_already_exists', 'Default status already exists !'),
(868, 'store_name_already_exists', 'Store name already exists !'),
(869, 'please_set_default_store', 'Please set default store !'),
(870, 'do_you_want_make_it_default_store', 'Do you want make it default store ?'),
(871, 'do_you_want_make_it_default_currency', 'Do you want it default currency ?'),
(872, 'you_must_have_a_default_currency', 'You must have a default currency'),
(873, 'you_cant_delete_this_is_default_currency', 'You cant delete ! This is default currency. '),
(874, 'you_must_have_a_default_store', 'You must have a default sote'),
(875, 'email_not_send', 'Email not send !'),
(876, 'client_id', 'Client ID'),
(877, 'app_qr_code', 'App QR Code'),
(878, 'sms_configuration', 'Sms Configuration'),
(879, 'charset', 'Charset'),
(880, 'port', 'Port'),
(881, 'host', 'Host'),
(882, 'title', 'Title'),
(883, 'gateway', 'Gateway'),
(884, 'smsrank', 'SMS Rank'),
(885, 'sms_pre_text', 'Your Order No '),
(886, 'sms_text', 'has been confirmed '),
(887, 'sms_settings', 'SMS Settings '),
(888, 'sms_template', 'SMS Template'),
(889, 'template_name', 'Template Name'),
(890, 'sms_template_warning', 'please use \"{id}\" format without quotation to set dynamic value inside template. '),
(891, 'qr_status', 'QR Code Status'),
(892, 'pay_with', 'Pay With'),
(893, 'manage_pay_with', 'Manage Pay With'),
(894, 'add_pay_with', 'Add Pay With'),
(895, 'pay_with_edit', 'Pay With Edit'),
(896, 'color_setting_frontend', 'Color Setting Front End'),
(897, 'color1', 'Color 1'),
(898, 'color2', 'Color 2'),
(899, 'color3', 'Color 3'),
(900, 'color_setting_backend', 'Color Setting Backend'),
(901, 'color4', 'Color 4'),
(902, 'forget_password', 'Forgot Password'),
(903, 'send', 'Send'),
(904, 'password_recovery', 'Password Recovery'),
(905, 'color5', 'Color 5'),
(906, 'please_select_product_size', 'Please Select Product Size'),
(907, 'please_keep_quantity_up_to_zero', 'Please Keep Quantity Up To Zero'),
(908, 'product_added_to_cart', 'Product Added To Cart'),
(909, 'not_enough_product_in_stock', 'Not Enough Product In Stock. Please Reduce The Product Quantity.'),
(910, 'please_fill_up_all_required_field', 'Please Fill Up All Required Field'),
(911, 'fe_color1', 'Color1 = header section'),
(912, 'fe_color2', 'Color2 = Dropdown and Footer Section'),
(913, 'fe_color3', 'Color3 = Menu Bar'),
(914, 'be_color1', 'Color1 = Left Bar'),
(915, 'be_color2', 'Color2 = Top And Bottom Bar'),
(916, 'be_color3', 'Color3 = Body Background'),
(917, 'be_color4', 'Color4 = For All Button Except Edit & Delete Button'),
(918, 'be_color5', 'Color5 =  Button Font Color Except edit & Delete Button'),
(919, 'sales_report_store_wise', 'Sales Report (Store Wise)'),
(920, 'fe_color4', 'Color4 = Notification, Sign-up button, Rating, Footer text border, Go to top button  '),
(921, 'link', 'Link'),
(922, 'userid', 'UserId'),
(923, 'this_email_not_exits', 'This Email Not Exits'),
(924, 'sell', 'Sell'),
(925, 'transfer_quantity', 'Transfer Quantity'),
(926, 'order_completed', 'Your Order Is Completed. '),
(927, 'this_coupon_is_already_used', 'This Coupon Is Already Used'),
(928, 'please_login_first', 'Please Login First'),
(929, 'product_added_to_wishlist', 'Product Added To Wishlist'),
(930, 'product_already_exists_in_wishlist', 'Product Already Exists In Wishlist'),
(931, 'support', 'Support'),
(932, 'add_country_code', 'Please Add Country Code To Use SMS Services '),
(933, 'search_items', 'Items Found For '),
(934, 'variant_not_available', 'This variant is not available'),
(935, 'request_failed', 'Request Failed, Please check and try again!'),
(936, 'write_your_comment', 'Please write your comment.'),
(937, 'your_review_added', 'Your review added.'),
(938, 'already_reviewed', 'Thanks. You already reviewed.'),
(939, 'please_type_email_and_password', 'Please type email and password.'),
(940, 'ordered', 'Ordered '),
(941, 'your_order_has_been_confirm', 'Your order has been confirm.'),
(942, 'receive_quantity', 'Receive Quantity'),
(943, 'receive_from', 'Receive From'),
(944, 'stock_report_order_wise', 'Stock Report Order Wise'),
(945, 'theme_activation', 'Theme Activation'),
(946, 'manage_themes', 'Manage Themes'),
(947, 'upload_new_theme', 'Upload New Theme'),
(948, 'theme_name', 'Theme Name'),
(949, 'upload', 'Upload'),
(950, 'themes', 'Themes'),
(951, 'theme_active_successfully', 'Theme Active successfully.'),
(952, 'theme_uploaded_successfully', 'Theme uploaded successfully.'),
(953, 'there_was_a_problem_with_the_upload', 'There was a problem with the upload. Please try again.'),
(954, 'the_theme_has_not_uploaded', 'The Theme has not uploaded!'),
(955, 'have_a_question', 'Have a question?'),
(956, 'buy_now_promotion', 'Buy Now Promotions'),
(957, 'all_departments', 'All Departments'),
(958, 'best_sale_product', 'Best sale Product'),
(959, 'most_popular_product', 'Most Popular Product'),
(960, 'view_all', 'View All'),
(961, 'view_all', 'View All'),
(962, 'brand_of_the_week', 'Brands of the Week'),
(963, 'download_the_app', 'Download The App'),
(964, 'get_access_to_all_exclusive_offers', 'Get access to all exclusive offers, discounts and deals by download our App !'),
(965, 'select', 'Select'),
(966, 'you_may_alo_be_interested_in', 'You May Also Be Interested In'),
(967, 'rate_it', 'Rate It'),
(968, 'similar_products', 'Similar Products'),
(969, 'subscribe_successfully', 'Subscribe Successfully'),
(970, 'please_enter_email', 'Please Enter Valid Email. '),
(971, 'username_or_email', 'Username or Email'),
(972, 'dont_have_an_account', 'Don\'t have an account? '),
(973, 'already_member', 'Already Member ?'),
(974, 'success', 'Success'),
(975, 'lost_your_password', 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.'),
(976, 'reset_password', 'Reset Password'),
(977, 'ago', 'ago'),
(978, 'signin', 'Sign In'),
(979, 'your', 'Your'),
(980, 'product_remove_from_wishlist', 'Product Remove From Wish list'),
(981, 'product_not_remove_from_wishlist', 'Product not remove from wish list'),
(982, 'enter_your_coupon_code_if_you_have_one', 'Enter your coupon code if you have one.'),
(983, 'cart_total', 'Cart Totals'),
(984, 'remember_me', 'Remember Me'),
(985, 'click_here_to_login', 'Click here to login'),
(986, 'if_you_have_shopped_with_us', 'If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing & Shipping section.'),
(987, 'billing_address', 'Billing Address'),
(988, 'create_an_account', 'Create An Account ?'),
(989, 'create_account_password', 'Create Account Password'),
(990, 'notes_about_your_order', 'Notes about your order, e.g. special notes for delivery.'),
(991, 'ship_to_a_different_address', 'Ship to a different address?'),
(992, 'by_variant', 'By Variant  '),
(993, 'by_brand', 'By Brand'),
(994, 'rating', 'Rating'),
(995, 'filter', 'Filter'),
(996, 'by_price', 'By Price'),
(997, '5', '5'),
(998, '4', '4'),
(999, 'your_email_address_will_not_be_published', 'Your email address will not be published. Required fields are marked *'),
(1000, 'shop_of_the_week', 'Shop Of The Week'),
(1001, 'copyright', 'Copyright Â© 2018 Bdtask. All Rights Reserved'),
(1002, 'app_link_status', 'App Link Status'),
(1003, 'update_your_software_setting', 'Update Your Software Setting'),
(1004, 'update_color_setting', 'Update Color Setting'),
(1005, 'update_web_color', 'Update Web Color'),
(1006, 'update_dashboard_color', 'Update Dashboard Color'),
(1007, 'update_color', 'Update Color'),
(1008, 'sslcommerz_email', 'SSLCOMMERZ Email'),
(1009, 'store_id', 'Store ID'),
(1010, 'import_database', 'Import Database'),
(1011, 'check_for_update', 'Check For Update'),
(1012, 'software_update', 'Software Update'),
(1013, 'activated', 'Activated'),
(1014, 'back_to_home', 'Back to home'),
(1015, 'in_active', 'In Active'),
(1016, 'january', 'January'),
(1017, 'february', 'February'),
(1018, 'march', 'March'),
(1019, 'january', 'January'),
(1020, 'february', 'February'),
(1021, 'april', 'April'),
(1022, 'may', 'May'),
(1023, 'june', 'June'),
(1024, 'july', 'July'),
(1025, 'august', 'August'),
(1026, 'september', 'September'),
(1027, 'october', 'October'),
(1028, 'november', 'November'),
(1029, 'december', 'December'),
(1030, 'product_image_gallery', 'Product Image Gallery'),
(1031, 'add_product_image', 'Add product image'),
(1032, 'manage_product_image', 'Manage product image'),
(1033, 'sms_service', 'SMS Service '),
(1034, 'google_analytics', 'Google Analytics'),
(1035, 'facebook_messenger', 'Facebook Messenger'),
(1036, 'welcome_back_to_login', 'Welcome Back to Login.'),
(1037, 'application_protocol', 'Application Protocol'),
(1038, 'http', 'HTTP'),
(1039, 'https', 'HTTPS'),
(1040, 'login_with_facebook', 'Login with facebook'),
(1041, 'social_authentication', 'Social Authentication'),
(1042, 'manage_social_media', 'Manage social media'),
(1043, 'social', 'Social'),
(1044, 'app_id', 'App ID'),
(1045, 'app_secret', 'App Secret'),
(1046, 'api_key', 'Api key'),
(1047, 'shipping_charge', 'Shipping Charge'),
(1048, 'stock_report_variant_wise', 'Stock report variant wise'),
(1049, 'purchase', 'Purchase'),
(1050, 'rating_and_reviews', 'Ratings and Reviews'),
(1051, 'average_user_rating', 'Average user rating'),
(1052, 'rating_breakdown', 'Rating breakdown'),
(1053, '100_percent_complete', '100% Complete (success)'),
(1054, '80_percent_complete', '80% Complete (primary)'),
(1055, '60_percent_complete', '60% Complete (info)'),
(1056, '40_percent_complete', '40% Complete (warning)'),
(1057, '20_percent_complete', '20% Complete (danger)'),
(1058, 'default_variant', 'Default variant'),
(1059, 'video_link', 'Video Link'),
(1060, 'send_your_review', 'Send Your Review'),
(1061, 'if_you_have_shopped_with_us_before', 'If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing & Shipping section.'),
(1062, 'your_order', 'Your order'),
(1063, 'free_shipping', 'Free Shipping'),
(1064, 'from_newyork', 'From 345/E NewYork'),
(1065, 'the_internet_tend_to_repeat', 'The internet Tend To Repeat'),
(1066, '45_days_return', '45 Days Return'),
(1067, 'making_it_look_like_readable', 'Making it Look Like Readable'),
(1068, 'opening_all_week', 'Opening All Week'),
(1069, '8am_9pm', '08AM - 09PM'),
(1070, 'ad_style', 'Ads Style'),
(1071, 'style_one', 'Style One'),
(1072, 'style_two', 'Style Two'),
(1073, 'style_three', 'Style Three'),
(1074, 'embed_code2', 'Embed Code2'),
(1075, 'embed_code3', 'Embed Code3'),
(1076, 'url2', 'URL2'),
(1077, 'url3', 'URL3'),
(1078, 'image2', 'Image 2'),
(1079, 'image3', 'Image 3'),
(1080, 'order_now', 'Order Now'),
(1081, 'default_variant_must_have_to_be_one_of_the_variants', 'Default variant must have to be one of the variants'),
(1082, 'default_image', 'Default image'),
(1083, 'meta_keyword', 'Meta keyword'),
(1084, 'meta_description', 'Meta description'),
(1085, 'this_email_already_exists', 'This email already exists'),
(1086, 'you_cant_delete_this_is_default_store', 'You can\'t delete it. This is a default store. '),
(1087, 'already_exists_please_login', 'This Email already exists please login or use another email. '),
(1088, '4-5', '4-5'),
(1089, 'sign_office', 'Sign Office'),
(1090, 'customer_sign', 'Customer Sign'),
(1091, 'thank_you_for_shopping_with_us', 'Thank you for shopping with us.'),
(1092, 'new_sale', 'New sale'),
(1093, 'manage_sale', 'Manage sale'),
(1094, 'pos_sale', 'Pos sale'),
(1095, 'android_apps', 'Android apps'),
(1096, 'update_your_android_apps_link', 'Update your android apps link'),
(1097, 'put_your_apps_link', 'Put your apps link'),
(1098, 'go_to_website', 'Go to website'),
(1099, 'our_demo', 'Our demo'),
(1100, 'note', 'Note'),
(1101, 'login', 'Login'),
(1102, 'email', 'Email Address'),
(1103, 'password', 'Password'),
(1104, 'reset', 'Reset'),
(1105, 'dashboard', 'Dashboard'),
(1106, 'home', 'Home'),
(1107, 'profile', 'Profile'),
(1108, 'profile_setting', 'Profile Setting'),
(1109, 'firstname', 'First Name'),
(1110, 'lastname', 'Last Name'),
(1111, 'about', 'About'),
(1112, 'preview', 'Preview'),
(1113, 'image', 'Image'),
(1114, 'save', 'Save'),
(1115, 'upload_successfully', 'Upload Successfully!'),
(1116, 'user_added_successfully', 'User Added Successfully!'),
(1117, 'please_try_again', 'Please Try Again...'),
(1118, 'inbox_message', 'Inbox Messages'),
(1119, 'sent_message', 'Sent Message'),
(1120, 'message_details', 'Message Details'),
(1121, 'new_message', 'New Message'),
(1122, 'receiver_name', 'Receiver Name'),
(1123, 'sender_name', 'Sender Name'),
(1124, 'subject', 'Subject'),
(1125, 'message', 'Message'),
(1126, 'message_sent', 'Message Sent!'),
(1127, 'ip_address', 'IP Address'),
(1128, 'last_login', 'Last Login'),
(1129, 'last_logout', 'Last Logout'),
(1130, 'status', 'Status'),
(1131, 'deleted_successfully', 'Deleted Successfully!'),
(1132, 'send', 'Send'),
(1133, 'date', 'Date'),
(1134, 'action', 'Action'),
(1135, 'sl_no', 'SL No.'),
(1136, 'are_you_sure', 'Are You Sure ? '),
(1137, 'application_setting', 'Application Setting'),
(1138, 'application_title', 'Application Title'),
(1139, 'address', 'Address'),
(1140, 'phone', 'Phone'),
(1141, 'favicon', 'Favicon'),
(1142, 'logo', 'Logo'),
(1143, 'language', 'Language'),
(1144, 'left_to_right', 'Left To Right'),
(1145, 'right_to_left', 'Right To Left'),
(1146, 'footer_text', 'Footer Text'),
(1147, 'site_align', 'Application Alignment'),
(1148, 'welcome_back', 'Welcome Back!'),
(1149, 'please_contact_with_admin', 'Please Contact With Admin'),
(1150, 'incorrect_email_or_password', 'Incorrect Email/Password');
INSERT INTO `language` (`id`, `phrase`, `english`) VALUES
(1151, 'select_option', 'Select Option'),
(1152, 'ftp_setting', 'Data Synchronize [FTP Setting]'),
(1153, 'hostname', 'Host Name'),
(1154, 'username', 'Username'),
(1155, 'ftp_port', 'FTP Port'),
(1156, 'ftp_debug', 'FTP Debug'),
(1157, 'project_root', 'Project Root'),
(1158, 'update_successfully', 'Update Successfully'),
(1159, 'save_successfully', 'Save Successfully!'),
(1160, 'delete_successfully', 'Delete Successfully!'),
(1161, 'internet_connection', 'Internet Connection'),
(1162, 'ok', 'Ok'),
(1163, 'not_available', 'Not Available'),
(1164, 'available', 'Available'),
(1165, 'outgoing_file', 'Outgoing File'),
(1166, 'incoming_file', 'Incoming File'),
(1167, 'data_synchronize', 'Data Synchronize'),
(1168, 'unable_to_upload_file_please_check_configuration', 'Unable to upload file! please check configuration'),
(1169, 'please_configure_synchronizer_settings', 'Please configure synchronizer settings'),
(1170, 'download_successfully', 'Download Successfully'),
(1171, 'unable_to_download_file_please_check_configuration', 'Unable to download file! please check configuration'),
(1172, 'data_import_first', 'Data Import First'),
(1173, 'data_import_successfully', 'Data Import Successfully!'),
(1174, 'unable_to_import_data_please_check_config_or_sql_file', 'Unable to import data! please check configuration / SQL file.'),
(1175, 'download_data_from_server', 'Download Data from Server'),
(1176, 'data_import_to_database', 'Data Import To Database'),
(1177, 'data_upload_to_server', 'Data Upload to Server'),
(1178, 'please_wait', 'Please Wait...'),
(1179, 'ooops_something_went_wrong', ' Ooops something went wrong...'),
(1180, 'module_permission_list', 'Module Permission List'),
(1181, 'user_permission', 'User Permission'),
(1182, 'add_module_permission', 'Add Module Permission'),
(1183, 'module_permission_added_successfully', 'Module Permission Added Successfully!'),
(1184, 'update_module_permission', 'Update Module Permission'),
(1185, 'download', 'Download'),
(1186, 'module_name', 'Module Name'),
(1187, 'create', 'Create'),
(1188, 'read', 'Read'),
(1189, 'update', 'Update'),
(1190, 'delete', 'Delete'),
(1191, 'module_list', 'Module List'),
(1192, 'add_module', 'Add Module'),
(1193, 'directory', 'Module Direcotory'),
(1194, 'description', 'Description'),
(1195, 'image_upload_successfully', 'Image Upload Successfully!'),
(1196, 'module_added_successfully', 'Module Added Successfully'),
(1197, 'inactive', 'Inactive'),
(1198, 'active', 'Active'),
(1199, 'user_list', 'User List'),
(1200, 'see_all_message', 'See All Messages'),
(1201, 'setting', 'Setting'),
(1202, 'logout', 'Logout'),
(1203, 'admin', 'Admin'),
(1204, 'add_user', 'Add User'),
(1205, 'user', 'User'),
(1206, 'module', 'Module'),
(1207, 'new', 'New'),
(1208, 'inbox', 'Inbox'),
(1209, 'sent', 'Sent'),
(1210, 'synchronize', 'Synchronize'),
(1211, 'data_synchronizer', 'Data Synchronizer'),
(1212, 'module_permission', 'Module Permission'),
(1213, 'backup_now', 'Backup Now!'),
(1214, 'restore_now', 'Restore Now!'),
(1215, 'backup_and_restore', 'Backup and Restore'),
(1216, 'captcha', 'Captcha Word'),
(1217, 'database_backup', 'Database Backup'),
(1218, 'restore_successfully', 'Restore Successfully'),
(1219, 'backup_successfully', 'Backup Successfully'),
(1220, 'filename', 'File Name'),
(1221, 'file_information', 'File Information'),
(1222, 'size', 'size'),
(1223, 'backup_date', 'Backup Date'),
(1224, 'overwrite', 'Overwrite'),
(1225, 'invalid_file', 'Invalid File!'),
(1226, 'invalid_module', 'Invalid Module'),
(1227, 'remove_successfully', 'Remove Successfully!'),
(1228, 'install', 'Install'),
(1229, 'uninstall', 'Uninstall'),
(1230, 'tables_are_not_available_in_database', 'Tables are not available in database.sql'),
(1231, 'no_tables_are_registered_in_config', 'No tables are registerd in config.php'),
(1232, 'enquiry', 'Enquiry'),
(1233, 'read_unread', 'Read/Unread'),
(1234, 'enquiry_information', 'Enquiry Information'),
(1235, 'user_agent', 'User Agent'),
(1236, 'checked_by', 'Checked By'),
(1237, 'new_enquiry', 'New Enquiry'),
(1238, 'first_name_is_required', 'First name is required'),
(1239, 'last_name_is_required', 'Last name is required'),
(1240, 'mobile_is_required', 'Mobile is required'),
(1241, 'country_is_required', 'Country is required'),
(1242, 'address_is_required', 'Address is required'),
(1243, 'state_is_required', 'State is required'),
(1244, 'failed_try_again', 'Failed! Please try again.'),
(1245, 'failed', 'Failed'),
(1246, 'subscribe_for_news_and', 'Subscribe for news and'),
(1247, 'subscribe', 'Subscribe'),
(1248, 'reviews', 'Reviews'),
(1249, 'feedback', 'Feedback'),
(1250, 'unit_id', 'Unit ID'),
(1251, 'set_default', 'Set default'),
(1252, 'add', 'Add'),
(1253, 'list', 'List'),
(1254, 'invalid_coupon', 'Invalid Coupon'),
(1255, 'login_to_apply_coupon', 'Login to apply coupon'),
(1256, 'great_your_coupon_is_applied', 'Great! Your coupon is applied'),
(1257, 'fe_color5', 'color5=Header Top Bar'),
(1258, 'receiver_email', 'Receiver email'),
(1259, 'modules', 'Modules'),
(1260, 'modules_management', 'Modules Management'),
(1261, 'buy_now', 'Buy now'),
(1262, 'no_theme_available', 'No Theme Available!'),
(1263, 'purchase_key', 'Purchase Key'),
(1264, 'invalid_purchase_key', 'Invalid Purchase Key'),
(1265, 'theme_deleted_successfully', 'Theme Deleted Successfully'),
(1266, 'downloaded_successfully', 'Downloaded Successfully'),
(1267, 'slider_category', 'Slider Category'),
(1268, 'clear_cart', 'Clear Cart'),
(1269, 'continue_shopping', 'Continue Shopping'),
(1270, 'my_cart', 'My Cart'),
(1271, 'favorites', 'Favorites'),
(1272, 'states', 'States'),
(1273, 'manage_states', 'Manage States'),
(1274, 'add_state', 'Add State'),
(1275, 'edit_state', 'Edit State'),
(1276, 'connect_with_us', 'Connect With Us'),
(1277, 'footer_block_1', 'Footer Block 1'),
(1278, 'footer_block_2', 'Footer Block 2'),
(1279, 'footer_block_3', 'Footer Block 3'),
(1280, 'footer_block_4', 'Footer Block 4'),
(1281, 'show', 'Show'),
(1282, 'hide', 'Hide'),
(1283, 'mobile_settings', 'Mobile Settings (For website Footer)'),
(1284, 'social_share', 'Social Share'),
(1285, 'bank', 'Bank'),
(1286, 'order_placed', 'Your order has been successfully placed'),
(1287, 'update_woocommerce_stock', 'Update Woocommerce Stock'),
(1288, 'track_my_order', 'Track My Order'),
(1289, 'no_data_found', 'No data found'),
(1290, 'payment_status', 'Payment Status'),
(1291, 'order_status', 'Order Status'),
(1292, 'latest_search_keywords', 'Latest Search Keywords'),
(1293, 'keywords', 'Keywords'),
(1294, 'results', 'Results'),
(1295, 'hits', 'Hits'),
(1296, 'latest_product_reviews', 'Latest Product Reviews'),
(1297, 'products', 'Products'),
(1298, 'category_products', 'Category Products'),
(1299, 'categories', 'Categories'),
(1300, 'products_count', 'Products Count'),
(1301, 'bank', 'Bank'),
(1302, 'orders_count', 'orders Count'),
(1303, 'all_best_sale_product', 'All Best Sale Product'),
(1304, 'monthly_best_sale_product', 'Monthly Best Sale Product'),
(1305, 'role', 'Role'),
(1306, 'add_role', 'Add Role'),
(1307, 'manage_roles', 'Manage Roles'),
(1308, 'manage_user_roles', 'Manage User Roles'),
(1309, 'role_name', 'Role Name'),
(1310, 'role_description', 'Role Description'),
(1311, 'menu_title', 'Menu Title'),
(1312, 'role_edit', 'Role Edit'),
(1313, 'user_access_role', 'User Access Role'),
(1314, 'role_add_to_user', 'Role Add To User'),
(1315, 'variant_type', 'Variant Type'),
(1316, 'color', 'Color'),
(1317, 'color_code', 'Color Code'),
(1318, 'set_variant_wise_price', 'Set Variant Wise Price'),
(1319, 'all_category_products', 'All Category Products'),
(1320, 'all_latest_search_keywords', 'All Latest Search Keywords'),
(1321, 'positive_review', 'Positive Review'),
(1322, 'all_category_products', 'All Category Products'),
(1323, 'all_latest_search_keywords', 'All Latest Search Keywords'),
(1324, 'positive_review', 'Positive Review'),
(1325, 'customer_activities', 'Customer Activities'),
(1326, 'new_customers', 'New Customers'),
(1327, 'returning_customers', 'Returning Customers'),
(1328, 'average_spending_per_visit', 'Average Spending Per Visit'),
(1329, 'average_visits_per_customer', 'Average Visits Per Customer'),
(1330, 'seo_tools', 'SEO Tools'),
(1331, 'popular_products', 'Popular Products'),
(1332, 'website_meta_keywords', 'Website Meta Keywords'),
(1333, 'meta_keywords', 'Meta Keywords'),
(1334, 'clicks', 'Clicks'),
(1335, 'created_by', 'Created by'),
(1336, 'product_added_to_compare', 'Product Added to Compare'),
(1337, 'compare', 'Compare'),
(1338, 'bonus', 'Bonus'),
(1339, 'edit_delivery_boy', 'Edit Delivery Boy'),
(1340, 'national_id_card', 'National Id Card'),
(1341, 'driving_license', 'Driving License'),
(1342, 'other_payment_info', 'Other Payment Info.'),
(1343, 'add_time_slot', 'Add Time Slot'),
(1344, 'from_time', 'From Time'),
(1345, 'to_time', 'To Time'),
(1346, 'last_order_time', 'Last Order Time'),
(1347, 'edit_delivery_time_slot', 'Edit Delivery Time Slot'),
(1348, 'paid_by', 'Paid By'),
(1349, 'transferred_at', 'Transferred At'),
(1350, 'assign_time_slot', 'Assign Time Slot'),
(1351, 'delivery_zone', 'Delivery Zone'),
(1352, 'manage_delivery_zone', 'Manage Delivery Zone'),
(1353, 'edit_delivery_zone', 'Edit Delivery Zone'),
(1354, 'assign_delivery', 'Assign Delivery'),
(1355, 'select_delivery_zone', 'Select Delivery Zone'),
(1356, 'select_delivery_boy', 'Select Delivery Boy'),
(1357, 'manage_assign_delivery', 'Manage Assign Delivery'),
(1358, 'orders', 'Orders'),
(1359, 'select_order', 'Select Order'),
(1360, 'successfully_assigned', 'Successfully Assigned'),
(1361, 'assigns', 'Assigns'),
(1362, 'manage_assigned_delivery', 'Manage Assigned Delivery'),
(1363, 'time_slot', 'Time Slot'),
(1364, 'select_time_slot', 'Select Time Slot'),
(1365, 'select_orders', 'Select Orders'),
(1366, 'delivery_id', 'Delivery Id'),
(1367, 'assigned_delivery_orders', 'Assigned Delivery Orders'),
(1368, 'edit_assigned_delivery', 'Edit Assigned Delivery'),
(1369, 'completed_at', 'Completed At'),
(1370, 'delivery_assigns', 'Delivery Assigns'),
(1371, 'delivery_system', 'Delivery System'),
(1372, 'delivery_boy', 'Delivery Boy'),
(1373, 'add_delivery_boy', 'Add Delivery Boy'),
(1374, 'manage_delivery_boy', 'Manage Delivery Boy'),
(1375, 'delivery_slot', 'Delivery Slot'),
(1376, 'manage_time_slot', 'Manage Time Slot'),
(1377, 'birth_certificate', 'Birth Certificate'),
(1378, 'date_of_birth', 'Date of Birth'),
(1379, 'bank_account_name', 'Bank Account Name'),
(1380, 'delivery_balance_transfer', 'Delivery Balance Transfer'),
(1381, 'transfer_amount', 'Transfer Amount'),
(1382, 'amount', 'Amount'),
(1383, 'successfully_transferred', 'Successfully Transferred'),
(1384, 'balance_transfer', 'Balance Transfer'),
(1385, 'balance_transfer_history', 'Balance Transfer History'),
(1386, 'out_of_balance', 'Out of Balance'),
(1387, 'delivery_area', 'Delivery Area'),
(1388, 'add_delivery_zone', 'Add Delivery Zone'),
(1389, 'created_at', 'Created at'),
(1390, 'role_user', 'Role User'),
(1391, 'newsletters', 'Newsletters'),
(1392, 'compare_product', 'Compare Product'),
(1393, 'models', 'Models'),
(1394, 'order_title', 'Order Title'),
(1395, 'in_amount', 'In Amount'),
(1396, 'out_amount', 'Out Amount'),
(1397, 'product_name', 'Product name');

-- --------------------------------------------------------

--
-- Table structure for table `link_page`
--

CREATE TABLE `link_page` (
  `link_page_id` varchar(100) NOT NULL,
  `page_id` varchar(255) NOT NULL,
  `language_id` varchar(255) NOT NULL,
  `headlines` text,
  `image` text,
  `details` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `link_page`
--

INSERT INTO `link_page` (`link_page_id`, `page_id`, `language_id`, `headlines`, `image`, `details`, `status`) VALUES
('1O7RLB4BQ1HR94K', '3', 'bangla', '', 'my-assets/image/link_page/8f5013440d835b56c55867a9125f0e4c.jpg', '', 1),
('E3XOZ4N7DM8IG4P', '1', 'english', '<p>ABOUT US<br></p>', 'my-assets/image/link_page/2eaa2ed9eee24c9c08feb568d26f54e7.jpg', '<p><span xss=removed>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</span><br></p>', 1),
('PQA7JY6HKXTHW81', '1', 'bangla', '<p><br></p>', 'my-assets/image/link_page/2eaa2ed9eee24c9c08feb568d26f54e7.jpg', '<p><br></p>', 1),
('SCHKM9YIFLEJ7OV', '3', 'english', '<p>Delivery Infomation<br></p>', 'my-assets/image/link_page/8f5013440d835b56c55867a9125f0e4c.jpg', '<p>we are trying to deliver our product  very short time<br></p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `datetime` datetime NOT NULL,
  `sender_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=unseen, 1=seen, 2=delete',
  `receiver_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=unseen, 1=seen, 2=delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `directory` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `module_permission`
--

CREATE TABLE `module_permission` (
  `id` int(11) NOT NULL,
  `fk_module_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `create` tinyint(1) DEFAULT NULL,
  `read` tinyint(1) DEFAULT NULL,
  `update` tinyint(1) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` varchar(100) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `store_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `total_amount` float NOT NULL,
  `order` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `total_discount` float DEFAULT NULL,
  `order_discount` float DEFAULT NULL COMMENT 'total_discount + order_discount',
  `service_charge` float DEFAULT NULL,
  `paid_amount` float NOT NULL,
  `due_amount` float NOT NULL,
  `file_path` text NOT NULL,
  `coupon` varchar(200) DEFAULT NULL,
  `status` int(2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery`
--

CREATE TABLE `order_delivery` (
  `order_delivery_id` varchar(255) NOT NULL,
  `delivery_id` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `details` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_details_id` varchar(100) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `variant_id` varchar(100) NOT NULL,
  `variant_color` varchar(30) DEFAULT NULL,
  `store_id` varchar(255) NOT NULL,
  `quantity` int(8) NOT NULL,
  `rate` float NOT NULL,
  `supplier_rate` float DEFAULT NULL,
  `total_price` float NOT NULL,
  `discount` float DEFAULT NULL COMMENT 'discount_total_per_product',
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_payment`
--

CREATE TABLE `order_payment` (
  `order_payment_id` varchar(255) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `details` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_tax_col_details`
--

CREATE TABLE `order_tax_col_details` (
  `order_tax_col_de_id` varchar(100) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `variant_id` varchar(100) NOT NULL,
  `tax_id` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_tax_col_summary`
--

CREATE TABLE `order_tax_col_summary` (
  `order_tax_col_id` varchar(100) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `tax_id` varchar(100) NOT NULL,
  `tax_amount` float NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `our_location`
--

CREATE TABLE `our_location` (
  `location_id` int(11) NOT NULL,
  `language_id` varchar(255) NOT NULL,
  `headline` text NOT NULL,
  `details` text NOT NULL,
  `position` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `our_location`
--

INSERT INTO `our_location` (`location_id`, `language_id`, `headline`, `details`, `position`, `status`) VALUES
(1, 'english', 'Head Office Location <br>', '<p>We sell our product all over the world . <br></p>', 1, 1),
(2, 'bangla', '', '', 1, 1),
(3, 'english', '<p>Africa </p>', '<p>our second location at Cameroon in Africa.<br></p>', 2, 1),
(4, 'bangla', '', '', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payeer_payments`
--

CREATE TABLE `payeer_payments` (
  `id` int(11) NOT NULL,
  `m_operation_id` int(11) NOT NULL,
  `m_operation_ps` int(11) NOT NULL,
  `m_operation_date` varchar(100) NOT NULL,
  `m_operation_pay_date` varchar(100) NOT NULL,
  `m_shop` int(11) NOT NULL,
  `m_orderid` varchar(300) NOT NULL,
  `m_amount` varchar(100) NOT NULL,
  `m_curr` varchar(100) NOT NULL,
  `m_desc` varchar(300) NOT NULL,
  `m_status` varchar(100) NOT NULL,
  `m_sign` text NOT NULL,
  `lang` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `transection_id` varchar(200) NOT NULL,
  `tracing_id` varchar(200) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `store_id` varchar(200) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `payment_type` varchar(10) NOT NULL,
  `date` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `description` text NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway`
--

CREATE TABLE `payment_gateway` (
  `id` int(11) NOT NULL,
  `used_id` int(11) NOT NULL,
  `module_id` varchar(100) DEFAULT NULL,
  `agent` varchar(100) NOT NULL,
  `public_key` varchar(100) NOT NULL,
  `private_key` varchar(100) NOT NULL,
  `shop_id` varchar(100) NOT NULL,
  `secret_key` varchar(100) NOT NULL,
  `paypal_email` varchar(250) DEFAULT NULL,
  `paypal_client_id` text,
  `currency` text,
  `is_live` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=live,0=sandbox',
  `image` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_gateway`
--

INSERT INTO `payment_gateway` (`id`, `used_id`, `module_id`, `agent`, `public_key`, `private_key`, `shop_id`, `secret_key`, `paypal_email`, `paypal_client_id`, `currency`, `is_live`, `image`, `status`) VALUES
(1, 3, NULL, 'Bitcoin', '22592AAtNOwwBitcoin77BTCPUBzo4PVkUmYCa2dR770wNNstd', '22592AAtNOwwBitcoin77BTCPRVk7hmp8s3ew6pwgOMgxMq81F', '', '', NULL, NULL, NULL, 1, 'my-assets/image/bitcoin.png', 2),
(2, 4, NULL, 'Payeer', '', '', '514435930', 'JH8LZUHCNrtHhlRW', NULL, NULL, NULL, 1, 'my-assets/image/payeer.png', 2),
(3, 5, NULL, 'Paypal', '', '', '', '', 'mamun.sabuj99-seller@gmail.com', '', 'USD', 0, 'my-assets/image/paypal.png', 1),
(4, 6, NULL, 'sslcommerz\r\n', '', '', 'style5c246d140fefc', 'style5c246d140fefc@ssl', 'shemul.rabbani@gmail.com', NULL, 'BDT', 0, 'my-assets/image/sslcommerz.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `pay_method` varchar(20) DEFAULT NULL,
  `used_id` varchar(20) DEFAULT NULL,
  `customer_id` varchar(100) DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `order_no` varchar(30) NOT NULL,
  `trans_id` varchar(100) DEFAULT NULL,
  `amount` float(10,2) NOT NULL DEFAULT '0.00',
  `store_amount` float(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(20) DEFAULT NULL,
  `trans_date` varchar(100) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pay_withs`
--

CREATE TABLE `pay_withs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pay_withs`
--

INSERT INTO `pay_withs` (`id`, `title`, `image`, `link`, `status`, `created_at`, `updated_at`) VALUES
(2, 'mastercard', '54e64b679aeba35bb2888d303342b75b.png', 'http://bdtask.com', 1, '2018-12-31 19:39:14', '2021-02-27 06:43:38'),
(5, 'visa', 'ab52aa6b0653710cdd75ce58d2faf7ab.png', 'https://visa.com', 1, '2019-01-01 10:14:38', '2021-02-27 06:43:38'),
(6, 'paypal', '56e595d709a8a4d500b7e893a51acc0c.png', 'https://paypal.com', 1, '2019-01-01 10:24:35', '2021-02-27 06:43:38'),
(7, 'bkash', '15d320188b47f3f8f00866a26dd88403.jpg', 'https://bkash.com', 1, '2018-12-10 12:22:39', '2021-02-27 06:43:38'),
(8, 'rocket', 'dd6425bd07943dcc90698b3d0e81187f.jpeg', 'http://rocket.com', 1, '2019-03-08 13:04:19', '2021-02-27 06:43:38');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `category_id` varchar(255) NOT NULL,
  `parent_category_id` varchar(255) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `top_menu` int(11) NOT NULL,
  `menu_pos` int(11) NOT NULL,
  `cat_image` text NOT NULL,
  `cat_favicon` text,
  `cat_type` int(11) DEFAULT NULL COMMENT '1=parent,2=sub caregory',
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`category_id`, `parent_category_id`, `category_name`, `top_menu`, `menu_pos`, `cat_image`, `cat_favicon`, `cat_type`, `status`) VALUES
('ADXL7ARPEMKH3DI', 'F9GNCBBPCOIEN67', 'Category_7', 0, 7, 'my-assets/image/category/77d14ea6ae1ed219556ece65858f9d57.jpg', 'my-assets/image/category/0c9839f47ecf49664d2f7985be6887e5.png', 2, 1),
('CSSBW6HW54N62HE', NULL, 'Category_8', 0, 8, 'my-assets/image/category/77d14ea6ae1ed219556ece65858f9d57.jpg', 'my-assets/image/category/0c9839f47ecf49664d2f7985be6887e5.png', 1, 1),
('F9GNCBBPCOIEN67', '', 'Category_1', 1, 1, 'my-assets/image/category/77d14ea6ae1ed219556ece65858f9d57.jpg', 'my-assets/image/category/0c9839f47ecf49664d2f7985be6887e5.png', 1, 1),
('MY58TSN15SDZ36E', NULL, 'Category_2', 1, 2, 'my-assets/image/category/77d14ea6ae1ed219556ece65858f9d57.jpg', 'my-assets/image/category/0c9839f47ecf49664d2f7985be6887e5.png', 1, 1),
('OER22ASL88IWCCI', NULL, 'Category_10', 0, 10, 'my-assets/image/category/77d14ea6ae1ed219556ece65858f9d57.jpg', 'my-assets/image/category/0c9839f47ecf49664d2f7985be6887e5.png', 1, 1),
('QK1RF1L7G5ID28Q', NULL, 'Category_6', 0, 6, 'my-assets/image/category/77d14ea6ae1ed219556ece65858f9d57.jpg', 'my-assets/image/category/0c9839f47ecf49664d2f7985be6887e5.png', 1, 1),
('S8UEL9N18YX7481', 'F9GNCBBPCOIEN67', 'Category_9', 0, 9, 'my-assets/image/category/77d14ea6ae1ed219556ece65858f9d57.jpg', 'my-assets/image/category/0c9839f47ecf49664d2f7985be6887e5.png', 2, 0),
('UJRTM2YY6941UGA', 'F9GNCBBPCOIEN67', 'Category_3', 1, 3, 'my-assets/image/category/77d14ea6ae1ed219556ece65858f9d57.jpg', 'my-assets/image/category/0c9839f47ecf49664d2f7985be6887e5.png', 2, 0),
('UZ2UQ4PV74K8JK9', 'F9GNCBBPCOIEN67', 'Category_5', 1, 5, 'my-assets/image/category/77d14ea6ae1ed219556ece65858f9d57.jpg', 'my-assets/image/category/0c9839f47ecf49664d2f7985be6887e5.png', 2, 1),
('WLFACXRF6T3U3UV', NULL, 'Category_4', 1, 4, 'my-assets/image/category/77d14ea6ae1ed219556ece65858f9d57.jpg', 'my-assets/image/category/0c9839f47ecf49664d2f7985be6887e5.png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_information`
--

CREATE TABLE `product_information` (
  `id` int(11) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `supplier_id` varchar(255) NOT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `supplier_price` float DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `product_model` varchar(100) NOT NULL,
  `product_details` longtext,
  `image_thumb` text,
  `brand_id` varchar(255) DEFAULT NULL,
  `variants` text,
  `default_variant` varchar(255) DEFAULT NULL,
  `variant_price` tinyint(1) NOT NULL DEFAULT '0',
  `type` text,
  `best_sale` int(11) NOT NULL DEFAULT '0',
  `onsale` int(11) NOT NULL DEFAULT '0',
  `onsale_price` float DEFAULT NULL,
  `invoice_details` text,
  `image_large_details` text NOT NULL,
  `review` text,
  `description` text,
  `tag` text,
  `specification` text,
  `video` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_information`
--

INSERT INTO `product_information` (`id`, `product_id`, `supplier_id`, `category_id`, `product_name`, `price`, `supplier_price`, `unit`, `product_model`, `product_details`, `image_thumb`, `brand_id`, `variants`, `default_variant`, `variant_price`, `type`, `best_sale`, `onsale`, `onsale_price`, `invoice_details`, `image_large_details`, `review`, `description`, `tag`, `specification`, `video`, `status`) VALUES
(1, '98366399', 'I3JRQQJSJ67GG2ZTEEU1', 'F9GNCBBPCOIEN67', 'Product_3', 200, 150, '', 'P3', 'product details', 'my-assets/image/product/thumb/5852af8e1870db74fb43e5234f8cbeb0.jpg', 'W6TGN2N16JUL5XA', '3JJRT8TG11VD1FY,DBQD7B1AGBAUZSS,MMYXJ4FWYXAHXPJ', 'DBQD7B1AGBAUZSS', 0, '', 0, 0, NULL, 'invoice details 1 ', 'my-assets/image/product/5852af8e1870db74fb43e5234f8cbeb0.jpg', 'review1', 'description 1', '', 'spec 1', '', 1),
(2, '25869255', 'I3JRQQJSJ67GG2ZTEEU1', 'F9GNCBBPCOIEN67', 'Product_4', 300, 250, '', 'P4', 'product details', 'my-assets/image/product/thumb/d8aac1ebd37a1d16e6fcbe0c4a339956.jpg', 'T36ZSIXTRZVPVEM', '3JJRT8TG11VD1FY,DBQD7B1AGBAUZSS,MMYXJ4FWYXAHXPJ', 'DBQD7B1AGBAUZSS', 0, '', 1, 0, 300, 'invoice details 2', 'my-assets/image/product/d8aac1ebd37a1d16e6fcbe0c4a339956.jpg', 'review2', 'description 2', '', 'spec 2', '', 1),
(3, '21473628', 'I3JRQQJSJ67GG2ZTEEU1', 'F9GNCBBPCOIEN67', 'Product_5', 400, 350, '', 'P5', '', 'my-assets/image/product/thumb/f993579035d7691c3d367ad37bf910d3.jpg', '7XX8FG7MH7FGS87', '3JJRT8TG11VD1FY,DBQD7B1AGBAUZSS,MMYXJ4FWYXAHXPJ', '3JJRT8TG11VD1FY', 1, '', 1, 0, NULL, '', 'my-assets/image/product/f993579035d7691c3d367ad37bf910d3.jpg', '', '', '', '', '', 1),
(4, '62572489', 'I3JRQQJSJ67GG2ZTEEU1', 'F9GNCBBPCOIEN67', 'Product_6', 500, 470, '', 'P6', '', 'my-assets/image/product/thumb/e8d15852cbbde19f38b40309b2d6e0e1.jpg', '1JDEMJYYXH1K7UQ', '3JJRT8TG11VD1FY,DBQD7B1AGBAUZSS,MMYXJ4FWYXAHXPJ', 'DBQD7B1AGBAUZSS', 0, '', 1, 0, NULL, '', 'my-assets/image/product/e8d15852cbbde19f38b40309b2d6e0e1.jpg', '', '', '', '', '', 1),
(5, '11389311', 'I3JRQQJSJ67GG2ZTEEU1', 'F9GNCBBPCOIEN67', 'Product_7', 600, 570, '', 'P7', '', 'my-assets/image/product/thumb/551f0014e4e6dbf0805455534b0eab36.jpg', '', '3JJRT8TG11VD1FY,DBQD7B1AGBAUZSS,MMYXJ4FWYXAHXPJ', 'DBQD7B1AGBAUZSS', 0, '', 1, 0, NULL, '', 'my-assets/image/product/551f0014e4e6dbf0805455534b0eab36.jpg', '', '', '', '', '', 1),
(6, '77144835', 'I3JRQQJSJ67GG2ZTEEU1', 'F9GNCBBPCOIEN67', 'Product_8', 200, 150, '', 'P8', '', 'my-assets/image/product/thumb/54490be7219193a7fb07194efcb1aab3.jpg', '', '3JJRT8TG11VD1FY,DBQD7B1AGBAUZSS,MMYXJ4FWYXAHXPJ', 'DBQD7B1AGBAUZSS', 0, '', 1, 0, NULL, '', 'my-assets/image/product/54490be7219193a7fb07194efcb1aab3.jpg', '', '', '', '', '', 1),
(7, '64148874', 'I3JRQQJSJ67GG2ZTEEU1', 'F9GNCBBPCOIEN67', 'Product_9', 400, 350, '', 'P9', '', 'my-assets/image/product/thumb/2ed8a6979f7bb9d530bb98f6a2e3bbeb.jpg', '', '3JJRT8TG11VD1FY,DBQD7B1AGBAUZSS,MMYXJ4FWYXAHXPJ', 'DBQD7B1AGBAUZSS', 0, '', 0, 0, NULL, '', 'my-assets/image/product/2ed8a6979f7bb9d530bb98f6a2e3bbeb.jpg', '', '', '', '', '', 1),
(8, '16789548', 'I3JRQQJSJ67GG2ZTEEU1', 'F9GNCBBPCOIEN67', 'Product_10', 500, 450, '', 'P10', '', 'my-assets/image/product/thumb/8dc3d76fe74e4aa1de5dd1f0dfddbf10.jpg', '', 'DBQD7B1AGBAUZSS,MMYXJ4FWYXAHXPJ,HCI7GK7I8CT46E6,F6Q9ERLBZTUPJH7', 'DBQD7B1AGBAUZSS', 1, '', 1, 0, NULL, '', 'my-assets/image/product/8dc3d76fe74e4aa1de5dd1f0dfddbf10.jpg', '', '', '', '', 'https://www.youtube.com/watch?v=iRuS9EuQonw', 1),
(9, '69428333', 'I3JRQQJSJ67GG2ZTEEU1', 'F9GNCBBPCOIEN67', 'Product_11', 300, 250, '', 'P11', '', 'my-assets/image/product/thumb/6964e1feeae391db310c5230cff125e2.jpg', '', '3JJRT8TG11VD1FY,DBQD7B1AGBAUZSS,MMYXJ4FWYXAHXPJ,F6Q9ERLBZTUPJH7,W1YXEI3VIYW85KA', 'DBQD7B1AGBAUZSS', 1, '', 1, 0, NULL, '', 'my-assets/image/product/6964e1feeae391db310c5230cff125e2.jpg', '', '', '', '', '', 1),
(10, '22161617', 'I3JRQQJSJ67GG2ZTEEU1', 'F9GNCBBPCOIEN67', 'Product_12', 100, 80, '', 'P12', '', 'my-assets/image/product/thumb/a66a7502d4d823781de7ec79c025bd63.jpg', '', '3JJRT8TG11VD1FY,DBQD7B1AGBAUZSS,MMYXJ4FWYXAHXPJ,F6Q9ERLBZTUPJH7,HCI7GK7I8CT46E6', 'DBQD7B1AGBAUZSS', 0, '', 0, 1, 90, '', 'my-assets/image/product/a66a7502d4d823781de7ec79c025bd63.jpg', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase`
--

CREATE TABLE `product_purchase` (
  `purchase_id` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `supplier_id` varchar(100) NOT NULL,
  `store_id` varchar(255) DEFAULT NULL,
  `wearhouse_id` varchar(255) DEFAULT NULL,
  `grand_total_amount` float NOT NULL,
  `purchase_date` varchar(50) NOT NULL,
  `purchase_details` text NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase_details`
--

CREATE TABLE `product_purchase_details` (
  `purchase_detail_id` varchar(100) NOT NULL,
  `purchase_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `variant_id` varchar(100) NOT NULL,
  `variant_color` varchar(30) DEFAULT NULL,
  `store_id` varchar(100) DEFAULT NULL,
  `wearhouse_id` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `rate` float NOT NULL,
  `total_amount` float NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `product_review_id` varchar(100) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `reviewer_id` varchar(255) DEFAULT NULL,
  `comments` text,
  `rate` varchar(100) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `product_id` varchar(100) DEFAULT NULL,
  `var_size_id` varchar(30) DEFAULT NULL,
  `var_color_id` varchar(30) DEFAULT NULL,
  `price` double(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE `quotation` (
  `quotation_id` varchar(100) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `store_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `total_amount` float NOT NULL,
  `quotation` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `total_discount` float DEFAULT NULL,
  `quotation_discount` float NOT NULL COMMENT 'total_discount + quotation_discount',
  `service_charge` float DEFAULT NULL,
  `paid_amount` float NOT NULL,
  `due_amount` float NOT NULL,
  `file_path` text,
  `status` int(2) NOT NULL COMMENT '1=not_invoice,2=invoiced'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_details`
--

CREATE TABLE `quotation_details` (
  `quotation_details_id` varchar(100) NOT NULL,
  `quotation_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `variant_id` varchar(100) NOT NULL,
  `store_id` varchar(100) NOT NULL,
  `quantity` int(8) NOT NULL,
  `rate` float NOT NULL,
  `supplier_rate` float DEFAULT NULL,
  `total_price` float NOT NULL,
  `discount` float DEFAULT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_tax_col_details`
--

CREATE TABLE `quotation_tax_col_details` (
  `quot_tax_col_de_id` varchar(100) NOT NULL,
  `quotation_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `variant_id` varchar(100) NOT NULL,
  `tax_id` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_tax_col_summary`
--

CREATE TABLE `quotation_tax_col_summary` (
  `quot_tax_col_id` varchar(100) NOT NULL,
  `quotation_id` varchar(100) NOT NULL,
  `tax_id` varchar(100) NOT NULL,
  `tax_amount` float NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `received`
--

CREATE TABLE `received` (
  `transection_id` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `store_id` varchar(200) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `description` text NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `search_history`
--

CREATE TABLE `search_history` (
  `id` int(11) NOT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `results` int(11) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sec_menu_item`
--

CREATE TABLE `sec_menu_item` (
  `menu_id` int(11) NOT NULL,
  `menu_title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_menu` int(11) DEFAULT NULL,
  `actions` varchar(10) COLLATE utf8_unicode_ci DEFAULT '1111' COMMENT 'Create,Read,Update,Delete',
  `is_report` tinyint(1) DEFAULT '0',
  `createby` int(11) DEFAULT '1',
  `createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sec_menu_item`
--

INSERT INTO `sec_menu_item` (`menu_id`, `menu_title`, `page_url`, `module`, `parent_menu`, `actions`, `is_report`, `createby`, `createdate`) VALUES
(1, 'dashboard', NULL, 'dashboard', NULL, '1111', 0, 1, '2021-02-18 14:36:57'),
(2, 'sales', NULL, 'sales', NULL, '0100', 0, 1, '2021-02-18 14:40:13'),
(3, 'new_sale', NULL, 'sales', 2, '1000', 0, 1, '2021-02-18 14:43:30'),
(4, 'manage_sale', NULL, 'sales', 2, '0111', 0, 1, '2021-02-18 14:43:30'),
(5, 'pos_sale', NULL, 'sales', 2, '1111', 0, 1, '2021-02-18 14:43:30'),
(6, 'order', NULL, 'order', NULL, '0100', 0, 1, '2021-02-18 14:52:22'),
(7, 'new_order', NULL, 'order', 6, '1000', 0, 1, '2021-02-18 14:56:45'),
(8, 'manage_order', NULL, 'order', 6, '0111', 0, 1, '2021-02-18 14:56:45'),
(9, 'product', NULL, 'product', NULL, '0100', 0, 1, '2021-02-18 14:59:17'),
(10, 'add_product', NULL, 'product', 9, '1000', 0, 1, '2021-02-18 14:59:17'),
(11, 'import_product_csv', NULL, 'product', 9, '1100', 0, 1, '2021-02-18 14:59:17'),
(12, 'manage_product', NULL, 'product', 0, '0111', 0, 1, '2021-02-18 14:59:17'),
(13, 'product_ledger', NULL, 'product', 9, '0100', 0, 1, '2021-02-18 14:59:17'),
(14, 'customer', NULL, 'customer', NULL, '0100', 0, 1, '2021-02-18 15:09:08'),
(15, 'add_customer', NULL, 'customer', 14, '1000', 0, 1, '2021-02-18 15:37:22'),
(16, 'manage_customer', NULL, 'customer', 14, '0111', 0, 1, '2021-02-18 15:37:22'),
(17, 'customer_ledger', NULL, 'customer', 0, '0100', 0, 1, '2021-02-18 15:37:22'),
(18, 'supplier', NULL, 'supplier', NULL, '0100', 0, 1, '2021-02-18 15:41:08'),
(19, 'add_supplier', NULL, 'supplier', 18, '1000', 0, 1, '2021-02-18 15:41:08'),
(20, 'manage_supplier', NULL, 'supplier', 18, '0111', 0, 1, '2021-02-18 15:41:08'),
(21, 'supplier_ledger', NULL, 'supplier', 18, '0100', 0, 1, '2021-02-18 15:41:08'),
(22, 'purchase', NULL, 'purchase', NULL, '0100', 0, 1, '2021-02-18 15:47:11'),
(23, 'add_purchase', NULL, 'purchase', 22, '1000', 0, 1, '2021-02-18 15:47:50'),
(24, 'manage_purchase', NULL, 'purchase', 22, '0111', 0, 1, '2021-02-18 15:47:50'),
(25, 'category', NULL, 'category', NULL, '0100', 0, 1, '2021-02-18 15:49:37'),
(26, 'add_category', NULL, 'category', 25, '1000', 0, 1, '2021-02-18 15:49:37'),
(27, 'import_category_csv', NULL, 'category', 25, '1100', 0, 1, '2021-02-18 15:49:37'),
(28, 'manage_category', NULL, 'category', 25, '0111', 0, 1, '2021-02-18 15:49:37'),
(29, 'brand', NULL, 'brand', NULL, '0100', 0, 1, '2021-02-18 16:03:02'),
(30, 'add_brand', NULL, 'brand', 29, '0111', 0, 1, '2021-02-18 16:03:02'),
(31, 'manage_brand', NULL, 'brand', 29, '0111', 0, 1, '2021-02-18 16:03:02'),
(32, 'variant', NULL, 'variant', NULL, '0100', 0, 1, '2021-02-18 16:08:57'),
(33, 'add_variant', NULL, 'variant', 32, '1000', 0, 1, '2021-02-18 16:08:57'),
(34, 'manage_variant', NULL, 'variant', 32, '0111', 0, 1, '2021-02-18 16:08:57'),
(35, 'Unit', NULL, 'Unit', NULL, '0100', 0, 1, '2021-02-18 16:08:57'),
(36, 'add_unit', NULL, 'unit', 35, '1000', 0, 1, '2021-02-18 16:17:39'),
(37, 'manage_unit', NULL, 'unit', 35, '0111', 0, 1, '2021-02-18 16:17:39'),
(38, 'product_image_gallery', NULL, 'product_image_gallery', NULL, '0100', 0, 1, '2021-02-18 16:22:06'),
(39, 'add_product_image', NULL, 'product_image_gallery', 38, '1000', 0, 1, '2021-02-18 16:22:06'),
(40, 'manage_product_image', NULL, 'product_image_gallery', 38, '0111', 0, 1, '2021-02-18 16:22:06'),
(41, 'tax', NULL, 'tax', NULL, '0100', 0, 1, '2021-02-18 16:23:51'),
(42, 'tax_product_service', NULL, 'tax', 41, '1100', 0, 1, '2021-02-18 16:26:09'),
(43, 'manage_product_tax', NULL, 'tax', 41, '1111', 0, 1, '2021-02-18 16:26:09'),
(44, 'tax_setting', NULL, 'tax', 41, '0010', 0, 1, '2021-02-18 16:26:50'),
(45, 'currency', NULL, 'currency', NULL, '0100', 0, 1, '2021-02-18 16:34:12'),
(46, 'add_currency', NULL, 'currency', 45, '1000', 0, 1, '2021-02-18 16:34:12'),
(47, 'manage_currency', NULL, 'currency', 45, '0111', 0, 1, '2021-02-18 16:34:12'),
(48, 'store', NULL, 'store', NULL, '0100', 0, 1, '2021-02-18 16:37:59'),
(49, 'store_add', NULL, 'store', 48, '1000', 0, 1, '2021-02-18 16:39:51'),
(50, 'import_store_csv', NULL, 'store', 48, '1111', 0, 1, '2021-02-18 16:39:51'),
(51, 'manage_store', NULL, 'store', 48, '0111', 0, 1, '2021-02-18 16:39:51'),
(52, 'store_transfer', NULL, 'store', 48, '0010', 0, 1, '2021-02-18 16:41:43'),
(53, 'manage_store_product', NULL, 'store', 48, '0011', 0, 1, '2021-02-18 16:41:43'),
(54, 'stock', NULL, 'stock', NULL, '0100', 0, 1, '2021-02-18 16:44:25'),
(55, 'stock_report', NULL, 'stock', 54, '0100', 0, 1, '2021-02-18 16:44:25'),
(56, 'stock_report_supplier_wise', NULL, 'stock', 54, '1111', 0, 1, '2021-02-18 16:44:25'),
(57, 'stock_report_product_wise', NULL, 'stock', 54, '0100', 0, 1, '2021-02-18 17:24:19'),
(58, 'stock_report_store_wise', NULL, 'stock', 54, '0100', 0, 1, '2021-02-18 17:24:19'),
(59, 'bank', NULL, 'bank', NULL, '0100', 0, 1, '2021-02-18 17:37:27'),
(60, 'add_new_bank', NULL, 'bank', 59, '1000', 0, 1, '2021-02-18 17:37:27'),
(61, 'manage_bank', NULL, 'bank', 59, '0111', 0, 1, '2021-02-18 17:37:27'),
(62, 'accounts', NULL, 'accounts', NULL, '0100', 0, 1, '2021-02-18 17:53:45'),
(63, 'create_accounts', NULL, 'accounts', 62, '1000', 0, 1, '2021-02-18 17:53:45'),
(64, 'manage_accounts', NULL, 'accounts', 62, '0111', 0, 1, '2021-02-18 17:53:45'),
(65, 'received', NULL, 'accounts', 62, '1100', 0, 1, '2021-02-18 17:53:45'),
(66, 'payment', NULL, 'accounts', 62, '1100', 0, 1, '2021-02-18 17:53:45'),
(67, 'accounts_summary', NULL, 'accounts', 62, '1100', 0, 1, '2021-02-18 17:53:45'),
(68, 'cheque_manager', NULL, 'accounts', 62, '0110', 0, 1, '2021-02-18 17:53:45'),
(69, 'closing', NULL, 'accounts', 62, '1100', 0, 1, '2021-02-18 17:53:45'),
(70, 'closing_report', NULL, 'accounts', 62, '1100', 0, 1, '2021-02-18 17:53:45'),
(71, 'report', NULL, 'report', NULL, '0100', 0, 1, '2021-02-23 11:38:42'),
(72, 'sales_report', NULL, 'report', 71, '1100', 0, 1, '2021-02-23 11:38:42'),
(73, 'sales_report_store_wise', NULL, 'report', 71, '1100', 0, 1, '2021-02-23 11:40:20'),
(74, 'purchase_report', NULL, 'report', 71, '1100', 0, 1, '2021-02-23 11:43:21'),
(75, 'transfer_report', NULL, 'report', 71, '0100', 0, 1, '2021-02-23 11:45:24'),
(76, 'store_to_store_transfer', NULL, 'report', 75, '1100', 0, 1, '2021-02-23 11:47:39'),
(77, 'tax_report_product_wise', NULL, 'report', 71, '1100', 0, 1, '2021-02-23 11:50:31'),
(78, 'tax_report_invoice_wise', NULL, 'report', 71, '1100', 0, 1, '2021-02-23 11:52:10'),
(79, 'pay_with', NULL, 'pay_with', NULL, '0100', 0, 1, '2021-02-23 11:54:50'),
(80, 'manage_pay_with', NULL, 'pay_with', 79, '1111', 0, 1, '2021-02-23 11:56:38'),
(81, 'states', NULL, 'states', NULL, '0100', 0, 1, '2021-02-23 11:58:40'),
(82, 'add_state', NULL, 'states', 81, '1000', 0, 1, '2021-02-23 12:03:07'),
(83, 'manage_states', NULL, 'states', 81, '0111', 0, 1, '2021-02-23 12:07:03'),
(84, 'modules', NULL, 'modules', NULL, '1111', 0, 1, '2021-02-23 12:13:06'),
(85, 'themes', NULL, 'themes', NULL, '1111', 0, 1, '2021-02-23 12:19:59'),
(86, 'sms_settings', NULL, 'sms_settings', NULL, '0100', 0, 1, '2021-02-23 12:21:19'),
(87, 'sms_configuration', NULL, 'sms_settings', 86, '0010', 0, 1, '2021-02-23 12:24:57'),
(88, 'sms_template', NULL, 'sms_settings', 86, '1111', 0, 1, '2021-02-23 12:26:52'),
(89, 'web_settings', NULL, 'web_settings', NULL, '0100', 0, 1, '2021-02-23 12:41:43'),
(90, 'slider', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 12:44:44'),
(91, 'block', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 12:45:51'),
(92, 'advertisement', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 12:48:18'),
(93, 'product_review', NULL, 'web_settings', 89, '0111', 0, 1, '2021-02-23 12:50:13'),
(94, 'subscriber', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 13:09:44'),
(95, 'wishlist', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 13:12:22'),
(96, 'web_footer', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 13:26:56'),
(97, 'link_page', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 13:26:56'),
(98, 'coupon', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 13:28:18'),
(99, 'contact_form', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 13:29:08'),
(100, 'why_choose_us', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 13:31:01'),
(101, 'our_location', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 14:06:51'),
(102, 'shipping_method', NULL, 'web_settings', 89, '1111', 0, 1, '2021-02-23 14:07:52'),
(103, 'setting', NULL, 'web_settings', 89, '0110', 0, 1, '2021-02-23 14:09:03'),
(104, 'software_settings', NULL, 'software_settings', NULL, '0110', 0, 1, '2021-02-23 14:10:08'),
(105, 'manage_company', NULL, 'software_settings', 104, '0110', 0, 1, '2021-02-23 14:11:35'),
(106, 'add_user', NULL, 'software_settings', 104, '1000', 0, 1, '2021-02-23 14:13:05'),
(107, 'manage_users', NULL, 'software_settings', 104, '1111', 0, 1, '2021-02-23 14:14:25'),
(108, 'language', NULL, 'software_settings', 104, '1111', 0, 1, '2021-02-23 14:16:20'),
(109, 'color_setting_frontend', NULL, 'software_settings', 104, '0110', 0, 1, '2021-02-23 14:17:33'),
(110, 'color_setting_backend', NULL, 'software_settings', 104, '0110', 0, 1, '2021-02-23 14:19:00'),
(111, 'email_configuration', NULL, 'software_settings', 104, '0110', 0, 1, '2021-02-23 14:20:05'),
(112, 'payment_gateway_setting', NULL, 'software_settings', 104, '1110', 0, 1, '2021-02-23 14:21:31'),
(113, 'software_settings', NULL, 'software_settings', 104, '0110', 0, 1, '2021-02-23 14:22:40'),
(114, 'update', NULL, 'update', NULL, '0110', 0, 1, '2021-02-23 14:23:40'),
(115, 'backup_and_restore', NULL, 'backup_and_restore', NULL, '1111', 0, 1, '2021-02-23 14:24:41'),
(116, 'android_apps', NULL, 'android_apps', NULL, '0110', 0, 1, '2021-02-23 14:25:53'),
(117, 'support', NULL, 'support', NULL, '0100', 0, 1, '2021-02-23 14:26:54'),
(118, 'role', NULL, 'software_settings', 104, '1111', 0, 1, '2021-02-25 12:43:43'),
(119, 'seo_tools', NULL, 'web_settings', 89, '0100', 0, 1, '2021-02-28 17:42:28'),
(120, 'popular_products', NULL, 'web_settings', 89, '0100', 0, 1, '2021-02-28 17:42:28'),
(121, 'website_meta_keywords', NULL, 'web_settings', 89, '0110', 0, 1, '2021-02-28 17:42:28'),
(122, 'google_analytics', NULL, 'web_settings', 89, '0110', 0, 1, '2021-02-28 17:42:28'),
(123, 'delivery_system', NULL, 'delivery_system', NULL, '0100', 0, 1, '2021-03-20 15:32:02'),
(124, 'delivery_boy', NULL, 'delivery_system', 127, '0100', 0, 1, '2021-03-20 15:32:02'),
(125, 'add_delivery_boy', NULL, 'delivery_system', 127, '1000', 0, 1, '2021-03-20 15:32:02'),
(126, 'manage_delivery_boy', NULL, 'delivery_system', 127, '0111', 0, 1, '2021-03-20 15:32:02'),
(127, 'delivery_slot', NULL, 'delivery_system', 127, '0100', 0, 1, '2021-03-20 15:32:02'),
(128, 'add_time_slot', NULL, 'delivery_system', 127, '1000', 0, 1, '2021-03-20 15:32:02'),
(129, 'manage_time_slot', NULL, 'delivery_system', 127, '0111', 0, 1, '2021-03-20 15:32:02'),
(130, 'delivery_zone', NULL, 'delivery_system', 127, '0100', 0, 1, '2021-03-20 15:32:02'),
(131, 'add_delivery_zone', NULL, 'delivery_system', 127, '1000', 0, 1, '2021-03-20 15:32:02'),
(132, 'manage_delivery_zone', NULL, 'delivery_system', 127, '0111', 0, 1, '2021-03-20 15:32:02'),
(133, 'delivery_assigns', NULL, 'delivery_system', 127, '0100', 0, 1, '2021-03-20 15:32:02'),
(134, 'assign_delivery', NULL, 'delivery_system', 127, '1000', 0, 1, '2021-03-20 15:32:02'),
(135, 'manage_assigned_delivery', NULL, 'delivery_system', 127, '0111', 0, 1, '2021-03-20 15:32:02');

-- --------------------------------------------------------

--
-- Table structure for table `sec_role_permission`
--

CREATE TABLE `sec_role_permission` (
  `id` bigint(20) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `can_access` tinyint(1) NOT NULL,
  `can_create` tinyint(1) NOT NULL,
  `can_edit` tinyint(1) NOT NULL,
  `can_delete` tinyint(1) NOT NULL,
  `createby` int(11) NOT NULL,
  `createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sec_role_permission`
--

INSERT INTO `sec_role_permission` (`id`, `role_id`, `menu_id`, `can_access`, `can_create`, `can_edit`, `can_delete`, `createby`, `createdate`) VALUES
(235, 2, 1, 1, 1, 1, 1, 1, '2021-02-24 07:50:58'),
(236, 2, 2, 1, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(237, 2, 3, 0, 1, 0, 0, 1, '2021-02-24 07:50:58'),
(238, 2, 4, 1, 0, 1, 1, 1, '2021-02-24 07:50:58'),
(239, 2, 5, 1, 1, 1, 1, 1, '2021-02-24 07:50:58'),
(240, 2, 6, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(241, 2, 7, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(242, 2, 8, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(243, 2, 9, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(244, 2, 10, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(245, 2, 11, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(246, 2, 12, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(247, 2, 13, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(248, 2, 14, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(249, 2, 15, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(250, 2, 16, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(251, 2, 17, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(252, 2, 18, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(253, 2, 19, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(254, 2, 20, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(255, 2, 21, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(256, 2, 22, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(257, 2, 23, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(258, 2, 24, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(259, 2, 25, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(260, 2, 26, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(261, 2, 27, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(262, 2, 28, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(263, 2, 29, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(264, 2, 30, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(265, 2, 31, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(266, 2, 32, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(267, 2, 33, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(268, 2, 34, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(269, 2, 35, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(270, 2, 36, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(271, 2, 37, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(272, 2, 38, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(273, 2, 39, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(274, 2, 40, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(275, 2, 41, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(276, 2, 42, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(277, 2, 43, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(278, 2, 44, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(279, 2, 45, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(280, 2, 46, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(281, 2, 47, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(282, 2, 48, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(283, 2, 49, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(284, 2, 50, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(285, 2, 51, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(286, 2, 52, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(287, 2, 53, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(288, 2, 54, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(289, 2, 55, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(290, 2, 56, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(291, 2, 57, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(292, 2, 58, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(293, 2, 59, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(294, 2, 60, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(295, 2, 61, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(296, 2, 62, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(297, 2, 63, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(298, 2, 64, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(299, 2, 65, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(300, 2, 66, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(301, 2, 67, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(302, 2, 68, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(303, 2, 69, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(304, 2, 70, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(305, 2, 71, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(306, 2, 72, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(307, 2, 73, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(308, 2, 74, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(309, 2, 75, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(310, 2, 76, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(311, 2, 77, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(312, 2, 78, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(313, 2, 79, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(314, 2, 80, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(315, 2, 81, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(316, 2, 82, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(317, 2, 83, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(318, 2, 84, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(319, 2, 85, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(320, 2, 86, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(321, 2, 87, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(322, 2, 88, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(323, 2, 89, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(324, 2, 90, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(325, 2, 91, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(326, 2, 92, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(327, 2, 93, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(328, 2, 94, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(329, 2, 95, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(330, 2, 96, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(331, 2, 97, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(332, 2, 98, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(333, 2, 99, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(334, 2, 100, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(335, 2, 101, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(336, 2, 102, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(337, 2, 103, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(338, 2, 104, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(339, 2, 105, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(340, 2, 106, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(341, 2, 107, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(342, 2, 108, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(343, 2, 109, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(344, 2, 110, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(345, 2, 111, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(346, 2, 112, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(347, 2, 113, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(348, 2, 114, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(349, 2, 115, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(350, 2, 116, 0, 0, 0, 0, 1, '2021-02-24 07:50:58'),
(351, 2, 117, 0, 0, 0, 0, 1, '2021-02-24 07:50:58');

-- --------------------------------------------------------

--
-- Table structure for table `sec_role_tbl`
--

CREATE TABLE `sec_role_tbl` (
  `role_id` int(11) NOT NULL,
  `role_name` text NOT NULL,
  `role_description` text NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `role_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sec_role_tbl`
--

INSERT INTO `sec_role_tbl` (`role_id`, `role_name`, `role_description`, `create_by`, `date_time`, `role_status`) VALUES
(2, 'sales executive', 'sales executive', 1, '2021-02-24 07:50:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sec_user_access_tbl`
--

CREATE TABLE `sec_user_access_tbl` (
  `role_acc_id` int(11) NOT NULL,
  `fk_role_id` int(11) NOT NULL,
  `fk_user_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `address` text,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `favicon` varchar(100) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `site_align` varchar(50) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `title`, `address`, `email`, `phone`, `logo`, `favicon`, `language`, `site_align`, `footer_text`) VALUES
(2, 'Dynamic Admin Panel', '98 Green Road, Farmgate, Dhaka-1215.', 'bdtask@gmail.com', '0123456789', 'assets/img/icons/logo.png', 'assets/img/icons/m.png', 'english', 'LTR', '2017©Copyright');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_info`
--

CREATE TABLE `shipping_info` (
  `shiping_info_id` int(100) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `customer_short_address` text NOT NULL,
  `customer_address_1` text NOT NULL,
  `customer_address_2` text NOT NULL,
  `customer_mobile` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `zip` varchar(100) NOT NULL,
  `company` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method`
--

CREATE TABLE `shipping_method` (
  `method_id` int(11) NOT NULL,
  `method_name` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `charge_amount` float NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shipping_method`
--

INSERT INTO `shipping_method` (`method_id`, `method_name`, `details`, `charge_amount`, `position`) VALUES
(1, 'Inside the city', '', 0, 1),
(2, 'Outside the city', '', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `site_analytics`
--

CREATE TABLE `site_analytics` (
  `id` int(11) NOT NULL,
  `product_id` varchar(30) NOT NULL,
  `clicks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_analytics`
--

INSERT INTO `site_analytics` (`id`, `product_id`, `clicks`) VALUES
(1, '16789548', 1);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `slider_id` varchar(100) NOT NULL,
  `slider_link` varchar(255) NOT NULL,
  `slider_image` varchar(255) NOT NULL,
  `slider_category` varchar(255) DEFAULT NULL,
  `slider_position` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slider_id`, `slider_link`, `slider_image`, `slider_category`, `slider_position`, `status`) VALUES
('DLHEPY7IUPOJKAD', 'https://demo453464315.com', 'my-assets/image/slider/ca47da198e25a27b6c7c0d37eb9fba82.jpg', '', 1, 1),
('T17X8HSQ8W8MYG1', 'https://demo453464315.com', 'my-assets/image/slider/4d4a2f55be2c0f046cb281aefb68f629.jpg', '', 2, 1),
('ZFTN9GODSNWAN7Q', 'https://demo453464315.com', 'my-assets/image/slider/aaf9b565ecadcb2a20cadd736baaa4a3.jpg', '', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sms_configuration`
--

CREATE TABLE `sms_configuration` (
  `id` int(11) NOT NULL,
  `gateway` varchar(255) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `userid` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `link` varchar(255) NOT NULL,
  `sms_from` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_configuration`
--

INSERT INTO `sms_configuration` (`id`, `gateway`, `user_name`, `userid`, `password`, `status`, `link`, `sms_from`, `created_at`, `updated_at`) VALUES
(2, 'nexmo', 'd7a32ebc', '', 'SYCgDWZGgF8IDzx5', 0, 'https://www.nexmo.com/', 'isshue', '2020-08-22 12:46:20', '2018-12-10 00:00:00'),
(3, 'budgetsms', 'user1', '21547', '1e753da74', 1, 'https://www.budgetsms.net/', 'budgetsms', '2020-08-22 12:46:28', '2018-12-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sms_template`
--

CREATE TABLE `sms_template` (
  `id` int(11) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `default_status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_template`
--

INSERT INTO `sms_template` (`id`, `template_name`, `message`, `type`, `status`, `default_status`, `created_at`, `updated_at`) VALUES
(1, 'one', 'your registration is complete', 'Registration', 1, 1, '2020-08-22 12:58:41', '2020-08-22 18:58:53'),
(2, 'two', 'your order {id} is completed', 'Order', 1, 1, '2020-08-22 12:58:45', '2020-08-22 18:58:53'),
(3, 'three', 'your order {id} is processing', 'Processing', 1, 1, '2020-08-22 12:58:48', '2020-08-22 18:58:53'),
(5, 'four', 'your order {id} is shipped', 'Shipped', 1, 1, '2020-08-22 12:58:53', '2020-08-22 18:58:53');

-- --------------------------------------------------------

--
-- Table structure for table `social_auth`
--

CREATE TABLE `social_auth` (
  `id` int(11) NOT NULL,
  `name` text,
  `app_id` text,
  `app_secret` text,
  `api_key` text,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `soft_setting`
--

CREATE TABLE `soft_setting` (
  `setting_id` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `invoice_logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `language` varchar(255) DEFAULT NULL,
  `rtr` varchar(255) DEFAULT NULL,
  `captcha` int(11) DEFAULT '1' COMMENT '0=active,1=inactive',
  `site_key` varchar(250) DEFAULT NULL,
  `secret_key` varchar(250) DEFAULT NULL,
  `sms_service` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `soft_setting`
--

INSERT INTO `soft_setting` (`setting_id`, `logo`, `invoice_logo`, `favicon`, `footer_text`, `country_id`, `language`, `rtr`, `captcha`, `site_key`, `secret_key`, `sms_service`) VALUES
(1, 'my-assets/image/logo/b8ff8857c1620fab5853a68c12842246.png', 'my-assets/image/logo/62cd9a2d8daedec26abc30bcfbbaf5cb.png', 'my-assets/image/logo/8409b9e21c1a226954929cf091a09f68.png', 'Developed by Demosoft586454684', 18, 'english', '0', 1, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`) VALUES
(1, 'Andaman and Nicobar Islands', 101),
(2, 'Andhra Pradesh', 101),
(3, 'Arunachal Pradesh', 101),
(4, 'Assam', 101),
(5, 'Bihar', 101),
(6, 'Chandigarh', 101),
(7, 'Chhattisgarh', 101),
(8, 'Dadra and Nagar Haveli', 101),
(9, 'Daman and Diu', 101),
(10, 'Delhi', 101),
(11, 'Goa', 101),
(12, 'Gujarat', 101),
(13, 'Haryana', 101),
(14, 'Himachal Pradesh', 101),
(15, 'Jammu and Kashmir', 101),
(16, 'Jharkhand', 101),
(17, 'Karnataka', 101),
(18, 'Kenmore', 101),
(19, 'Kerala', 101),
(20, 'Lakshadweep', 101),
(21, 'Madhya Pradesh', 101),
(22, 'Maharashtra', 101),
(23, 'Manipur', 101),
(24, 'Meghalaya', 101),
(25, 'Mizoram', 101),
(26, 'Nagaland', 101),
(27, 'Narora', 101),
(28, 'Natwar', 101),
(29, 'Odisha', 101),
(30, 'Paschim Medinipur', 101),
(31, 'Pondicherry', 101),
(32, 'Punjab', 101),
(33, 'Rajasthan', 101),
(34, 'Sikkim', 101),
(35, 'Tamil Nadu', 101),
(36, 'Telangana', 101),
(37, 'Tripura', 101),
(38, 'Uttar Pradesh', 101),
(39, 'Uttarakhand', 101),
(40, 'Vaishali', 101),
(41, 'West Bengal', 101),
(42, 'Badakhshan', 1),
(43, 'Badgis', 1),
(44, 'Baglan', 1),
(45, 'Balkh', 1),
(46, 'Bamiyan', 1),
(47, 'Farah', 1),
(48, 'Faryab', 1),
(49, 'Gawr', 1),
(50, 'Gazni', 1),
(51, 'Herat', 1),
(52, 'Hilmand', 1),
(53, 'Jawzjan', 1),
(54, 'Kabul', 1),
(55, 'Kapisa', 1),
(56, 'Khawst', 1),
(57, 'Kunar', 1),
(58, 'Lagman', 1),
(59, 'Lawghar', 1),
(60, 'Nangarhar', 1),
(61, 'Nimruz', 1),
(62, 'Nuristan', 1),
(63, 'Paktika', 1),
(64, 'Paktiya', 1),
(65, 'Parwan', 1),
(66, 'Qandahar', 1),
(67, 'Qunduz', 1),
(68, 'Samangan', 1),
(69, 'Sar-e Pul', 1),
(70, 'Takhar', 1),
(71, 'Uruzgan', 1),
(72, 'Wardag', 1),
(73, 'Zabul', 1),
(74, 'Berat', 2),
(75, 'Bulqize', 2),
(76, 'Delvine', 2),
(77, 'Devoll', 2),
(78, 'Dibre', 2),
(79, 'Durres', 2),
(80, 'Elbasan', 2),
(81, 'Fier', 2),
(82, 'Gjirokaster', 2),
(83, 'Gramsh', 2),
(84, 'Has', 2),
(85, 'Kavaje', 2),
(86, 'Kolonje', 2),
(87, 'Korce', 2),
(88, 'Kruje', 2),
(89, 'Kucove', 2),
(90, 'Kukes', 2),
(91, 'Kurbin', 2),
(92, 'Lezhe', 2),
(93, 'Librazhd', 2),
(94, 'Lushnje', 2),
(95, 'Mallakaster', 2),
(96, 'Malsi e Madhe', 2),
(97, 'Mat', 2),
(98, 'Mirdite', 2),
(99, 'Peqin', 2),
(100, 'Permet', 2),
(101, 'Pogradec', 2),
(102, 'Puke', 2),
(103, 'Sarande', 2),
(104, 'Shkoder', 2),
(105, 'Skrapar', 2),
(106, 'Tepelene', 2),
(107, 'Tirane', 2),
(108, 'Tropoje', 2),
(109, 'Vlore', 2),
(110, 'Ayn Daflah', 3),
(111, 'Ayn Tamushanat', 3),
(112, 'Adrar', 3),
(113, 'Algiers', 3),
(114, 'Annabah', 3),
(115, 'Bashshar', 3),
(116, 'Batnah', 3),
(117, 'Bijayah', 3),
(118, 'Biskrah', 3),
(119, 'Blidah', 3),
(120, 'Buirah', 3),
(121, 'Bumardas', 3),
(122, 'Burj Bu Arririj', 3),
(123, 'Ghalizan', 3),
(124, 'Ghardayah', 3),
(125, 'Ilizi', 3),
(126, 'Jijili', 3),
(127, 'Jilfah', 3),
(128, 'Khanshalah', 3),
(129, 'Masilah', 3),
(130, 'Midyah', 3),
(131, 'Milah', 3),
(132, 'Muaskar', 3),
(133, 'Mustaghanam', 3),
(134, 'Naama', 3),
(135, 'Oran', 3),
(136, 'Ouargla', 3),
(137, 'Qalmah', 3),
(138, 'Qustantinah', 3),
(139, 'Sakikdah', 3),
(140, 'Satif', 3),
(141, 'Sayda\'', 3),
(142, 'Sidi ban-al-\'Abbas', 3),
(143, 'Suq Ahras', 3),
(144, 'Tamanghasat', 3),
(145, 'Tibazah', 3),
(146, 'Tibissah', 3),
(147, 'Tilimsan', 3),
(148, 'Tinduf', 3),
(149, 'Tisamsilt', 3),
(150, 'Tiyarat', 3),
(151, 'Tizi Wazu', 3),
(152, 'Umm-al-Bawaghi', 3),
(153, 'Wahran', 3),
(154, 'Warqla', 3),
(155, 'Wilaya d Alger', 3),
(156, 'Wilaya de Bejaia', 3),
(157, 'Wilaya de Constantine', 3),
(158, 'al-Aghwat', 3),
(159, 'al-Bayadh', 3),
(160, 'al-Jaza\'ir', 3),
(161, 'al-Wad', 3),
(162, 'ash-Shalif', 3),
(163, 'at-Tarif', 3),
(164, 'Eastern', 4),
(165, 'Manu\'a', 4),
(166, 'Swains Island', 4),
(167, 'Western', 4),
(168, 'Andorra la Vella', 5),
(169, 'Canillo', 5),
(170, 'Encamp', 5),
(171, 'La Massana', 5),
(172, 'Les Escaldes', 5),
(173, 'Ordino', 5),
(174, 'Sant Julia de Loria', 5),
(175, 'Bengo', 6),
(176, 'Benguela', 6),
(177, 'Bie', 6),
(178, 'Cabinda', 6),
(179, 'Cunene', 6),
(180, 'Huambo', 6),
(181, 'Huila', 6),
(182, 'Kuando-Kubango', 6),
(183, 'Kwanza Norte', 6),
(184, 'Kwanza Sul', 6),
(185, 'Luanda', 6),
(186, 'Lunda Norte', 6),
(187, 'Lunda Sul', 6),
(188, 'Malanje', 6),
(189, 'Moxico', 6),
(190, 'Namibe', 6),
(191, 'Uige', 6),
(192, 'Zaire', 6),
(193, 'Other Provinces', 7),
(194, 'Sector claimed by Argentina/Ch', 8),
(195, 'Sector claimed by Argentina/UK', 8),
(196, 'Sector claimed by Australia', 8),
(197, 'Sector claimed by France', 8),
(198, 'Sector claimed by New Zealand', 8),
(199, 'Sector claimed by Norway', 8),
(200, 'Unclaimed Sector', 8),
(201, 'Barbuda', 9),
(202, 'Saint George', 9),
(203, 'Saint John', 9),
(204, 'Saint Mary', 9),
(205, 'Saint Paul', 9),
(206, 'Saint Peter', 9),
(207, 'Saint Philip', 9),
(208, 'Buenos Aires', 10),
(209, 'Catamarca', 10),
(210, 'Chaco', 10),
(211, 'Chubut', 10),
(212, 'Cordoba', 10),
(213, 'Corrientes', 10),
(214, 'Distrito Federal', 10),
(215, 'Entre Rios', 10),
(216, 'Formosa', 10),
(217, 'Jujuy', 10),
(218, 'La Pampa', 10),
(219, 'La Rioja', 10),
(220, 'Mendoza', 10),
(221, 'Misiones', 10),
(222, 'Neuquen', 10),
(223, 'Rio Negro', 10),
(224, 'Salta', 10),
(225, 'San Juan', 10),
(226, 'San Luis', 10),
(227, 'Santa Cruz', 10),
(228, 'Santa Fe', 10),
(229, 'Santiago del Estero', 10),
(230, 'Tierra del Fuego', 10),
(231, 'Tucuman', 10),
(232, 'Aragatsotn', 11),
(233, 'Ararat', 11),
(234, 'Armavir', 11),
(235, 'Gegharkunik', 11),
(236, 'Kotaik', 11),
(237, 'Lori', 11),
(238, 'Shirak', 11),
(239, 'Stepanakert', 11),
(240, 'Syunik', 11),
(241, 'Tavush', 11),
(242, 'Vayots Dzor', 11),
(243, 'Yerevan', 11),
(244, 'Aruba', 12),
(245, 'Auckland', 13),
(246, 'Australian Capital Territory', 13),
(247, 'Balgowlah', 13),
(248, 'Balmain', 13),
(249, 'Bankstown', 13),
(250, 'Baulkham Hills', 13),
(251, 'Bonnet Bay', 13),
(252, 'Camberwell', 13),
(253, 'Carole Park', 13),
(254, 'Castle Hill', 13),
(255, 'Caulfield', 13),
(256, 'Chatswood', 13),
(257, 'Cheltenham', 13),
(258, 'Cherrybrook', 13),
(259, 'Clayton', 13),
(260, 'Collingwood', 13),
(261, 'Frenchs Forest', 13),
(262, 'Hawthorn', 13),
(263, 'Jannnali', 13),
(264, 'Knoxfield', 13),
(265, 'Melbourne', 13),
(266, 'New South Wales', 13),
(267, 'Northern Territory', 13),
(268, 'Perth', 13),
(269, 'Queensland', 13),
(270, 'South Australia', 13),
(271, 'Tasmania', 13),
(272, 'Templestowe', 13),
(273, 'Victoria', 13),
(274, 'Werribee south', 13),
(275, 'Western Australia', 13),
(276, 'Wheeler', 13),
(277, 'Bundesland Salzburg', 14),
(278, 'Bundesland Steiermark', 14),
(279, 'Bundesland Tirol', 14),
(280, 'Burgenland', 14),
(281, 'Carinthia', 14),
(282, 'Karnten', 14),
(283, 'Liezen', 14),
(284, 'Lower Austria', 14),
(285, 'Niederosterreich', 14),
(286, 'Oberosterreich', 14),
(287, 'Salzburg', 14),
(288, 'Schleswig-Holstein', 14),
(289, 'Steiermark', 14),
(290, 'Styria', 14),
(291, 'Tirol', 14),
(292, 'Upper Austria', 14),
(293, 'Vorarlberg', 14),
(294, 'Wien', 14),
(295, 'Abseron', 15),
(296, 'Baki Sahari', 15),
(297, 'Ganca', 15),
(298, 'Ganja', 15),
(299, 'Kalbacar', 15),
(300, 'Lankaran', 15),
(301, 'Mil-Qarabax', 15),
(302, 'Mugan-Salyan', 15),
(303, 'Nagorni-Qarabax', 15),
(304, 'Naxcivan', 15),
(305, 'Priaraks', 15),
(306, 'Qazax', 15),
(307, 'Saki', 15),
(308, 'Sirvan', 15),
(309, 'Xacmaz', 15),
(310, 'Abaco', 16),
(311, 'Acklins Island', 16),
(312, 'Andros', 16),
(313, 'Berry Islands', 16),
(314, 'Biminis', 16),
(315, 'Cat Island', 16),
(316, 'Crooked Island', 16),
(317, 'Eleuthera', 16),
(318, 'Exuma and Cays', 16),
(319, 'Grand Bahama', 16),
(320, 'Inagua Islands', 16),
(321, 'Long Island', 16),
(322, 'Mayaguana', 16),
(323, 'New Providence', 16),
(324, 'Ragged Island', 16),
(325, 'Rum Cay', 16),
(326, 'San Salvador', 16),
(327, '\'Isa', 17),
(328, 'Badiyah', 17),
(329, 'Hidd', 17),
(330, 'Jidd Hafs', 17),
(331, 'Mahama', 17),
(332, 'Manama', 17),
(333, 'Sitrah', 17),
(334, 'al-Manamah', 17),
(335, 'al-Muharraq', 17),
(336, 'ar-Rifa\'a', 17),
(337, 'Bagar Hat', 18),
(338, 'Bandarban', 18),
(339, 'Barguna', 18),
(340, 'Barisal', 18),
(341, 'Bhola', 18),
(342, 'Bogora', 18),
(343, 'Brahman Bariya', 18),
(344, 'Chandpur', 18),
(345, 'Chattagam', 18),
(346, 'Chittagong Division', 18),
(347, 'Chuadanga', 18),
(348, 'Dhaka', 18),
(349, 'Dinajpur', 18),
(350, 'Faridpur', 18),
(351, 'Feni', 18),
(352, 'Gaybanda', 18),
(353, 'Gazipur', 18),
(354, 'Gopalganj', 18),
(355, 'Habiganj', 18),
(356, 'Jaipur Hat', 18),
(357, 'Jamalpur', 18),
(358, 'Jessor', 18),
(359, 'Jhalakati', 18),
(360, 'Jhanaydah', 18),
(361, 'Khagrachhari', 18),
(362, 'Khulna', 18),
(363, 'Kishorganj', 18),
(364, 'Koks Bazar', 18),
(365, 'Komilla', 18),
(366, 'Kurigram', 18),
(367, 'Kushtiya', 18),
(368, 'Lakshmipur', 18),
(369, 'Lalmanir Hat', 18),
(370, 'Madaripur', 18),
(371, 'Magura', 18),
(372, 'Maimansingh', 18),
(373, 'Manikganj', 18),
(374, 'Maulvi Bazar', 18),
(375, 'Meherpur', 18),
(376, 'Munshiganj', 18),
(377, 'Naral', 18),
(378, 'Narayanganj', 18),
(379, 'Narsingdi', 18),
(380, 'Nator', 18),
(381, 'Naugaon', 18),
(382, 'Nawabganj', 18),
(383, 'Netrakona', 18),
(384, 'Nilphamari', 18),
(385, 'Noakhali', 18),
(386, 'Pabna', 18),
(387, 'Panchagarh', 18),
(388, 'Patuakhali', 18),
(389, 'Pirojpur', 18),
(390, 'Rajbari', 18),
(391, 'Rajshahi', 18),
(392, 'Rangamati', 18),
(393, 'Rangpur', 18),
(394, 'Satkhira', 18),
(395, 'Shariatpur', 18),
(396, 'Sherpur', 18),
(397, 'Silhat', 18),
(398, 'Sirajganj', 18),
(399, 'Sunamganj', 18),
(400, 'Tangayal', 18),
(401, 'Thakurgaon', 18),
(402, 'Christ Church', 19),
(403, 'Saint Andrew', 19),
(404, 'Saint George', 19),
(405, 'Saint James', 19),
(406, 'Saint John', 19),
(407, 'Saint Joseph', 19),
(408, 'Saint Lucy', 19),
(409, 'Saint Michael', 19),
(410, 'Saint Peter', 19),
(411, 'Saint Philip', 19),
(412, 'Saint Thomas', 19),
(413, 'Brest', 20),
(414, 'Homjel\'', 20),
(415, 'Hrodna', 20),
(416, 'Mahiljow', 20),
(417, 'Mahilyowskaya Voblasts', 20),
(418, 'Minsk', 20),
(419, 'Minskaja Voblasts\'', 20),
(420, 'Petrik', 20),
(421, 'Vicebsk', 20),
(422, 'Antwerpen', 21),
(423, 'Berchem', 21),
(424, 'Brabant', 21),
(425, 'Brabant Wallon', 21),
(426, 'Brussel', 21),
(427, 'East Flanders', 21),
(428, 'Hainaut', 21),
(429, 'Liege', 21),
(430, 'Limburg', 21),
(431, 'Luxembourg', 21),
(432, 'Namur', 21),
(433, 'Ontario', 21),
(434, 'Oost-Vlaanderen', 21),
(435, 'Provincie Brabant', 21),
(436, 'Vlaams-Brabant', 21),
(437, 'Wallonne', 21),
(438, 'West-Vlaanderen', 21),
(439, 'Belize', 22),
(440, 'Cayo', 22),
(441, 'Corozal', 22),
(442, 'Orange Walk', 22),
(443, 'Stann Creek', 22),
(444, 'Toledo', 22),
(445, 'Alibori', 23),
(446, 'Atacora', 23),
(447, 'Atlantique', 23),
(448, 'Borgou', 23),
(449, 'Collines', 23),
(450, 'Couffo', 23),
(451, 'Donga', 23),
(452, 'Littoral', 23),
(453, 'Mono', 23),
(454, 'Oueme', 23),
(455, 'Plateau', 23),
(456, 'Zou', 23),
(457, 'Hamilton', 24),
(458, 'Saint George', 24),
(459, 'Bumthang', 25),
(460, 'Chhukha', 25),
(461, 'Chirang', 25),
(462, 'Daga', 25),
(463, 'Geylegphug', 25),
(464, 'Ha', 25),
(465, 'Lhuntshi', 25),
(466, 'Mongar', 25),
(467, 'Pemagatsel', 25),
(468, 'Punakha', 25),
(469, 'Rinpung', 25),
(470, 'Samchi', 25),
(471, 'Samdrup Jongkhar', 25),
(472, 'Shemgang', 25),
(473, 'Tashigang', 25),
(474, 'Timphu', 25),
(475, 'Tongsa', 25),
(476, 'Wangdiphodrang', 25),
(477, 'Beni', 26),
(478, 'Chuquisaca', 26),
(479, 'Cochabamba', 26),
(480, 'La Paz', 26),
(481, 'Oruro', 26),
(482, 'Pando', 26),
(483, 'Potosi', 26),
(484, 'Santa Cruz', 26),
(485, 'Tarija', 26),
(486, 'Federacija Bosna i Hercegovina', 27),
(487, 'Republika Srpska', 27),
(488, 'Central Bobonong', 28),
(489, 'Central Boteti', 28),
(490, 'Central Mahalapye', 28),
(491, 'Central Serowe-Palapye', 28),
(492, 'Central Tutume', 28),
(493, 'Chobe', 28),
(494, 'Francistown', 28),
(495, 'Gaborone', 28),
(496, 'Ghanzi', 28),
(497, 'Jwaneng', 28),
(498, 'Kgalagadi North', 28),
(499, 'Kgalagadi South', 28),
(500, 'Kgatleng', 28),
(501, 'Kweneng', 28),
(502, 'Lobatse', 28),
(503, 'Ngamiland', 28),
(504, 'Ngwaketse', 28),
(505, 'North East', 28),
(506, 'Okavango', 28),
(507, 'Orapa', 28),
(508, 'Selibe Phikwe', 28),
(509, 'South East', 28),
(510, 'Sowa', 28),
(511, 'Bouvet Island', 29),
(512, 'Acre', 30),
(513, 'Alagoas', 30),
(514, 'Amapa', 30),
(515, 'Amazonas', 30),
(516, 'Bahia', 30),
(517, 'Ceara', 30),
(518, 'Distrito Federal', 30),
(519, 'Espirito Santo', 30),
(520, 'Estado de Sao Paulo', 30),
(521, 'Goias', 30),
(522, 'Maranhao', 30),
(523, 'Mato Grosso', 30),
(524, 'Mato Grosso do Sul', 30),
(525, 'Minas Gerais', 30),
(526, 'Para', 30),
(527, 'Paraiba', 30),
(528, 'Parana', 30),
(529, 'Pernambuco', 30),
(530, 'Piaui', 30),
(531, 'Rio Grande do Norte', 30),
(532, 'Rio Grande do Sul', 30),
(533, 'Rio de Janeiro', 30),
(534, 'Rondonia', 30),
(535, 'Roraima', 30),
(536, 'Santa Catarina', 30),
(537, 'Sao Paulo', 30),
(538, 'Sergipe', 30),
(539, 'Tocantins', 30),
(540, 'British Indian Ocean Territory', 31),
(541, 'Belait', 32),
(542, 'Brunei-Muara', 32),
(543, 'Temburong', 32),
(544, 'Tutong', 32),
(545, 'Blagoevgrad', 33),
(546, 'Burgas', 33),
(547, 'Dobrich', 33),
(548, 'Gabrovo', 33),
(549, 'Haskovo', 33),
(550, 'Jambol', 33),
(551, 'Kardzhali', 33),
(552, 'Kjustendil', 33),
(553, 'Lovech', 33),
(554, 'Montana', 33),
(555, 'Oblast Sofiya-Grad', 33),
(556, 'Pazardzhik', 33),
(557, 'Pernik', 33),
(558, 'Pleven', 33),
(559, 'Plovdiv', 33),
(560, 'Razgrad', 33),
(561, 'Ruse', 33),
(562, 'Shumen', 33),
(563, 'Silistra', 33),
(564, 'Sliven', 33),
(565, 'Smoljan', 33),
(566, 'Sofija grad', 33),
(567, 'Sofijska oblast', 33),
(568, 'Stara Zagora', 33),
(569, 'Targovishte', 33),
(570, 'Varna', 33),
(571, 'Veliko Tarnovo', 33),
(572, 'Vidin', 33),
(573, 'Vraca', 33),
(574, 'Yablaniza', 33),
(575, 'Bale', 34),
(576, 'Bam', 34),
(577, 'Bazega', 34),
(578, 'Bougouriba', 34),
(579, 'Boulgou', 34),
(580, 'Boulkiemde', 34),
(581, 'Comoe', 34),
(582, 'Ganzourgou', 34),
(583, 'Gnagna', 34),
(584, 'Gourma', 34),
(585, 'Houet', 34),
(586, 'Ioba', 34),
(587, 'Kadiogo', 34),
(588, 'Kenedougou', 34),
(589, 'Komandjari', 34),
(590, 'Kompienga', 34),
(591, 'Kossi', 34),
(592, 'Kouritenga', 34),
(593, 'Kourweogo', 34),
(594, 'Leraba', 34),
(595, 'Mouhoun', 34),
(596, 'Nahouri', 34),
(597, 'Namentenga', 34),
(598, 'Noumbiel', 34),
(599, 'Oubritenga', 34),
(600, 'Oudalan', 34),
(601, 'Passore', 34),
(602, 'Poni', 34),
(603, 'Sanguie', 34),
(604, 'Sanmatenga', 34),
(605, 'Seno', 34),
(606, 'Sissili', 34),
(607, 'Soum', 34),
(608, 'Sourou', 34),
(609, 'Tapoa', 34),
(610, 'Tuy', 34),
(611, 'Yatenga', 34),
(612, 'Zondoma', 34),
(613, 'Zoundweogo', 34),
(614, 'Bubanza', 35),
(615, 'Bujumbura', 35),
(616, 'Bururi', 35),
(617, 'Cankuzo', 35),
(618, 'Cibitoke', 35),
(619, 'Gitega', 35),
(620, 'Karuzi', 35),
(621, 'Kayanza', 35),
(622, 'Kirundo', 35),
(623, 'Makamba', 35),
(624, 'Muramvya', 35),
(625, 'Muyinga', 35),
(626, 'Ngozi', 35),
(627, 'Rutana', 35),
(628, 'Ruyigi', 35),
(629, 'Banteay Mean Chey', 36),
(630, 'Bat Dambang', 36),
(631, 'Kampong Cham', 36),
(632, 'Kampong Chhnang', 36),
(633, 'Kampong Spoeu', 36),
(634, 'Kampong Thum', 36),
(635, 'Kampot', 36),
(636, 'Kandal', 36),
(637, 'Kaoh Kong', 36),
(638, 'Kracheh', 36),
(639, 'Krong Kaeb', 36),
(640, 'Krong Pailin', 36),
(641, 'Krong Preah Sihanouk', 36),
(642, 'Mondol Kiri', 36),
(643, 'Otdar Mean Chey', 36),
(644, 'Phnum Penh', 36),
(645, 'Pousat', 36),
(646, 'Preah Vihear', 36),
(647, 'Prey Veaeng', 36),
(648, 'Rotanak Kiri', 36),
(649, 'Siem Reab', 36),
(650, 'Stueng Traeng', 36),
(651, 'Svay Rieng', 36),
(652, 'Takaev', 36),
(653, 'Adamaoua', 37),
(654, 'Centre', 37),
(655, 'Est', 37),
(656, 'Littoral', 37),
(657, 'Nord', 37),
(658, 'Nord Extreme', 37),
(659, 'Nordouest', 37),
(660, 'Ouest', 37),
(661, 'Sud', 37),
(662, 'Sudouest', 37),
(663, 'Alberta', 38),
(664, 'British Columbia', 38),
(665, 'Manitoba', 38),
(666, 'New Brunswick', 38),
(667, 'Newfoundland and Labrador', 38),
(668, 'Northwest Territories', 38),
(669, 'Nova Scotia', 38),
(670, 'Nunavut', 38),
(671, 'Ontario', 38),
(672, 'Prince Edward Island', 38),
(673, 'Quebec', 38),
(674, 'Saskatchewan', 38),
(675, 'Yukon', 38),
(676, 'Boavista', 39),
(677, 'Brava', 39),
(678, 'Fogo', 39),
(679, 'Maio', 39),
(680, 'Sal', 39),
(681, 'Santo Antao', 39),
(682, 'Sao Nicolau', 39),
(683, 'Sao Tiago', 39),
(684, 'Sao Vicente', 39),
(685, 'Grand Cayman', 40),
(686, 'Bamingui-Bangoran', 41),
(687, 'Bangui', 41),
(688, 'Basse-Kotto', 41),
(689, 'Haut-Mbomou', 41),
(690, 'Haute-Kotto', 41),
(691, 'Kemo', 41),
(692, 'Lobaye', 41),
(693, 'Mambere-Kadei', 41),
(694, 'Mbomou', 41),
(695, 'Nana-Gribizi', 41),
(696, 'Nana-Mambere', 41),
(697, 'Ombella Mpoko', 41),
(698, 'Ouaka', 41),
(699, 'Ouham', 41),
(700, 'Ouham-Pende', 41),
(701, 'Sangha-Mbaere', 41),
(702, 'Vakaga', 41),
(703, 'Batha', 42),
(704, 'Biltine', 42),
(705, 'Bourkou-Ennedi-Tibesti', 42),
(706, 'Chari-Baguirmi', 42),
(707, 'Guera', 42),
(708, 'Kanem', 42),
(709, 'Lac', 42),
(710, 'Logone Occidental', 42),
(711, 'Logone Oriental', 42),
(712, 'Mayo-Kebbi', 42),
(713, 'Moyen-Chari', 42),
(714, 'Ouaddai', 42),
(715, 'Salamat', 42),
(716, 'Tandjile', 42),
(717, 'Aisen', 43),
(718, 'Antofagasta', 43),
(719, 'Araucania', 43),
(720, 'Atacama', 43),
(721, 'Bio Bio', 43),
(722, 'Coquimbo', 43),
(723, 'Libertador General Bernardo O\'', 43),
(724, 'Los Lagos', 43),
(725, 'Magellanes', 43),
(726, 'Maule', 43),
(727, 'Metropolitana', 43),
(728, 'Metropolitana de Santiago', 43),
(729, 'Tarapaca', 43),
(730, 'Valparaiso', 43),
(731, 'Anhui', 44),
(732, 'Anhui Province', 44),
(733, 'Anhui Sheng', 44),
(734, 'Aomen', 44),
(735, 'Beijing', 44),
(736, 'Beijing Shi', 44),
(737, 'Chongqing', 44),
(738, 'Fujian', 44),
(739, 'Fujian Sheng', 44),
(740, 'Gansu', 44),
(741, 'Guangdong', 44),
(742, 'Guangdong Sheng', 44),
(743, 'Guangxi', 44),
(744, 'Guizhou', 44),
(745, 'Hainan', 44),
(746, 'Hebei', 44),
(747, 'Heilongjiang', 44),
(748, 'Henan', 44),
(749, 'Hubei', 44),
(750, 'Hunan', 44),
(751, 'Jiangsu', 44),
(752, 'Jiangsu Sheng', 44),
(753, 'Jiangxi', 44),
(754, 'Jilin', 44),
(755, 'Liaoning', 44),
(756, 'Liaoning Sheng', 44),
(757, 'Nei Monggol', 44),
(758, 'Ningxia Hui', 44),
(759, 'Qinghai', 44);

-- --------------------------------------------------------

--
-- Table structure for table `store_product`
--

CREATE TABLE `store_product` (
  `store_product_id` varchar(100) NOT NULL,
  `store_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `variant_id` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `store_set`
--

CREATE TABLE `store_set` (
  `store_id` varchar(100) NOT NULL,
  `store_name` varchar(100) NOT NULL,
  `store_address` text NOT NULL,
  `default_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=inactive,1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_set`
--

INSERT INTO `store_set` (`store_id`, `store_name`, `store_address`, `default_status`) VALUES
('3384CTWDU7QZFRO', 'Store_a', 'Lorem ipsum dolor sit amet.', 1),
('JSG794YZP94M2QF', 'Store_b', 'Lorem ipsum dolor sit amet.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscriber`
--

CREATE TABLE `subscriber` (
  `subscriber_id` varchar(100) NOT NULL,
  `apply_ip` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_information`
--

CREATE TABLE `supplier_information` (
  `supplier_id` varchar(100) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `details` text NOT NULL,
  `website` text NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier_information`
--

INSERT INTO `supplier_information` (`supplier_id`, `supplier_name`, `address`, `mobile`, `email`, `details`, `website`, `status`) VALUES
('I3JRQQJSJ67GG2ZTEEU1', 'Supplier_1', '', '48454656544', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_ledger`
--

CREATE TABLE `supplier_ledger` (
  `transaction_id` varchar(100) NOT NULL,
  `purchase_id` varchar(100) DEFAULT NULL,
  `supplier_id` varchar(100) NOT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `deposit_no` varchar(50) DEFAULT NULL,
  `amount` float NOT NULL,
  `description` text NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `date` varchar(50) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `synchronizer_setting`
--

CREATE TABLE `synchronizer_setting` (
  `id` int(11) NOT NULL,
  `hostname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `port` varchar(10) NOT NULL,
  `debug` varchar(10) NOT NULL,
  `project_root` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `synchronizer_setting`
--

INSERT INTO `synchronizer_setting` (`id`, `hostname`, `username`, `password`, `port`, `debug`, `project_root`) VALUES
(8, '', '', '', '21', 'true', '');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `tax_id` varchar(100) NOT NULL,
  `tax_name` varchar(100) NOT NULL,
  `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`tax_id`, `tax_name`, `status`) VALUES
('52C2SKCKGQY6Q9J', 'Income tax', 1),
('5SN9PRWPN131T4V', 'Tax 3', 1),
('H5MQN4NXJBSDX4L', 'sales tax', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tax_collection_details`
--

CREATE TABLE `tax_collection_details` (
  `tax_col_de_id` varchar(100) NOT NULL,
  `invoice_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `tax_id` varchar(100) NOT NULL,
  `variant_id` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tax_collection_summary`
--

CREATE TABLE `tax_collection_summary` (
  `tax_collection_id` varchar(100) NOT NULL,
  `invoice_id` varchar(100) NOT NULL,
  `tax_id` varchar(100) NOT NULL,
  `tax_amount` float NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tax_product_service`
--

CREATE TABLE `tax_product_service` (
  `t_p_s_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `tax_id` varchar(100) NOT NULL,
  `tax_percentage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `terminal_payment`
--

CREATE TABLE `terminal_payment` (
  `pay_terminal_id` varchar(100) NOT NULL,
  `terminal_name` varchar(100) NOT NULL,
  `terminal_provider_company` varchar(250) NOT NULL,
  `linked_bank_account_no` varchar(100) NOT NULL,
  `customer_care_phone_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'isshue_classic', 0, '2020-08-26 19:26:41', '2021-04-17 09:11:42'),
(2, 'martbd', 0, '2020-08-30 12:09:01', '2021-04-21 13:39:53'),
(3, 'shatu', 0, '2020-08-30 12:09:01', '2021-04-21 13:40:58'),
(4, 'zaima', 1, '2020-08-30 12:09:01', '2021-04-04 05:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `transfer_id` varchar(100) NOT NULL,
  `store_id` varchar(100) DEFAULT NULL,
  `warehouse_id` varchar(100) DEFAULT NULL,
  `product_id` varchar(100) NOT NULL,
  `variant_id` varchar(100) NOT NULL,
  `variant_color` varchar(30) DEFAULT NULL,
  `quantity` float NOT NULL,
  `t_store_id` varchar(100) DEFAULT NULL,
  `t_warehouse_id` varchar(100) DEFAULT NULL,
  `purchase_id` varchar(100) DEFAULT NULL,
  `date_time` varchar(100) NOT NULL,
  `transfer_by` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1=store to store,2=store to warehouse,3=warehouse to store,4=warehouse to warehouse,5=purchase'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unit_id` varchar(100) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `unit_short_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `about` text,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `password_reset_token` varchar(20) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL,
  `ip_address` varchar(14) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin` tinyint(4) NOT NULL DEFAULT '0',
  `user_type` tinyint(4) NOT NULL COMMENT '1=admin,2=shop-manager,3=sales man,4=store keeper,5=customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(100) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `gender` int(2) NOT NULL,
  `date_of_birth` varchar(255) NOT NULL,
  `logo` varchar(250) DEFAULT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `user_id` varchar(100) NOT NULL,
  `store_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `user_type` int(2) NOT NULL COMMENT '1=admin,2=shop-manager,3=sales man,4=store keeper,5=customer',
  `security_code` varchar(255) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `variant`
--

CREATE TABLE `variant` (
  `variant_id` varchar(100) NOT NULL,
  `variant_type` enum('size','color') NOT NULL DEFAULT 'size',
  `color_code` varchar(30) DEFAULT NULL,
  `variant_name` varchar(100) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `variant`
--

INSERT INTO `variant` (`variant_id`, `variant_type`, `color_code`, `variant_name`, `status`) VALUES
('3JJRT8TG11VD1FY', 'size', NULL, 'Large', 1),
('DBQD7B1AGBAUZSS', 'size', NULL, 'Medium', 1),
('F6Q9ERLBZTUPJH7', 'color', '#1bb169', 'Green', 1),
('HCI7GK7I8CT46E6', 'color', '#261bc5', 'Blue', 1),
('MMYXJ4FWYXAHXPJ', 'size', NULL, 'Small', 1),
('TJ8IK6SW9RHT443', 'size', '#1f7a53', 'Xtra Large', 1),
('W1YXEI3VIYW85KA', 'color', '#df1616', 'Red', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wearhouse_set`
--

CREATE TABLE `wearhouse_set` (
  `wearhouse_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `wearhouse_name` varchar(100) NOT NULL,
  `wearhouse_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `website_content`
--

CREATE TABLE `website_content` (
  `web_content_id` int(11) NOT NULL,
  `content_id` varchar(255) NOT NULL,
  `language_id` varchar(255) NOT NULL,
  `content_headline` text NOT NULL,
  `content_image` text NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `web_footer`
--

CREATE TABLE `web_footer` (
  `footer_section_id` varchar(100) NOT NULL,
  `headlines` text NOT NULL,
  `details` text NOT NULL,
  `position` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web_footer`
--

INSERT INTO `web_footer` (`footer_section_id`, `headlines`, `details`, `position`, `status`) VALUES
('4UXP4OHYVGUBDSQ', 'First Block', '<h4 class=\"link-title fs-16 mb-3 font-weight-600 position-relative footer-app-link\">Our Communities</h4>\r\n<ul class=\"list-unstyled social-icon\">\r\n<li><a href=\"#\"><div class=\"icon-wrap fs-19 d-inline-block bg-primary text-white text-center fb\"><i class=\"fab fa-facebook-f\"></i></div>Facebook </a></li>\r\n\r\n<li><a href=\"#\"><div class=\"icon-wrap fs-19 d-inline-block bg-primary text-white text-center twi\"><i class=\"fab fa-twitter\"></i></div>Twitter</a></li>\r\n\r\n<li><a href=\"#\"><div class=\"icon-wrap fs-19 d-inline-block bg-primary text-white text-center inst\"><i class=\"fab fa-instagram\"></i></div>Instagram</a></li>\r\n\r\n<li><a href=\"#\"><div class=\"icon-wrap fs-19 d-inline-block bg-primary text-white text-center lin\"><i class=\"fab fa-linkedin\"></i></div>Linkedin</a></li>\r\n\r\n<li><a href=\"#\"><div class=\"icon-wrap fs-19 d-inline-block bg-primary text-white text-center yt\"><i class=\"fab fa-youtube-square\"></i></div>Youtube</a></li>\r\n                            \r\n</ul>', 1, 1),
('R65OGYDCBUWYYI3', 'Second Block', '<h4 class=\"link-title fs-16 mb-3 font-weight-600 position-relative footer-app-link\">Information</h4>\r\n                        <ul class=\"footer-link list-unstyled menu mb-0\">\r\n                            <li class=\"mb-2\"><a href=\"about_us\" class=\"link d-block\">About Us</a></li>\r\n                            <li class=\"mb-2\"><a href=\"contact_us\" class=\"link d-block\">Contact us</a></li>\r\n                            <li class=\"mb-2\"><a href=\"delivery_info\" class=\"link d-block\">Delivery Information</a></li>\r\n                            <li class=\"mb-2\"><a href=\"privacy_policy\" class=\"link d-block\">Privacy Policy</a></li>\r\n                            <li class=\"mb-2\"><a href=\"terms_condition\" class=\"link d-block\">Terms & Conditions</a></li>\r\n                            <li class=\"mb-2\"><a href=\"#\" class=\"link d-block\">Track My Order</a></li>\r\n                        </ul>', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `web_setting`
--

CREATE TABLE `web_setting` (
  `setting_id` int(11) NOT NULL,
  `logo` text,
  `invoice_logo` text,
  `favicon` text,
  `footer_logo` text,
  `footer_text` text,
  `footer_details` text,
  `google_analytics` text,
  `facebook_messenger` text,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `application_protocol` varchar(30) NOT NULL DEFAULT 'http',
  `app_link_status` tinyint(4) NOT NULL,
  `pay_with_status` tinyint(4) NOT NULL COMMENT '1=active , 0=inactive',
  `map_api_key` text,
  `map_latitude` text,
  `map_langitude` text,
  `apps_url` varchar(255) DEFAULT NULL,
  `mob_footer_block` varchar(100) DEFAULT NULL,
  `social_share` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web_setting`
--

INSERT INTO `web_setting` (`setting_id`, `logo`, `invoice_logo`, `favicon`, `footer_logo`, `footer_text`, `footer_details`, `google_analytics`, `facebook_messenger`, `meta_keyword`, `meta_description`, `application_protocol`, `app_link_status`, `pay_with_status`, `map_api_key`, `map_latitude`, `map_langitude`, `apps_url`, `mob_footer_block`, `social_share`) VALUES
(1, 'my-assets/image/logo/df04af33355957b356412ee3699f4a7e.png', NULL, 'my-assets/image/logo/ce1697c92622e92f91e2b341eb89419c.png', 'my-assets/image/logo/5e8f6887b4830e633d9c8ded53fe990c.png', 'Developed by <a href=\"https://demo453464315.com/\" target=\"_blank\">Demo</a>', 'Isshue Multistore E-Commerce system.', '<script></script>', '', 'meta keyword, aaa, bbb, ccc', 'multistore ecommerce software bb, bbb, ccc, ddd', '', 1, 1, 'AIzaSyBGwh3ShY_W1hMms1wmwlHK3hpInhExn3o', '8.901922', '66.325790', '', '[\"1\",\"0\",\"0\",\"1\"]', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`adv_id`);

--
-- Indexes for table `bank_add`
--
ALTER TABLE `bank_add`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`block_id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `category_variant`
--
ALTER TABLE `category_variant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `check_out`
--
ALTER TABLE `check_out`
  ADD PRIMARY KEY (`check_out_id`);

--
-- Indexes for table `cheque_manger`
--
ALTER TABLE `cheque_manger`
  ADD PRIMARY KEY (`cheque_id`);

--
-- Indexes for table `color_backends`
--
ALTER TABLE `color_backends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `color_frontends`
--
ALTER TABLE `color_frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_information`
--
ALTER TABLE `company_information`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `coupon_invoice`
--
ALTER TABLE `coupon_invoice`
  ADD PRIMARY KEY (`coupon_invoice_id`);

--
-- Indexes for table `crypto_payments`
--
ALTER TABLE `crypto_payments`
  ADD PRIMARY KEY (`paymentID`),
  ADD UNIQUE KEY `key3` (`boxID`,`orderID`,`userID`,`txID`,`amount`,`addr`),
  ADD KEY `boxID` (`boxID`),
  ADD KEY `boxType` (`boxType`),
  ADD KEY `userID` (`userID`),
  ADD KEY `countryID` (`countryID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `amount` (`amount`),
  ADD KEY `amountUSD` (`amountUSD`),
  ADD KEY `coinLabel` (`coinLabel`),
  ADD KEY `unrecognised` (`unrecognised`),
  ADD KEY `addr` (`addr`),
  ADD KEY `txID` (`txID`),
  ADD KEY `txDate` (`txDate`),
  ADD KEY `txConfirmed` (`txConfirmed`),
  ADD KEY `txCheckDate` (`txCheckDate`),
  ADD KEY `processed` (`processed`),
  ADD KEY `processedDate` (`processedDate`),
  ADD KEY `recordCreated` (`recordCreated`),
  ADD KEY `key1` (`boxID`,`orderID`),
  ADD KEY `key2` (`boxID`,`orderID`,`userID`);

--
-- Indexes for table `currency_info`
--
ALTER TABLE `currency_info`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `customer_activities`
--
ALTER TABLE `customer_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_information`
--
ALTER TABLE `customer_information`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_ledger`
--
ALTER TABLE `customer_ledger`
  ADD KEY `receipt_no` (`receipt_no`),
  ADD KEY `receipt_no_2` (`receipt_no`),
  ADD KEY `receipt_no_3` (`receipt_no`),
  ADD KEY `receipt_no_4` (`receipt_no`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`customer_order_id`);

--
-- Indexes for table `daily_closing`
--
ALTER TABLE `daily_closing`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `delivery_assign`
--
ALTER TABLE `delivery_assign`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Indexes for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_time_slot`
--
ALTER TABLE `delivery_time_slot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_zone`
--
ALTER TABLE `delivery_zone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_configuration`
--
ALTER TABLE `email_configuration`
  ADD PRIMARY KEY (`email_id`);

--
-- Indexes for table `image_gallery`
--
ALTER TABLE `image_gallery`
  ADD PRIMARY KEY (`image_gallery_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`invoice_details_id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link_page`
--
ALTER TABLE `link_page`
  ADD PRIMARY KEY (`link_page_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_permission`
--
ALTER TABLE `module_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_module_id` (`fk_module_id`),
  ADD KEY `fk_user_id` (`fk_user_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_details_id`);

--
-- Indexes for table `order_tax_col_details`
--
ALTER TABLE `order_tax_col_details`
  ADD PRIMARY KEY (`order_tax_col_de_id`);

--
-- Indexes for table `order_tax_col_summary`
--
ALTER TABLE `order_tax_col_summary`
  ADD PRIMARY KEY (`order_tax_col_id`);

--
-- Indexes for table `our_location`
--
ALTER TABLE `our_location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `payeer_payments`
--
ALTER TABLE `payeer_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_gateway`
--
ALTER TABLE `payment_gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay_withs`
--
ALTER TABLE `pay_withs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `product_information`
--
ALTER TABLE `product_information`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_model` (`product_model`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `product_purchase`
--
ALTER TABLE `product_purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `product_purchase_details`
--
ALTER TABLE `product_purchase_details`
  ADD PRIMARY KEY (`purchase_detail_id`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`product_review_id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`quotation_id`);

--
-- Indexes for table `quotation_details`
--
ALTER TABLE `quotation_details`
  ADD PRIMARY KEY (`quotation_details_id`);

--
-- Indexes for table `quotation_tax_col_details`
--
ALTER TABLE `quotation_tax_col_details`
  ADD PRIMARY KEY (`quot_tax_col_de_id`);

--
-- Indexes for table `quotation_tax_col_summary`
--
ALTER TABLE `quotation_tax_col_summary`
  ADD PRIMARY KEY (`quot_tax_col_id`);

--
-- Indexes for table `search_history`
--
ALTER TABLE `search_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sec_menu_item`
--
ALTER TABLE `sec_menu_item`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `sec_role_permission`
--
ALTER TABLE `sec_role_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sec_role_tbl`
--
ALTER TABLE `sec_role_tbl`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `sec_user_access_tbl`
--
ALTER TABLE `sec_user_access_tbl`
  ADD PRIMARY KEY (`role_acc_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_info`
--
ALTER TABLE `shipping_info`
  ADD PRIMARY KEY (`shiping_info_id`);

--
-- Indexes for table `shipping_method`
--
ALTER TABLE `shipping_method`
  ADD PRIMARY KEY (`method_id`);

--
-- Indexes for table `site_analytics`
--
ALTER TABLE `site_analytics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `sms_configuration`
--
ALTER TABLE `sms_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_template`
--
ALTER TABLE `sms_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_auth`
--
ALTER TABLE `social_auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soft_setting`
--
ALTER TABLE `soft_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_product`
--
ALTER TABLE `store_product`
  ADD PRIMARY KEY (`store_product_id`);

--
-- Indexes for table `store_set`
--
ALTER TABLE `store_set`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`subscriber_id`);

--
-- Indexes for table `supplier_information`
--
ALTER TABLE `supplier_information`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `supplier_ledger`
--
ALTER TABLE `supplier_ledger`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `receipt_no` (`deposit_no`),
  ADD KEY `receipt_no_2` (`deposit_no`),
  ADD KEY `receipt_no_3` (`deposit_no`),
  ADD KEY `receipt_no_4` (`deposit_no`);

--
-- Indexes for table `synchronizer_setting`
--
ALTER TABLE `synchronizer_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `tax_collection_details`
--
ALTER TABLE `tax_collection_details`
  ADD PRIMARY KEY (`tax_col_de_id`);

--
-- Indexes for table `tax_collection_summary`
--
ALTER TABLE `tax_collection_summary`
  ADD PRIMARY KEY (`tax_collection_id`);

--
-- Indexes for table `tax_product_service`
--
ALTER TABLE `tax_product_service`
  ADD PRIMARY KEY (`t_p_s_id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `variant`
--
ALTER TABLE `variant`
  ADD PRIMARY KEY (`variant_id`);

--
-- Indexes for table `wearhouse_set`
--
ALTER TABLE `wearhouse_set`
  ADD PRIMARY KEY (`wearhouse_id`);

--
-- Indexes for table `website_content`
--
ALTER TABLE `website_content`
  ADD PRIMARY KEY (`web_content_id`);

--
-- Indexes for table `web_footer`
--
ALTER TABLE `web_footer`
  ADD PRIMARY KEY (`footer_section_id`);

--
-- Indexes for table `web_setting`
--
ALTER TABLE `web_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_variant`
--
ALTER TABLE `category_variant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `color_backends`
--
ALTER TABLE `color_backends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `color_frontends`
--
ALTER TABLE `color_frontends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `crypto_payments`
--
ALTER TABLE `crypto_payments`
  MODIFY `paymentID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_activities`
--
ALTER TABLE `customer_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_assign`
--
ALTER TABLE `delivery_assign`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `delivery_time_slot`
--
ALTER TABLE `delivery_time_slot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_zone`
--
ALTER TABLE `delivery_zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1398;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `module_permission`
--
ALTER TABLE `module_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `our_location`
--
ALTER TABLE `our_location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payeer_payments`
--
ALTER TABLE `payeer_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_gateway`
--
ALTER TABLE `payment_gateway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pay_withs`
--
ALTER TABLE `pay_withs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_information`
--
ALTER TABLE `product_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `search_history`
--
ALTER TABLE `search_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sec_menu_item`
--
ALTER TABLE `sec_menu_item`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `sec_role_permission`
--
ALTER TABLE `sec_role_permission`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=469;

--
-- AUTO_INCREMENT for table `sec_role_tbl`
--
ALTER TABLE `sec_role_tbl`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sec_user_access_tbl`
--
ALTER TABLE `sec_user_access_tbl`
  MODIFY `role_acc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shipping_info`
--
ALTER TABLE `shipping_info`
  MODIFY `shiping_info_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_method`
--
ALTER TABLE `shipping_method`
  MODIFY `method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_analytics`
--
ALTER TABLE `site_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_configuration`
--
ALTER TABLE `sms_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms_template`
--
ALTER TABLE `sms_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `social_auth`
--
ALTER TABLE `social_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `soft_setting`
--
ALTER TABLE `soft_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=760;

--
-- AUTO_INCREMENT for table `synchronizer_setting`
--
ALTER TABLE `synchronizer_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `website_content`
--
ALTER TABLE `website_content`
  MODIFY `web_content_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web_setting`
--
ALTER TABLE `web_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
