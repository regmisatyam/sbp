# SBP - Simple Blogging Platform

A lightweight, self-hosted blogging platform similar to WordPress, built with PHP and MySQL. Clone, configure, and deploy your own blogging website in minutes.

## Table of Contents

- [Features](#features)
- [Demo](#demo)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Project Structure](#project-structure)
- [Usage](#usage)
- [Admin Dashboard](#admin-dashboard)


## Features

- **Easy Setup**: Clone and configure in minutes
- **Admin Dashboard**: Full-featured admin panel for content management
- **User Authentication**: Secure login and user management system
- **Blog Management**: Create, edit, and delete blog posts
- **Category System**: Organize content with categories
- **Comment System**: Built-in commenting functionality
- **Responsive Design**: Mobile-friendly layout
- **SEO Friendly**: Clean URLs and meta tag support
- **Contact Form**: Email contact functionality
- **Load More**: Ajax-based pagination for better UX
- **Social Media Integration**: Connect your social profiles
- **Image Upload**: Featured image support for posts

## Demo Website

Visit the live demo: [https://blog.satyamregmi.com.np] *(SBP)*

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- mod_rewrite enabled (for clean URLs)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/regmisatyam/sbp.git
cd sbp
```

### 2. Create Database

```sql
CREATE DATABASE sbp;
```

### 3. Import Database Schema

```sql
-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql101.infinityfree.com
-- Generation Time: Jan 28, 2026 at 07:48 PM
-- Server version: 11.4.9-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sbp`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `subject` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `already_read` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('subscribed','unsubscribed') DEFAULT 'subscribed',
  `token` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Table structure for table `sbp_comments`
--

CREATE TABLE `sbp_comments` (
  `id` int(11) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `parent_comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_ip` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `is_posted` tinyint(1) NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Table structure for table `sbp_pages`
--

CREATE TABLE `sbp_pages` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `page_contents` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `displayInNav` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `sbp_pages`
--

INSERT INTO `sbp_pages` (`id`, `page_title`, `slug`, `page_contents`, `author`, `date`, `displayInNav`) VALUES
(1, 'About ', 'about', '<p>About Us. Welcome User!</p>', 'satyamregmi', '2024-01-01 03:04:50', 1),
(2, 'Contact', 'contact', '  <section >\r\n        <div class="container">\r\n            <div class="row">\r\n                <div class="col-12">\r\n                    <h2 class="contac[...]`
-- --------------------------------------------------------

-- Table structure for table `sbp_posts`
--

CREATE TABLE `sbp_posts` (
  `id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_contents` text NOT NULL,
  `post_excerpt` varchar(255) NOT NULL,
  `image` longblob NOT NULL,
  `slug` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `post_category` varchar(255) NOT NULL,
  `post_tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table `sbp_posts`
--

INSERT INTO `sbp_posts` (`id`, `post_title`, `post_contents`, `post_excerpt`, `image`, `slug`, `author`, `date`, `post_category`, `post_tags`) VALUES
(1, 'Green Hydrogen', '<p>&nbsp;</p>\r\n<p>Green hydrogen is a clean and sustainable fuel that has gained significant attention in recent years. It is a type of hydrogen fuel that is produced usi[...]`
(2, 'Devin World\'s First AI Software Engineer', '<p>The worlds first fully autonomous powerful AI Software Engineer is here, "Devin", created by US-based startup Cognition AI. Devin uses machi[...]`
(22, 'Google Eying to Buy HubSpot: Stock Alert!', '<p>HubSpot is a prominent software company specializing in inbound marketing, sales, and customer service solutions. Established in 2006, HubSpo[...]`
(23, 'Virtual Reality', '<p>What is VR?<br style=\"list-style-type: none;\">Virtual reality (VR) is a computer-generated simulation of a real world environment. In virtual reality, users wear hea[...]`
(24, 'All Nepali News (ANN)', '<p><strong>### About</strong></p>\r\n<p><br>The All Nepali News app is a single platform for the most recent news from Nepal. For your convenience, we\'ve gathered [...]`
(25, 'The Secret to Mastering Your Thoughts and Emotions for a Better Life', '<p>Gaining control of your mind and thoughts is a powerful practice that can improve your emotional well-being, focus[...]`
(26, 'Top 10 Python OOPs Questions, Answers and Explanation', '<p><strong>1. Classes and Objects:</strong></p>\r\n<pre class=\"language-python\"><code>class Animal:\r\n    def __init__(self, name[...]`
INSERT INTO `sbp_posts` (`id`, `post_title`, `post_contents`, `post_excerpt`, `image`, `slug`, `author`, `date`, `post_category`, `post_tags`) VALUES
(27, 'Python Dunder - Questions and Simple Explanation with output', '<p dir=\"ltr\"><strong>Dunder Methods:</strong></p>\r\n<p dir=\"ltr\">In python &ldquo;dunder methods&rdquo; (double undersco[...]`

-- --------------------------------------------------------

-- Table structure for table `sbp_users`
--

CREATE TABLE `sbp_users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `image` blob NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `about` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `phone` bigint(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `x` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table `sbp_users`
--

INSERT INTO `sbp_users` (`id`, `firstName`, `lastName`, `email`, `username`, `password`, `role`, `date`, `image`, `address`, `about`, `job_title`, `country`, `phone`, `facebook`, `x`, `linkedin`,[...]`
(1, 'Admin', '', 'info.satyamregmi@gmail.com', 'admin', '$2y$10$/vh6FhcjvMsXlz9Q.IgWCOQPJziDxTaCDwpFtfV.GhYCyWN/1dG/i', 'admin', '2024-06-28 08:22:27', 0x312e706e67, '', '', '', '', 0, '', '', ''[...]`

-- Indexes for dumped tables
--

-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

-- Indexes for table `sbp_comments`
--
ALTER TABLE `sbp_comments`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `sbp_pages`
--
ALTER TABLE `sbp_pages`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `sbp_posts`
--
ALTER TABLE `sbp_posts`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `sbp_users`
--
ALTER TABLE `sbp_users`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT for dumped tables
--

-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

-- AUTO_INCREMENT for table `sbp_comments`
--
ALTER TABLE `sbp_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

-- AUTO_INCREMENT for table `sbp_pages`
--
ALTER TABLE `sbp_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- AUTO_INCREMENT for table `sbp_posts`
--
ALTER TABLE `sbp_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

-- AUTO_INCREMENT for table `sbp_users`
--
ALTER TABLE `sbp_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

```
---

### 4. Configure Database Connection

Edit sbp-admin/credentials.php

```php
<?php
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$database = "sbp";
```
---
### 5. Configure Variables:

Edit sbp-contents/globalVar.php

```php
<?php
// Website Link
$website = 'http://yourdomain.com'; 
$imgUploads = $website . '/assets/uploads'; 

// Social Links
$fbLink = 'https://facebook.com/yourprofile'; 
$igLink = 'https://instagram.com/yourprofile';
$xLink =  'https://x.com/yourprofile';
$ldLink = 'https://linkedin.com/in/yourprofile';
$gitLink = 'https://github.com/yourprofile';
?>

```
---
### 6. Default Admin Account:

Access your Dashboard from:
[URL: http://yourdomain.com/sbp-admin/dashboard/](URL: http://yourdomain.com/sbp-admin/dashboard/)

Username: admin
Password: info
---
### Project Structure

sbp/
├── assets/                    # Static assets
│   ├── css/                   # Stylesheets
│   ├── js/                    # JavaScript files
│   ├── img/                   # Images
│   ├── fonts/                 # Font files
│   └── uploads/               # User uploaded content
│
├── sbp-admin/                 # Admin backend
│   ├── credentials.php        # Database configuration
│   ├── dashboard/             # Admin dashboard
│   │   ├── index.php          # Dashboard home
│   │   ├── login/             # Login page
│   │   ├── editPost.php       # Edit blog posts
│   │   ├── editPage.php       # Edit pages
│   │   ├── editUser.php       # Edit users
│   │   ├── logout.php         # Logout handler
│   │   ├── components/        # Reusable components
│   │   └── assets/            # Admin-specific assets
│   ├── edit.php               # Post editing
│   └── uploadpost.php         # Post upload handler
│
├── sbp-contents/              # Content templates
│   ├── globalVar.php          # Global variables
│   ├── top-header.php         # Header component
│   ├── footer.php             # Footer component
│   ├── sidebar.php            # Sidebar widget
│   ├── nav-contents.php       # Navigation menu
│   ├── trending-area.php      # Trending posts section
│   ├── template.php           # Single post template
│   ├── template-page.php      # Page template
│   ├── comments_template.php  # Comments section
│   ├── load-more.php          # Ajax load more
│   ├── importCss.php          # CSS imports
│   └── importJs.php           # JS imports
│
├── new/                       # User registration
│   └── register/              # Registration page
│
├── index.php                  # Homepage
├── category.php               # Category archive
├── author.php                 # Author archive
├── 404.php                    # 404 error page
├── contact_process.php        # Contact form handler
├── send-mail.php              # Email functionality
├── .htaccess                  # Apache configuration
└── README.md                  # This file

---

## Troubleshooting & Support

### Common Issues

**Issue**: Database connection fails
**Solution**: Verify credentials in `sbp-admin/credentials.php` and ensure MySQL service is running

**Issue**: Images not uploading
**Solution**: Check permissions on `assets/uploads/` directory (should be 777)

**Issue**: Clean URLs not working
**Solution**: Ensure mod_rewrite is enabled and `.htaccess` is present

**Issue**: Cannot access admin dashboard
**Solution**: use admin as username and info as password

---

### Contact Me:
Email: mail@satym.me
