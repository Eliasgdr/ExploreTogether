-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 12 mai 2024 à 20:15
-- Version du serveur : 10.5.20-MariaDB
-- Version de PHP : 7.3.33

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
CREATE DATABASE IF NOT EXISTS `id22104896_jsp` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `id22104896_jsp`;

-- --------------------------------------------------------

--
-- Structure de la table `blockedUsers`
--

CREATE TABLE `blockedUsers` (
  `blockID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `blockedUserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `blockedUsers`
--

INSERT INTO `blockedUsers` (`blockID`, `userID`, `blockedUserID`) VALUES
(2, 5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

CREATE TABLE `countries` (
  `countryID` int(11) NOT NULL,
  `countryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `friendship`
--

CREATE TABLE `friendship` (
  `friendshipID` int(11) NOT NULL,
  `user1` int(11) DEFAULT NULL,
  `user2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `friendship`
--

INSERT INTO `friendship` (`friendshipID`, `user1`, `user2`) VALUES
(1, 5, 5),
(2, 5, 10),
(3, 5, 11),
(4, 5, 31);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `messageID` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `body` varchar(535) NOT NULL,
  `authorID` int(11) DEFAULT NULL,
  `threadID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`messageID`, `Date`, `body`, `authorID`, `threadID`) VALUES
(20, '2024-05-03 22:44:05', 'Hi, I just created a new Thread named ae', 10, 8),
(21, '2024-05-03 22:44:24', 'wow', 10, 8),
(23, '2024-05-03 22:54:32', 'Hi, I just created a new Thread named yt', 10, 9),
(24, '2024-05-03 22:55:01', 'test', 10, 9),
(45, '2024-05-08 21:31:23', 'Hi, I just created a new Thread named t', 5, 16),
(46, '2024-05-09 22:51:49', 'Hi, I just created a new Thread named rzr', 5, 17),
(47, '2024-05-09 22:52:02', 'rzrer', 5, 17),
(48, '2024-05-09 22:52:05', 'ezrdsdgsdg', 5, 17),
(49, '2024-05-10 10:39:37', 'aa', 5, 16),
(50, '2024-05-10 10:39:39', 'aa', 5, 16),
(51, '2024-05-10 10:49:38', 'ere', 5, 16),
(52, '2024-05-10 11:36:52', 'tretretre', 5, 16),
(53, '2024-05-10 11:36:58', 'h', 5, 16),
(54, '2024-05-10 11:50:48', 'ar', 5, 16),
(55, '2024-05-10 11:52:00', 'rere', 5, 16),
(56, '2024-05-10 11:52:12', 'rere', 5, 16),
(57, '2024-05-10 11:52:14', 'rerer', 5, 16),
(58, '2024-05-10 11:52:17', 'trtrt', 5, 16),
(59, '2024-05-10 12:00:13', 'rte', 5, 16),
(60, '2024-05-10 12:02:09', 'test', 5, 16),
(61, '2024-05-10 12:02:17', 'hello in here', 5, 16),
(62, '2024-05-10 12:02:50', 'hihihih', 5, 16),
(63, '2024-05-10 12:04:02', 'hi', 5, 16),
(64, '2024-05-10 12:04:05', 'hi', 5, 16),
(65, '2024-05-10 12:04:07', 'hi', 5, 16),
(66, '2024-05-10 12:04:09', 'hi', 5, 16),
(67, '2024-05-10 15:03:55', 'tzt', 5, 16),
(68, '2024-05-10 15:03:58', 'tztztzt', 5, 16),
(69, '2024-05-10 18:32:37', 'Hi, I just created a new Thread named ar', 5, 23),
(70, '2024-05-10 18:35:16', 'Hi, I just created a new Thread named ae', 5, 24),
(71, '2024-05-10 18:58:31', 'Hi, I just created a new Thread named halo', 5, 25),
(72, '2024-05-10 18:58:37', 'hehehehe', 5, 25),
(73, '2024-05-10 18:58:45', 'hehehehejheakzjhekjaeb', 5, 25),
(74, '2024-05-10 18:58:46', 'hehehehejheakzjhekjaeb', 5, 25),
(75, '2024-05-10 19:12:15', 'Hi, I just created a new Thread named ae', 5, 26),
(76, '2024-05-10 19:13:13', 'Hi, I just created a new Thread named rr', 5, 27),
(77, '2024-05-10 19:14:12', 'Hi, I just created a new Thread named test', 5, 28),
(78, '2024-05-10 22:08:36', 'hi', 5, 8),
(79, '2024-05-10 22:08:44', 'yeah wow', 5, 8),
(80, '2024-05-10 22:09:55', 'hi', 5, 8),
(81, '2024-05-10 22:10:02', 'how are u', 5, 8),
(82, '2024-05-10 22:10:11', 'fine and u ?', 5, 8),
(83, '2024-05-10 22:12:52', 'test', 5, 8),
(84, '2024-05-10 22:12:59', 'does it work ?', 5, 8),
(85, '2024-05-10 22:24:29', 'zr', 5, 8),
(86, '2024-05-10 22:24:32', 'zrzr', 5, 8),
(87, '2024-05-10 22:24:35', 'test', 5, 8),
(88, '2024-05-10 22:29:19', 'test', 5, 8),
(89, '2024-05-10 22:38:02', 're', 5, 8),
(90, '2024-05-10 22:38:04', 're', 5, 8),
(91, '2024-05-10 22:38:06', 'ze', 5, 8),
(92, '2024-05-10 22:40:08', 're', 5, 8),
(93, '2024-05-10 22:40:10', 're', 5, 8),
(94, '2024-05-10 22:51:30', 'za', 5, 8),
(95, '2024-05-10 22:51:32', 'za', 5, 8),
(96, '2024-05-10 22:51:37', 'aze', 5, 8),
(97, '2024-05-10 22:52:08', 'er', 5, 8),
(98, '2024-05-10 22:52:34', 'test', 5, 8),
(99, '2024-05-10 22:52:37', 'test', 5, 8),
(100, '2024-05-10 22:55:42', 'hi', 5, 8),
(101, '2024-05-10 22:55:47', 'hello', 5, 8),
(102, '2024-05-10 22:57:10', 'hehehe', 5, 8),
(103, '2024-05-10 22:57:27', 'te', 5, 8),
(104, '2024-05-10 22:59:32', 'hehe', 5, 8),
(105, '2024-05-11 09:14:42', 'Hi, I just created a new Thread named tr', 5, 29),
(106, '2024-05-11 09:44:47', 'Hi, I just created a new Thread named test', 5, 30);

-- --------------------------------------------------------

--
-- Structure de la table `moderators`
--

CREATE TABLE `moderators` (
  `moderationID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `threadID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notifs`
--

CREATE TABLE `notifs` (
  `notifID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `content` varchar(535) NOT NULL,
  `link` varchar(535) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `threads`
--

CREATE TABLE `threads` (
  `threadID` int(11) NOT NULL,
  `lastMessageID` int(11) DEFAULT NULL,
  `title` varchar(535) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `isDM` tinyint(1) NOT NULL DEFAULT 0,
  `ownerID` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `threads`
--

INSERT INTO `threads` (`threadID`, `lastMessageID`, `title`, `description`, `isDM`, `ownerID`) VALUES
(8, 104, 'ae', 'ae', 0, NULL),
(9, 24, 'yt', 'yt', 0, NULL),
(16, 68, 't', 't', 0, NULL),
(17, 48, 'rzr', 'zrzr', 0, NULL),
(18, NULL, 'ar', 'ar', 0, NULL),
(19, NULL, 'ar', 'ar', 0, NULL),
(20, NULL, 'ar', 'ar', 0, NULL),
(21, NULL, 'ar', 'ar', 0, NULL),
(22, NULL, 'ar', 'ar', 0, NULL),
(23, 69, 'ar', 'ar', 0, NULL),
(24, 70, 'ae', 'ae', 0, NULL),
(25, 74, 'halo', 'german', 0, NULL),
(26, 75, 'ae', 'ae', 0, NULL),
(27, 76, 'rr', 'rr', 0, NULL),
(28, 77, 'test', 'test', 0, NULL),
(29, 105, 'tr', 'tr', 0, NULL),
(30, 106, 'test', 'test', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `threadSubscriptions`
--

CREATE TABLE `threadSubscriptions` (
  `threadSubscriptionID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `threadID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `threadSubscriptions`
--

INSERT INTO `threadSubscriptions` (`threadSubscriptionID`, `userID`, `threadID`) VALUES
(1, 10, 16),
(5, 5, 25),
(6, 5, 26),
(7, 5, 27),
(8, 5, 28),
(9, 5, 29);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(535) NOT NULL,
  `gender` enum('M','F','O') NOT NULL,
  `birthdate` date NOT NULL,
  `password` varchar(535) NOT NULL,
  `registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `threads` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID`, `username`, `gender`, `birthdate`, `password`, `registrationDate`, `threads`) VALUES
(5, 'test', 'M', '0020-02-20', '$2y$10$6P/U0CbFg9LQ7k4LSAddEet2D7N7sSwJXslH3EC2y9eBd634QI7f.', '2024-05-02 00:00:00', ',15,16,17'),
(7, 'D', 'M', '2020-02-20', '$2y$10$BwSjlb9F33n7HA7Wg5byGe5VU.7J2ysPgmPPtwkghDtgsgPJ4rpfW', '2024-05-02 00:00:00', ''),
(8, 'John Wick', 'F', '1978-04-01', '$2y$10$It6iujIe7d.m7z/Pgl3v4eUNhzvVjpQCsfaT0kloQTVrFRYL8hWFm', '2024-05-03 00:00:00', ''),
(9, 'Toto', 'M', '2001-01-01', '$2y$10$tlstgkkQQeaXs4rX3ht3SeUWeh.gMjzhoWCG8y64mM.jd9DtyTOpS', '2024-05-03 00:00:00', NULL),
(10, 'test2', 'M', '2020-02-20', '$2y$10$72xJya76jD5p9rRt7KM25uHf7bsKWI6V.C3M25b/YyifIRIS5shMG', '2024-05-03 00:00:00', '1,2,5,6,7,8'),
(11, 'test3', 'M', '0200-02-20', '$2y$10$Mxemorws7aW0E2ZeoFP3D.vqKKE7zr4LtjI743h/.7bIpuai.gk/W', '2024-05-10 00:00:00', NULL),
(12, 't', 'M', '0002-02-20', '$2y$10$v2be6JNti/g2CrJiJjX0Cupqq5dNoMByL.NODjq7EV.rcBu77Yq5u', '2024-05-10 00:00:00', NULL),
(13, 'e', 'M', '0010-10-10', '$2y$10$5kyO9/mW1gReE3G8SibDOeCr/xyfWVs3GOcefdbuOhEYCQqIRwEEi', '2024-05-10 00:00:00', NULL),
(14, '', 'M', '0025-02-10', '$2y$10$iYPjhhlqeF7kGg8Igb9CeOLrDob3GruyaolhuXhZcliDJdEcZhEbC', '2024-05-10 00:00:00', NULL),
(15, '', 'F', '0010-10-10', '$2y$10$vNznhAjxHyDvJ9DZA3tSbeAx16bUnbHxeWZEjqIBF/a3DGMSLfhmO', '2024-05-10 00:00:00', NULL),
(16, '', 'O', '0101-10-10', '$2y$10$PCys4Ep0SOz0E0X2GW6une53.MGt1BGsvNtTlVVZm7rlsRCzIk0/e', '2024-05-10 00:00:00', NULL),
(17, '', 'O', '0001-01-01', '$2y$10$x6BVesnY6SXDO0SnueLhUu.NdW0W8Sm6cZZ7etIBrv6hRpvEv8SwW', '2024-05-10 00:00:00', NULL),
(18, '', 'O', '0001-01-01', '$2y$10$XxJbe8pW.jFRTfo30DDsiu6yJajaeyJE2K6X1aTKn5WRmIOd7csUS', '2024-05-10 00:00:00', NULL),
(19, '', 'O', '0001-01-01', '$2y$10$kCtQWigMBGJbZRW68b6vv.8TjxzHVC/Eo8K6GQwjBg9jhoCAuedrm', '2024-05-10 00:00:00', NULL),
(20, '', 'O', '0001-01-01', '$2y$10$5qY4j1M1PHePmtPphuACEOZ8vjDUnV9j6iZSy88oIYhnWr8uEM1Dy', '2024-05-10 00:00:00', NULL),
(21, '', 'O', '0001-01-01', '$2y$10$EX/V7tNmnvxzs/45Ib.N4uatAl91.q5snTY.di.oLG/j2AISl3sg.', '2024-05-10 00:00:00', NULL),
(22, '', 'O', '0001-01-01', '$2y$10$5ZwFK072JHIa4mzt.l.8lOPoHh.AEUqvAmhjBJdvPniPSHmUnpT6i', '2024-05-10 00:00:00', NULL),
(23, '', 'O', '0001-01-01', '$2y$10$rZUXuKEKBNK2Z9EzTPIMdesSFCx/oBPKkTg6JKD8cdgHnQ0mX5Wbq', '2024-05-10 00:00:00', NULL),
(24, '', 'O', '0001-01-01', '$2y$10$zEe97fsSwpbLVHj8j61OYuyz2482VuE658u.UekR2up4a2M5N/vLy', '2024-05-10 00:00:00', NULL),
(25, '', 'O', '0001-01-01', '$2y$10$ZoQPYywobGnbX3AbJo267eiyrXtT1EnAJTHi34X.bW/N2fAFKDBLO', '2024-05-10 00:00:00', NULL),
(26, '', 'O', '0001-01-01', '$2y$10$XBjjoyeocxkKl/DqORfkWepRvMiZv4NMKYLtXh6w6BNrBi6ukySjW', '2024-05-10 00:00:00', NULL),
(27, 'ae', 'F', '0010-10-10', '$2y$10$n2A7dxHI0b6IxltdmgchzOXBXfsPUzq3.hFXm34ea5kVTnomSR4Iq', '2024-05-10 00:00:00', NULL),
(28, 'erezrze', 'F', '0100-10-10', '$2y$10$fRo8c2/..YrnBhYWZCPfOuuyplTPnnJJMmy1.Z/Aia65oy3CW3DVW', '2024-05-10 00:00:00', NULL),
(29, 'ERZ', 'F', '0010-10-10', '$2y$10$ctCu05dk0Vl1Y8V1VF.5beUphfkUZ1NX5V1jnXvNX3izBA0YYyYaW', '2024-05-10 00:00:00', NULL),
(30, 'test4', 'M', '1010-10-10', '$2y$10$411LoGFlwmX3LLtl9udZluCupaINY3U6zZ6voCoi6NfBxMel1CW4S', '2024-05-10 00:00:00', NULL),
(31, 'test6', 'O', '0001-10-10', '$2y$10$2Z3.cwB.QVcJEf3RJ1EY2.ngNPJDOLH8BBaTtfzoZcDBzgfayofku', '2024-05-10 00:00:00', NULL),
(32, 'test5', 'M', '0010-10-10', '$2y$10$fgnQTQRWTr5IGS.eVckf5.gRCkf/hawQZ.ZZOzAV8HnDaW2X4ehpK', '2024-05-10 00:00:00', NULL),
(33, 'test7', 'M', '0010-10-10', '$2y$10$UeyPylH4psQGGkr0G7/wx.wWn32lLfc6GperCwhzxNswFGdWtKSMW', '2024-05-10 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `UserVisitedCountries`
--

CREATE TABLE `UserVisitedCountries` (
  `UserVisitedCountriesID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `countryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `UserWishlistCountries`
--

CREATE TABLE `UserWishlistCountries` (
  `UserVisitedCountriesID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `countryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blockedUsers`
--
ALTER TABLE `blockedUsers`
  ADD PRIMARY KEY (`blockID`),
  ADD UNIQUE KEY `userID` (`userID`) USING BTREE,
  ADD UNIQUE KEY `userBlockedID` (`blockedUserID`) USING BTREE;

--
-- Index pour la table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`countryID`);

--
-- Index pour la table `friendship`
--
ALTER TABLE `friendship`
  ADD PRIMARY KEY (`friendshipID`),
  ADD KEY `user1` (`user1`),
  ADD KEY `user2` (`user2`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `authorID` (`authorID`),
  ADD KEY `threadID` (`threadID`);

--
-- Index pour la table `moderators`
--
ALTER TABLE `moderators`
  ADD PRIMARY KEY (`moderationID`),
  ADD KEY `userID_index` (`userID`),
  ADD KEY `threadID_index` (`threadID`);

--
-- Index pour la table `notifs`
--
ALTER TABLE `notifs`
  ADD PRIMARY KEY (`notifID`),
  ADD KEY `user` (`userID`);

--
-- Index pour la table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`threadID`),
  ADD KEY `owner` (`ownerID`),
  ADD KEY `lastMessage` (`lastMessageID`);

--
-- Index pour la table `threadSubscriptions`
--
ALTER TABLE `threadSubscriptions`
  ADD PRIMARY KEY (`threadSubscriptionID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `threadID` (`threadID`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `UserVisitedCountries`
--
ALTER TABLE `UserVisitedCountries`
  ADD PRIMARY KEY (`UserVisitedCountriesID`),
  ADD UNIQUE KEY `userID` (`userID`),
  ADD UNIQUE KEY `countyID` (`countryID`);

--
-- Index pour la table `UserWishlistCountries`
--
ALTER TABLE `UserWishlistCountries`
  ADD PRIMARY KEY (`UserVisitedCountriesID`),
  ADD UNIQUE KEY `userID` (`userID`),
  ADD UNIQUE KEY `countyID` (`countryID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `blockedUsers`
--
ALTER TABLE `blockedUsers`
  MODIFY `blockID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `countries`
--
ALTER TABLE `countries`
  MODIFY `countryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `friendship`
--
ALTER TABLE `friendship`
  MODIFY `friendshipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT pour la table `moderators`
--
ALTER TABLE `moderators`
  MODIFY `moderationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notifs`
--
ALTER TABLE `notifs`
  MODIFY `notifID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `threads`
--
ALTER TABLE `threads`
  MODIFY `threadID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `threadSubscriptions`
--
ALTER TABLE `threadSubscriptions`
  MODIFY `threadSubscriptionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `UserVisitedCountries`
--
ALTER TABLE `UserVisitedCountries`
  MODIFY `UserVisitedCountriesID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `UserWishlistCountries`
--
ALTER TABLE `UserWishlistCountries`
  MODIFY `UserVisitedCountriesID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `blockedUsers`
--
ALTER TABLE `blockedUsers`
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
-- Contraintes pour la table `moderators`
--
ALTER TABLE `moderators`
  ADD CONSTRAINT `moderators_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `moderators_ibfk_2` FOREIGN KEY (`threadID`) REFERENCES `threads` (`threadID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notifs`
--
ALTER TABLE `notifs`
  ADD CONSTRAINT `user` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `lastMessage` FOREIGN KEY (`lastMessageID`) REFERENCES `message` (`messageID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `owner` FOREIGN KEY (`ownerID`) REFERENCES `users` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `threadSubscriptions`
--
ALTER TABLE `threadSubscriptions`
  ADD CONSTRAINT `threadSubscriptions_ibfk_1` FOREIGN KEY (`threadID`) REFERENCES `threads` (`threadID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `UserVisitedCountries`
--
ALTER TABLE `UserVisitedCountries`
  ADD CONSTRAINT `UserVisitedCountries_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `UserVisitedCountries_ibfk_2` FOREIGN KEY (`countryID`) REFERENCES `countries` (`countryID`);

--
-- Contraintes pour la table `UserWishlistCountries`
--
ALTER TABLE `UserWishlistCountries`
  ADD CONSTRAINT `UserWishlistCountries_ibfk_1` FOREIGN KEY (`countryID`) REFERENCES `countries` (`countryID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UserWishlistCountries_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
