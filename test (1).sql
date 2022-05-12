-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2022 at 09:29 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `op_id` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `question_number` int(11) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `coption` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`op_id`, `paper_id`, `question_number`, `is_correct`, `coption`) VALUES
(76, 1, 1, 0, 'amal'),
(77, 1, 1, 1, 'kaml'),
(78, 1, 1, 0, 'nimal'),
(79, 1, 1, 0, 'imal'),
(80, 1, 2, 1, 'cat'),
(81, 1, 2, 0, 'dog'),
(82, 1, 2, 0, 'Rabbit'),
(83, 1, 2, 0, 'parrot'),
(84, 2, 1, 0, 'Red'),
(85, 2, 1, 0, 'Black'),
(86, 2, 1, 0, 'White'),
(87, 2, 1, 1, 'Green'),
(88, 1, 3, 0, 'Teacher'),
(89, 1, 3, 1, 'Doctor'),
(90, 1, 3, 0, 'Driver'),
(91, 1, 3, 0, 'Famer'),
(96, 5, 1, 0, 'eeee'),
(97, 5, 1, 1, 'rrrr'),
(98, 5, 1, 0, 'yyyy'),
(99, 5, 1, 0, 'kkkk');

-- --------------------------------------------------------

--
-- Table structure for table `paper`
--

CREATE TABLE `paper` (
  `paper_id` int(11) NOT NULL,
  `paper_name` text NOT NULL,
  `last_update` text NOT NULL,
  `exam_duration` int(11) NOT NULL,
  `status` text NOT NULL DEFAULT 'Draft'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paper`
--

INSERT INTO `paper` (`paper_id`, `paper_name`, `last_update`, `exam_duration`, `status`) VALUES
(1, 'Mid Exam', '2022-04-23,22:37', 30, 'published'),
(2, 'End Exam', '', 0, 'Draft'),
(5, 'Fainal Exam', '2022-05-12/11:35', 30, 'published');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `paper_id` int(11) NOT NULL,
  `question_number` int(11) NOT NULL,
  `question_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`paper_id`, `question_number`, `question_name`) VALUES
(1, 1, 'what is your name?'),
(2, 1, 'What is your favorite colour ?'),
(5, 1, 'what is your name?'),
(1, 2, 'what is your pet name?'),
(1, 3, 'What is your job role?');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `id` int(225) NOT NULL,
  `stud_id` int(45) NOT NULL COMMENT 'user id from test1 table',
  `exm_id` int(44) NOT NULL,
  `q_id` int(45) NOT NULL,
  `answer` int(45) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`id`, `stud_id`, `exm_id`, `q_id`, `answer`, `status`) VALUES
(37, 1, 1, 1, 76, 0),
(38, 1, 1, 2, 80, 1),
(39, 1, 1, 3, 89, 1);

-- --------------------------------------------------------

--
-- Table structure for table `test1`
--

CREATE TABLE `test1` (
  `id` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(10) NOT NULL,
  `designation` varchar(10) NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test1`
--

INSERT INTO `test1` (`id`, `email`, `password`, `designation`) VALUES
(1, 'abcd@gmail.com', '1234', 'student'),
(2, 'pqr@gmail.com', '1234', 'teacher'),
(4, 'lmn@gmail.com', '1212', 'student'),
(7, 'lmn@gmail.com', '2323', 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`op_id`),
  ADD KEY `paper_question_option` (`paper_id`),
  ADD KEY `question_option` (`question_number`);

--
-- Indexes for table `paper`
--
ALTER TABLE `paper`
  ADD PRIMARY KEY (`paper_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_number`,`paper_id`) USING BTREE,
  ADD KEY `paper_question` (`paper_id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test1`
--
ALTER TABLE `test1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `paper`
--
ALTER TABLE `paper`
  MODIFY `paper_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `test1`
--
ALTER TABLE `test1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `paper_question_option` FOREIGN KEY (`paper_id`) REFERENCES `paper` (`paper_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `question_option` FOREIGN KEY (`question_number`) REFERENCES `questions` (`question_number`) ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `paper_question` FOREIGN KEY (`paper_id`) REFERENCES `paper` (`paper_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
