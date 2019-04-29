-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 08, 2019 at 03:35 AM
-- Server version: 5.7.24-log
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialnetwork`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `ID` int(11) NOT NULL,
  `BUSINESS_EMAIL` varchar(45) DEFAULT NULL,
  `PHONE` varchar(45) DEFAULT NULL,
  `ABOUT` varchar(100) DEFAULT NULL,
  `STREET` varchar(45) DEFAULT NULL,
  `CITY` varchar(45) DEFAULT NULL,
  `STATE` varchar(45) DEFAULT NULL,
  `ZIPCODE` int(11) DEFAULT NULL,
  `USERS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`ID`, `BUSINESS_EMAIL`, `PHONE`, `ABOUT`, `STREET`, `CITY`, `STATE`, `ZIPCODE`, `USERS_ID`) VALUES
(6, 'emily.quevedo77@gmail.com', '2015608544', 'fghvgbnm', '1668 S 174th Lane', 'Scotts', 'California', 85338, 1),
(7, 'emily.quevedo77@gmail.com', '2015608544', 'afssdsdfdsfsdfsdf', '1668 S 174th Lane', 'Scotts', 'California', 85338, 7);

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `ID` int(11) NOT NULL,
  `DEGREE` varchar(45) DEFAULT NULL,
  `SCHOOL` varchar(45) DEFAULT NULL,
  `CITY` varchar(45) DEFAULT NULL,
  `STATE` varchar(45) DEFAULT NULL,
  `GRADUATION` date DEFAULT NULL,
  `USERS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`ID`, `DEGREE`, `SCHOOL`, `CITY`, `STATE`, `GRADUATION`, `USERS_ID`) VALUES
(2, 'Associate Degree', 'MCCC', 'Avondale', 'Arizona', '2019-03-01', 1),
(3, 'Bachelor of Science in Computer Programming', 'Harvard', 'Cambridge', 'Massachusetts', '2019-03-01', 1),
(7, 'Bachelor of Arts In Graphics', 'Grand Canyon University', 'Phoenix', 'Arizona', '2019-03-18', 1),
(8, 'asfdgf', 'asdfs', 'asfdgd', 'asfdg', '2019-04-03', 7);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(45) DEFAULT NULL,
  `DESCRIPTION` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`ID`, `NAME`, `DESCRIPTION`) VALUES
(5, 'Web Developers1', 'web developers group1'),
(7, 'Web Devs', 'Web devs only'),
(12, 'Web Developers', 'vfuyuigguigiuyniimj'),
(14, 'Laravel 2', 'sfdgh');

-- --------------------------------------------------------

--
-- Table structure for table `job_history`
--

CREATE TABLE `job_history` (
  `ID` int(11) NOT NULL,
  `PREVJOB` varchar(45) DEFAULT NULL,
  `PREVJOBDESC` varchar(45) DEFAULT NULL,
  `STARTDATE` date DEFAULT NULL,
  `ENDDATE` date DEFAULT NULL,
  `COMPANY` varchar(45) DEFAULT NULL,
  `CITY` varchar(45) DEFAULT NULL,
  `STATE` varchar(45) DEFAULT NULL,
  `USERS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `job_history`
--

INSERT INTO `job_history` (`ID`, `PREVJOB`, `PREVJOBDESC`, `STARTDATE`, `ENDDATE`, `COMPANY`, `CITY`, `STATE`, `USERS_ID`) VALUES
(1, 'Web Developer', 'Costume', '2019-03-06', '2019-03-06', 'hgfgh', 'Fresno', 'California', 1),
(2, 'asdsfsgdfgdfg', 'dfgdfgdfgfdgdfg', '2019-04-03', '2019-04-03', 'dgdfgdfgfdg', 'dfgdfgdfgdfgdf', 'dfgfgddfgfdgd', 7);

-- --------------------------------------------------------

--
-- Table structure for table `job_posting`
--

