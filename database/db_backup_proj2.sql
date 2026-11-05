-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 04, 2026 at 07:45 PM
-- Server version: 8.0.46-0ubuntu0.22.04.4
-- PHP Version: 8.1.2-1ubuntu2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `f26_anrt`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(4, 'Clothing'),
(5, 'Dorm Supplies'),
(3, 'Electronics'),
(6, 'Free Stuff'),
(2, 'Furniture'),
(7, 'Lab Supplies'),
(1, 'Textbooks');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `conversation_id` int NOT NULL,
  `listing_id` int NOT NULL,
  `buyer_id` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`conversation_id`, `listing_id`, `buyer_id`, `created_at`) VALUES
(1, 1, 5, '2026-09-03 10:45:00'),
(2, 2, 7, '2026-09-06 20:00:00'),
(3, 3, 6, '2026-09-11 18:40:00'),
(4, 4, 3, '2026-09-15 11:00:00'),
(5, 6, 10, '2026-09-22 20:15:00'),
(6, 8, 5, '2026-10-30 19:45:00'),
(7, 9, 8, '2026-11-02 09:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int NOT NULL,
  `department` varchar(10) NOT NULL,
  `course_number` varchar(10) NOT NULL,
  `title` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `department`, `course_number`, `title`) VALUES
(1, 'CS', '360', 'Databases'),
(2, 'CS', '216', 'Data Structures'),
(3, 'MATH', '111', 'Calculus I'),
(4, 'CHEM', '107', 'General Chemistry I'),
(5, 'ECON', '103', 'Principles of Microeconomics'),
(6, 'BIO', '111', 'Introductory Biology'),
(7, 'PSYC', '101', 'General Psychology'),
(8, 'ENG', '216', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int NOT NULL,
  `listing_id` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`user_id`, `listing_id`, `created_at`) VALUES
