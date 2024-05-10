-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2024 at 07:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `contact_information` varchar(12) NOT NULL,
  `address` varchar(50) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `login_role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `contact_information`, `address`, `username`, `password`, `login_role_id`) VALUES
(1, 'Juliana Arla Paguinto', '09471026007', 'San Fernando Pampanga', 'jasp', 'jasp', 4),
(2, 'yuna shin', '235234562345', 'Arayat Pampanga', 'yuna', 'yuna', 4),
(4, 'Arron Rebustes', '09471026007', 'Arayat Pampanga', 'ronreb@customer.com', 'ronreb', 4),
(5, 'Kim Dokja', '09917377152', 'Tigaon, camarines Sur', 'kdj@customer.com', 'squid', 4);

-- --------------------------------------------------------

--
-- Table structure for table `deduction_details`
--

CREATE TABLE `deduction_details` (
  `deduction_id` int(11) NOT NULL,
  `absent_count` int(11) DEFAULT NULL,
  `absent_rate` decimal(10,2) DEFAULT NULL,
  `philhealth` decimal(10,2) DEFAULT NULL,
  `sss` decimal(10,2) DEFAULT NULL,
  `pagibig` decimal(10,2) DEFAULT NULL,
  `salary_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deduction_details`
--

INSERT INTO `deduction_details` (`deduction_id`, `absent_count`, `absent_rate`, `philhealth`, `sss`, `pagibig`, `salary_id`) VALUES
(1, 0, 0.00, 100.00, 100.00, 100.00, 1),
(3, 0, 0.00, 0.00, 0.00, 0.00, 3),
(4, 0, 0.00, 100.00, 100.00, 100.00, 4),
(5, 0, 0.00, 100.00, 100.00, 100.00, 5),
(6, 0, 0.00, 0.00, 0.00, 0.00, 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `delivery_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `delivery_address`) VALUES
(1, 1, '2024-05-05 13:34:43', 'jan lnag'),
(2, 2, '2024-05-06 13:00:24', 'tgjterjyytry'),
(3, 2, '2024-05-06 13:27:47', 'tgjterjyytry'),
(4, 2, '2024-05-06 13:35:55', 'tgjterjyytry'),
(5, 2, '2024-05-06 13:37:01', 'tgjterjyytry'),
(6, 2, '2024-05-06 13:45:36', 'tgjterjyytry');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(50) NOT NULL,
  `order_id` int(50) NOT NULL,
  `product_id` int(50) NOT NULL,
  `quantity_ordered` int(50) NOT NULL,
  `price_at_order_time` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity_ordered`, `price_at_order_time`) VALUES
(1, 1, 1, 1, 25),
(2, 1, 3, 2, 1000),
(3, 2, 3, 1, 1000),
(4, 2, 2, 1, 23),
(5, 2, 1, 2, 25),
(6, 3, 2, 1, 23),
(7, 4, 2, 2, 23),
(8, 5, 2, 1, 23),
(9, 6, 2, 1, 23);

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `payment_ID` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `order_id` int(11) NOT NULL,
  `Amount` bigint(200) DEFAULT NULL,
  `transaction_fee` float NOT NULL,
  `Type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`payment_ID`, `name`, `order_id`, `Amount`, `transaction_fee`, `Type`) VALUES
(1, 'Juliana Arla Paguinto', 1, 2025, 400, 'COD'),
(2, 'yuna shin', 2, 1073, 120, 'COD'),
(3, 'yuna shin', 3, 23, 80, 'COD'),
(4, 'yuna shin', 4, 46, 80, 'COD'),
(5, 'yuna shin', 5, 23, 80, 'COD'),
(6, 'yuna shin', 6, 23, 80, 'COD');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `price` int(200) NOT NULL,
  `quantity_in_stock` int(50) NOT NULL,
  `net_weight_in_kg` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `description`, `price`, `quantity_in_stock`, `net_weight_in_kg`) VALUES
(1, 'wilkins2', 'tubig', 25, 10, 0.5),
(2, 'cena', 'john', 23, 26, 0.6),
(3, 'shirt', 'white shirt', 1000, 20, 6);

-- --------------------------------------------------------

--
-- Table structure for table `salary_details`
--

