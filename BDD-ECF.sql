-- Adminer 4.8.1 MySQL 8.0.30 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_880E0D76E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admin` (`id`, `email`, `roles`, `password`) VALUES
(3,	'admin@sport.fr',	'[\"ROLE_ADMIN\"]',	'$2y$13$lMNJ8QRb.jXLqni3UFk9deZZmQRVyQUJHehx7eeH/RYFPaSERbA0y')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `email` = VALUES(`email`), `roles` = VALUES(`roles`), `password` = VALUES(`password`);

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220813132451',	'2022-08-19 09:43:44',	67),
('DoctrineMigrations\\Version20220813134044',	'2022-08-19 09:43:44',	50),
('DoctrineMigrations\\Version20220815195805',	'2022-08-19 09:43:44',	11),
('DoctrineMigrations\\Version20220818001058',	'2022-08-19 09:43:44',	52),
('DoctrineMigrations\\Version20220818115146',	'2022-08-19 09:43:44',	10),
('DoctrineMigrations\\Version20220819094349',	'2022-08-19 09:43:52',	82),
('DoctrineMigrations\\Version20220819094729',	'2022-08-19 09:47:31',	80),
('DoctrineMigrations\\Version20220819101909',	'2022-08-19 10:19:12',	90),
('DoctrineMigrations\\Version20220819132247',	'2022-08-19 13:23:03',	44),
('DoctrineMigrations\\Version20220820105927',	'2022-08-20 10:59:39',	79),
('DoctrineMigrations\\Version20220824073213',	'2022-08-24 07:32:24',	149),
('DoctrineMigrations\\Version20220824160318',	'2022-08-24 16:03:37',	136),
('DoctrineMigrations\\Version20220824160843',	'2022-08-24 16:08:56',	67),
('DoctrineMigrations\\Version20220824222440',	'2022-08-24 22:24:51',	79),
('DoctrineMigrations\\Version20220825152153',	'2022-08-25 15:21:59',	36),
('DoctrineMigrations\\Version20220826134737',	'2022-08-26 13:47:45',	54),
('DoctrineMigrations\\Version20220826150232',	'2022-08-26 15:02:43',	47)
ON DUPLICATE KEY UPDATE `version` = VALUES(`version`), `executed_at` = VALUES(`executed_at`), `execution_time` = VALUES(`execution_time`);

DROP TABLE IF EXISTS `franchise`;
CREATE TABLE `franchise` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `sauna` tinyint(1) NOT NULL,
  `ring_boxe` tinyint(1) NOT NULL,
  `crossfit` tinyint(1) NOT NULL,
  `biking` tinyint(1) NOT NULL,
  `whey_sale` tinyint(1) NOT NULL,
  `towel_sale` tinyint(1) NOT NULL,
  `drink_sale` tinyint(1) NOT NULL,
  `payment_day` tinyint(1) NOT NULL,
  `late_closing` tinyint(1) NOT NULL,
  `send_newsletter` tinyint(1) NOT NULL,
  `roles` json NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `activation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_66F6CE2ABEAB6C24` (`password_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `franchise` (`id`, `name`, `email`, `password`, `active`, `sauna`, `ring_boxe`, `crossfit`, `biking`, `whey_sale`, `towel_sale`, `drink_sale`, `payment_day`, `late_closing`, `send_newsletter`, `roles`, `image_name`, `updated_at`, `activation_token`, `password_token`, `city`) VALUES
