# SBP - Simple Blogging Platform

A lightweight, self-hosted blogging platform similar to WordPress, built with PHP and MySQL. Clone, configure, and deploy your own blogging website in minutes.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-blue)

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
(2, 'Contact', 'contact', '  <section >\r\n        <div class=\"container\">\r\n            <div class=\"row\">\r\n                <div class=\"col-12\">\r\n                    <h2 class=\"contact-title\">Get in Touch</h2>\r\n                </div>\r\n                <div class=\"col-lg-8\">\r\n                    <form class=\"form-contact contact_form\" action=\"\" method=\"post\" id=\"contactForm\"\r\n                        novalidate=\"novalidate\">\r\n                        <div class=\"row\">\r\n                            <div class=\"col-12\">\r\n                                <div class=\"form-group\">\r\n                                    <textarea class=\"form-control w-100\" name=\"message\" id=\"message\" cols=\"30\" rows=\"9\"\r\n                                        onfocus=\"this.placeholder = \'\'\" onblur=\"this.placeholder = \'Enter Message\'\"\r\n                                        placeholder=\" Enter Message\"></textarea>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-sm-6\">\r\n                                <div class=\"form-group\">\r\n                                    <input class=\"form-control valid\" name=\"name\" id=\"name\" type=\"text\"\r\n                                        onfocus=\"this.placeholder = \'\'\" onblur=\"this.placeholder = \'Enter your name\'\"\r\n                                        placeholder=\"Enter your name\">\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-sm-6\">\r\n                                <div class=\"form-group\">\r\n                                    <input class=\"form-control valid\" name=\"email\" id=\"email\" type=\"email\"\r\n                                        onfocus=\"this.placeholder = \'\'\"\r\n                                        onblur=\"this.placeholder = \'Enter email address\'\" placeholder=\"Email\">\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-12\">\r\n                                <div class=\"form-group\">\r\n                                    <input class=\"form-control\" name=\"subject\" id=\"subject\" type=\"text\"\r\n                                        onfocus=\"this.placeholder = \'\'\" onblur=\"this.placeholder = \'Enter Subject\'\"\r\n                                        placeholder=\"Enter Subject\">\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"form-group mt-3\">\r\n                            <button type=\"submit\" class=\"button button-contactForm boxed-btn\">Send</button>\r\n                        </div>\r\n                    </form>\r\n                </div>\r\n                <div class=\"col-lg-3 offset-lg-1\">\r\n                    <div class=\"media contact-info\">\r\n                        <span class=\"contact-info__icon\"><i class=\"ti-home\"></i></span>\r\n                        <div class=\"media-body\">\r\n                            <h3>Kathmandu, Nepal.</h3>\r\n                            \r\n                        </div>\r\n                    </div>\r\n                    <div class=\"media contact-info\">\r\n                        <span class=\"contact-info__icon\"><i class=\"ti-tablet\"></i></span>\r\n                        <div class=\"media-body\">\r\n                            <h3>+977 9840112337</h3>\r\n                            <p>Mon to Fri 10am to 5pm</p>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"media contact-info\">\r\n                        <span class=\"contact-info__icon\"><i class=\"ti-email\"></i></span>\r\n                        <div class=\"media-body\">\r\n                            <h3>info@satyamregmi.com.np</h3>\r\n                            <p>Send us your query anytime!</p>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </section>', 'satyamregmi', '2024-04-23 09:33:19', 1),

-- --------------------------------------------------------

--
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

--
-- Dumping data for table `sbp_posts`
--