(3, 9, '2026-11-01 13:40:00'),
(4, 3, '2026-09-07 20:10:00'),
(5, 8, '2026-10-29 18:00:00'),
(6, 1, '2026-09-02 09:00:00'),
(7, 8, '2026-10-31 10:25:00'),
(7, 9, '2026-11-01 12:00:00'),
(8, 2, '2026-09-04 16:30:00'),
(8, 9, '2026-11-02 09:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `listing_id` int NOT NULL,
  `seller_id` int NOT NULL,
  `category_id` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `item_condition` varchar(20) NOT NULL,
  `pickup_location` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `sold_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`listing_id`, `seller_id`, `category_id`, `course_id`, `title`, `description`, `price`, `item_condition`, `pickup_location`, `status`, `created_at`, `updated_at`, `sold_at`) VALUES
(1, 3, 1, 1, 'Database Systems textbook', 'Used for CS 360 last spring. Some highlighting in the first few chapters, otherwise clean.', 45.00, 'good', 'Musselman Library', 'sold', '2026-09-01 10:15:00', '2026-09-06 15:30:00', '2026-09-06 15:30:00'),
(2, 4, 1, 3, 'Calculus: Early Transcendentals', 'Hardcover, 8th edition. No writing inside and the spine is in great shape.', 60.00, 'like_new', 'Glatfelter Hall', 'sold', '2026-09-02 17:30:00', '2026-09-09 12:15:00', '2026-09-09 12:15:00'),
(3, 5, 2, NULL, 'Gray futon couch', 'Folds flat into a bed. Seat is 54 inches wide. You need a car or a friend to move it.', 80.00, 'fair', 'Quarry Suites', 'sold', '2026-09-05 12:00:00', '2026-09-18 11:00:00', '2026-09-14 16:00:00'),
(4, 6, 3, 3, 'TI-84 Plus graphing calculator', 'Works perfectly and comes with a slide cover. New batteries installed in August.', 55.00, 'good', 'College Union Building', 'sold', '2026-09-10 10:00:00', '2026-09-18 13:45:00', '2026-09-18 13:45:00'),
(5, 7, 4, NULL, 'Gettysburg College hoodie, size M', 'Navy with orange lettering. Worn twice, it just doesn\'t fit me.', 15.00, 'like_new', 'Servo', 'sold', '2026-09-15 18:00:00', '2026-09-20 17:00:00', '2026-09-20 17:00:00'),
(6, 3, 5, NULL, 'Mini fridge, 3.2 cu ft', 'Keeps drinks cold and has a small freezer shelf. Cleaned and ready for a new room.', 40.00, 'good', 'Hanson Hall', 'sold', '2026-09-20 14:30:00', '2026-09-28 18:30:00', '2026-09-28 18:30:00'),
(7, 8, 7, 4, 'Lab coat and goggles set', 'Bought for General Chemistry and never used. Coat is size S.', 20.00, 'new', 'McCreary Hall', 'sold', '2026-09-25 10:00:00', '2026-10-02 14:00:00', '2026-10-02 14:00:00'),
(8, 4, 1, 5, 'Principles of Microeconomics, 9th ed.', 'Paperback with a few notes in the margins. Access code has already been used.', 35.00, 'good', 'Musselman Library', 'active', '2026-10-26 08:15:00', '2026-10-26 08:15:00', NULL),
(9, 6, 6, NULL, 'Desk lamp, free to a good home', 'Neck still bends, but the base is cracked. Free, just pick it up.', 0.00, 'poor', 'Hanson Hall', 'active', '2026-11-01 11:00:00', '2026-11-01 11:00:00', NULL),
(10, 9, 3, NULL, 'Wireless earbuds, sealed box', 'Brand new and sealed. Selling for a fraction of the store price, message me fast.', 25.00, 'new', NULL, 'removed', '2026-10-10 21:00:00', '2026-10-13 09:15:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `listing_images`
--

CREATE TABLE `listing_images` (
  `image_id` int NOT NULL,
  `listing_id` int NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `sort_order` int NOT NULL,
  `uploaded_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `listing_images`
--

INSERT INTO `listing_images` (`image_id`, `listing_id`, `file_path`, `sort_order`, `uploaded_at`) VALUES
(1, 1, 'listings/1_0.jpg', 0, '2026-09-01 10:16:00'),
(2, 1, 'listings/1_1.jpg', 1, '2026-09-01 10:17:00'),
(3, 2, 'listings/2_0.jpg', 0, '2026-09-02 17:31:00'),
(4, 3, 'listings/3_0.jpg', 0, '2026-09-05 12:02:00'),
(5, 3, 'listings/3_1.jpg', 1, '2026-09-05 12:03:00'),
(6, 4, 'listings/4_0.jpg', 0, '2026-09-10 10:01:00'),
(7, 5, 'listings/5_0.jpg', 0, '2026-09-15 18:01:00'),
(8, 6, 'listings/6_0.jpg', 0, '2026-09-20 14:32:00'),
(9, 8, 'listings/8_0.jpg', 0, '2026-10-26 08:16:00'),
(10, 9, 'listings/9_0.jpg', 0, '2026-11-01 11:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int NOT NULL,
  `conversation_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `body` varchar(500) NOT NULL,
  `sent_at` datetime NOT NULL,
  `read_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `conversation_id`, `sender_id`, `body`, `sent_at`, `read_at`) VALUES
(1, 1, 5, 'Hi, is the database book still available? I\'m in CS 360 this fall.', '2026-09-03 10:45:00', '2026-09-03 11:30:00'),
(2, 1, 3, 'Yes it is. I countered your offer at $43, and we can meet at Musselman.', '2026-09-04 09:35:00', '2026-09-04 13:00:00'),
(3, 2, 7, 'Is the calculus book still for sale? I could meet at Glatfelter.', '2026-09-06 20:00:00', '2026-09-06 21:15:00'),
(4, 3, 6, 'Will the futon fit in a small SUV?', '2026-09-11 18:40:00', '2026-09-11 19:10:00'),
(5, 3, 5, 'Should be fine with the back seats folded down.', '2026-09-11 19:30:00', '2026-09-11 19:45:00'),
(6, 4, 3, 'Does the calculator come with a link cable?', '2026-09-15 11:00:00', '2026-09-15 11:20:00'),
(7, 5, 10, 'Answer me already. You are wasting my time and you will regret ignoring me.', '2026-09-22 20:15:00', '2026-09-22 22:00:00'),
(8, 6, 5, 'Would you take $30 for the econ book? I just sent an offer.', '2026-10-30 19:45:00', NULL),
(9, 7, 8, 'Is the lamp still free? I could grab it tonight.', '2026-11-02 09:30:00', '2026-11-02 11:50:00'),
(10, 7, 6, 'Yes! Meet me in the Hanson lobby after 6.', '2026-11-02 12:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `moderation_actions`
--

CREATE TABLE `moderation_actions` (
  `action_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `target_user_id` int DEFAULT NULL,
  `target_listing_id` int DEFAULT NULL,
  `report_id` int DEFAULT NULL,
  `action_type` varchar(20) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `moderation_actions`
--

INSERT INTO `moderation_actions` (`action_id`, `admin_id`, `target_user_id`, `target_listing_id`, `report_id`, `action_type`, `reason`, `expires_at`, `created_at`) VALUES
(1, 2, 10, NULL, 3, 'warn', 'Warned about a threatening message to a seller.', NULL, '2026-09-23 12:00:00'),
(2, 2, 10, NULL, 3, 'ban', 'Harassment continued after a warning.', NULL, '2026-09-25 17:00:00'),
(3, 1, NULL, 3, 6, 'edit_listing', 'Corrected the futon\'s width in the description.', NULL, '2026-09-18 11:00:00'),
(4, 1, NULL, 10, 1, 'remove_listing', 'Likely counterfeit goods, reported by two students.', NULL, '2026-10-13 09:15:00'),
(5, 1, 9, NULL, 2, 'suspend', 'Posted a likely counterfeit listing.', '2026-11-20 00:00:00', '2026-10-13 09:20:00'),
(6, 2, 8, NULL, NULL, 'suspend', 'Reposted the same listing repeatedly.', '2026-10-12 00:00:00', '2026-10-05 14:00:00'),
(7, 2, 8, NULL, NULL, 'reinstate', 'Suspension served and no further problems.', NULL, '2026-10-12 00:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `offer_id` int NOT NULL,
  `listing_id` int NOT NULL,
  `buyer_id` int NOT NULL,
  `made_by_id` int NOT NULL,
  `parent_offer_id` int DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `responded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`offer_id`, `listing_id`, `buyer_id`, `made_by_id`, `parent_offer_id`, `amount`, `note`, `status`, `created_at`, `responded_at`) VALUES
(1, 1, 5, 5, NULL, 40.00, 'Would you take $40?', 'countered', '2026-09-03 11:00:00', '2026-09-04 09:30:00'),
(2, 1, 5, 3, 1, 43.00, 'I can do $43.', 'accepted', '2026-09-04 09:30:00', '2026-09-05 14:00:00'),
(3, 2, 7, 7, NULL, 55.00, NULL, 'accepted', '2026-09-07 13:00:00', '2026-09-08 10:00:00'),
(4, 2, 8, 8, NULL, 50.00, 'Can pick up any weekday.', 'expired', '2026-09-06 09:00:00', NULL),
(5, 3, 6, 6, NULL, 75.00, 'I have a car and can move it myself.', 'accepted', '2026-09-11 19:00:00', '2026-09-12 08:30:00'),
(6, 4, 8, 8, NULL, 30.00, NULL, 'rejected', '2026-09-12 15:00:00', '2026-09-13 09:00:00'),
(7, 4, 3, 3, NULL, 50.00, NULL, 'accepted', '2026-09-15 11:30:00', '2026-09-16 10:00:00'),
(8, 5, 6, 6, NULL, 12.00, NULL, 'withdrawn', '2026-09-16 12:00:00', NULL),
(9, 8, 5, 5, NULL, 30.00, 'I can meet at the library this week.', 'pending', '2026-10-30 19:40:00', NULL),
(10, 6, 4, 4, NULL, 38.00, NULL, 'accepted', '2026-09-25 15:00:00', '2026-09-26 09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int NOT NULL,
  `reporter_id` int NOT NULL,
  `reported_user_id` int NOT NULL,
  `reported_listing_id` int DEFAULT NULL,
  `reason` varchar(20) NOT NULL,
  `details` varchar(500) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `reviewed_by` int DEFAULT NULL,
  `resolution_note` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `reviewed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `reporter_id`, `reported_user_id`, `reported_listing_id`, `reason`, `details`, `status`, `reviewed_by`, `resolution_note`, `created_at`, `reviewed_at`) VALUES
(1, 4, 9, 10, 'scam', 'The price is far too low for sealed earbuds, and the photos look like stock images.', 'actioned', 1, 'Listing removed and seller suspended.', '2026-10-12 10:30:00', '2026-10-13 09:15:00'),
(2, 7, 9, 10, 'prohibited_item', 'These look counterfeit.', 'actioned', 1, 'Same listing as report 1.', '2026-10-12 16:05:00', '2026-10-13 09:20:00'),
(3, 3, 10, NULL, 'harassment', 'Sent me a threatening message about my mini fridge listing.', 'actioned', 2, 'Warned, then banned after the behavior continued.', '2026-09-23 08:10:00', '2026-09-25 17:00:00'),
(4, 4, 6, 9, 'spam', 'This looks like a duplicate post.', 'dismissed', 2, 'Only one lamp listing exists, so no rule was broken.', '2026-11-02 13:00:00', '2026-11-03 10:00:00'),
(5, 3, 4, 8, 'inappropriate', 'The listing photo has an off-topic joke written on the cover.', 'under_review', 2, NULL, '2026-11-01 15:30:00', NULL),
(6, 6, 5, 3, 'other', 'The futon was smaller than the listing said.', 'escalated', 1, 'Listing corrected and sent to a senior moderator.', '2026-09-16 08:45:00', '2026-09-18 11:00:00'),
(7, 5, 9, NULL, 'spam', 'Sent me repeated promotional messages in October.', 'open', NULL, NULL, '2026-11-03 09:40:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `transaction_id` int NOT NULL,
  `reviewer_id` int NOT NULL,
  `reviewee_id` int NOT NULL,
  `rating` int NOT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `transaction_id`, `reviewer_id`, `reviewee_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 5, 3, 5, 'Book was exactly as described and the meetup was easy.', '2026-09-07 10:00:00'),
(2, 1, 3, 5, 5, 'On time and friendly.', '2026-09-07 12:00:00'),
(3, 2, 7, 4, 4, 'Great book, took a couple of days to set up a meetup.', '2026-09-10 18:30:00'),
(4, 3, 6, 5, 3, 'Futon was smaller than the listing said.', '2026-09-15 09:45:00'),
(5, 3, 5, 6, 5, 'Showed up with a car and moved it without any trouble.', '2026-09-15 11:20:00'),
(6, 4, 3, 6, 5, 'Calculator works great.', '2026-09-19 14:00:00'),
(7, 5, 4, 3, 4, 'Fridge works, but it runs a little loud.', '2026-09-29 20:15:00'),
(8, 7, 6, 8, 5, NULL, '2026-10-03 08:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int NOT NULL,
  `listing_id` int NOT NULL,
  `buyer_id` int NOT NULL,
  `offer_id` int DEFAULT NULL,
  `final_price` decimal(8,2) NOT NULL,
  `completed_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `listing_id`, `buyer_id`, `offer_id`, `final_price`, `completed_at`) VALUES
(1, 1, 5, 2, 43.00, '2026-09-06 15:30:00'),
(2, 2, 7, 3, 55.00, '2026-09-09 12:15:00'),
(3, 3, 6, 5, 75.00, '2026-09-14 16:00:00'),
(4, 4, 3, 7, 50.00, '2026-09-18 13:45:00'),
(5, 6, 4, 10, 38.00, '2026-09-28 18:30:00'),
(6, 5, 8, NULL, 15.00, '2026-09-20 17:00:00'),
(7, 7, 6, NULL, 20.00, '2026-10-02 14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `class_year` int DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `account_status` varchar(20) NOT NULL,
  `suspended_until` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `last_login_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password_hash`, `first_name`, `last_name`, `class_year`, `role`, `account_status`, `suspended_until`, `created_at`, `last_login_at`) VALUES
(1, 'test.dwhitfield@gettysburg.edu', '$2y$12$oiIlwRDl2jmPHJoTkDAWvuITeJ9bFd5vKb7ny9gDETLZFKvNhU2OO', 'Dana', 'Whitfield', NULL, 'admin', 'active', NULL, '2026-08-15 09:00:00', '2026-11-04 08:30:00'),
(2, 'test.moyelaran@gettysburg.edu', '$2y$12$19WE0ISFHLjTldh8DCPH3OalVDmH9uPdIcZF1c3flmlczNyRLssSa', 'Marcus', 'Oyelaran', 2027, 'admin', 'active', NULL, '2026-08-15 09:10:00', '2026-11-03 16:20:00'),
(3, 'test.alindqvist@gettysburg.edu', '$2y$12$jfiekEVnluV747XTnf8QBe/qZXUKRofPc9VU3q6g4VrLh2aHw8quK', 'Alex', 'Lindqvist', 2027, 'student', 'active', NULL, '2026-08-24 13:05:00', '2026-11-03 21:10:00'),
(4, 'test.sreyes@gettysburg.edu', '$2y$12$2emtj/szqq55NoAKm/4qje60T2jshr78QYLp9b83wzT3USQVk2xqC', 'Sam', 'Reyes', 2028, 'student', 'active', NULL, '2026-08-25 10:40:00', '2026-11-04 07:45:00'),
(5, 'test.tkowalski@gettysburg.edu', '$2y$12$ayX1a38ryvZErGCm.7OK3.F.2.54GF7blwhtV/360MV2cUh5ZiPeu', 'Taylor', 'Kowalski', 2029, 'student', 'active', NULL, '2026-08-26 18:22:00', '2026-11-03 09:35:00'),
(6, 'test.mpatel@gettysburg.edu', '$2y$12$ojFfJUpvGXoAzEHaKBoL2.kYHThvmqE4hFkqAPezCzxbbo8R8o0ZW', 'Morgan', 'Patel', 2027, 'student', 'active', NULL, '2026-08-27 11:15:00', '2026-11-03 12:05:00'),
(7, 'test.jnakamura@gettysburg.edu', '$2y$12$TTreDHebVzFQ3TKvh8CxuO1Z8S3uQ0i5cykvKdu4JVaXsn7s164O.', 'Jordan', 'Nakamura', 2028, 'student', 'active', NULL, '2026-08-28 20:30:00', '2026-11-01 17:40:00'),
(8, 'test.cokafor@gettysburg.edu', '$2y$12$qzCaQ7othwsekzRJx8Nokuqx6FGayhREAq3uhVwQ/HPCs7cZQKXZ6', 'Casey', 'Okafor', 2030, 'student', 'active', NULL, '2026-08-30 14:00:00', '2026-11-03 18:15:00'),
(9, 'test.rbrandt@gettysburg.edu', '$2y$12$Axgzo8PvWdE2YTMxIIPn.ejx7KEf/CL3KeAbSuZhsxePcSe5Q4QSm', 'Riley', 'Brandt', 2029, 'student', 'suspended', '2026-11-20 00:00:00', '2026-09-02 09:50:00', '2026-10-13 08:00:00'),
(10, 'test.dvasquez@gettysburg.edu', '$2y$12$k7mVxY8etEsbAztxlARruuP9MC6mvbnZCP3QHoZip7fJBZqcGARIG', 'Drew', 'Vasquez', 2028, 'student', 'banned', NULL, '2026-09-03 16:45:00', '2026-09-24 22:10:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversation_id`),
  ADD UNIQUE KEY `listing_id` (`listing_id`,`buyer_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `department` (`department`,`course_number`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`listing_id`),
  ADD KEY `listing_id` (`listing_id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`listing_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `idx_listings_status` (`status`),
  ADD KEY `idx_listings_price` (`price`),
  ADD KEY `idx_listings_created` (`created_at`);

--
-- Indexes for table `listing_images`
--
ALTER TABLE `listing_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `listing_id` (`listing_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `moderation_actions`
--
ALTER TABLE `moderation_actions`
  ADD PRIMARY KEY (`action_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `target_user_id` (`target_user_id`),
  ADD KEY `target_listing_id` (`target_listing_id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`offer_id`),
  ADD KEY `listing_id` (`listing_id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `made_by_id` (`made_by_id`),
  ADD KEY `parent_offer_id` (`parent_offer_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `reporter_id` (`reporter_id`),
  ADD KEY `reported_user_id` (`reported_user_id`),
  ADD KEY `reported_listing_id` (`reported_listing_id`),
  ADD KEY `reviewed_by` (`reviewed_by`),
  ADD KEY `idx_reports_status` (`status`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`,`reviewer_id`),
  ADD KEY `reviewer_id` (`reviewer_id`),
  ADD KEY `reviewee_id` (`reviewee_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD UNIQUE KEY `listing_id` (`listing_id`),
  ADD UNIQUE KEY `offer_id` (`offer_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `listing_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `listing_images`
--
ALTER TABLE `listing_images`
  MODIFY `image_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `moderation_actions`
--
ALTER TABLE `moderation_actions`
  MODIFY `action_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `offer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`listing_id`),
  ADD CONSTRAINT `conversations_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`listing_id`);

--
-- Constraints for table `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `listings_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `listings_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `listings_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `listing_images`
--
ALTER TABLE `listing_images`
  ADD CONSTRAINT `listing_images_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`listing_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `moderation_actions`
--
ALTER TABLE `moderation_actions`
  ADD CONSTRAINT `moderation_actions_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `moderation_actions_ibfk_2` FOREIGN KEY (`target_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `moderation_actions_ibfk_3` FOREIGN KEY (`target_listing_id`) REFERENCES `listings` (`listing_id`),
  ADD CONSTRAINT `moderation_actions_ibfk_4` FOREIGN KEY (`report_id`) REFERENCES `reports` (`report_id`);

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`listing_id`),
  ADD CONSTRAINT `offers_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `offers_ibfk_3` FOREIGN KEY (`made_by_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `offers_ibfk_4` FOREIGN KEY (`parent_offer_id`) REFERENCES `offers` (`offer_id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`reported_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reports_ibfk_3` FOREIGN KEY (`reported_listing_id`) REFERENCES `listings` (`listing_id`),
  ADD CONSTRAINT `reports_ibfk_4` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`reviewee_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`listing_id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`offer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
