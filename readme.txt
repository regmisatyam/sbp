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
Download and upload schema to your phpmyadmin. Goto your database choose import and import file: sbp-schema.sql

--

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
