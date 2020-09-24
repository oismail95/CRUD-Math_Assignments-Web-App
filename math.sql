-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2020 at 03:40 AM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `math`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE IF NOT EXISTS `assignments` (
`assignment_num` int(10) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `due_date` date NOT NULL,
  `course_num` varchar(20) NOT NULL,
  `section` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_num`, `title`, `due_date`, `course_num`, `section`) VALUES
(1, 'Series', '2019-03-07', 'MATH 1900', 1),
(2, 'Integrals', '2018-11-20', 'MATH 1900', 1),
(3, 'Limit', '2018-07-02', 'MATH 1800', 1),
(4, 'Trigonometry Exercise 1', '2018-07-02', 'MATH 1035', 1);

-- --------------------------------------------------------

--
-- Table structure for table `belongs`
--

CREATE TABLE IF NOT EXISTS `belongs` (
`belong_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `assignment_num` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `belongs`
--

INSERT INTO `belongs` (`belong_id`, `question_id`, `assignment_num`) VALUES
(1, 1, 1),
(2, 3, 1),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `math_questions`
--

CREATE TABLE IF NOT EXISTS `math_questions` (
`question_id` int(10) unsigned NOT NULL,
  `problem` varchar(30) NOT NULL,
  `answer` varchar(30) NOT NULL,
  `points` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `math_questions`
--

INSERT INTO `math_questions` (`question_id`, `problem`, `answer`, `points`) VALUES
(1, 'y = 2 + 3', 'y = 5', 5),
(2, 'x = 3 * 3', 'x = 9', 5),
(3, 'y = 9 / 3', 'y = 3', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
 ADD PRIMARY KEY (`assignment_num`), ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `belongs`
--
ALTER TABLE `belongs`
 ADD PRIMARY KEY (`belong_id`), ADD KEY `question_id` (`question_id`), ADD KEY `assignment_num` (`assignment_num`);

--
-- Indexes for table `math_questions`
--
ALTER TABLE `math_questions`
 ADD PRIMARY KEY (`question_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
MODIFY `assignment_num` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `belongs`
--
ALTER TABLE `belongs`
MODIFY `belong_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `math_questions`
--
ALTER TABLE `math_questions`
MODIFY `question_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `belongs`
--
ALTER TABLE `belongs`
ADD CONSTRAINT `belongs_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `math_questions` (`question_id`),
ADD CONSTRAINT `belongs_ibfk_2` FOREIGN KEY (`assignment_num`) REFERENCES `assignments` (`assignment_num`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
