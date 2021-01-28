-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 28 jan. 2021 à 12:41
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sondage`
--

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0000_00_00_000000_create_websockets_statistics_entries_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2020_11_05_114755_create_questions_table', 1),
(6, '2020_11_05_115302_create_reponses_table', 1),
(7, '2021_01_06_100345_create_user_answers_table', 1),
(8, '2021_01_06_111502_create_answer_reps_table', 1),
(9, '2021_01_06_132515_creat_reponse_user_answer_table', 2),
(10, '2021_01_06_152110_creat_reponse_user_answer_table', 3);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Qst` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `situation` tinyint(1) NOT NULL DEFAULT 0,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `countdown` time DEFAULT NULL,
  `QstVote` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id`, `Qst`, `situation`, `type`, `time`, `countdown`, `QstVote`, `created_at`, `updated_at`) VALUES
(1, 'halooosannn', 0, 'uniq', 'Tue Jan 19 2021 14:52:09 GMT+0100 (UTC+01:00)', '00:00:50', 0, '2021-01-06 10:50:57', '2021-01-21 09:31:10'),
(2, 'how mallls', 1, 'uniq', 'Thu Jan 21 2021 11:46:58 GMT+0100 (UTC+01:00)', '00:00:55', 2, '2021-01-06 10:52:23', '2021-01-21 09:46:54'),
(3, 'your name', 0, 'multi', NULL, NULL, 5, '2021-01-06 10:53:15', '2021-01-21 09:44:49'),
(4, 'haloo world', 0, 'multi', 'Thu Jan 21 2021 11:38:34 GMT+0100 (UTC+01:00)', '00:00:55', 4, '2021-01-07 10:06:11', '2021-01-21 09:39:37'),
(5, 'haloo my test', 0, 'uniq', NULL, NULL, 3, '2021-01-20 08:21:31', '2021-01-21 09:37:32');

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

CREATE TABLE `reponses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rps` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vote` int(11) DEFAULT NULL,
  `vrai` tinyint(1) DEFAULT 0,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reponses`
--

INSERT INTO `reponses` (`id`, `rps`, `vote`, `vrai`, `question_id`, `created_at`, `updated_at`) VALUES
(4, 'testanser', 1, 0, 2, NULL, '2021-01-21 09:46:29'),
(5, 'test 2', 1, 1, 2, NULL, '2021-01-21 09:47:00'),
(9, 'test22', 1, 0, 3, NULL, '2021-01-21 09:44:11'),
(10, 'test23', 3, 1, 3, NULL, '2021-01-21 09:44:11'),
(11, 'tetsla', 1, NULL, 3, NULL, '2021-01-21 09:42:08'),
(12, 'test99', 0, 1, 1, NULL, '2021-01-21 09:31:14'),
(13, 'test19', 0, NULL, 1, NULL, '2021-01-21 09:31:14'),
(14, 'haloo1', 0, 0, 4, NULL, '2021-01-21 09:37:33'),
(15, 'haloo2', 2, 1, 4, NULL, '2021-01-21 09:38:18'),
(16, 'haloo3', 1, NULL, 4, NULL, '2021-01-21 09:38:18'),
(17, 'haloo4', 1, 1, 4, NULL, '2021-01-21 09:37:59'),
(18, 'test3355', 0, 0, 5, NULL, '2021-01-21 09:32:18'),
(19, 'test8899', 1, NULL, 5, NULL, '2021-01-21 09:34:12'),
(20, 'test8555', 2, 1, 5, NULL, '2021-01-21 09:35:11');

-- --------------------------------------------------------

--
-- Structure de la table `reponse_user_answer`
--

CREATE TABLE `reponse_user_answer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_answer_id` bigint(20) UNSIGNED NOT NULL,
  `reponse_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reponse_user_answer`
--

INSERT INTO `reponse_user_answer` (`id`, `user_answer_id`, `reponse_id`, `created_at`, `updated_at`) VALUES
(22, 39, 12, NULL, NULL),
(23, 40, 12, NULL, NULL),
(24, 41, 13, NULL, NULL),
(25, 42, 12, NULL, NULL),
(26, 43, 9, NULL, NULL),
(27, 43, 10, NULL, NULL),
(28, 44, 10, NULL, NULL),
(29, 45, 17, NULL, NULL),
(30, 45, 15, NULL, NULL),
(31, 46, 4, NULL, NULL),
(32, 47, 5, NULL, NULL),
(33, 48, 10, NULL, NULL),
(34, 49, 11, NULL, NULL),
(35, 49, 10, NULL, NULL),
(36, 50, 10, NULL, NULL),
(37, 52, 11, NULL, NULL),
(38, 53, 10, NULL, NULL),
(39, 54, 9, NULL, NULL),
(40, 55, 4, NULL, NULL),
(41, 56, 5, NULL, NULL),
(42, 57, 4, NULL, NULL),
(43, 58, 5, NULL, NULL),
(44, 59, 4, NULL, NULL),
(45, 60, 5, NULL, NULL),
(46, 61, 5, NULL, NULL),
(47, 62, 13, NULL, NULL),
(48, 63, 16, NULL, NULL),
(49, 63, 15, NULL, NULL),
(50, 64, 14, NULL, NULL),
(51, 64, 17, NULL, NULL),
(52, 64, 16, NULL, NULL),
(53, 65, 17, NULL, NULL),
(54, 65, 15, NULL, NULL),
(55, 66, 10, NULL, NULL),
(56, 66, 9, NULL, NULL),
(57, 67, 9, NULL, NULL),
(58, 68, 10, NULL, NULL),
(59, 69, 20, NULL, NULL),
(60, 70, 19, NULL, NULL),
(61, 71, 20, NULL, NULL),
(62, 72, 15, NULL, NULL),
(63, 72, 17, NULL, NULL),
(64, 73, 16, NULL, NULL),
(65, 73, 15, NULL, NULL),
(66, 74, 10, NULL, NULL),
(67, 75, 11, NULL, NULL),
(68, 75, 10, NULL, NULL),
(69, 76, 9, NULL, NULL),
(70, 76, 10, NULL, NULL),
(71, 77, 4, NULL, NULL),
(72, 78, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vote_stats` int(11) DEFAULT NULL,
  `admin_key` tinyint(1) NOT NULL DEFAULT 0,
  `voted` tinyint(1) NOT NULL DEFAULT 0,
  `watchresult` tinyint(1) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `vote_stats`, `admin_key`, `voted`, `watchresult`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'abou saad', 'saad_niko@hotmail.com', NULL, '$2y$10$EY5CbpGEi1Niu73BuZpNJuffddqnjPD/wkVi/ibqr5U1eIt7OqhGK', NULL, 0, 1, 1, NULL, '2021-01-06 10:43:31', '2021-01-21 09:48:46'),
