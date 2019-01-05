-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2018 at 10:16 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `larsgallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,0) NOT NULL,
  `special` tinyint(1) DEFAULT '0',
  `sale_off` int(3) DEFAULT '0',
  `picture` text,
  `created` date DEFAULT '0000-00-00',
  `created_by` varchar(255) DEFAULT NULL,
  `modified` date DEFAULT '0000-00-00',
  `modified_by` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `name`, `description`, `price`, `special`, `sale_off`, `picture`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `category_id`) VALUES
(12, 'UnrealScript Game Programming Cookbook', 'Designed for high-level game programming, UnrealScript is used in tandem with the Unreal Engine to provide a scripting language that is ideal for creating your very own unique gameplay experience. By learning how to replicate some of the advanced techniques used in today\'s modern games, you too can take your game to the next level and stand out from the crowd.\r\n\r\nBy providing a series of engaging and practical recipes, this \"UnrealScript Game Programming Cookbook\" will show you how to leverage the advanced functionality within UDK. You\'ll be shown how to implement a wide variety of practical features using the high-level scripting language ranging from designing your own HUD, creating your very own custom tailored weapons, to generating pathfinding solutions, and even meticulously crafting your own AI.', '25000', 0, 20, '46fQT.jpg', '2013-12-12', 'admin', '2018-11-12', 'admin', 1, 3, 4),
(13, 'Functional Programming in Scala', 'Functional programming (FP) is a programming style emphasizing functions that return consistent and predictable results regardless of a program\'s state. As a result, functional code is easier to test and reuse, simpler to parallelize, and less prone to bugs. Scala is an emerging JVM language that offers strong support for FP. Its familiar syntax and transparent interoperability with existing Java libraries make Scala a great place to start learning FP.\r\n\r\nFunctional Programming in Scala is a serious tutorial for programmers looking to learn FP and apply it to the everyday business of coding. The book guides readers from basic techniques to advanced topics in a logical, concise, and clear progression. In it, you\'ll find concrete examples and exercises that open up the world of functional programming.', '35000', 0, 3, 'gydxH.jpg', '2013-12-12', 'admin', '2018-11-12', 'admin', 1, 1, 3),
(14, 'iOS 7 Programming Fundamentals', 'If you\'re getting started with iOS development, or want a firmer grasp of the basics, this practical guide provides a clear view of its fundamental building blocks—Objective-C, Xcode, and Cocoa Touch. You\'ll learn object-oriented concepts, understand how to use Apple\'s development tools, and discover how Cocoa provides the underlying functionality iOS apps need to have. Dozens of example projects are available at GitHub.\r\n\r\nOnce you master the fundamentals, you\'ll be ready to tackle the details of iOS app development with author Matt Neuburg\'s companion guide.', '45000', 0, 0, 'UXh8E.jpg', '2013-12-12', 'admin', '2018-11-12', 'admin', 1, 2, 2),
(15, 'iOS 7 Programming Cookbook', 'Overcome the vexing issues you\'re likely to face when creating apps for the iPhone, iPad, or iPod touch. With new and thoroughly revised recipes in this updated cookbook, you\'ll quickly learn the steps necessary to work with the iOS 7 SDK, including solutions for bringing real-world physics and movement to your apps with UIKit Dynamics APIs.\r\n\r\nYou\'ll learn hundreds of techniques for storing and protecting data, sending and receiving notifications, enhancing and animating graphics, managing files and folders, and many other options. Each recipe includes sample code you can use right away.', '44000', 0, 0, 'RpOso.jpg', '2013-12-12', 'admin', '2018-11-12', 'admin', 1, 3, 3),
(16, 'Advanced Programming in the UNIX Environment, 3rd Edition', 'For more than twenty years, serious C programmers have relied on one book for practical, in-depth knowledge of the programming interfaces that drive the UNIX and Linux kernels: W. Richard Stevens\' Advanced Programming in the UNIX Environment. Now, once again, Rich\'s colleague Steve Rago has thoroughly updated this classic work. The new third edition supports today\'s leading platforms, reflects new technical advances and best practices, and aligns with Version 4 of the Single UNIX Specification.\r\n\r\nSteve carefully retains the spirit and approach that have made this book so valuable. Building on Rich\'s pioneering work, he begins with files, directories, and processes, carefully laying the groundwork for more advanced techniques, such as signal handling and terminal I/O. He also thoroughly covers threads and multithreaded programming, and socket-based IPC.', '36000', 1, 2, 'h3KWN.jpg', '2013-12-12', 'admin', '2018-11-12', 'admin', 1, 3, 3),
(17, 'jMonkeyEngine 3.0 Beginner', 'jMonkeyEngine 3.0 is a powerful set of free Java libraries that allows you to unlock your imagination, create 3D games and stunning graphics. Using jMonkeyEngine\'s library of time-tested methods, this book will allow you to unlock its potential and make the creation of beautiful interactive 3D environments a breeze.\r\n\r\njMonkeyEngine 3.0 Beginner\'s Guide teaches aspiring game developers how to build modern 3D games with Java. This primer on 3D programming is packed with best practices, tips and tricks and loads of example code. Progressing from elementary concepts to advanced effects, budding game developers will have their first game up and running by the end of this book.', '36000', 0, 12, 'zqEde.jpg', '2013-12-12', 'admin', '2018-11-12', 'admin', 1, 3, 2),
(18, 'Scala Cookbook', 'Save time and trouble when using Scala to build object-oriented, functional, and concurrent applications. With more than 250 ready-to-use recipes and 700 code examples, this comprehensive cookbook covers the most common problems you\'ll encounter when using the Scala language, libraries, and tools. It\'s ideal not only for experienced Scala developers, but also for programmers learning to use this JVM language.\r\n\r\nAuthor Alvin Alexander (creator of DevDaily.com) provides solutions based on his experience using Scala for highly scalable, component-based applications that support concurrency and distribution.', '46000', 0, 0, 'Pwzyk.png', '2013-12-12', 'admin', '2018-11-12', 'admin', 1, 10, 4),
(19, 'PostgreSQL Server Programming', 'Learn how to work with PostgreSQL as if you spent the last decade working on it. PostgreSQL is capable of providing you with all of the options that you have in your favourite development language and then extending that right on to the database server. With this knowledge in hand, you will be able to respond to the current demand for advanced PostgreSQL skills in a lucrative and booming market.\r\n\r\nPostgreSQL Server Programming will show you that PostgreSQL is so much more than a database server. In fact, it could even be seen as an application development framework, with the added bonuses of transaction support, massive data storage, journaling, recovery and a host of other features that the PostgreSQL engine provides.', '54000', 0, 5, 'NGQbE.jpg', '2013-12-12', 'admin', '2018-11-12', 'admin', 1, 3, 2),
(20, 'Programming Drupal 7 Entities', 'Writing code for manipulating Drupal data has never been easier! Learn to dice and serve your data as you slowly peel back the layers of the Drupal entity onion. Next, expose your legacy local and remote data to take full advantage of Drupal\'s vast solution space.\r\n\r\nProgramming Drupal 7 Entities is a practical, hands-on guide that provides you with a thorough knowledge of Drupal\'s entity paradigm and a number of clear step-by-step exercises, which will help you take advantage of the real power that is available when developing using entities.', '58000', 0, 4, 'msLo1.jpg', '2013-12-12', 'admin', '2018-11-12', 'admin', 1, 3, 2),
(21, 'Moving from C to C++', 'The author says it best, I hope to move you, a little at a time,from understanding C to the point where C++ becomes your mindset. This remarkable book is designed to streamline the process of learning C++ in a way that discusses programming problems, why they exist, and the approach C++ has taken to solve such problems.\r\n\r\nYou can\'t just look at C++ as a collection of features; some of the features make no sense in isolation. You can only use the sum of the parts if you are thinking about design, not simply coding. To understand C++, you must understand the problems with C and with programming in general. This book discusses programming problems, why they are problems, and the approach C++ has taken to solve such problems. Thus, the set of features that I explain in each chapter will be based on the way that I see a particular type of problem being solved in C++.', '36000', 0, 3, 'mb0TH.jpg', '2013-12-12', 'admin', '2018-11-12', 'admin', 1, 3, 2),
(23, 'Advanced Network Programming - Principles and Techniques', 'The field of network programming is so large, and developing so rapidly, that it can appear almost overwhelming to those new to the discipline.\r\n\r\nAnswering the need for an accessible overview of the field, this text/reference presents a manageable introduction to both the theoretical and practical aspects of computer networks and network programming. Clearly structured and easy to follow, the book describes cutting-edge developments in network architectures, communication protocols, and programming techniques and models, supported by code examples for hands-on practice with creating network-based applications.', '43000', 1, 20, 'iP1p8.jpg', '2013-12-12', 'admin', '2018-11-15', 'admin', 1, 2, 3),
(30, 'Lars', 'ggggg', '200000', 0, 0, 'ahfGR.jpg', '2018-11-11', 'admin', '2018-11-15', 'admin', 1, 1, 1),
(31, 'Sách Konosuba', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. At natus tempore, ullam voluptate explicabo officiis deserunt minima blanditiis quidem voluptates dolore, nesciunt doloremque debitis, eos ducimus maiores cupiditate! Optio tempora consequatur enim, officia dolore corporis fugit asperiores. Rem, unde, deserunt? Id temporibus necessitatibus aut veniam deserunt! Sequi facere a, velit quidem ducimus dolor autem atque dicta voluptatum tempora dolorum, laudantium voluptates quam ullam error quod magnam amet doloribus ipsa pariatur quae assumenda? Ad molestias vel rerum voluptatem nobis quia, itaque, earum minima, veniam totam temporibus ab cupiditate quae distinctio quidem provident. Eos dolore eum sed placeat, similique dicta numquam eaque!', '200000', 0, 0, 'gNOb8.jpg', '2018-11-11', 'admin', '2018-11-15', 'admin', 1, 10, 8),
(32, 'Programing Logics', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus sapiente, fugiat, deserunt quod libero qui omnis doloremque. Sed vitae iure, quam nam autem ipsum amet dignissimos atque. Harum facere cum alias veritatis nemo. Tempore, animi odit eveniet amet, minus tenetur maiores natus magnam, molestias nobis eum soluta, nihil excepturi aut accusantium. Repellat, reiciendis. Facilis earum numquam amet eaque hic ipsa eveniet, quod quo incidunt ex eligendi deleniti fugit dolor dignissimos veniam ipsam culpa, provident aut eum natus fugiat doloremque vitae distinctio aliquam! Obcaecati mollitia porro accusamus illo voluptatum. Doloremque, id qui consectetur quia! Adipisci cumque, veniam praesentium non cum quo?', '200000', 1, 50, '0d5U2.jpg', '2018-11-12', 'admin', '2018-11-15', 'admin', 1, 2, 4),
(34, 'C Programming for Arduino', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus sapiente, fugiat, deserunt quod libero qui omnis doloremque. Sed vitae iure, quam nam autem ipsum amet dignissimos atque. Harum facere cum alias veritatis nemo. Tempore, animi odit eveniet amet, minus tenetur maiores natus magnam, molestias nobis eum soluta, nihil excepturi aut accusantium. Repellat, reiciendis. Facilis earum numquam amet eaque hic ipsa eveniet, quod quo incidunt ex eligendi deleniti fugit dolor dignissimos veniam ipsam culpa, provident aut eum natus fugiat doloremque vitae distinctio aliquam! Obcaecati mollitia porro accusamus illo voluptatum. Doloremque, id qui consectetur quia! Adipisci cumque, veniam praesentium non cum quo?', '200000', 0, 0, 'ieWpg.jpg', '2018-11-12', 'admin', '2018-11-15', 'admin', 1, 10, 3),
(35, 'My Youth Romantic Comedy Is Wrong, As I Expected', 'My Youth Romantic Comedy Is Wrong, As I Expected (Japanese: やはり俺の青春ラブコメはまちがっている。 Hepburn: Yahari Ore no Seishun Rabukome wa Machigatteiru.), abbreviated as OreGairu (俺ガイル) and Hamachi (はまち),[2] and also known as My Teen Romantic Comedy SNAFU, is a Japanese light novel series written by Wataru Watari and illustrated by Ponkan8 about a socially awkward boy who is forced by his teacher to join the school\'s service club, working with two girls who have their own, personal issues to offer help and advice to others while dealing with their inner conflicts.', '135000', 1, 0, 'QvY4F.jpg', '2018-11-16', 'admin', '2018-11-16', 'admin', 1, 1, 18),
(36, 'Gintama', 'Gin Tama (Japanese: 銀魂 Hepburn: Gin Tama, \"Silver Soul\") is a Japanese manga written and illustrated by Hideaki Sorachi and serialized, beginning on December 8, 2003, in Shueisha\'s Weekly Shōnen Jump. Set in Edo which has been conquered by aliens named Amanto, the plot follows life from the point of view of samurai Gintoki Sakata, who works as a freelancer alongside his friends Shinpachi Shimura and Kagura in order to pay the monthly rent. Sorachi added the science fiction setting to develop characters to his liking after his editor suggested doing a historical series.', '150000', 1, 3, 'ThPob.jpg', '2018-11-16', 'admin', '2018-11-16', 'admin', 1, 1, 18),
(38, 'Beelzebub', 'Beelzebub (Japanese: べるぜバブ Hepburn: Beruzebabu) is a Japanese manga series about a first year student at a school for juvenile delinquents, written and illustrated by Ryūhei Tamura. Beelzebub was first published in 2008 as a one-shot by Tamura in issue 37-38 of Weekly Shōnen Jump, subsequently winning the fourth Gold Future Cup.[3] The manga was then serialized in the same magazine, from its 13th issue in 2009 to its 13th issue in 2014, then in Shōnen Jump Next!! as Beelzebub Another (べるぜバブ 番外編 Beruzebabu Bangai Hen), from its 2nd issue in 2014 to its 1st issue in 2015.[4]', '200000', 1, 0, 'B8u17.jpg', '2018-11-16', 'admin', '2018-11-16', 'admin', 1, 1, 18),
(39, 'Sword Art Online', 'Sword Art Online (Japanese: ソードアート・オンライン Hepburn: Sōdo Āto Onrain) is a Japanese light novel series written by Reki Kawahara and illustrated by abec. The series takes place in the near future and focuses on protagonist Kazuto \"Kirito\" Kirigaya and Asuna Yuuki as they play through various virtual reality MMORPG worlds. The light novels began publication on ASCII Media Works\' Dengeki Bunko imprint from April 10, 2009, with a spin-off series launching in October 2012. The series has spawned eight manga adaptations published by ASCII Media Works and Kadokawa. The novels and four of the manga adaptations have been licensed for release in North America by Yen Press', '175000', 1, 30, 'K0MRs.jpg', '2018-11-16', 'admin', '0000-00-00', NULL, 1, 1, 18),
(40, 'Rezero - Starting Life in Another World', 'Re:Zero − Starting Life in Another World (Japanese: Re：ゼロから始める異世界生活 Hepburn: Ri:Zero kara Hajimeru Isekai Seikatsu, lit. \"Re: Starting life in a different world from zero\") is a Japanese light novel series written by Tappei Nagatsuki and illustrated by Shinichirou Otsuka. The story centers on Subaru Natsuki, a hikikomori who suddenly finds himself transported to another world on his way home from the convenience store. The series was initially serialized on the website Shōsetsuka ni Narō from 2012 onwards. Seventeen volumes have been published by Media Factory since January 24, 2014, under their MF Bunko J imprint.', '200000', 1, 14, 'Kzc49.png', '2018-11-16', 'admin', '2018-11-16', 'admin', 1, 1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` varchar(45) NOT NULL,
  `username` varchar(255) NOT NULL,
  `books` text NOT NULL,
  `prices` text NOT NULL,
  `quantities` text NOT NULL,
  `names` text NOT NULL,
  `pictures` text NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `username`, `books`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`) VALUES
('1mA9h1542120669', 'admin', '[\"14\"]', '[\"45000\"]', '[\"2\"]', '[\"iOS 7 Programming Fundamentals\"]', '[\"UXh8E.jpg\"]', 1, '2018-11-13 15:51:09'),
('bLdyI1542117451', 'admin', '[\"12\",\"16\",\"32\"]', '[\"20000\",\"35280\",\"100000\"]', '[\"4\",\"1\",\"5\"]', '[\"UnrealScript Game Programming Cookbook\",\"Advanced Programming in the UNIX Environment, 3rd Edition\",\"Programing Logics\"]', '[\"46fQT.jpg\",\"h3KWN.jpg\",\"0d5U2.jpg\"]', 1, '2018-11-13 14:57:31'),
('BnSWm1542985542', 'admin', '[\"16\"]', '[\"35280\"]', '[\"3\"]', '[\"Advanced Programming in the UNIX Environment, 3rd Edition\"]', '[\"h3KWN.jpg\"]', 1, '2018-11-23 16:05:42'),
('cAr541542355382', 'admin', '[\"14\",\"19\"]', '[\"45000\",\"51300\"]', '[\"3\",\"3\"]', '[\"iOS 7 Programming Fundamentals\",\"PostgreSQL Server Programming\"]', '[\"UXh8E.jpg\",\"NGQbE.jpg\"]', 1, '2018-11-16 09:03:02'),
('eaEuo1542986179', 'admin', '[\"40\"]', '[\"43000\"]', '[\"2\"]', '[\"Rezero - Starting Life in Another World\"]', '[\"Kzc49.png\"]', 1, '2018-11-23 16:16:19'),
('HpPbE1542985274', 'admin', '[\"40\"]', '[\"57333.333333333\"]', '[\"4\"]', '[\"Rezero - Starting Life in Another World\"]', '[\"Kzc49.png\"]', 1, '2018-11-23 16:01:14'),
('JbMv41542257816', 'admin', '[\"12\"]', '[\"20000\"]', '[\"2\"]', '[\"UnrealScript Game Programming Cookbook\"]', '[\"46fQT.jpg\"]', 0, '2018-11-15 05:56:56'),
('MFE8u1542983627', 'admin', '[\"16\",\"35\",\"36\"]', '[\"35280\",\"45000\",\"145500\"]', '[\"2\",\"4\",\"2\"]', '[\"Advanced Programming in the UNIX Environment, 3rd Edition\",\"My Youth Romantic Comedy Is Wrong, As I Expected\",\"Gintama\"]', '[\"h3KWN.jpg\",\"QvY4F.jpg\",\"ThPob.jpg\"]', 1, '2018-11-23 15:33:47'),
('Mi7YC1542185612', 'admin', '[\"12\",\"16\",\"32\"]', '[\"20000\",\"35280\",\"100000\"]', '[\"3\",\"3\",\"6\"]', '[\"UnrealScript Game Programming Cookbook\",\"Advanced Programming in the UNIX Environment, 3rd Edition\",\"Programing Logics\"]', '[\"46fQT.jpg\",\"h3KWN.jpg\",\"0d5U2.jpg\"]', 1, '2018-11-14 09:53:32'),
('nNqLt1542117597', 'admin', '[\"12\",\"14\",\"16\",\"17\",\"21\",\"32\"]', '[\"20000\",\"45000\",\"35280\",\"31680\",\"34920\",\"100000\"]', '[\"3\",\"3\",\"2\",\"5\",\"3\",\"4\"]', '[\"UnrealScript Game Programming Cookbook\",\"iOS 7 Programming Fundamentals\",\"Advanced Programming in the UNIX Environment, 3rd Edition\",\"jMonkeyEngine 3.0 Beginner\",\"Moving from C to C++\",\"Programing Logics\"]', '[\"46fQT.jpg\",\"UXh8E.jpg\",\"h3KWN.jpg\",\"zqEde.jpg\",\"mb0TH.jpg\",\"0d5U2.jpg\"]', 1, '2018-11-13 14:59:57'),
('o2UJr1542258643', 'admin', '[\"12\",\"17\"]', '[\"20000\",\"31680\"]', '[\"1\",\"2\"]', '[\"UnrealScript Game Programming Cookbook\",\"jMonkeyEngine 3.0 Beginner\"]', '[\"46fQT.jpg\",\"zqEde.jpg\"]', 1, '2018-11-15 06:10:43'),
('O9Acf1542985488', 'admin', '[\"35\"]', '[\"33750\"]', '[\"5\"]', '[\"My Youth Romantic Comedy Is Wrong, As I Expected\"]', '[\"QvY4F.jpg\"]', 1, '2018-11-23 16:04:48'),
('OzEuR1542984258', 'admin', '[\"38\"]', '[\"66666.666666667\"]', '[\"3\"]', '[\"Beelzebub\"]', '[\"B8u17.jpg\"]', 1, '2018-11-23 15:44:18'),
('p3mSl1542984793', 'admin', '[\"16\",\"32\",\"39\",\"40\"]', '[\"7056\",\"11111.111111111\",\"30625\",\"43000\"]', '[\"3\",\"9\",\"2\",\"1\"]', '[\"Advanced Programming in the UNIX Environment, 3rd Edition\",\"Programing Logics\",\"Sword Art Online\",\"Rezero - Starting Life in Another World\"]', '[\"h3KWN.jpg\",\"0d5U2.jpg\",\"K0MRs.jpg\",\"Kzc49.png\"]', 1, '2018-11-23 15:53:13'),
('rsQCn1542985525', 'admin', '[\"12\"]', '[\"20000\"]', '[\"3\"]', '[\"UnrealScript Game Programming Cookbook\"]', '[\"46fQT.jpg\"]', 1, '2018-11-23 16:05:25'),
('VJmMu1542258692', 'admin', '[\"32\"]', '[\"100000\"]', '[\"20\"]', '[\"Programing Logics\"]', '[\"0d5U2.jpg\"]', 1, '2018-11-15 06:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` text,
  `created` date DEFAULT '0000-00-00',
  `created_by` varchar(255) DEFAULT NULL,
  `modified` date DEFAULT '0000-00-00',
  `modified_by` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `category_descript` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `picture`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `category_descript`) VALUES
