-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2021 at 06:09 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobilive`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `clm_a_id` int(11) NOT NULL,
  `clm_a_user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clm_a_pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clm_a_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clm_a_date` datetime NOT NULL DEFAULT current_timestamp(),
  `clm_a_img` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`clm_a_id`, `clm_a_user`, `clm_a_pass`, `clm_a_email`, `clm_a_date`, `clm_a_img`) VALUES
(4, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'don.karimmansour@gmail.com', '2020-05-28 20:17:35', 'adminfdd9898a875df114297a4937e00b6014__profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_channel`
--

CREATE TABLE `tbl_channel` (
  `clm_cn_id` int(11) NOT NULL,
  `clm_cn_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clm_cn_logo` text COLLATE utf8_unicode_ci NOT NULL,
  `clm_cn_link` text COLLATE utf8_unicode_ci NOT NULL,
  `clm_cn_status` enum('publish','draft') COLLATE utf8_unicode_ci NOT NULL,
  `clm_cn_type` enum('live_link','youtube') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_channel`
--

INSERT INTO `tbl_channel` (`clm_cn_id`, `clm_cn_name`, `clm_cn_logo`, `clm_cn_link`, `clm_cn_status`, `clm_cn_type`) VALUES
(-1, 'empty', 'empty', 'empty', 'publish', 'live_link'),
(15, 'premium 1 720p', 'bein_sports.png', 'http://50.anfalrou.xyz/live/6161655/index.m3u8', 'publish', 'live_link'),
(16, 'premium 2 720p', 'bein_sports.png', 'http://50.anfalrou.xyz/live/616194987/index.m3u8', 'publish', 'live_link'),
(17, 'premium 3 720p', 'bein_sports.png', 'http://50.anfalrou.xyz/live/6151278887/index.m3u8', 'publish', 'live_link'),
(18, 'hd 1 720p', 'bein_sports.png', 'http://59.anfalrou.xyz/live/918454578/index.m3u8', 'publish', 'live_link'),
(19, 'hd 2 720p', 'bein_sports.png', 'http://53.anfalrou.xyz/live/69854211/index.m3u8', 'publish', 'live_link'),
(20, 'hd 3 720p', 'bein_sports.png', 'http://45.anfalrou.xyz/live/645587700/index.m3u8', 'publish', 'live_link'),
(21, 'hd 4 720p', 'bein_sports.png', 'http://52.anfalrou.xyz/live/9787488847/index.m3u8', 'publish', 'live_link'),
(22, 'hd 6 720p', 'bein_sports.png', 'http://55.banrhfour.xyz.global.prod.fastly.net/live/1515000000/index.m3u8', 'publish', 'live_link'),
(23, 'xtra 1 720p', 'bein_sports.png', 'http://52.anfalrou.xyz/live/9962564400/index.m3u8', 'publish', 'live_link'),
(24, 'xtra 2 720p', 'bein_sports.png', 'http://42.anfalrou.xyz/live/880025552/index.m3u8', 'publish', 'live_link'),
(25, 'france 1 720p', 'bein_sports.png', 'http://58.anfalrou.xyz/live/33523510/index.m3u8', 'publish', 'live_link'),
(26, 'france 2 720p', 'bein_sports.png', 'http://47.anfalrou.xyz/live/652177700/index.m3u8', 'publish', 'live_link'),
(27, 'france 3 720p', 'bein_sports.png', 'http://51.anfalrou.xyz/live/62464521/index.m3u8', 'publish', 'live_link'),
(31, 'premium 1 360p', 'bein_sports.png', 'http://52.anfalrou.xyz/live/88824257/index.m3u8', 'publish', 'live_link'),
(32, 'premium 2 360p', 'bein_sports.png', 'http://55.anfalrou.xyz/live/79481245/index.m3u8', 'publish', 'live_link'),
(33, 'premium 3 360p', 'bein_sports.png', 'http://50.anfalrou.xyz/live/17988558/index.m3u8', 'publish', 'live_link'),
(34, 'hd 1 360p', 'bein_sports.png', 'http://59.anfalrou.xyz/live/978488877/index.m3u8', 'publish', 'live_link'),
(35, 'hd 2 360p', 'bein_sports.png', 'http://51.anfalrou.xyz/live/10011244/index.m3u8', 'publish', 'live_link'),
(36, 'hd 3 360p', 'bein_sports.png', 'http://58.anfalrou.xyz/live/161988840/index.m3u8', 'publish', 'live_link'),
(37, 'hd 4 360p', 'bein_sports.png', 'http://54.anfalrou.xyz/live/0103088447/index.m3u8', 'publish', 'live_link'),
(38, 'hd 6 360p', 'bein_sports.png', 'http://55.banrhfour.xyz.global.prod.fastly.net/live/115451004/index.m3u8', 'publish', 'live_link'),
(39, 'xtra 1 360p', 'bein_sports.png', 'http://58.anfalrou.xyz/live/500025558/index.m3u8', 'publish', 'live_link'),
(40, 'xtra 2 360p', 'bein_sports.png', 'http://54.anfalrou.xyz/live/5151400337/index.m3u8', 'publish', 'live_link'),
(41, 'france 1 360p', 'bein_sports.png', 'http://42.anfalrou.xyz/live/14066007/index.m3u8', 'publish', 'live_link'),
(44, 'france 2 360p', 'bein_sports.png', 'http://45.anfalrou.xyz/live/68525202/index.m3u8', 'publish', 'live_link'),
(45, 'france 3 360p', 'bein_sports.png', 'http://42.anfalrou.xyz/live/32842140/index.m3u8', 'publish', 'live_link'),
(46, 'news 360p', 'bein_sports.png', 'http://53.anfalrou.xyz/live/32842140/index.m3u8', 'publish', 'live_link'),
(49, 'premium 1 244p', 'bein_sports.png', 'http://52.anfalrou.xyz/live/97848484/index.m3u8', 'publish', 'live_link'),
(50, 'premium 2 244p', 'bein_sports.png', 'http://54.anfalrou.xyz/live/122233888/index.m3u8', 'publish', 'live_link'),
(51, 'premium 3 244p', 'bein_sports.png', 'http://48.anfalrou.xyz/live/819797877/index.m3u8', 'publish', 'live_link'),
(52, 'hd 1 244p', 'bein_sports.png', 'http://47.anfalrou.xyz/live/31009988/index.m3u8', 'publish', 'live_link'),
(53, 'hd 2 244p', 'bein_sports.png', 'http://41.anfalrou.xyz/live/4798998070/index.m3u8', 'publish', 'live_link'),
(54, 'hd 3 244p', 'bein_sports.png', 'http://45.anfalrou.xyz/live/551818447/index.m3u8', 'publish', 'live_link'),
(55, 'hd 4 244p', 'bein_sports.png', 'http://42.anfalrou.xyz/live/131326625/index.m3u8', 'publish', 'live_link'),
(56, 'hd 6 244p', 'bein_sports.png', 'http://55.banrhfour.xyz.global.prod.fastly.net/live/115451004/index.m3u8', 'draft', 'live_link'),
(57, 'xtra 1 244p', 'bein_sports.png', 'http://49.anfalrou.xyz/live/0417877700/index.m3u8', 'publish', 'live_link'),
(58, 'xtra 2 244p', 'bein_sports.png', 'http://54.anfalrou.xyz/live/5151400337/index.m3u8', 'draft', 'live_link'),
(59, 'france 1 244p', 'bein_sports.png', 'http://41.anfalrou.xyz/live/79247621/index.m3u8', 'publish', 'live_link'),
(60, 'france 2 244p', 'bein_sports.png', 'http://57.anfalrou.xyz/live/0417877700/index.m3u8', 'publish', 'live_link'),
(61, 'france 3 244p', 'bein_sports.png', 'http://46.anfalrou.xyz/live/2433016410/index.m3u8', 'publish', 'live_link'),
(62, 'news 244p', 'bein_sports.png', 'http://49.anfalrou.xyz/live/2433016410/index.m3u8', 'publish', 'live_link'),
(63, 'movies 1', 'bein_sports.png', 'http://56.bihourmkras.xyz.global.prod.fastly.net/live/077/index.m3u8', 'publish', 'live_link'),
(64, 'movies 2', 'bein_sports.png', 'http://56.bihourmkras.xyz.global.prod.fastly.net/live/077/index.m3u8', 'publish', 'live_link'),
(65, 'movies 3', 'bein_sports.png', 'http://56.bihourmkras.xyz.global.prod.fastly.net/live/079/index.m3u8', 'publish', 'live_link');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat_room`
--

CREATE TABLE `tbl_chat_room` (
  `clm_cr_id` int(11) NOT NULL,
  `clm_cr_msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `clm_cr_date` datetime NOT NULL DEFAULT current_timestamp(),
  `clm_cr_match_id` int(11) NOT NULL,
  `clm_cr_user_id` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_chat_room`
--

INSERT INTO `tbl_chat_room` (`clm_cr_id`, `clm_cr_msg`, `clm_cr_date`, `clm_cr_match_id`, `clm_cr_user_id`) VALUES
(187, 'Welcome to th\\u00E9 app', '2021-10-14 16:57:26', 38, 34),
(189, 'Mm', '2021-10-14 17:00:29', 38, 34),
(196, 'Hi bro', '2021-10-14 17:07:33', 38, -1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_html`
--

CREATE TABLE `tbl_html` (
  `clm_html` text COLLATE utf8_unicode_ci NOT NULL,
  `clm_subject` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_html`
--

INSERT INTO `tbl_html` (`clm_html`, `clm_subject`) VALUES
('PGRpdiBzdHlsZT0ndGV4dC1hbGlnbjogY2VudGVyOyc+DQoJCQnCoCAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS08d2JyPi0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLTx3YnI+LS0tLS0tLS0tPGJyPg0KCQkJwqAgTW9iaUtvcmEgUGFzc3dvcmQgUmVzZXQ8YnI+DQoJCQnCoCAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS08d2JyPi0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLTx3YnI+LS0tLS0tLS0tPGJyPg0KCQkJPGJyPg0KCQkJwqAgRGVhciAoL3VzZXJuYW1lKSw8YnI+DQoJCQk8YnI+DQoJCQk8YnI+DQoJCQnCoEZvciB5b3VyIGluZm9ybWF0aW9uOjxicj4NCgkJCTxicj4NCgkJCTxicj4NCgkJCcKgIFVzZXIgTmFtZSA6wqAgKC91c2VybmFtZSl9IDxicj4NCgkJCcKgIEVtYWlsIDrCoCAoL2VtYWlsKSA8YnI+DQoJCQnCoCBOZXcgUGFzc3dvcmQgOsKgICgvbmV3Q29kZSkgPGJyPg0KCQkJPGJyPg0KCQkJPGJyPg0KCQkJPC9kaXY+DQo8YnI+ICgvaW1nKQ==', 'new Password');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_matches`
--

CREATE TABLE `tbl_matches` (
  `clm_m_id` int(11) NOT NULL,
  `clm_m_host_name` varchar(255) NOT NULL,
  `clm_m_guest_name` varchar(255) CHARACTER SET utf32 NOT NULL,
  `clm_m_host_logo` varchar(255) NOT NULL,
  `clm_m_guest_logo` varchar(255) NOT NULL,
  `clm_m_date` varchar(255) NOT NULL,
  `clm_m_status` enum('draft','publish') NOT NULL,
  `clm_m_cn_id_one` int(11) NOT NULL DEFAULT -1,
  `clm_m_cn_id_two` int(11) NOT NULL DEFAULT -1,
  `clm_m_cn_id_three` int(11) NOT NULL DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_matches`
--

INSERT INTO `tbl_matches` (`clm_m_id`, `clm_m_host_name`, `clm_m_guest_name`, `clm_m_host_logo`, `clm_m_guest_logo`, `clm_m_date`, `clm_m_status`, `clm_m_cn_id_one`, `clm_m_cn_id_two`, `clm_m_cn_id_three`) VALUES
(38, 'Barcelona', 'Real Madrid', 'barcelona.png', 'Real_Madrid.png', '20:00', 'publish', 18, 34, 52),
(39, 'Inter', 'Lazio', 'inter.png', 'Lazio.png', '22:15', 'publish', 19, 35, 53);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

CREATE TABLE `tbl_news` (
  `clm_nw_id` int(11) NOT NULL,
  `clm_nw_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clm_nw_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `clm_nw_img` text COLLATE utf8_unicode_ci NOT NULL,
  `clm_nw_date` datetime NOT NULL DEFAULT current_timestamp(),
  `clm_nw_status` enum('publish','draft') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_news`
--

INSERT INTO `tbl_news` (`clm_nw_id`, `clm_nw_title`, `clm_nw_desc`, `clm_nw_img`, `clm_nw_date`, `clm_nw_status`) VALUES
(1, 'Belgian FA confirms contract extension for Martinez', 'Belgian national team manager Roberto Martinez’s contract has been extended, officials confirmed on Wednesday, more than a fortnight after it was first reported.\r\n\r\nMartinez will stay until the end of the 2022 World Cup and will also act as the technical director of the Belgian Football Association, it said in a statement.\r\n\r\n“Talk about a renewal of the current contract of the national manager, which ends on June 30, has been going on for some time and each time in a particularly constructive atmosphere,” it said.\r\n\r\n“The coronavirus crisis delayed the process somewhat, but the contract extension is now confirmed and official.\r\n\r\n“This allows Roberto Martinez to continue his work, lay the foundation for the future of Belgian football and train his successor to take over after the 2022 World Cup.”\r\n\r\nMartinez, whose contract was up after this year’s European Championship, which has been shifted back a year because of the coronavirus crisis, is due to address a news conference later on Wednesday but added in the same statement: “Because of the Euro 2020 postponement we could not possibly end our collaboration already now.\r\n\r\n“The Belgian FA has an ambitious plan that I look forward to with great enthusiasm, both in the short and long term.\r\n\r\n“The next two and a half years will be very intense for our national team, with the European Championship, Nations League, 2020 World Cup qualifying matches and the World Cup in Qatar itself. I can only be happy and proud that I can continue working and prepare the future of Belgian football.”\r\n\r\nMartinez, 46, had already said in interviews over the last month he wanted to continue in charge in order to take Belgium to Euro 2021, where they are drawn in Group B and will play Denmark, Finland and Russia.\r\n\r\nThe team, who are top of the FIFA world rankings, had qualified in imposing fashion, by winning all 10 qualifiers, scoring 40 goals and conceding only three.\r\n\r\nSpanish-born Martinez, the former Wigan Athletic and Everton manager, took Belgium to third place at the World Cup in Russia two years ago. ', 'reuters_2019-11-16_2019-11-16t173233z_1769381502_rc2hcd9lpqch_rtrmadp_3_soccer-euro-rus-bel-report_reuters.jpg', '2020-05-20 22:20:39', 'publish'),
(2, 'Konta wants ATP/WTA to be a merger of equals', 'British number one Johanna Konta feels a merger of the women\'s governing WTA tennis body with the men\'s ATP makes sense but stressed it must only be on equal terms.\r\n\r\nRoger Federer last month called for a merger between the two organisations, with the Women\'s Tennis Association chief Steve Simon and Association of Tennis Professionals Tour Chairman Andrea Gaudenzi welcoming the suggestion.\r\n\r\nKonta, who sits on the WTA player council, has joined some of her fellow women professionals in calling for an equal position in any combined body in the future.\r\n\r\n\"For me, for my comprehension, I don\'t understand how it wouldn\'t be of equals because if we are then talking about that, would it be us literally saying we are worth less than our male counterparts?\" the world number 14 told British media.\r\n\r\n\"It would have to be a merger of equals because that\'s what we are. I wouldn\'t see how, right now in today\'s age, it would be allowed to be called anything else.\"\r\n\r\nAs many as seven associations run different parts of tennis in the world. Besides the ATP and the WTA Tours, the sport is also controlled by the International Tennis Federation and the boards of the four Grand Slam tournaments.\r\n\r\nCurrently viewers need different pay-TV platforms to watch tennis matches and a merger of the Tours could simplify television contracts and sponsorship deals.\r\n\r\nThe men\'s and women\'s players have a separate ranking system while some rules, including on-court coaching, are also different.\r\n\r\nAmerican great Billie Jean King had called for a unified governing body for men and women years ago but the 29-year-old Konta feels Federer\'s comments have brought attention back to the topic.\r\n\r\n\"I definitely think in the long run it makes sense for it to be one tour, it makes logical sense but I also know there are a lot of moving parts to it, and I know there will be a lot of people who won\'t want it to happen, but also a lot of people who do want it to happen,\" Konta added. ', 'reuters_2019-09-03_2019-09-03t192807z_1505087373_nocid_rtrmadp_3_tennis-us-open_reuters.jpg', '2020-05-20 22:20:39', 'publish'),
(3, 'Man City appeal against two-year European ban set for June', 'Manchester City&#39;s appeal against their two-year\r\nEuropean ban for breaching financial fair-play rules will be heard on\r\nJune 8-10, the Court of Arbitration for Sport said Tuesday.\r\n\r\nEuropean football governing body UEFA banned City from the Champions\r\nLeague for two years and fined them 30 million euros (32.7 million\r\ndollars) after it found the English champions had overstated its \r\nsponsorship revenue between 2012 and 2016.\r\n\r\nThe case needs to be decided before the draw for next season&#39;s\r\nChampions League.\r\n\r\nby ziyad mansour', 'reuters_2020-03-08_2020-03-08t172220z_2005280347_rc2tff9dtqsg_rtrmadp_3_soccer-england-mun-mci-report_reuters.jpg', '2020-05-20 22:20:39', 'publish');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smtp`
--

CREATE TABLE `tbl_smtp` (
  `clm_st_host` text COLLATE utf8_unicode_ci NOT NULL,
  `clm_st_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clm_st_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clm_st_port` int(11) NOT NULL,
  `clm_st_from` text COLLATE utf8_unicode_ci NOT NULL,
  `clm_st_fromname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clm_st_state` enum('on','off') COLLATE utf8_unicode_ci NOT NULL,
  `clm_st_reply_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clm_st_security` enum('tls','ssl') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_smtp`
--

INSERT INTO `tbl_smtp` (`clm_st_host`, `clm_st_username`, `clm_st_password`, `clm_st_port`, `clm_st_from`, `clm_st_fromname`, `clm_st_state`, `clm_st_reply_to`, `clm_st_security`) VALUES
('mail.privateemail.com', 'admin@digital-keys.shop', 'mmmm1111', 587, 'admin@digital-keys.shop', 'Mobilive', 'on', 'admin@digital-keys.shop', 'tls');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `clm_u_id` int(11) NOT NULL,
  `clm_u_username` varchar(255) NOT NULL,
  `clm_u_email` varchar(255) NOT NULL,
  `clm_u_password` varchar(255) NOT NULL,
  `clm_u_date` datetime NOT NULL DEFAULT current_timestamp(),
  `clm_u_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`clm_u_id`, `clm_u_username`, `clm_u_email`, `clm_u_password`, `clm_u_date`, `clm_u_img`) VALUES
(-1, 'Unknown', 'Unknown@Unknown.com', 'Unknown', '2021-10-14 17:06:51', 'empty'),
(34, 'karimmansour', 'don.karimmansour@gmail.com', 'd94c9a93d6f01fb9d26479baf78844d5', '2021-10-14 16:52:25', 'karimmansour__ 56b82a76-8df0-4e5d-b3c2-89742f0ff76d.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`clm_a_id`);

--
-- Indexes for table `tbl_channel`
--
ALTER TABLE `tbl_channel`
  ADD PRIMARY KEY (`clm_cn_id`);

--
-- Indexes for table `tbl_chat_room`
--
ALTER TABLE `tbl_chat_room`
  ADD PRIMARY KEY (`clm_cr_id`),
  ADD KEY `clm_cr_match_id` (`clm_cr_match_id`),
  ADD KEY `clm_cr_user_id` (`clm_cr_user_id`);

--
-- Indexes for table `tbl_matches`
--
ALTER TABLE `tbl_matches`
  ADD PRIMARY KEY (`clm_m_id`),
  ADD KEY `clm_m_cn_id_one` (`clm_m_cn_id_one`),
  ADD KEY `clm_m_cn_id_two` (`clm_m_cn_id_two`),
  ADD KEY `clm_m_cn_id_three` (`clm_m_cn_id_three`);

--
-- Indexes for table `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`clm_nw_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`clm_u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `clm_a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_channel`
--
ALTER TABLE `tbl_channel`
  MODIFY `clm_cn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tbl_chat_room`
--
ALTER TABLE `tbl_chat_room`
  MODIFY `clm_cr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `tbl_matches`
--
ALTER TABLE `tbl_matches`
  MODIFY `clm_m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `clm_nw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `clm_u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_chat_room`
--
ALTER TABLE `tbl_chat_room`
  ADD CONSTRAINT `tbl_chat_room_ibfk_1` FOREIGN KEY (`clm_cr_match_id`) REFERENCES `tbl_matches` (`clm_m_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_chat_room_ibfk_2` FOREIGN KEY (`clm_cr_user_id`) REFERENCES `tbl_users` (`clm_u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_matches`
--
ALTER TABLE `tbl_matches`
  ADD CONSTRAINT `tbl_matches_ibfk_1` FOREIGN KEY (`clm_m_cn_id_one`) REFERENCES `tbl_channel` (`clm_cn_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_matches_ibfk_2` FOREIGN KEY (`clm_m_cn_id_two`) REFERENCES `tbl_channel` (`clm_cn_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_matches_ibfk_3` FOREIGN KEY (`clm_m_cn_id_three`) REFERENCES `tbl_channel` (`clm_cn_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
