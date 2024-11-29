-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 24 nov. 2024 à 01:45
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `demotpthree`
--

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

CREATE TABLE `auteur` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`id`, `nom`, `prenom`) VALUES
(3, 'Austen', 'Jane'),
(4, 'Shakespeare', 'William'),
(5, 'Tolkien', 'J.R.R.'),
(6, 'Dickens', 'Charles'),
(7, 'Rowling', 'J.K.'),
(8, 'Fitzgerald', 'F. Scott'),
(9, 'Poe', 'Edgar Allan'),
(10, 'Hawking', 'Stephen'),
(106, 'Evan', 'Winter'),
(107, 'naruto', 'uzumaki');

-- --------------------------------------------------------

--
-- Structure de la table `auteur_livre`
--

CREATE TABLE `auteur_livre` (
  `auteur_id` int(11) NOT NULL,
  `livre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `auteur_livre`
--

INSERT INTO `auteur_livre` (`auteur_id`, `livre_id`) VALUES
(5, 105),
(6, 106),
(6, 108),
(7, 107),
(8, 105),
(8, 108),
(9, 107),
(10, 106),
(106, 106),
(107, 103),
(107, 104);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `designation`, `description`) VALUES
(4, 'Non-Fiction', 'Based on facts'),
(5, 'Biography', 'Real life stories'),
(6, 'History', 'Past events records'),
(7, 'Philosophy', 'Existence and knowledge'),
(8, 'Mystery', 'Crime and secrets'),
(9, 'Romance', 'Love and relationships'),
(10, 'Self-Help', 'Personal growth guides'),
(101, 'Manga', 'most talented'),
(102, 'History', 'Moon Dance'),
(103, 'Science Fiction', 'act of cooking');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241107122603', '2024-11-07 13:26:09', 333),
('DoctrineMigrations\\Version20241108141159', '2024-11-08 15:12:28', 110),
('DoctrineMigrations\\Version20241108142728', '2024-11-08 15:27:37', 10),
('DoctrineMigrations\\Version20241123123013', '2024-11-23 13:30:49', 85);

-- --------------------------------------------------------

--
-- Structure de la table `editeur`
--

CREATE TABLE `editeur` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `editeur`
--

INSERT INTO `editeur` (`id`, `nom`, `adresse`) VALUES
(4, 'Hachette Livre', '58 Rue Jean-Baptiste Pigalle, Paris, France'),
(5, 'Macmillan', '120 Broadway, New York, NY'),
(6, 'Oxford University Press', 'Great Clarendon Street, Oxford, UK'),
(7, 'Bloomsbury', '50 Bedford Square, London, UK'),
(8, 'Scholastic', '557 Broadway, New York, NY'),
(9, 'Penguin Books', '80 Strand, London, UK'),
(10, 'Wiley', '111 River Street, Hoboken, NJ'),
(101, 'Mahdi', 'Sousse'),
(102, 'Wassim', 'Bouzid');

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `id` int(11) NOT NULL,
  `editeur_id` int(11) DEFAULT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `titre` varchar(50) NOT NULL,
  `nbrpage` int(11) NOT NULL,
  `date_edition` date NOT NULL,
  `nbrexemplaire` int(11) DEFAULT NULL,
  `prix` double NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`id`, `editeur_id`, `categories_id`, `titre`, `nbrpage`, `date_edition`, `nbrexemplaire`, `prix`, `image`, `updated_at`) VALUES
(103, 102, 101, 'The Rage of Dragons', 120, '2024-11-20', 109, 299, 'best-books1-1732406226.jpg', NULL),
(104, 101, 103, 'Dark Space', 200, '2024-11-29', 10, 960, 'best-selling7-1732406299.jpg', NULL),
(105, 8, 5, 'Verry Nice', 966, '2016-02-04', 15, 126, 'best-selling2-1732407341.jpg', NULL),
(106, 7, 9, 'Evanesce', 302, '2024-11-04', 500, 122, 'best-selling3-1732407415.jpg', NULL),
(107, 8, 7, 'Queen Bee', 150, '2024-11-06', 142, 59, 'best-selling4-1732407475.jpg', NULL),
(108, 6, 8, 'Sin Eater', 522, '2024-10-30', 153, 23, 'best-selling5-1732407538.jpg', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `livre_auteur`
--

CREATE TABLE `livre_auteur` (
  `livre_id` int(11) NOT NULL,
  `auteur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livre_auteur`
--

INSERT INTO `livre_auteur` (`livre_id`, `auteur_id`) VALUES
(103, 107),
(104, 107),
(105, 5),
(105, 8),
(106, 6),
(106, 10),
(106, 106),
(107, 7),
(107, 9),
(108, 6),
(108, 8);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ouvrier`
--

CREATE TABLE `ouvrier` (
  `id` int(11) NOT NULL,
  `matricule` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`) VALUES
(1, 'whamdi617@gmail.com', '[]', '$2y$13$F6HYEpfbGwGjAQj0bNKt1uhuWI.L4neQfQdb.xt4Ah7Tm8u1RNDxK', 0),
(2, 'soumaw2@gmail.com', '[]', '$2y$13$k3OMIShFwf2yJO20a5baXe6oxQKfb9XQE75gJLSB7u6RBSMilyanu', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `auteur_livre`
--
ALTER TABLE `auteur_livre`
  ADD PRIMARY KEY (`auteur_id`,`livre_id`),
  ADD KEY `IDX_A6DFA5E060BB6FE6` (`auteur_id`),
  ADD KEY `IDX_A6DFA5E037D925CB` (`livre_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `editeur`
--
ALTER TABLE `editeur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AC634F993375BD21` (`editeur_id`),
  ADD KEY `IDX_AC634F99A21214B7` (`categories_id`);

--
-- Index pour la table `livre_auteur`
--
ALTER TABLE `livre_auteur`
  ADD PRIMARY KEY (`livre_id`,`auteur_id`),
  ADD KEY `IDX_A11876B537D925CB` (`livre_id`),
  ADD KEY `IDX_A11876B560BB6FE6` (`auteur_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `ouvrier`
--
ALTER TABLE `ouvrier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT pour la table `editeur`
--
ALTER TABLE `editeur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT pour la table `livre`
--
ALTER TABLE `livre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ouvrier`
--
ALTER TABLE `ouvrier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `auteur_livre`
--
ALTER TABLE `auteur_livre`
  ADD CONSTRAINT `FK_A6DFA5E037D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A6DFA5E060BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `auteur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `FK_AC634F993375BD21` FOREIGN KEY (`editeur_id`) REFERENCES `editeur` (`id`),
  ADD CONSTRAINT `FK_AC634F99A21214B7` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `livre_auteur`
--
ALTER TABLE `livre_auteur`
  ADD CONSTRAINT `FK_A11876B537D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A11876B560BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `auteur` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