(1, 'Văn Học - Tiểu Thuyết', '9L7jd.jpg', '2013-12-09', 'admin', '2018-11-16', 'admin', 0, 3, NULL),
(2, 'Kinh Tế', NULL, '2013-12-09', 'admin', '2018-11-16', 'admin', 0, 4, NULL),
(3, 'Tin học', 'zhpNF.png', '2013-12-09', 'admin', '2018-11-16', 'admin', 1, 1, NULL),
(4, ' Kỹ Năng Sống', 'Y3Sjw.jpg', '2013-12-09', 'admin', '2018-11-16', 'admin', 1, 1, NULL),
(5, 'Thiếu Nhi', 'EQfJD.png', '2013-12-09', 'admin', '2018-11-16', 'admin', 1, 10, NULL),
(6, ' Thường Thức - Đời Sống', 'mISau.png', '2013-12-09', 'admin', '2018-11-16', 'admin', 1, 2, NULL),
(7, 'Ngoại Ngữ - Từ Điển', 'ohk92.jpg', '2013-12-09', 'admin', '2018-11-16', 'admin', 1, 5, NULL),
(8, 'Truyện Tranh', 'Wbohg.jpg', '2013-12-09', 'admin', '2018-11-16', 'admin', 1, 1, NULL),
(9, ' Văn Hoá - Nghệ Thuật - Du Lịch', 'btkjrfal.jpg', '2013-12-06', 'admin', '2018-11-16', 'admin', 1, 10, NULL),
(17, 'Adult', 'zuDCS.jpg', '2018-11-15', 'admin', '2018-11-16', 'admin', 1, 1, NULL),
(18, 'Manga-LN', 'WZiSa.jpg', '2018-11-16', 'admin', '2018-11-24', 'admin', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_acp` tinyint(1) DEFAULT '0',
  `created` date DEFAULT '0000-00-00',
  `created_by` varchar(50) DEFAULT NULL,
  `modified` date DEFAULT '0000-00-00',
  `modified_by` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `group_descript` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `group_acp`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `group_descript`) VALUES
(1, 'Admin', 1, '0000-00-00', NULL, '2018-11-04', '10', 0, 8, '  '),
(2, 'Manager', 1, '2013-11-07', NULL, '2018-11-14', 'admin', 1, 5, NULL),
(3, 'Fouder', 1, '2018-12-18', 'admin', '0000-00-00', NULL, 1, 1, ' Another fouder to testing'),
(4, 'Manager2', 0, '2018-12-18', 'admin', '0000-00-00', NULL, 0, 3, ' Another  Manager to testing'),
(6, 'ADMIN LARS', 0, '2018-12-18', 'admin', '0000-00-00', NULL, 1, 1, ' No descript'),
(7, 'Blue', 1, '2018-12-18', 'admin', '0000-00-00', NULL, 1, 5, ' No descript '),
(8, 'Blue1', 0, '2018-12-18', 'admin', '0000-00-00', NULL, 1, 1, ' No descript  '),
(9, 'Blue2', 0, '2018-12-18', 'admin', '0000-00-00', NULL, 0, 1, ' No descript   '),
(10, 'Founder', 1, '2018-12-19', 'admin', '0000-00-00', NULL, 1, 1, ' '),
(11, 'Founder1', 0, '2018-12-19', 'admin', '0000-00-00', NULL, 0, 1, '  '),
(12, 'Founder2', 0, '2018-12-19', 'admin', '0000-00-00', NULL, 0, 5, '   '),
(13, 'Founder3', 0, '2018-12-19', 'admin', '0000-00-00', NULL, 0, 3, '    '),
(14, 'Founder4', 0, '2018-12-19', 'admin', '0000-00-00', NULL, 0, 3, '     '),
(15, 'Founder5', 0, '2018-12-19', 'admin', '0000-00-00', NULL, 0, 3, '      '),
(16, 'CEO', 1, '2018-12-19', 'admin', '0000-00-00', NULL, 1, 1, '       '),
(17, 'CEO1', 0, '2018-12-19', 'admin', '0000-00-00', NULL, 0, 1, '        '),
(18, 'CEO2', 0, '2018-12-19', 'admin', '0000-00-00', NULL, 0, 1, '         '),
(19, 'CEO3', 0, '2018-12-19', 'admin', '0000-00-00', NULL, 0, 1, '          '),
(20, 'CEO4', 0, '2018-12-19', 'admin', '0000-00-00', NULL, 0, 1, '           '),
(21, 'CEO5', 0, '2018-12-19', 'admin', '0000-00-00', NULL, 0, 1, 'CEO 5'),
(22, 'script', 0, '2018-12-19', 'admin', '0000-00-00', NULL, 0, 2, '<script>console.log(\"The sql injection\")</script>');

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE `privilege` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `module` varchar(45) NOT NULL,
  `controller` varchar(45) NOT NULL,
  `action` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `name`, `module`, `controller`, `action`) VALUES
(1, 'Hiển thị danh sách người dùng', 'admin', 'user', 'index'),
(2, 'Thay đổi status của người dùng', 'admin', 'user', 'status'),
(3, 'Cập nhật thông tin của người dùng', 'admin', 'user', 'form'),
(4, 'Thay đổi status của người dùng sử dụng Ajax', 'admin', 'user', 'ajaxStatus'),
(5, 'Xóa một hoặc nhiều người dùng', 'admin', 'user', 'trash'),
(6, 'Thay đổi vị trí hiển thị của các người dùng', 'admin', 'user', 'ordering'),
(7, 'Truy cập menu Admin Control Panel', 'admin', 'index', 'index'),
(8, 'Đăng nhập Admin Control Panel', 'admin', 'index', 'login'),
(9, 'Đăng xuất Admin Control Panel', 'admin', 'index', 'logout'),
(10, 'Cập nhật thông tin tài khoản quản trị', 'admin', 'index', 'profile');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created` date DEFAULT '0000-00-00',
  `created_by` int(11) DEFAULT NULL,
  `modified` date DEFAULT '0000-00-00',
  `modified_by` int(11) DEFAULT NULL,
  `register_date` datetime DEFAULT NULL,
  `register_ip` varchar(25) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `group_id` int(11) NOT NULL,
  `user_descript` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `fullname`, `password`, `created`, `created_by`, `modified`, `modified_by`, `register_date`, `register_ip`, `status`, `ordering`, `group_id`, `user_descript`) VALUES