CREATE TABLE `job_posting` (
  `ID` int(11) NOT NULL,
  `JOBTITLE` varchar(45) DEFAULT NULL,
  `POSITION` varchar(45) DEFAULT NULL,
  `DESCRIPTION` varchar(45) DEFAULT NULL,
  `EMPLOYER` varchar(45) DEFAULT NULL,
  `CITY` varchar(45) DEFAULT NULL,
  `STATE` varchar(45) DEFAULT NULL,
  `DATE` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `job_posting`
--

INSERT INTO `job_posting` (`ID`, `JOBTITLE`, `POSITION`, `DESCRIPTION`, `EMPLOYER`, `CITY`, `STATE`, `DATE`) VALUES
(7, 'Web Developer', 'Entry-Level', 'Looking for Programmer', 'Google', 'San Francisco', 'California', '2019-03-01'),
(8, 'Europe 2017!', 'fegr', 'ergre', 'rgregge', 'ergegerg', 'ergergergerg', '2019-03-14'),
(9, 'Backend Programmer', 'Intern', 'summer internship', 'Google', 'San Francisco', 'California', '2019-03-15'),
(10, 'random', 'random', 'random2', 'random', 'random', 'random', '2019-03-17');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `ID` int(11) NOT NULL,
  `SKILL` varchar(45) DEFAULT NULL,
  `USERS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`ID`, `SKILL`, `USERS_ID`) VALUES
(3, 'C#', 1),
(4, 'PHP', 1),
(5, 'Painting and Drawing', 1),
(6, 'Java, PHP, C#', 1),
(7, 'dfgdfgdfg', 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `FIRSTNAME` varchar(45) DEFAULT NULL,
  `LASTNAME` varchar(45) DEFAULT NULL,
  `EMAIL` varchar(45) DEFAULT NULL,
  `USERNAME` varchar(45) DEFAULT NULL,
  `PASSWORD` varchar(45) DEFAULT NULL,
  `ROLE` tinyint(4) NOT NULL,
  `ACTIVE` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `USERNAME`, `PASSWORD`, `ROLE`, `ACTIVE`) VALUES
(1, 'Emily', 'Quevedo', 'emily@email.com', 'EmilyQ', 'password', 1, 0),
(7, 'Random', 'Random', 'random', 'Random', 'random', 0, 1),
(8, 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `ID` int(11) NOT NULL,
  `GROUPS_ID` int(11) NOT NULL,
  `USERS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`ID`, `GROUPS_ID`, `USERS_ID`) VALUES
(29, 12, 1),
(33, 7, 1),
(34, 12, 7),
(36, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_job`
--

CREATE TABLE `user_job` (
  `ID` int(11) NOT NULL,
  `JOB_POSTING_ID` int(11) NOT NULL,
  `USERS_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_job`
--

INSERT INTO `user_job` (`ID`, `JOB_POSTING_ID`, `USERS_ID`) VALUES
(10, 7, 7),
(11, 8, 7),
(12, 9, 1),
(13, 9, 1),
(14, 7, 7),
(15, 7, 1),
(16, 8, 1),
(17, 10, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_profile_users_idx` (`USERS_ID`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_contact_users1_idx` (`USERS_ID`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `job_history`
--
ALTER TABLE `job_history`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_job_history_users1_idx` (`USERS_ID`);

--
-- Indexes for table `job_posting`
--
ALTER TABLE `job_posting`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_contact_users1_idx` (`USERS_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_user_groups_groups1_idx` (`GROUPS_ID`),
  ADD KEY `fk_user_groups_users1_idx` (`USERS_ID`);

--
-- Indexes for table `user_job`
--
ALTER TABLE `user_job`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_user_job_job_posting1_idx` (`JOB_POSTING_ID`),
  ADD KEY `fk_user_job_users1_idx` (`USERS_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `job_history`
--
ALTER TABLE `job_history`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_posting`
--
ALTER TABLE `job_posting`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_job`
--
ALTER TABLE `user_job`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `fk_profile_users` FOREIGN KEY (`USERS_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `fk_contact_users1` FOREIGN KEY (`USERS_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_history`
--
ALTER TABLE `job_history`
  ADD CONSTRAINT `fk_job_history_users1` FOREIGN KEY (`USERS_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `fk_contact_users10` FOREIGN KEY (`USERS_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD CONSTRAINT `fk_user_groups_groups1` FOREIGN KEY (`GROUPS_ID`) REFERENCES `groups` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_groups_users1` FOREIGN KEY (`USERS_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_job`
--
ALTER TABLE `user_job`
  ADD CONSTRAINT `fk_user_job_job_posting1` FOREIGN KEY (`JOB_POSTING_ID`) REFERENCES `job_posting` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_job_users1` FOREIGN KEY (`USERS_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
