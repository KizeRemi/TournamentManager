-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:3306
-- Généré le :  Mer 22 Juin 2016 à 16:02
-- Version du serveur :  5.5.42
-- Version de PHP :  5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `tournament-manager`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `address` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `nickname` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birth_date` date DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `account`
--

INSERT INTO `account` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `address`, `city`, `country`, `region`, `img`, `created_at`, `updated_at`, `nickname`, `name`, `lastname`, `slug`, `birth_date`, `banner`) VALUES
(27, 'remi.mavillaz@live.fr', 'remi.mavillaz@live.fr', 'remi.mavillaz@live.fr', 'remi.mavillaz@live.fr', 1, 'p73lfospsf4g884o48ogwgs8o8wwckg', 'mzQSM/3Q9YjHIvnWz7nqrGgHLwv0do5Q9zdIsqOzubBuzMmidxdSnipn1OhIyQwspdEzOi5F0TQL38ewSTf7yA==', '2016-06-22 14:30:00', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 0, NULL, NULL, NULL, NULL, NULL, 'img_4200dcd588bc15653c8a7a741e2f25d1.png', '2016-06-22 10:48:19', '2016-06-22 14:30:00', 'Kize', 'Remi1', 'Mavillaz1', 'remi1-mavillaz1', NULL, 'banner_ebb4f3de567224de995808d41926f4ce.jpeg'),
(32, 'jean.michel@gmail.fr', 'jean.michel@gmail.fr', 'jean.michel@gmail.fr', 'jean.michel@gmail.fr', 1, 'k0zfwkweleoksoog0w4kksow8sokw4s', 'tsL3Y00YMGQyFBxOqTcs1xkrlD+7jBhqIiM9NLchIffOVvFYp24NkUWs3+MjCR5ds5v/9FNxEfH8cv0ZLvlo9g==', '2016-06-22 14:30:08', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 0, NULL, '29 Avenue des néons', 'Strasbourg', 'France', 'Isere', NULL, '2016-06-22 14:28:34', '2016-06-22 14:39:33', 'Darkounet', 'Jean michel', 'Jarre', 'jean-michel-jarre', '2015-11-11', NULL),
(33, 'OlivierChalifour@teleworm.us', 'olivierchalifour@teleworm.us', 'OlivierChalifour@teleworm.us', 'olivierchalifour@teleworm.us', 1, 'szam79cm674k08c0skw4kwk4000g4cw', 'RXTlGNGDnU91h5X67sQZn7A8aFz9fTsYcAaLpHp3zL3QSMibYKTqxG0hMC7VzpZ7C1CPsD3zeCzAAr2N2GBGjA==', '2016-06-22 14:42:13', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 0, NULL, '79, rue Gustave Eiffel', 'REZÉ', 'France', 'Yvelines', NULL, '2016-06-22 14:41:24', '2016-06-22 14:44:04', 'Thadox', 'Olivier', 'Chalifour', 'olivier-chalifour', '1938-05-07', NULL),
(34, 'DorotheeBlanchard@teleworm.us', 'dorotheeblanchard@teleworm.us', 'DorotheeBlanchard@teleworm.us', 'dorotheeblanchard@teleworm.us', 1, 'ew2uj6y799ko0o8sgcoscgs0s448wo8', 'hE5b9YGChkVdpHq+Y+dApJTZctq5PoHnFArLMsNz2BZs4Vu+nljb0SdtTGXS0wwN3zD12vRC04SmJ+b3Y6n93g==', '2016-06-22 14:53:42', 0, 0, NULL, 'ByNmpwLiVf0DJldoECAl5EKVmF_ivqbX5S7PXmA1W-U', NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 0, NULL, '69, Rue Joseph Vernet', 'Baie Mahault', 'France', 'Normandie', NULL, '2016-06-22 14:44:42', '2016-06-22 14:55:58', 'Whoul1982', 'Dorothée ', 'Blanchard', 'dorothee-blanchard', '1982-11-07', NULL),
(35, 'JacquesRiquier@dayrep.com', 'jacquesriquier@dayrep.com', 'JacquesRiquier@dayrep.com', 'jacquesriquier@dayrep.com', 1, '6hlcvi1ke288ogso0k8wg0gs8wgcoos', 'h5mMOQrOMoiB62H81nSiUS/XCZT4Hc1FUrjcBDp4nxn+ORODZBFKdgCJxY9ZxJ2RiEVySsUQYZ3Qjmrd7OOKZg==', '2016-06-22 15:09:28', 0, 0, NULL, 'h50AEtsAwbWBtpVPoOMOnJ6DlFz7E8F0yargYbEzjAM', NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 0, NULL, '84, Rue de la Pompe', 'Marignane', 'France', 'Pays de loire', NULL, '2016-06-22 15:00:02', '2016-06-22 15:11:15', 'Prowenties', 'Jacques ', 'Riquier', 'jacques-riquier', '1964-03-09', NULL),
(36, 'DorenePouchard@rhyta.com', 'dorenepouchard@rhyta.com', 'DorenePouchard@rhyta.com', 'dorenepouchard@rhyta.com', 1, 'g3b62hodxy8kkkwo4o0swkkcwow4c00', 'GUuylVJdK0ICk8Tfrk3jgI5OVXoB5B419NZfw7T0pfL+pBKvs7S+Ek/wCBFzxdFOxuF9FPiA87einA/ZvDqfPw==', '2016-06-22 15:15:34', 0, 0, NULL, 'CBO51b6r73aaC1wSEXGuealR7Psbz2SQsZhTBPqG8fQ', NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 0, NULL, '10, Rue Roussy', 'Olivet', 'France', 'Languedoc', NULL, '2016-06-22 15:12:20', '2016-06-22 15:16:04', 'Sked1944', 'Dorene ', 'Pouchard', 'dorene-pouchard', '1944-01-18', NULL),
(37, 'AngelettePaiement@dayrep.com', 'angelettepaiement@dayrep.com', 'AngelettePaiement@dayrep.com', 'angelettepaiement@dayrep.com', 1, 'neyn4zktoaowgsgs0800owc8owgwo4k', 'AKprLmg92jNHuadydxXADgBZT09wpZzci6GdOLftaZi0FnzZaS8zGJIeFGI1LNAirF2sSAPig+IR5gOta2jpWg==', '2016-06-22 15:45:22', 0, 0, NULL, 'uT1Pl1zRH0ORKCuY5GclXl3WIT77BIKKkWZu4b2GVVs', NULL, 'a:1:{i:0;s:9:"ROLE_USER";}', 0, NULL, '24, boulevard d''Alsace', 'Velizy Villacoublay', 'France', 'Centre', NULL, '2016-06-22 15:19:22', '2016-06-22 15:48:05', 'Goided', 'Angelette', 'Paiement', 'angelette-paiement', '1982-12-23', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_7D3656A492FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_7D3656A4A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_7D3656A4989D9B62` (`slug`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;