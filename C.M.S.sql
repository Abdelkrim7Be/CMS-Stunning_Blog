-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 11 mai 2024 à 15:08
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cms4.2.1`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `aname` varchar(30) NOT NULL,
  `aheadline` varchar(30) NOT NULL,
  `abio` varchar(500) NOT NULL,
  `aimage` varchar(60) NOT NULL DEFAULT 'avatar.jpg',
  `added_by` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `datetime`, `username`, `password`, `aname`, `aheadline`, `abio`, `aimage`, `added_by`) VALUES
(1, 'March-25-2023 18:19:58', 'Abdelkrim_BL', '1234', 'Abdelkrim Bel', 'Technicien', 'Professionel', 'android2.jpg', 'Zerox7412'),
(2, 'March-25-2023 18:27:54', 'Zineb_752', 'Tr0ub4dor&3', 'Zineb Be', '', '', '', 'Zerox7412'),
(4, 'March-26-2023 12:01:03', 'Hamid_752', 'R@inB0wB1t3', 'Marouane Hamdani', '', '', '', 'Jad452'),
(5, 'March-26-2023 13:26:18', 'Zero_7412', 'Tr0ub4dor&3', 'Zeriach Ackrami', '', '', '', 'Hanan452'),
(6, 'March-29-2023 15:33:29', 'Jad_452', '5tud3nt$M@th', 'Jad Belha', '', '', 'avatar.jpg', 'Abdelkrim123'),
(7, 'March-29-2023 17:05:26', 'Soufiane', 'G0Ld3nG@t3$', 'Soufiane ELbk', '', '', 'avatar.jpg', 'Abdelkrim123');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `title`, `author`, `datetime`) VALUES
(1, 'Technologie', 'Soufiane', 'March-22-2023 17:58:05'),
(2, 'Sport', 'Soufiane', 'March-22-2023 18:02:05'),
(3, 'Politics', 'Soufiane', 'March-23-2023 14:36:41'),
(4, 'News', 'Soufiane', 'March-24-2023 15:15:26'),
(6, 'Loto', 'Hanan_452', 'March-26-2023 13:16:57'),
(7, 'Gambling', 'Abdelkrim_123', 'March-26-2023 17:28:26'),
(8, 'Watering', 'Abdelkrim_123', 'April-17-2023 13:44:46');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approvedby` varchar(50) NOT NULL,
  `status` varchar(3) NOT NULL,
  `post_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `datetime`, `name`, `email`, `comment`, `approvedby`, `status`, `post_id`) VALUES
(6, 'March-25-2023 15:23:20', 'hicham', 'hichammessrar@gmail.com', 'hello, SQL is an SGBDR', 'Abdelkrim Bellagnech', 'ON', 19),
(7, 'March-25-2023 15:23:49', 'Ibtissam', 'ibti78@gmail.com', 'Hello, SQL helped me a lot during my CMS project', 'Abdelkrim Bellagnech', 'ON', 19),
(8, 'March-25-2023 15:24:08', 'Aya', 'aya99@gmail.com', 'I hate it a lot', 'Abdelkrim Bellagnech', 'ON', 19),
(12, 'March-25-2023 15:25:56', 'Simo', 'simo@gmail.com', 'im simo, and javascript is the best programming language out there\r\n', 'Pending', 'OFF', 13);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `title` varchar(300) NOT NULL,
  `category` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `post` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `datetime`, `title`, `category`, `author`, `image`, `post`) VALUES
(12, 'March-24-2023 14:58:21', 'Post 3 : PHP Back-End pg. language.', 'Technologie', 'Soufiane', 'php2.png', 'Karim vxgcvd Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere omnis molestias earum voluptate nam? Rem iure fugit ducimus, dolores animi corporis sequi ab, culpa totam quas eveniet repudiandae nostrum pariatur, voluptates quis error dolor ad neque minima deleniti placeat ex inventore ratione eum. Nihil sequi tempora ab consequatur facilis. Tempore illo fugiat officia, accusantium voluptatum aut corrupti sed modi amet qui atque, voluptatibus eveniet voluptate, reprehenderit inventore ad itaque dolorem aperiam obcaecati veniam ex perspiciatis. Eaque omnis ea cum possimus?'),
(13, 'March-24-2023 14:58:55', 'Post 4 : JAVASCRIPT Vanilla', 'Sport', 'Soufiane', 'javascript.png', 'Testing : Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas doloremque alias inventore quod quae repellat non unde asperiores fugit nesciunt dolorum, cupiditate corporis ducimus animi, esse corrupti sunt nisi error molestiae perspiciatis velit? Animi corrupti cupiditate fugiat rerum mollitia ipsa impedit repellendus minima corporis eos reiciendis labore, alias magni provident, blanditiis aperiam quam fuga sapiente cum! Corrupti facilis quod assumenda officia soluta reiciendis quo aliquam odio eveniet, doloribus, ducimus incidunt modi repellat delectus nesciunt nihil molestiae atque veritatis natus iure animi eum. Praesentium ea eaque omnis deserunt rem! Molestiae inventore minima dolorum quaerat earum fuga?'),
(15, 'March-24-2023 15:00:02', 'Post 6 : C', 'Sport', 'Soufiane', 'C.png', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum optio ex fuga dolor quae vitae reiciendis iste sed quod quos iure quisquam dolorem facere officia, distinctio aperiam maiores esse quis, asperiores tempore repudiandae quam. Sapiente praesentium alias hic, earum tenetur iure doloribus tempore molestias nulla, velit porro animi corrupti, itaque sint. Dolorem eligendi explicabo quod. Mollitia harum saepe repellendus eveniet!'),
(17, 'March-24-2023 15:01:19', 'Post 8 : java', 'Technologie', 'Soufiane', 'java.png', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Totam illo porro consectetur? Tempora ut cupiditate vitae hic aspernatur? Culpa laudantium laboriosam laborum inventore modi voluptatibus commodi explicabo veniam quisquam maiores quia consequatur aspernatur quam provident at id molestiae odio, deserunt minima omnis dolorem. Ipsa enim tenetur quis neque assumenda natus maiores in quaerat. In blanditiis et alias molestias consequuntur eos optio quae fugiat eaque ullam harum vitae iste adipisci, enim voluptate, assumenda nulla necessitatibus aspernatur. Dolor temporibus dicta est vitae ipsum doloremque sapiente expedita, blanditiis harum, cumque itaque maiores nobis facere et! Dolor pariatur dolore sapiente ad cupiditate. Necessitatibus, magni?'),
(18, 'March-24-2023 15:01:55', 'Post 9 : GO', 'Politics', 'Soufiane', 'go.png', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda excepturi accusantium eius quidem facere mollitia hic rem voluptatibus, optio adipisci incidunt voluptate vero quam soluta, itaque deleniti totam placeat possimus?'),
(19, 'March-24-2023 15:03:46', 'Post 10 : SQL', 'Sport', 'Soufiane', 'sql.png', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam impedit adipisci ad rem eum laborum pariatur nobis sequi nulla fugiat, beatae quibusdam amet debitis accusamus? Cum placeat molestiae praesentium dolores sint accusantium, pariatur itaque ut quaerat id possimus, illo culpa, reprehenderit optio nulla ducimus dolorum architecto inventore! Minima velit perspiciatis earum unde id quis sequi, sed eveniet illo provident reprehenderit veniam assumenda voluptatibus ea voluptatum! Repellat explicabo earum possimus quod!'),
(20, 'March-24-2023 15:04:18', 'Post 11 : Swift', 'Technologie', 'Soufiane', 'swift.jpeg', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sequi non rem quo expedita obcaecati sit explicabo necessitatibus earum tempora, nam ipsam fugiat et est beatae magni facilis ullam enim dolor. At, sunt omnis impedit inventore facilis perferendis veniam? Odio velit fuga quaerat reiciendis nihil culpa perferendis autem ipsa. Amet corporis unde nam commodi nisi odit aut consequuntur quia reiciendis inventore, deleniti quod asperiores necessitatibus accusantium officia suscipit! Sint accusamus labore, in unde modi eveniet ea aut quam voluptate, ullam maiores blanditiis rem dignissimos corrupti aliquam.');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