(2, 'hamza', 'hamza_test@hotmail.com', NULL, '$2y$10$RimIsix.Cdorfpe0GxgqmeitJen/r4PWC8YCC3Mhoz.qs1ClvoVsy', NULL, 0, 1, 1, NULL, '2021-01-07 14:00:08', '2021-01-21 09:48:46'),
(3, 'youness', 'youness_test@gmail.com', NULL, '$2y$10$YfB3rm.80zgFGzb3NlifQO7l2A0SHLHpLyTbQCj6D.YVUKVfiQGre', NULL, 0, 1, 1, NULL, '2021-01-07 14:09:04', '2021-01-21 09:48:46'),
(4, 'saad_admin@gmail.com', 'saad_admin@gmail.com', NULL, '$2y$10$aInRdv/R22pzRC6AqxW9D.CaCcLOF7JF5dlwTJg7S1jCoPgi26J9i', NULL, 1, 1, 1, NULL, '2021-01-11 09:50:11', '2021-01-21 09:48:46'),
(5, 'ahmed', 'ahme-test@gmail.com', NULL, '$2y$10$6Gi4w9zqvdyqAaCAGTcaqeT..6F0iNN1pKQzDY9DhKZPD6S.lNcoq', NULL, 0, 1, NULL, NULL, '2021-01-21 12:48:33', '2021-01-21 12:48:41');

-- --------------------------------------------------------

--
-- Structure de la table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `answer` tinyint(1) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_answers`
--

INSERT INTO `user_answers` (`id`, `created_at`, `updated_at`, `answer`, `user_id`, `question_id`) VALUES
(69, '2021-01-21 09:32:58', '2021-01-21 09:32:58', 1, 3, 5),
(70, '2021-01-21 09:34:13', '2021-01-21 09:34:13', 0, 2, 5),
(71, '2021-01-21 09:35:13', '2021-01-21 09:35:13', 1, 1, 5),
(72, '2021-01-21 09:38:00', '2021-01-21 09:38:00', 1, 1, 4),
(73, '2021-01-21 09:38:20', '2021-01-21 09:38:20', 0, 2, 4),
(74, '2021-01-21 09:41:25', '2021-01-21 09:41:25', 1, 1, 3),
(75, '2021-01-21 09:42:09', '2021-01-21 09:42:09', 0, 2, 3),
(76, '2021-01-21 09:44:12', '2021-01-21 09:44:12', 0, 3, 3),
(77, '2021-01-21 09:46:32', '2021-01-21 09:46:32', 0, 3, 2),
(78, '2021-01-21 09:47:06', '2021-01-21 09:47:06', 1, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reponses_question_id_foreign` (`question_id`);

--
-- Index pour la table `reponse_user_answer`
--
ALTER TABLE `reponse_user_answer`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `reponses`
--
ALTER TABLE `reponses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `reponse_user_answer`
--
ALTER TABLE `reponse_user_answer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT pour la table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD CONSTRAINT `reponses_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