INSERT INTO `sbp_posts` (`id`, `post_title`, `post_contents`, `post_excerpt`, `image`, `slug`, `author`, `date`, `post_category`, `post_tags`) VALUES
(1, 'Green Hydrogen', '<p>&nbsp;</p>\r\n<p>Green hydrogen is a clean and sustainable fuel that has gained significant attention in recent years. It is a type of hydrogen fuel that is produced using renewable energy sources, such as solar and wind power. Green hydrogen has the potential to revolutionize the energy industry by providing a clean, reliable, and cost-effective alternative to fossil fuels. In this blog post, we will explore what green hydrogen is, how it is produced, and its potential uses. <br><br>What is Green Hydrogen? <br><br>Hydrogen is the most abundant element in the universe, but it is rarely found in its pure form on Earth. Instead, it is typically found in combination with other elements, such as oxygen in water (H2O). Hydrogen can be extracted from water through a process called electrolysis, which involves passing an electric current through water to break it down into its component elements. <br><br>Green hydrogen is produced through a process called electrolysis using electricity from renewable sources like wind, solar, or hydroelectric power. This means that the production of green hydrogen does not generate any greenhouse gas emissions or other pollutants. <br><br>How is Green Hydrogen Produced? <br><br>Green hydrogen is produced through a process called electrolysis, which involves passing an electric current through water to separate it into its component elements of hydrogen and oxygen. The electricity used in this process is generated from renewable sources such as wind, solar, or hydroelectric power. The process of producing green hydrogen can be summarized in the following steps: <br><br>Water is first purified to remove any impurities that may interfere with the electrolysis process. The purified water is then fed into an electrolyzer. An electric current is passed through the water, splitting it into its component elements of hydrogen and oxygen. The hydrogen is then collected and stored in high-pressure tanks for use in fuel cells or other applications. Green hydrogen can also be produced using other renewable energy sources such as biomass, geothermal energy, and tidal energy. However, these methods are not as common as using solar or wind power. <br><br>Potential Uses of Green Hydrogen <br><br>Green hydrogen has the potential to be used in a variety of applications, including transportation, industry, and energy storage. Here are some examples: <br><br>Transportation: <br>Hydrogen fuel cell vehicles are a promising alternative to traditional gasoline-powered cars. They produce no emissions other than water vapor and can be refueled in a matter of minutes. Green hydrogen can be produced on-site at hydrogen fueling stations, making it an attractive option for transportation. <br><br>Industry: <br>Green hydrogen can be used in a variety of industrial applications, including steelmaking, chemical production, and power generation. Using green hydrogen in these industries would significantly reduce carbon emissions and support the transition to a more sustainable future. <br><br>Energy storage:<br>One of the challenges of renewable energy sources like solar and wind power is that they are intermittent. Green hydrogen can be used to store excess renewable energy when it is produced and then used to generate electricity when it is needed. This could help to make renewable energy more reliable and cost-effective. <br><br>Conclusion<br><br>Green hydrogen has the potential to be a game-changer in the energy industry. It is a clean, reliable, and cost-effective alternative to fossil fuels, and its production does not generate any greenhouse gas emissions or other pollutants. As the world looks for ways to reduce carbon emissions and transition to a more sustainable future, green hydrogen is emerging as a promising solution.</p>\r\n<p>&nbsp;</p>', 'Green hydrogen is a clean and sustainable fuel that has gained significant attention in recent years. It is a type of hydrogen fuel that is produced using renewable energy sources, such as solar and wind power.', 0x677265656e2d68322e6a706567, 'green-hydrogen', 'satyamregmi', '2023-02-10', 'updates', 'Green Hydrogen'),
(2, 'Devin World\'s First AI Software Engineer', '<p>The worlds first fully autonomous powerful AI Software Engineer is here, \"Devin\", created by US-based startup Cognition AI. Devin uses machine learning algorithms to perform coding, debugging, and problem-solving tasks, and can write code and create websites with a single prompt. Devin can also continually learn and improve its performance, adapting to new challenges.</p>\r\n<div>\r\n<div>\r\n<div data-ved=\"2ahUKEwiR-5Cp3vWEAxWtUGwGHbsRCDIQo_EKegQIARAA\" data-hveid=\"CAEQAA\" data-attrid=\"SGEParagraphFeedback\">Devin is designed to help human engineers, not replace them.&nbsp;Devin\'s capabilities include:</div>\r\n</div>\r\n</div>\r\n<div>\r\n<div>\r\n<ul data-ved=\"2ahUKEwiR-5Cp3vWEAxWtUGwGHbsRCDIQm_YKegQIBBAA\" data-hveid=\"CAQQAA\">\r\n<li data-attrid=\"SGEListItem\">Writing code:&nbsp;Devin can write code and create websites and software.&nbsp;It can write and deploy hundreds of lines of code with a single prompt.</li>\r\n<li data-attrid=\"SGEListItem\">Debugging:&nbsp;Devin can alter the way code is debugged.</li>\r\n<li data-attrid=\"SGEListItem\">Problem-solving:&nbsp;Devin can perform complex engineering tasks using a code editor, web browser, and its own shell.</li>\r\n<li data-attrid=\"SGEListItem\">Learning:&nbsp;Devin can learn from its mistakes and adapt to new challenges.</li>\r\n<li data-attrid=\"SGEListItem\">Planning:&nbsp;Devin can think ahead and plan complex tasks.</li>\r\n<li data-attrid=\"SGEListItem\">Learning new technologies: Devin can learn new technologies.&nbsp;</li>\r\n</ul>\r\n<p>Devin functions within a secure sandbox.&nbsp;It has a chatbot-style interface that requires the user to prompt what code they want. Devin then creates a step-by-step strategy to solve the problem. The user can make changes or recommendations based on their preferences. Devin AI boasts advanced capabilities in software development, including&nbsp;<strong>coding, debugging, problem-solving, and more</strong>. Powered by machine learning algorithms, Devin AI can continually learn and improve its performance, adapting to new challenges with ease.</p>\r\n<div>\r\n<div>\r\n<div data-ved=\"2ahUKEwji8MP94PWEAxXwbWwGHXpEDhMQo_EKegQIAxAA\" data-hveid=\"CAMQAA\" data-attrid=\"SGEParagraphFeedback\">Cognition describes Devin as a \"teammate\" and does not market it as a replacement for human software engineers.&nbsp;\r\n<div data-cid=\"_aPrzZeKcLvDbseMP-oi5mAE_4\">\r\n<div tabindex=\"0\" role=\"button\" data-ved=\"2ahUKEwji8MP94PWEAxXwbWwGHXpEDhMQ3fYKegQIBxAA\" data-hveid=\"CAcQAA\" aria-label=\"Expand\">\r\n<div>\r\n<div>&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div>\r\n<div>\r\n<div data-ved=\"2ahUKEwji8MP94PWEAxXwbWwGHXpEDhMQo_EKegQIAhAA\" data-hveid=\"CAIQAA\" data-attrid=\"SGEParagraphFeedback\">Devin is currently in early access, and is not publicly available. You can request early access to Devin by filling out a <a href=\"https://docs.google.com/forms/d/e/1FAIpQLScHG0Kuxf9rVLR2Ceamr9qq85YLxKPx8fxdQeBr5TwvYEsPUg/viewform\">Google form</a>.&nbsp;You can also contact Cognition via email at info@cognition-labs.com for updates or access-related issues.&nbsp;\r\n<div data-cid=\"_aPrzZeKcLvDbseMP-oi5mAE_9\">\r\n<div tabindex=\"0\" role=\"button\" data-ved=\"2ahUKEwji8MP94PWEAxXwbWwGHXpEDhMQ3fYKegQIBhAA\" data-hveid=\"CAYQAA\" aria-label=\"Expand\">\r\n<div>\r\n<div>&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div>\r\n<div>\r\n<div data-ved=\"2ahUKEwji8MP94PWEAxXwbWwGHXpEDhMQo_EKegQIARAA\" data-hveid=\"CAEQAA\" data-attrid=\"SGEParagraphFeedback\">According to Coursera, there is a projected 23 percent job growth for AI engineers between 2022 and 2032, which is much faster than the average for all occupations (5 percent).&nbsp;AI engineers typically work for companies helping them improve their products, software, operations, and delivery.</div>\r\n</div>\r\n</div>\r\n<p>The website for Devin AI is: <a title=\"Devin Ai | Cognition Labs website\" href=\"https://cognition-labs.com\" target=\"_blank\" rel=\"noopener\">Cognition Labs.</a></p>\r\n<p>&nbsp;</p>\r\n</div>\r\n</div>', '', 0x646576696e2d61692e6a706567, 'devin-worlds-first-ai-software-engineer', 'satyamregmi', '2024-03-15', 'technology', 'ai, devin ai, ai software engineer, powerful ai engineer, chat gpt, gemini, human and ai'),
(22, 'Google Eying to Buy HubSpot: Stock Alert!', '<p>HubSpot is a prominent software company specializing in inbound marketing, sales, and customer service solutions. Established in 2006, HubSpot has become a leader in digital marketing and customer relationship management (CRM). Its offerings include a suite of tools for inbound marketing, social media marketing, email marketing, SEO, and analytics. The Sales Hub provides features for contact management, email tracking, pipeline management, and sales analytics, aiding sales teams in streamlining workflows and closing deals effectively.</p>\r\n<p>The Service Hub assists businesses in delivering exceptional customer service through ticketing, live chat, knowledge base, customer feedback, and automation. HubSpot also offers a free CRM platform that integrates seamlessly with its other tools, allowing businesses to manage customer interactions and track leads and deals.&nbsp;</p>\r\n<p>The company has fostered a robust ecosystem of third-party integrations and partnerships, enabling users to customize their marketing, sales, and service processes according to their needs. Overall, HubSpot empowers businesses to attract, engage, and delight customers through personalized experiences and inbound marketing strategies.</p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"color: #1378f1;\"><span style=\"color: #000000;\">HubSpot Inc (HUBS)</span></span> stock is seeing a rise on Thursday as investors consider reports hinting that the cloud-based customer relationship management company might be bought by Alphabet Inc (GOOGLE).</p>\r\n<p>Insiders say Alphabet is talking with advisor Morgan Stanley about a possible offer for HubSpot. We\'re not sure yet how much Alphabet might spend to buy HubSpot.&nbsp;<em>(Morgan Stanley is an American multinational investment bank and financial services company)&nbsp;</em></p>\r\n<p>&nbsp;</p>\r\n<p>HubSpot is valued at about $32 billion. So, any offer from Alphabet would probably be higher than that. Alphabet can afford it, though, with $110.9 billion in cash.</p>\r\n<p>But there might be issues. Antitrust regulators could step in and make things tricky. Alphabet is seeking advice from Morgan Stanley on how to deal with this, according to reports from Reuters.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>So, what does this mean for HUBS stock?</strong></p>\r\n<p>Well, with a possible deal in the works, we might see more activity around HUBS stock in the coming days. This morning alone, over 1.4 million shares of HUBS stock were traded, which is more than usual.</p>\r\n<p>As of Thursday morning, HUBS stock is up by 9.29%. And since the beginning of the year, it\'s gone up by more than 23.5%.</p>\r\n<p>&nbsp;</p>\r\n<p>Just to let you know, publisher of this article, doesn\'t have any investments in the companies mentioned here. These are just opinions, following the guidelines of&nbsp;<a title=\"Visit\" href=\"https://investorplace.com/stock-quotes/hubs-stock-quote/\" target=\"_blank\" rel=\"noopener\"><span style=\"color: #1378f1;\">InvestorPlace.com</span></a>.</p>', '', 0x53637265656e73686f7420323032342d30342d30342061742032322e31382e30302e706e67, 'google-eying-to-buy-hubspot-stock-alert', 'satyamregmi', '2024-04-04', 'updates', 'hubspot, google, stock, share market, google buying hubspot, trends'),
(23, 'Virtual Reality', '<p>What is VR?<br style=\"list-style-type: none;\">Virtual reality (VR) is a computer-generated simulation of a real world environment. In virtual reality, users wear headsets that display computer graphics representing their surroundings. These graphics may simulate visual perception, sound, touch, smell, taste, or movement. Virtual reality technology creates a fully immersive experience where the user feels they are actually present in the simulated environment.<br style=\"list-style-type: none;\"><br style=\"list-style-type: none;\">2. How does VR work?<br style=\"list-style-type: none;\">The brain interprets what it sees as real, even though it\'s not. When we look at something, our brains send signals to our eyes, ears, nose, and tongue to tell us what we\'re seeing. Our brain then processes these signals and makes sense of them. But if we don\'t have any sensory information coming in, our brain doesn\'t know what\'s going on. So, when we put on a headset, we get all kinds of data about the outside world. We hear sounds, feel textures, and see images. Our brain then takes all of this information and combines it together to make sense of it.<br style=\"list-style-type: none;\"><br style=\"list-style-type: none;\">3. Why do people use VR?<br style=\"list-style-type: none;\">People use VR for many reasons, including entertainment, education, training, therapy, and research. People who use VR for entertainment enjoy experiencing different worlds without leaving home. VR games let players explore new places and meet new characters. VR movies allow viewers to step inside the story. And VR simulations help train surgeons before performing surgery.<br style=\"list-style-type: none;\"><br style=\"list-style-type: none;\">4. How can I use VR?<br style=\"list-style-type: none;\">You can use VR for many things, including gaming, watching videos, exploring new environments, and learning new skills. You can find VR hardware online and in stores. There are two types of VR systems: tethered and untethered. A tethered system requires a PC or console to power the device. An untethered system uses its own battery and works independently of a computer or console.<br style=\"list-style-type: none;\"><br style=\"list-style-type: none;\">5. What are some examples of VR experiences?<br style=\"list-style-type: none;\">There are many ways to use VR, including:<br style=\"list-style-type: none;\">&nbsp; &nbsp; &nbsp;&bull; Playing video games<br style=\"list-style-type: none;\">&nbsp; &nbsp; &nbsp;&bull; Watching movies<br style=\"list-style-type: none;\">&nbsp; &nbsp; &nbsp;&bull; Exploring nature<br style=\"list-style-type: none;\">&nbsp; &nbsp; &nbsp;&bull; Learning how to play instruments<br style=\"list-style-type: none;\">&nbsp; &nbsp; &nbsp;&bull; Training for sports<br style=\"list-style-type: none;\">&nbsp; &nbsp; &nbsp;&bull; Creating art<br style=\"list-style-type: none;\">&nbsp; &nbsp; &nbsp;&bull; Immersing yourself in a fantasy world<br style=\"list-style-type: none;\">&nbsp; &nbsp; &nbsp;&bull; Traveling to distant lands<br style=\"list-style-type: none;\">&nbsp; &nbsp; &nbsp;&bull; Seeing the future<br style=\"list-style-type: none;\">&nbsp; &nbsp; &nbsp;&bull; Teleporting<br style=\"list-style-type: none;\">&nbsp; &nbsp; &nbsp;&bull; Being transported to another time and place</p>', '', 0x7669727475616c2d7265616c6974792e6a706567, 'virtual-reality', 'satyamregmi', '2022-05-13', 'technology', 'virtual reality, vr, ai'),
(24, 'All Nepali News (ANN)', '<p><strong>### About</strong></p>\r\n<p><br>The All Nepali News app is a single platform for the most recent news from Nepal. For your convenience, we\'ve gathered news from a number of reliable sources in one place. This simple application makes sure you never miss a news, regardless of your interests in politics, sports, entertainment, or business.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>### Disclaimer</strong></p>\r\n<p><br>The goal of the impartial website All Nepali News is to increase news accessibility. We don\'t support or recommend any one news media outlet over another. We fully attribute all content to its individual writers and organisations, and all content is sourced straight from legitimate news sources. Our objective is to give you an easy way to stay informed without changing the news\' original viewpoints.</p>', '<strong>About</strong><p><br>The All Nepali News app is a single platform for the mos...', 0x414e4e2e706e67, 'all-nepali-news', 'satyamregmi', '2024-06-28', 'Updates', 'All nepali news, ANN'),
(25, 'The Secret to Mastering Your Thoughts and Emotions for a Better Life', '<p>Gaining control of your mind and thoughts is a powerful practice that can improve your emotional well-being, focus, and decision-making abilities. Here are a few practical strategies to help you get better control:</p>\r\n<p><br>&nbsp;<strong>1. Mindfulness Meditation</strong><br>Mindfulness involves looking into your thoughts without judging. It\'s about being present in the moment and learning to separate from your constant flow of ideas.<br>&nbsp; &nbsp;How it helps: Meditation teaches your brain to identify when you\'re being consumed by negative or distracting thoughts. Over time, you\'ll gain more awareness and control over them.<br>&nbsp; How to get started: Set aside 5-10 minutes each day to sit quietly, concentrate on your breathing, and notice your thoughts without reacting to them. When your thoughts get lost, gently bring them back to your breathing.</p>\r\n<p><strong>2. Cognitive-Behavioral Techniques (CBT)</strong><br>CBT is a technique for identifying and confronting negative or unwanted thoughts. It involves noticing automatic thoughts, analyzing their legitimacy, and replacing them with healthier, wholesome thoughts.<br><em>How it works:</em> It helps you become more conscious of skewed thinking (such as all-or-nothing thinking and worrying) and develop healthier, more objective thought habits.<br><em>How to get started:</em> When you have a negative or disturbing thought, ask yourself:<br>&nbsp; &nbsp; &nbsp;&gt;&gt; Is this thought based on facts or assumptions?<br>&nbsp; &nbsp; &nbsp;&gt;&gt; What is the evidence for and against this thought?<br>&nbsp; &nbsp; &nbsp;&gt;&gt; How would I feel if I thought about it differently?</p>\r\n<p><strong>3. Practice positive affirmations.</strong><br>Positive affirmations are positive words that you repeat to challenge and alter/change negative or self-limiting beliefs.</p>\r\n<p><em>How it works:</em> Repeating affirmations can reorganize the subconscious mind to prioritize self-empowerment, resilience, and good results.<br><em>How to get started:</em> Choose affirmations that speak to you (e.g., \"I am in control of my thoughts\" or \"I handle challenges with confidence\") and repeat them regularly.</p>\r\n<p><strong>4. Mindful breathing.</strong><br><em>What is it?</em> It\'s a basic approach for calming the mind and regaining attention on your breath.<br>Breathing deeply can help break negative thought cycles, reduce anxiety, and improve focus.<br><em>How to get started: </em>Try the 4-7-8 technique. Breathe in for 4 counts, hold for 7 counts, then gently exhale for 8 counts. Repeat for a few minutes.</p>\r\n<p><strong>5. Visualization</strong><br>Visualization involves picturing yourself attaining goals or coping with difficulties calmly and confidently.<br>It trains your mind to think positively and helps you overcome self-doubt.<br><em>How to get started:</em> Close your eyes and vividly imagine a situation in which you are in control and succeeding, utilizing all of your senses to make it feel its happening in real life.</p>\r\n<p><strong>6. Self-Awareness and Journaling</strong><br>Journaling involves writing down your thoughts, emotions, feelings and experiences. It allows you to better understand your mental thinking pattern and triggers.<br>Writing increases awareness of your cognitive processes, making it easier to challenge and change them.<br>To get started, Every day, take a few minutes to jot down any relevant thoughts, feelings, or patterns you\'ve noticed. Consider what triggered those thoughts and how you can change them. You can make this as your note or blog.</p>\r\n<p><strong>7. Limit Negative inputs</strong><br>Being aware of the stuff you encounter (e.g., news, social media) and how it influences your thinking.<br><em>How it helps:</em> Reducing your exposure to negativity can help keep your mind from becoming overwhelmed by anxiety, stress, worry, and pessimistic thinking.<br><em>How to get started:</em> Choose to consume uplifting or neutral information, restrict your time on social media, and be careful of the people and situations you interact with. Set limit to social media or block the pages that promotes negative informations.</p>\r\n<p><strong>8. Self-compassion</strong><br>Treating yourself with the same compassion and understanding that you would show a friend, especially during difficult times.<br>Self-compassion decreases self-criticism and allows you to better manage negative emotions.<br>Practice speaking kindly to yourself, especially when you make errors or are upset. Instead of being rude or judgmental, show yourself compassion and understanding. <em>(This is the best practice that I highly recommend)</em></p>\r\n<p><br><strong>9. Concentrate on what you can control</strong><br>Instead than worrying about external situations, focus your energy on what you can control.<br>It relieves tension and anxiety, leaving you feeling more empowered and less overwhelmed.<br><em>How to get started: </em>Ask yourself, \"What can I do right now to improve this situation?\" Instead of obsessing over problems beyond your control, focus your attention on doing action.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Key Takeaways:</strong><br>To gain control of your mind and thoughts, you must become more aware of what is going on in your mind, shift negative thought patterns, and practice practices that encourage attention, calmness, and optimism. With regular effort, these activities can help you gain control of your mental and emotional states, resulting in greater calm and clarity.&nbsp;</p>\r\n<p><em>Celebrities, leaders, founders, and public speakers often practice the points described above. Whenever you feel down, take a deep breath and recall the points listed above.</em></p>', '<p>Gaining control of your mind and thoughts is a powerful practice that can improve your emotional ...', 0x7375625f6d696e642e6a706567, 'the-secret-to-mastering-your-thoughts-and-emotions-for-a-better-life', 'satyamregmi', '2024-11-06', 'thoughts', 'meditation ,migraine-predictive-aq, mentalhealth-comorbidity, controlling emotions'),
(26, 'Top 10 Python OOPs Questions, Answers and Explanation', '<p><strong>1. Classes and Objects:</strong></p>\r\n<pre class=\"language-python\"><code>class Animal:\r\n    def __init__(self, name):\r\n        self.name = name\r\n\r\n    def speak(self):\r\n        print(f\"{self.name} makes a sound.\")\r\n\r\nclass Dog(Animal):\r\n    def speak(self):\r\n        print(f\"{self.name} barks!\")\r\n\r\ndog = Dog(\"Buddy\")\r\ndog.speak()\r\n</code></pre>\r\n<p><strong>Question: What will be the output of the code above?</strong></p>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>Ans: Buddy Barks</p>\r\n</details>\r\n<p>&nbsp;</p>\r\n<p><strong>2. Encapsulation</strong></p>\r\n<pre class=\"language-python\"><code>class Account:\r\n    def __init__(self, owner, balance=0):\r\n        self.__owner = owner\r\n        self.__balance = balance\r\n\r\n    def deposit(self, amount):\r\n        self.__balance += amount\r\n\r\n    def withdraw(self, amount):\r\n        if amount &lt;= self.__balance:\r\n            self.__balance -= amount\r\n        else:\r\n            print(\"Insufficient funds.\")\r\n\r\n    def get_balance(self):\r\n        return self.__balance\r\n\r\nacc = Account(\"Alice\", 1000)\r\nacc.deposit(500)\r\nacc.withdraw(300)\r\nprint(acc.get_balance())\r\n</code></pre>\r\n<p><strong>Question:&nbsp;</strong></p>\r\n<ul>\r\n<li>What is the purpose of the double underscores (<code>__</code>) before the variable names?</li>\r\n</ul>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>The purpose of double underscore(__) is to indicate it as <strong>private </strong>vars<strong> </strong>to class.</p>\r\n</details>\r\n<ul>\r\n<li>What will be the final output after the operations on the <code>Account</code> class?</li>\r\n</ul>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>1200</p>\r\n</details>\r\n<p>&nbsp;</p>\r\n<p><strong>3. Inheritance and Method Overriding</strong></p>\r\n<pre class=\"language-python\"><code>class Shape:\r\n    def area(self):\r\n        pass\r\n\r\nclass Circle(Shape):\r\n    def __init__(self, radius):\r\n        self.radius = radius\r\n\r\n    def area(self):\r\n        return 3.14 * self.radius ** 2\r\n\r\nclass Square(Shape):\r\n    def __init__(self, side):\r\n        self.side = side\r\n\r\n    def area(self):\r\n        return self.side ** 2\r\n\r\ncircle = Circle(5)\r\nsquare = Square(4)\r\nprint(circle.area())\r\nprint(square.area())\r\n</code></pre>\r\n<p><strong>Question:&nbsp;</strong></p>\r\n<ul>\r\n<li>What will the output be when calling <code>circle.area()</code> and <code>square.area()</code>?</li>\r\n</ul>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>78.5<br>16</p>\r\n</details>\r\n<p>&nbsp;</p>\r\n<p><strong>4. Polymorphism</strong></p>\r\n<pre class=\"language-python\"><code>class Bird:\r\n    def fly(self):\r\n        print(\"Bird is flying.\")\r\n\r\nclass Airplane:\r\n    def fly(self):\r\n        print(\"Airplane is flying.\")\r\n\r\ndef make_it_fly(flyable):\r\n    flyable.fly()\r\n\r\nbird = Bird()\r\nplane = Airplane()\r\n\r\nmake_it_fly(bird)\r\nmake_it_fly(plane)\r\n</code></pre>\r\n<p>Question: What will be the output?</p>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>Bird is flying.<br>Airplane is flying.</p>\r\n<p>&nbsp;</p>\r\n</details>\r\n<p>&nbsp;</p>\r\n<p><strong>5. Abstraction</strong></p>\r\n<pre class=\"language-python\"><code>from abc import ABC, abstractmethod\r\n\r\nclass Animal(ABC):\r\n    @abstractmethod\r\n    def speak(self):\r\n        pass\r\n\r\nclass Cat(Animal):\r\n    def speak(self):\r\n        print(\"Meow\")\r\n\r\nclass Dog(Animal):\r\n    def speak(self):\r\n        print(\"Woof\")\r\n\r\ncat = Cat()\r\ndog = Dog()\r\ncat.speak()\r\ndog.speak()\r\n</code></pre>\r\n<p><strong>Questions:&nbsp;</strong></p>\r\n<ul>\r\n<li>What is the purpose of the <code>@abstractmethod</code> decorator?</li>\r\n</ul>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p><code>Animal</code> class is decorated with <code>@abstractmethod</code>, which means:</p>\r\n<ol>\r\n<li>Any class that inherits from <code>Animal</code> <strong>must</strong> provide its own implementation of the <code>speak()</code> method.</li>\r\n<li>If a subclass does not implement this method, Python will raise an error when trying to instantiate that subclass.</li>\r\n</ol>\r\n</details>\r\n<ul>\r\n<li>Why can&rsquo;t you create an instance of the <code>Animal</code> class directly?</li>\r\n</ul>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>You cannot create an instance of the Animal class directly because Animal is an abstract class.An abstract class is a class that is not meant to be instantiated on its own; it&rsquo;s a&nbsp;blueprint for other classes.</p>\r\n</details>\r\n<p>&nbsp;</p>\r\n<p><strong>6. Constructor Overloading</strong></p>\r\n<pre class=\"language-python\"><code>class MyClass:\r\n    def __init__(self, value=0):\r\n        self.value = value\r\n\r\n    def show(self):\r\n        print(f\"Value: {self.value}\")\r\n\r\nobj1 = MyClass()\r\nobj2 = MyClass(10)\r\n\r\nobj1.show()\r\nobj2.show()\r\n</code></pre>\r\n<p><strong>Question: What is the default value for <code>value</code> if no argument is passed to the constructor?</strong></p>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>0</p>\r\n</details>\r\n<p><strong>Question: What will be the output?</strong></p>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>0</p>\r\n<p>10</p>\r\n</details>\r\n<p>&nbsp;</p>\r\n<p><strong>7. Class Variables vs Instance Variables</strong></p>\r\n<pre class=\"language-python\"><code>class Employee:\r\n    company_name = \"XYZ Corp\"  # class variable\r\n\r\n    def __init__(self, name, position):\r\n        self.name = name        # instance variable\r\n        self.position = position # instance variable\r\n\r\nemployee1 = Employee(\"Alice\", \"Manager\")\r\nemployee2 = Employee(\"Bob\", \"Developer\")\r\n\r\nprint(employee1.company_name)\r\nprint(employee2.company_name)\r\n</code></pre>\r\n<p><strong>Question: What will the output be when accessing <code>employee1.company_name</code> and <code>employee2.company_name</code>?</strong></p>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>XYZ Corp</p>\r\n<p>XYZ Corp</p>\r\n<p>&nbsp;</p>\r\n</details>\r\n<p>&nbsp;</p>\r\n<p><strong>8. Multiple Inheritance:</strong></p>\r\n<pre class=\"language-python\"><code>class Animal:\r\n    def eat(self):\r\n        print(\"Eating food.\")\r\n\r\nclass Mammal:\r\n    def walk(self):\r\n        print(\"Walking on land.\")\r\n\r\nclass Human(Animal, Mammal):\r\n    def speak(self):\r\n        print(\"Speaking in human language.\")\r\n\r\nperson = Human()\r\nperson.eat()\r\nperson.walk()\r\nperson.speak()\r\n</code></pre>\r\n<p><strong>Question: What will be the output?</strong></p>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>Eating food.<br>Walking on land.<br>Speaking in human language.</p>\r\n</details>\r\n<p>&nbsp;</p>\r\n<p><strong>9. Static Methods</strong></p>\r\n<pre class=\"language-python\"><code>class Math:\r\n    @staticmethod\r\n    def add(a, b):\r\n        return a + b\r\n\r\n    @staticmethod\r\n    def multiply(a, b):\r\n        return a * b\r\n\r\nresult1 = Math.add(10, 5)\r\nresult2 = Math.multiply(4, 3)\r\n\r\nprint(result1)\r\nprint(result2)\r\n</code></pre>\r\n<p><strong>Question</strong>:</p>\r\n<ol>\r\n<li>What is the purpose of using the <code>@staticmethod</code> decorator?</li>\r\n</ol>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>The <code>@staticmethod</code> decorator is used to define a <strong>static method</strong> in a class. A static method:</p>\r\n<ul>\r\n<li>Does not require access to any instance or class-specific data (i.e., it does not take <code>self</code> or <code>cls</code> as the first parameter).</li>\r\n<li>Can be called directly on the <strong>class</strong> without needing to create an instance of the class.</li>\r\n<li>Is typically used for operations that are related to the class but do not need access to instance-specific data.</li>\r\n</ul>\r\n<p>In the case of this code:</p>\r\n<ul>\r\n<li>The <code>add()</code> and <code>multiply()</code> methods are <strong>static methods</strong>, meaning they perform the addition and multiplication operations without depending on any instance variables of the <code>Math</code> class.</li>\r\n<li>You can call these methods directly on the class (like <code>Math.add(10, 5)</code>), rather than having to create an instance of <code>Math</code>.</li>\r\n</ul>\r\n</details>\r\n<p>&nbsp; &nbsp; &nbsp; 2. What will the output be when <code>Math.add(10, 5)</code> and <code>Math.multiply(4, 3)</code> are called?</p>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>15</p>\r\n<p>12</p>\r\n</details>\r\n<p>&nbsp;</p>\r\n<p><strong>10. Property Decorator</strong></p>\r\n<pre class=\"language-python\"><code>class Rectangle:\r\n    def __init__(self, width, height):\r\n        self._width = width\r\n        self._height = height\r\n\r\n    @property\r\n    def area(self):\r\n        return self._width * self._height\r\n\r\nrect = Rectangle(10, 5)\r\nprint(rect.area)\r\n</code></pre>\r\n<p>Question: What does the <code>@property</code> decorator do in this code?</p>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>The <code>@property</code> decorator is used to define a <strong>read-only property</strong> in a class, which allows you to access a method like an <strong>attribute</strong> without explicitly calling it as a method (i.e., without using parentheses).</p>\r\n<p>In this case, the <code>@property</code> decorator is applied to the <code>area</code> method in the <code>Rectangle</code> class, making it accessible as a <strong>property</strong>. This means:</p>\r\n<ul>\r\n<li>Instead of needing to call <code>rect.area()</code> like a regular method, you can access it directly using <code>rect.area</code>, just like you would with an attribute (without parentheses).</li>\r\n<li>It provides a way to compute or retrieve a value on the fly, while still allowing you to access it in a clean and simple manner, as if it were just a regular attribute.</li>\r\n</ul>\r\n</details>\r\n<p>Question: What will be output?</p>\r\n<details class=\"mce-accordion\">\r\n<summary>Show Answer</summary>\r\n<p>50</p>\r\n</details>', '1. Classes and Objects:', 0x2e2e2f2e2e2f6173736574732f75706c6f6164732f53637265656e73686f7420323032352d30312d32382061742031372e31362e35312e706e67, 'top-10-python-oops-questions-answers-and-explanation', '', '2025-01-27', 'python', 'python, code, interview, oops');
INSERT INTO `sbp_posts` (`id`, `post_title`, `post_contents`, `post_excerpt`, `image`, `slug`, `author`, `date`, `post_category`, `post_tags`) VALUES
(27, 'Python Dunder - Questions and Simple Explanation with output', '<p dir=\"ltr\"><strong>Dunder Methods:</strong></p>\r\n<p dir=\"ltr\">In python &ldquo;dunder methods&rdquo; (double underscore methods) are special method that allows us to define how objects of our class behave when used in various operations (like add, subtract, comparison, etc).</p>\r\n<p dir=\"ltr\">Common Dunder methods:</p>\r\n<div dir=\"ltr\" align=\"left\">\r\n<pre class=\"language-python\"><code>class DunderExample:\r\n    def __init__(self, value):\r\n        self.value = value\r\n    \r\n    # String representation\r\n    def __repr__(self):\r\n        return f\"DunderExample({self.value!r})\"\r\n    \r\n    def __str__(self):\r\n        return f\"Value: {self.value}\"\r\n    \r\n    # Arithmetic operations\r\n    def __add__(self, other):\r\n        return DunderExample(self.value + other.value)\r\n    \r\n    def __sub__(self, other):\r\n        return DunderExample(self.value - other.value)\r\n    \r\n    def __mul__(self, other):\r\n        return DunderExample(self.value * other.value)\r\n    \r\n    def __truediv__(self, other):\r\n        return DunderExample(self.value / other.value)\r\n    \r\n    def __floordiv__(self, other):\r\n        return DunderExample(self.value // other.value)\r\n    \r\n    def __mod__(self, other):\r\n        return DunderExample(self.value % other.value)\r\n    \r\n    def __pow__(self, other):\r\n        return DunderExample(self.value ** other.value)\r\n    \r\n    # Comparison operations\r\n    def __eq__(self, other):\r\n        return self.value == other.value\r\n    \r\n    def __ne__(self, other):\r\n        return self.value != other.value\r\n    \r\n    def __lt__(self, other):\r\n        return self.value &lt; other.value\r\n    \r\n    def __le__(self, other):\r\n        return self.value &lt;= other.value\r\n    \r\n    def __gt__(self, other):\r\n        return self.value &gt; other.value\r\n    \r\n    def __ge__(self, other):\r\n        return self.value &gt;= other.value\r\n    \r\n    # Unary operations\r\n    def __neg__(self):\r\n        return DunderExample(-self.value)\r\n    \r\n    def __pos__(self):\r\n        return DunderExample(+self.value)\r\n    \r\n    def __abs__(self):\r\n        return DunderExample(abs(self.value))\r\n    \r\n    def __invert__(self):\r\n        return DunderExample(~self.value)\r\n    \r\n    # Container methods\r\n    def __len__(self):\r\n        return len(str(self.value))\r\n    \r\n    def __getitem__(self, key):\r\n        return str(self.value)[key]\r\n    \r\n    def __setitem__(self, key, value):\r\n        value = str(self.value)\r\n        self.value = int(value[:key] + str(value[key]) + value[key+1:])\r\n    \r\n    def __delitem__(self, key):\r\n        value = str(self.value)\r\n        self.value = int(value[:key] + value[key+1:])\r\n    \r\n    def __iter__(self):\r\n        return iter(str(self.value))\r\n    \r\n    def __contains__(self, item):\r\n        return str(item) in str(self.value)\r\n    \r\n    # Context management\r\n    def __enter__(self):\r\n        print(\"Entering context\")\r\n        return self\r\n    \r\n    def __exit__(self, exc_type, exc_value, traceback):\r\n        print(\"Exiting context\")\r\n    \r\n    # Callable\r\n    def __call__(self):\r\n        return f\"Called with value: {self.value}\"\r\n    \r\n    # Property methods\r\n    def __get__(self, instance, owner):\r\n        return self.value\r\n    \r\n    def __set__(self, instance, value):\r\n        self.value = value\r\n    \r\n    def __delete__(self, instance):\r\n        del self.value\r\n    \r\n    # Class creation and metaclass\r\n    def __new__(cls, *args, **kwargs):\r\n        return super(DunderExample, cls).__new__(cls)\r\n    \r\n    # Type conversion\r\n    def __int__(self):\r\n        return int(self.value)\r\n    \r\n    def __float__(self):\r\n        return float(self.value)\r\n    \r\n    def __complex__(self):\r\n        return complex(self.value)\r\n    \r\n    # Other\r\n    def __hash__(self):\r\n        return hash(self.value)\r\n    \r\n    def __bool__(self):\r\n        return bool(self.value)\r\n    \r\n    def __sizeof__(self):\r\n        return super(DunderExample, self).__sizeof__()\r\n\r\n# Example usage of DunderExample class\r\nobj1 = DunderExample(10)\r\nobj2 = DunderExample(5)\r\n\r\nprint(obj1 + obj2)  # Should use __add__\r\nprint(obj1 == obj2)  # Should use __eq__\r\nprint(abs(obj1))  # Should use __abs__\r\nprint(len(obj1))  # Should use __len__\r\n\r\nwith obj1 as context:\r\n    print(\"Inside context\")\r\n\r\nprint(callable(obj1))  # Should check if __call__ is implemented\r\n</code></pre>\r\n</div>\r\n<p dir=\"ltr\">Output:</p>\r\n<pre class=\"language-ruby\"><code>False\r\nValue: 10\r\n2\r\nEntering context\r\nInside context\r\nExiting context\r\nTrue</code></pre>\r\n<p dir=\"ltr\">&nbsp;</p>\r\n<p dir=\"ltr\">Example 2, with output:</p>\r\n<div dir=\"ltr\" align=\"left\">\r\n<pre class=\"language-python\"><code>class MyRange:\r\n    def __init__(self, start, stop):\r\n        self.start = start\r\n        self.stop = stop\r\n        \r\n    #string representation\r\n    def __repr__(self):\r\n        return f\"MyRange ({self.start}, {self.stop})\"\r\n        \r\n    def __str__(self):\r\n        return f\"MyRange from {self.start} to {self.stop}\"\r\n    \r\n    #Length of the range\r\n    \r\n    def __len__(self):\r\n        return max(0, self.stop - self.start)\r\n        \r\n    #iteration \r\n    def __iter__(self):\r\n        self.current = self.start\r\n        return self\r\n        \r\n    def __next__(self):\r\n        if self.current &lt; self.stop:\r\n            value = self.current\r\n            self.current += 1\r\n            return value\r\n        else:\r\n            raise StopIteration\r\n            \r\n    #Airthmetic operations \r\n    def __add__(self, other):\r\n        return MyRange(self.start + other.start, self.stop + other.stop)\r\n    \r\n    def __sub__(self, other):\r\n        return MyRange(self.start - other.start, self.stop - other.stop)\r\n        \r\n    def __lt__(self, other):\r\n        return self.stop &lt; other.stop\r\n        \r\n    def __le__(self, other):\r\n        return self.other &lt;= other.stop\r\n        \r\n         # Container-like behavior\r\n    def __contains__(self, item):\r\n        return self.start &lt;= item &lt; self.stop\r\n        \r\n    #type conversion to list\r\n    \r\n    def __iter__(self):\r\n        return iter(range(self.start, self.stop))\r\n        \r\n    def __bool__(self):\r\n        return self.start &lt; self.stop\r\n        \r\n    #hashing for using sets or dicts\r\n    \r\n    def __hash__(self):\r\n        return hash((self.start, self.stop))\r\n        \r\nr1 = MyRange(5, 10)\r\nr2 = MyRange(3, 8)\r\n\r\nprint(r1) # __str__\r\nprint(repr(r1))  # use __repr__\r\n\r\nprint(len(r1)) # uses __len__\r\n\r\nfor i in r1:\r\n    print(i) #iterate from 5 to 9\r\n#Arithmetic\r\nr3 = r1 + r2\r\nprint(r3)\r\n \r\n #Comparision type\r\nprint(r1 == r2) #checks using __eq__\r\nprint(r1 &lt; r2) # uses __lt__\r\nprint (6 in r1) #uses __contains__\r\nprint(bool(r1))\r\nprint(hash(r1))\r\n </code></pre>\r\n</div>\r\n<p><strong><br><br></strong></p>\r\n<p dir=\"ltr\">Output&nbsp;</p>\r\n<div dir=\"ltr\" align=\"left\">\r\n<table><colgroup></colgroup>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p dir=\"ltr\">MyRange from 5 to 10<br>MyRange(5, 10)<br>5<br>6<br>7<br>8<br>9<br>MyRange(8, 18)<br>False<br>True<br>True<br>-8579323903389255428</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p dir=\"ltr\">Top 10 questions and answers with explanation in python OOPs:&nbsp;</p>\r\n<p dir=\"ltr\"><a href=\"../../python/top-10-python-oops-questions-answers-and-explanation/\">https://blog.satyamregmi.com.np/python/top-10-python-oops-questions-answers-and-explanation/</a></p>\r\n</div>\r\n<p>&nbsp;</p>', 'Dunder Methods:  In python â€œdunder methodsâ€ (double underscore methods) are special method that allows us to define how objects of our class behave when used in various operations (like add, subtract, comparison, etc).', 0x7079686f6e5f64756e6465722e706e67, 'python-dunder-questions-and-simple-explanation-with-output', '', '2025-01-28', 'python', 'python dunder questions, python, coding, programming');

