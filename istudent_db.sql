-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2020 at 04:21 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `istudent_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllDegrees` (IN `inst_id` INT(11))  BEGIN
 select * 
 from degree 
 where institute_id=inst_id;
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllJobs` (IN `comp_id` INT(11))  BEGIN
select * 
from job 
where company_id=comp_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetContactList` (IN `login_user` INT(11))  BEGIN
 SELECT * 
 FROM user
 JOIN contact
 ON contact_id = id
 WHERE user_id = login_user;
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetMsgList` (IN `from_id` INT(11), IN `login_user` INT(11))  BEGIN
 SELECT * 
 FROM chat
 WHERE (sent_from = from_id and sent_to = login_user) or (sent_from = login_user and sent_to = from_id);
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Login` (IN `email` TEXT, IN `passwd` VARCHAR(32))  BEGIN
 SELECT * 
 FROM user
 WHERE email_id = email and password = passwd;
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `msg_counter` (IN `id` INT(11))  BEGIN
 SELECT * 
 FROM chat
 WHERE sent_to = id;
 END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(10) UNSIGNED NOT NULL,
  `sent_to` int(11) NOT NULL,
  `sent_from` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `sent_to`, `sent_from`, `message`, `sent_date`) VALUES
(1, 4, 1, 'Hello Mohsin', '2020-03-16 20:26:25'),
(2, 1, 4, 'Hiii Tauseef', '2020-03-16 20:27:07'),
(3, 4, 1, 'hiii mohsin', '2020-03-18 19:57:03'),
(4, 5, 1, 'hii Aamir', '2020-03-20 19:42:12');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`user_id`, `contact_id`) VALUES
(1, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE `degree` (
  `degree_id` int(11) NOT NULL,
  `degree_name` varchar(50) NOT NULL,
  `institute_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`degree_id`, `degree_name`, `institute_id`) VALUES
(1, 'Information Technology', 2),
(2, 'Computer Engineering', 2),
(3, 'Civil Engineering', 2),
(5, 'Mechanical Engineering', 2);

-- --------------------------------------------------------

--
-- Table structure for table `has_degree`
--

CREATE TABLE `has_degree` (
  `student_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `from_year` int(11) NOT NULL,
  `to_year` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `has_degree`
--

INSERT INTO `has_degree` (`student_id`, `degree_id`, `verified`, `from_year`, `to_year`, `institute_id`) VALUES
(1, 1, 0, 2018, 2021, 2);

-- --------------------------------------------------------

--
-- Table structure for table `has_document`
--

CREATE TABLE `has_document` (
  `student_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `doc_name` varchar(30) NOT NULL,
  `file` text NOT NULL,
  `size` varchar(255) NOT NULL,
  `verification_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `has_document`
--

INSERT INTO `has_document` (`student_id`, `doc_id`, `doc_name`, `file`, `size`, `verification_status`) VALUES
(1, 1, 'PaaS GAE', 'docs/5e722c1de5facexp-8-paas-googleappeng.pdf', '1474803', 'approved'),
(1, 2, 'Mohsin Resume', 'docs/5e722ef597482ResumeMohsin.pdf', '113433', 'pending'),
(1, 3, 'Hamza Resume', 'docs/5e722f67a933cResumeHamza.pdf', '486204', 'pending'),
(5, 4, 'CC EXP 8', 'docs/5e74a66175174Experiment8CC.pdf', '1603776', 'pending'),
(5, 5, 'CC EXP 8 DOC', 'docs/5e74a77a8fee8CorbettDeer_EN-IN2110502954_1366x768.jpg', '616695', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `has_interest`
--

CREATE TABLE `has_interest` (
  `student_id` int(11) NOT NULL,
  `interest` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `has_interest`
--

INSERT INTO `has_interest` (`student_id`, `interest`) VALUES
(1, 'Solving Rubik Cube'),
(1, 'Playing Football'),
(1, 'Reading Books');

-- --------------------------------------------------------

--
-- Table structure for table `has_job`
--

CREATE TABLE `has_job` (
  `student_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `has_job`
--

INSERT INTO `has_job` (`student_id`, `job_id`) VALUES
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `has_skill`
--

CREATE TABLE `has_skill` (
  `student_id` int(11) NOT NULL,
  `skill` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `has_skill`
--

INSERT INTO `has_skill` (`student_id`, `skill`) VALUES
(1, 'Artificial Intelligence'),
(1, 'Machine Learning'),
(1, 'Java Programming'),
(1, 'Python Programming'),
(1, 'Neural Network');

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `job_id` int(11) NOT NULL,
  `job_title` varchar(50) NOT NULL,
  `location` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `salary` int(11) NOT NULL,
  `job_type` varchar(20) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`job_id`, `job_title`, `location`, `description`, `salary`, `job_type`, `company_id`) VALUES
(1, 'Software Developer', 'Mumbai', 'Developer', 50000, 'Full Time', 3),
(3, 'Software Designer', 'China', 'Designer', 20000, 'Part Time', 3),
(4, 'Marketing Head', 'Bangalore', 'Marketing', 80000, 'Part Time', 3),
(5, 'Software Engineer', 'Ahemedabaad', 'Development of Software', 60000, 'Full Time', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `email_id` text NOT NULL,
  `password` varchar(32) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `user_type` enum('student','institute','company') NOT NULL,
  `img_url` varchar(255) NOT NULL DEFAULT 'images/dp.png'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `user_name`, `email_id`, `password`, `contact_no`, `user_type`, `img_url`) VALUES
(1, 'Tauseef Ansari', 'tauseefansari', 'tauseeftanvir@gmail.com', 'tauseef123', '9321391048', 'student', 'profile/5e75f250b09612018-01-27-09-03-17-545.jpg'),
(2, 'M H Saboo Siddik', 'mhsscoe', 'mhsscoe@gmail.com', 'mhsscoe', '', 'institute', 'profile/5e7858ebf2efdandrroid.jpg'),
(3, 'Capegemini', 'capegemini', 'capegemini@gmail.com', 'capegemini', '9876543210', 'company', 'profile/5e785b4920192java.png'),
(4, 'Mohsin', 'mohsinessani', 'mohsinessani@gmail.com', 'mohsin123', '9967867833', 'student', 'images/dp.png'),
(5, 'Aamir', 'aamir', 'aamirthekiya@gmail.com', 'aamir123', '', 'student', 'profile/5e75f2952bc82aamir.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sent_to` (`sent_to`),
  ADD KEY `sent_from` (`sent_from`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `contact_id` (`contact_id`);

--
-- Indexes for table `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`degree_id`),
  ADD KEY `institute_id` (`institute_id`);

--
-- Indexes for table `has_degree`
--
ALTER TABLE `has_degree`
  ADD KEY `has_degree_ibfk_1` (`student_id`),
  ADD KEY `has_degree_ibfk_2` (`institute_id`),
  ADD KEY `has_degree_ibfk_3` (`degree_id`);

--
-- Indexes for table `has_document`
--
ALTER TABLE `has_document`
  ADD UNIQUE KEY `doc_id` (`doc_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `has_interest`
--
ALTER TABLE `has_interest`
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `has_job`
--
ALTER TABLE `has_job`
  ADD KEY `student_id` (`student_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `has_skill`
--
ALTER TABLE `has_skill`
  ADD KEY `has_skill_ibfk_1` (`student_id`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `degree`
--
ALTER TABLE `degree`
  MODIFY `degree_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `has_document`
--
ALTER TABLE `has_document`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`sent_to`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`sent_from`) REFERENCES `user` (`id`);

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contact_ibfk_2` FOREIGN KEY (`contact_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `degree`
--
ALTER TABLE `degree`
  ADD CONSTRAINT `degree_ibfk_1` FOREIGN KEY (`institute_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `has_degree`
--
ALTER TABLE `has_degree`
  ADD CONSTRAINT `has_degree_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `has_degree_ibfk_2` FOREIGN KEY (`institute_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `has_document`
--
ALTER TABLE `has_document`
  ADD CONSTRAINT `has_document_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `has_interest`
--
ALTER TABLE `has_interest`
  ADD CONSTRAINT `has_interest_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `has_job`
--
ALTER TABLE `has_job`
  ADD CONSTRAINT `has_job_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `has_job_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `job` (`job_id`);

--
-- Constraints for table `has_skill`
--
ALTER TABLE `has_skill`
  ADD CONSTRAINT `has_skill_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `job_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