(1, 'nvan', 'nvan@gmail.com', 'Nguyễn Văn An', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, NULL, NULL, 0, 1, 1, NULL),
(2, 'nvb', 'nvb@gmail.com', 'Nguyễn Văn B', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, NULL, NULL, 0, 1, 2, NULL),
(3, 'nvc', 'nvc@gmail.com', 'Nguyễn Văn C', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '0000-00-00', NULL, NULL, NULL, 1, 5, 3, NULL),
(4, 'admin', 'admin@gmail.com', 'Admin', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', 1, '2018-11-10', 0, NULL, NULL, 1, 5, 1, NULL),
(13, 'lars', 'danghuunghia2712@gmail.com', 'Linzcc', 'ed55db1bbc93c1840aa59a9b3a1d71a3', '2018-11-05', 1, '2018-11-06', 10, NULL, NULL, 1, 5, 2, NULL),
(19, 'Mio', 'lars2739@gmail.com', 'Mio_lars', 'ed55db1bbc93c1840aa59a9b3a1d71a3', '0000-00-00', NULL, '2018-11-10', 0, '2018-11-08 16:39:35', '::1', 0, 10, 3, NULL),
(20, 'Linz123', 'danghuunghia22712@gmail.com', 'Đặng Hữu Nghĩa', '', '2018-12-20', 0, '0000-00-00', NULL, NULL, '::1', 1, 1, 1, '<script type=\"text/javascript\">alert(1)</script>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