(32,	'Nantes',	'nantes@sport.fr',	'$2y$13$Y1gG.9qs3t9bnbd.0WwhGuFcN1NGsjkoahGo7YHJrsueana4TSWsm',	1,	0,	0,	0,	1,	1,	0,	0,	1,	1,	0,	'[]',	NULL,	'2022-08-26 15:02:49',	NULL,	NULL,	'Nantes'),
(33,	'Marseille',	'marseilles@sport.fr',	'$2y$13$9RnWe5IhJ331P72uJUjNVOQvfL5q2DYjqcyKWqcPd7GXUNz4Sf2y.',	1,	0,	0,	1,	0,	0,	0,	1,	1,	0,	0,	'[]',	NULL,	'2022-08-26 15:02:49',	NULL,	NULL,	'Marseille'),
(34,	'BORDEAUX',	'bordeaux@sport.fr',	'$2y$13$BJGr4hLJxhaPlnVUajYfcuC.ys8pE.Y1sWiECkAjX0/I9pWJV6Ecy',	0,	0,	0,	0,	0,	1,	0,	0,	1,	0,	0,	'[]',	NULL,	'2022-08-27 19:43:27',	NULL,	NULL,	'Bordeaux'),
(35,	'Rennes',	'rennes@sport.fr',	'$2y$13$TUNEPVeKc/sLUGs6Yu7fyOomFMJKMmaZQkiKfBi/fje51BSnrbvqK',	0,	1,	0,	0,	1,	1,	0,	0,	0,	0,	0,	'[]',	NULL,	'2022-08-28 19:17:43',	NULL,	NULL,	'Rennes')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `name` = VALUES(`name`), `email` = VALUES(`email`), `password` = VALUES(`password`), `active` = VALUES(`active`), `sauna` = VALUES(`sauna`), `ring_boxe` = VALUES(`ring_boxe`), `crossfit` = VALUES(`crossfit`), `biking` = VALUES(`biking`), `whey_sale` = VALUES(`whey_sale`), `towel_sale` = VALUES(`towel_sale`), `drink_sale` = VALUES(`drink_sale`), `payment_day` = VALUES(`payment_day`), `late_closing` = VALUES(`late_closing`), `send_newsletter` = VALUES(`send_newsletter`), `roles` = VALUES(`roles`), `image_name` = VALUES(`image_name`), `updated_at` = VALUES(`updated_at`), `activation_token` = VALUES(`activation_token`), `password_token` = VALUES(`password_token`), `city` = VALUES(`city`);

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `structure`;
CREATE TABLE `structure` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` longtext COLLATE utf8mb4_unicode_ci,
  `full_description` longtext COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL,
  `sauna` tinyint(1) NOT NULL,
  `ring_boxe` tinyint(1) NOT NULL,
  `crossfit` tinyint(1) NOT NULL,
  `biking` tinyint(1) NOT NULL,
  `franchise_id` int NOT NULL,
  `roles` json NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whey_sale` tinyint(1) NOT NULL,
  `towel_sale` tinyint(1) NOT NULL,
  `drink_sale` tinyint(1) NOT NULL,
  `payment_day` tinyint(1) NOT NULL,
  `late_closing` tinyint(1) NOT NULL,
  `send_newsletter` tinyint(1) NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `activation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `franchise_validated` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6F0137EABEAB6C24` (`password_token`),
  KEY `IDX_6F0137EA523CAB89` (`franchise_id`),
  CONSTRAINT `FK_6F0137EA523CAB89` FOREIGN KEY (`franchise_id`) REFERENCES `franchise` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `structure` (`id`, `name`, `email`, `password`, `city`, `short_description`, `full_description`, `active`, `sauna`, `ring_boxe`, `crossfit`, `biking`, `franchise_id`, `roles`, `address`, `postal_code`, `whey_sale`, `towel_sale`, `drink_sale`, `payment_day`, `late_closing`, `send_newsletter`, `image_name`, `updated_at`, `activation_token`, `password_token`, `franchise_validated`) VALUES
(39,	'Nantes Moulin',	'nantes.moulin@sport.fr',	'$2y$13$3ju/hRnLl5YV1g/11JfmQ.rqZxLwekNTlCjd55gBAf/M4TvLYCDba',	'Nantes',	NULL,	NULL,	1,	0,	0,	0,	1,	32,	'[]',	'20 boulevard Jean Moulin',	'44100',	1,	0,	0,	1,	1,	0,	NULL,	'2022-08-26 15:02:50',	NULL,	NULL,	1),
(40,	'Nantes Erdre',	'nantes.erdre@sport.fr',	'$2y$13$h30/.KKYa3diIauIlSTQS.XeQuN6d8AGq7ED/HybfaIXkzn.2Y/JC',	'Nantes',	NULL,	NULL,	1,	0,	0,	0,	1,	32,	'[]',	'20 rue de l\'Erdre',	'44300',	1,	0,	0,	1,	1,	0,	NULL,	'2022-08-26 15:02:50',	NULL,	NULL,	1),
(41,	'Marseille Port',	'marseille.port@sport.fr',	'$2y$13$zQKHUW3lPD3vf5c.NjyAwOjpyqewLJ5Y4HruDuJGPeot9Dq0ybuj.',	'Marseille',	'Belle salle de sport, bon matériel',	NULL,	1,	0,	0,	1,	0,	33,	'[]',	'15 rue du port',	'13000',	0,	0,	1,	1,	0,	0,	'sport-630bb1085e7ca257042143.webp',	'2022-08-28 18:16:40',	NULL,	NULL,	1),
(42,	'Rennes Alma',	'rennes.alma@sport.fr',	'$2y$13$K.IWklBqdHNkZEE1B41fkO0syiONYngWuIwMHxotHeoD1x2mi9Thm',	'Rennes',	NULL,	NULL,	1,	1,	0,	0,	1,	35,	'[]',	'Boulevard Henri Fréville',	'35200',	1,	0,	0,	0,	0,	0,	NULL,	'2022-08-28 19:21:41',	NULL,	NULL,	1)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `name` = VALUES(`name`), `email` = VALUES(`email`), `password` = VALUES(`password`), `city` = VALUES(`city`), `short_description` = VALUES(`short_description`), `full_description` = VALUES(`full_description`), `active` = VALUES(`active`), `sauna` = VALUES(`sauna`), `ring_boxe` = VALUES(`ring_boxe`), `crossfit` = VALUES(`crossfit`), `biking` = VALUES(`biking`), `franchise_id` = VALUES(`franchise_id`), `roles` = VALUES(`roles`), `address` = VALUES(`address`), `postal_code` = VALUES(`postal_code`), `whey_sale` = VALUES(`whey_sale`), `towel_sale` = VALUES(`towel_sale`), `drink_sale` = VALUES(`drink_sale`), `payment_day` = VALUES(`payment_day`), `late_closing` = VALUES(`late_closing`), `send_newsletter` = VALUES(`send_newsletter`), `image_name` = VALUES(`image_name`), `updated_at` = VALUES(`updated_at`), `activation_token` = VALUES(`activation_token`), `password_token` = VALUES(`password_token`), `franchise_validated` = VALUES(`franchise_validated`);

-- 2022-09-01 08:01:37