-- --------------------------------------------------------

--
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

--
-- Dumping data for table `sbp_users`
--

INSERT INTO `sbp_users` (`id`, `firstName`, `lastName`, `email`, `username`, `password`, `role`, `date`, `image`, `address`, `about`, `job_title`, `country`, `phone`, `facebook`, `x`, `linkedin`, `instagram`) VALUES
(1, 'Admin', '', 'info.satyamregmi@gmail.com', 'admin', '$2y$10$/vh6FhcjvMsXlz9Q.IgWCOQPJziDxTaCDwpFtfV.GhYCyWN/1dG/i', 'admin', '2024-06-28 08:22:27', 0x312e706e67, '', '', '', '', 0, '', '', '', ''),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `sbp_comments`
--
ALTER TABLE `sbp_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sbp_pages`
--
ALTER TABLE `sbp_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sbp_posts`
--
ALTER TABLE `sbp_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sbp_users`
--
ALTER TABLE `sbp_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sbp_comments`
--
ALTER TABLE `sbp_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `sbp_pages`
--
ALTER TABLE `sbp_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sbp_posts`
--
ALTER TABLE `sbp_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
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

### 4 Configure Database Connection

Edit sbp-admin/credentials.php

```php
<?php
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$database = "sbp";
```
---
### 5 Configure Variables:

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
### 6 Default Admin Account:

Access your Dashboardfrom:
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