CREATE TABLE `salary_details` (
  `salary_id` int(11) NOT NULL,
  `TotalSalary_id` int(11) NOT NULL,
  `basic_salary` decimal(10,2) DEFAULT NULL,
  `overtime_hours` decimal(10,2) DEFAULT NULL,
  `regular_overtime_rate` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary_details`
--

INSERT INTO `salary_details` (`salary_id`, `TotalSalary_id`, `basic_salary`, `overtime_hours`, `regular_overtime_rate`) VALUES
(1, 1, 2352.00, 8.00, 24.50),
(3, 3, 536.00, 0.00, 16.75),
(5, 5, 688.00, 0.00, 21.50),
(6, 6, 0.00, 0.00, 24.50);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `attendance_id` int(100) NOT NULL,
  `employee_id` int(100) NOT NULL,
  `date` date NOT NULL,
  `timein` datetime NOT NULL,
  `timeout` datetime DEFAULT NULL,
  `status_id` int(10) DEFAULT NULL,
  `worktime_status_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`attendance_id`, `employee_id`, `date`, `timein`, `timeout`, `status_id`, `worktime_status_id`) VALUES
(25, 8, '2024-04-20', '2024-05-09 09:02:17', '2024-05-09 16:02:30', 1, 1),
(26, 8, '2024-04-19', '2024-05-09 22:26:07', '2024-05-09 22:26:10', 2, 3),
(27, 8, '2024-05-08', '2024-05-09 07:55:13', '2024-05-09 15:57:40', 1, 1),
(28, 2, '2024-05-09', '2024-05-09 00:25:38', NULL, 1, 0),
(29, 6, '2024-05-09', '2024-05-09 00:56:49', '2024-05-09 01:11:35', 1, 3),
(30, 4, '2024-05-09', '2024-05-09 08:00:00', '2024-05-09 17:00:00', 1, 2),
(31, 4, '2024-05-08', '2024-05-08 08:00:00', '2024-05-08 16:00:00', 1, 1),
(32, 4, '2024-05-08', '2024-05-07 08:00:00', '2024-05-07 23:00:00', 1, 3),
(33, 7, '2024-05-10', '2024-05-10 08:00:00', '2024-05-10 16:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_account`
--

CREATE TABLE `tbl_employee_account` (
  `employee_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `login_role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employee_account`
--

INSERT INTO `tbl_employee_account` (`employee_id`, `username`, `password`, `login_role_id`) VALUES
(2, 'admin@admin', 'asd', 1),
(4, 'asd@asd.com', 'asd', 2),
(6, 'ronreb@rider.com', 'ronreb', 3),
(7, 'hsy@itemployee.com', 'hsy', 5),
(8, 'jade@finance.com', 'jade', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_info`
--

CREATE TABLE `tbl_employee_info` (
  `employee_info_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(100) NOT NULL,
  `age` int(100) NOT NULL,
  `marital_status` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone_num` bigint(200) NOT NULL,
  `province` varchar(200) NOT NULL,
  `zip` varchar(4) NOT NULL,
  `elem` varchar(200) DEFAULT NULL,
  `jhs` varchar(200) DEFAULT NULL,
  `shs` varchar(200) DEFAULT NULL,
  `college` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employee_info`
--

INSERT INTO `tbl_employee_info` (`employee_info_id`, `employee_id`, `job_id`, `firstname`, `middlename`, `lastname`, `birthdate`, `gender`, `age`, `marital_status`, `email`, `phone_num`, `province`, `zip`, `elem`, `jhs`, `shs`, `college`) VALUES
(1, 2, 2, 'Juan', 'Simbulan', 'Dela Cruz Jr', '2001-04-26', 'MALE', 23, 'SINGLE', 'julianapaguinto426@gmail.com', 9471026008, 'PAMPANGA', '2012', 'central', 'ai', 'adelle', 'hcc'),
(2, 4, 4, 'Juliana Arla', 'Simbulan', 'Paguinto iii', '2003-04-26', 'FEMALE', 21, 'MARRIED', 'julianapaguinto426@gmail.com', 9471026008, 'PAMPANGA', '2012', 'ce', 'ai', 'adelle', 'hcc'),
(3, 6, 5, 'Arron', '', 'Rebustes ', '2002-09-08', 'MALE', 21, 'MARRIED', 'ronreb@rider.com', 7894651415, 'Bulacan', '2012', 'ACES', 'AI', 'AGMSI', 'HCC'),
(4, 7, 6, 'Soo', 'Young', 'Han', '2002-04-04', 'FEMALE', 22, 'SINGLE', 'arlapaguinto0426@gmail.com', 9879789436, 'Bulacan', '2012', 'central', 'ai', 'adelle', 'hcc'),
(5, 8, 7, 'Jade Alea', '', 'Paguinto ', '2001-01-08', 'FEMALE', 23, 'MARRIED', 'jade@gmail.com', 9999999999, 'Pampanga', '2012', 'ACES', 'JSHS', 'AGMSI', 'DHVSU');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job`
--

CREATE TABLE `tbl_job` (
  `job_id` int(11) NOT NULL,
  `job_title` varchar(200) NOT NULL,
  `department` varchar(200) NOT NULL,
  `hire_date` date NOT NULL,
  `hire_status` varchar(200) NOT NULL,
  `job_salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_job`
--

INSERT INTO `tbl_job` (`job_id`, `job_title`, `department`, `hire_date`, `hire_status`, `job_salary`) VALUES
(2, 'MANAGER', 'ORDER PROCESSING', '2018-04-04', 'FULL-TIME', 99),
(4, 'MANAGER', 'ORDER PROCESSING', '2018-04-26', 'FULL-TIME', 98),
(5, 'RIDER', 'SHIPPING/LOGISTICS', '2012-08-08', 'FULL-TIME', 67),
(6, 'IT EMPLOYEE', 'IT SUPPORT', '2024-05-09', 'PART-TIME', 78),
(7, 'FINANCE EMPLOYEE', 'FINANCE', '2024-05-10', 'PART-TIME', 86);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_role`
--

CREATE TABLE `tbl_login_role` (
  `login_role_id` int(11) NOT NULL,
  `login_role` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_login_role`
--

INSERT INTO `tbl_login_role` (`login_role_id`, `login_role`) VALUES
(1, 'ADMIN'),
(2, 'MANAGER'),
(3, 'RIDER'),
(4, 'CUSTOMER'),
(5, 'EMPLOYEE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payroll`
--

CREATE TABLE `tbl_payroll` (
  `payroll_id` int(11) NOT NULL,
  `reference_number` varchar(10) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `PayrollType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_payroll`
--

INSERT INTO `tbl_payroll` (`payroll_id`, `reference_number`, `StartDate`, `EndDate`, `PayrollType`) VALUES
(1, 'REF0509251', '2024-05-05', '2024-05-09', 'SEMI-MONTHLY'),
(2, 'REF0509062', '2024-04-18', '2024-05-04', 'SEMI-MONTHLY');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_postlocations`
--

CREATE TABLE `tbl_postlocations` (
  `postLocationID` int(11) NOT NULL,
  `PostName` varchar(200) NOT NULL,
  `PostAddress` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_postlocations`
--

INSERT INTO `tbl_postlocations` (`postLocationID`, `PostName`, `PostAddress`) VALUES
(1, 'Main Branch', 'Arayat Pampanga'),
(2, 'Branch 1', 'Bulacan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `status_id` int(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`status_id`, `status`) VALUES
(1, 'PRESENT'),
(2, 'LATE'),
(3, 'ABSENT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trackinginformation`
--

CREATE TABLE `tbl_trackinginformation` (
  `TrackingID` int(100) NOT NULL,
  `TrackingNumber` varchar(10) NOT NULL,
  `OrderID` int(100) NOT NULL,
  `TrackingStatusID` int(100) NOT NULL,
  `PostLocationID` int(100) NOT NULL,
  `DestinationPostID` int(11) DEFAULT NULL,
  `InitialDate` datetime DEFAULT NULL,
  `DeliveryDate` datetime DEFAULT NULL,
  `rider_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_trackinginformation`
--

INSERT INTO `tbl_trackinginformation` (`TrackingID`, `TrackingNumber`, `OrderID`, `TrackingStatusID`, `PostLocationID`, `DestinationPostID`, `InitialDate`, `DeliveryDate`, `rider_id`) VALUES
(1, 'TN05059323', 1, 5, 1, 2, '2024-05-05 13:34:54', '2024-05-05 23:28:40', 6),
(2, 'TN05066966', 2, 5, 1, 2, '2024-05-06 13:00:43', '2024-05-06 13:03:49', 6),
(3, 'TN05061590', 3, 6, 1, 2, '2024-05-06 13:27:55', '2024-05-10 22:31:58', 2),
(4, 'TN05062431', 4, 2, 1, 2, '2024-05-06 13:35:59', NULL, NULL),
(5, 'TN05062876', 5, 2, 1, 2, '2024-05-06 13:37:03', NULL, NULL),
(6, 'TN05062873', 6, 2, 1, 2, '2024-05-06 13:45:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trackingstatus`
--

CREATE TABLE `tbl_trackingstatus` (
  `TrackingStatusID` int(100) NOT NULL,
  `Status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_trackingstatus`
--

INSERT INTO `tbl_trackingstatus` (`TrackingStatusID`, `Status`) VALUES
(1, 'PENDING'),
(2, 'CONFIRMED'),
(3, 'IN TRANSIT'),
(4, 'OUT FOR DELIVERY'),
(5, 'DELIVERED'),
(6, 'RETURNED');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_worktime_status`
--

CREATE TABLE `tbl_worktime_status` (
  `worktime_status_id` int(100) NOT NULL,
  `worktime_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_worktime_status`
--

INSERT INTO `tbl_worktime_status` (`worktime_status_id`, `worktime_status`) VALUES
(0, 'PENDING'),
(1, 'NORMAL'),
(2, 'OVERTIME'),
(3, 'UNDERTIME');

-- --------------------------------------------------------

--
-- Table structure for table `total_salary`
--

CREATE TABLE `total_salary` (
  `TotalSalary_id` int(11) NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `total_gross` decimal(10,2) DEFAULT NULL,
  `total_deduction` decimal(10,2) DEFAULT NULL,
  `total_salary` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `total_salary`
--

INSERT INTO `total_salary` (`TotalSalary_id`, `payroll_id`, `total_gross`, `total_deduction`, `total_salary`, `date`, `employee_id`) VALUES
(1, 1, 2548.00, 300.00, 2248.00, '2024-05-10', 4),
(3, 1, 536.00, 0.00, 536.00, '2024-05-10', 6),
(5, 2, 688.00, 300.00, 388.00, '2024-05-10', 8),
(6, 2, 0.00, 0.00, 0.00, '2024-05-11', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `deduction_details`
--
ALTER TABLE `deduction_details`
  ADD PRIMARY KEY (`deduction_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`payment_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `salary_details`
--
ALTER TABLE `salary_details`
  ADD PRIMARY KEY (`salary_id`);

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `tbl_employee_account`
--
ALTER TABLE `tbl_employee_account`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `tbl_employee_info`
--
ALTER TABLE `tbl_employee_info`
  ADD PRIMARY KEY (`employee_info_id`);

--
-- Indexes for table `tbl_job`
--
ALTER TABLE `tbl_job`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `tbl_login_role`
--
ALTER TABLE `tbl_login_role`
  ADD PRIMARY KEY (`login_role_id`);

--
-- Indexes for table `tbl_payroll`
--
ALTER TABLE `tbl_payroll`
  ADD PRIMARY KEY (`payroll_id`);

--
-- Indexes for table `tbl_postlocations`
--
ALTER TABLE `tbl_postlocations`
  ADD PRIMARY KEY (`postLocationID`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `tbl_trackinginformation`
--
ALTER TABLE `tbl_trackinginformation`
  ADD PRIMARY KEY (`TrackingID`);

--
-- Indexes for table `tbl_trackingstatus`
--
ALTER TABLE `tbl_trackingstatus`
  ADD PRIMARY KEY (`TrackingStatusID`);

--
-- Indexes for table `tbl_worktime_status`
--
ALTER TABLE `tbl_worktime_status`
  ADD PRIMARY KEY (`worktime_status_id`);

--
-- Indexes for table `total_salary`
--
ALTER TABLE `total_salary`
  ADD PRIMARY KEY (`TotalSalary_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `deduction_details`
--
ALTER TABLE `deduction_details`
  MODIFY `deduction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `payment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `salary_details`
--
ALTER TABLE `salary_details`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `attendance_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_employee_account`
--
ALTER TABLE `tbl_employee_account`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_employee_info`
--
ALTER TABLE `tbl_employee_info`
  MODIFY `employee_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_job`
--
ALTER TABLE `tbl_job`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_login_role`
--
ALTER TABLE `tbl_login_role`
  MODIFY `login_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_payroll`
--
ALTER TABLE `tbl_payroll`
  MODIFY `payroll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_postlocations`
--
ALTER TABLE `tbl_postlocations`
  MODIFY `postLocationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `status_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_trackinginformation`
--
ALTER TABLE `tbl_trackinginformation`
  MODIFY `TrackingID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_trackingstatus`
--
ALTER TABLE `tbl_trackingstatus`
  MODIFY `TrackingStatusID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_worktime_status`
--
ALTER TABLE `tbl_worktime_status`
  MODIFY `worktime_status_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `total_salary`
--
ALTER TABLE `total_salary`
  MODIFY `TotalSalary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
