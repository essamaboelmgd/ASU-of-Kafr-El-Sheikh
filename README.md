<h1 align="center"> 📌 ASU Platform - Project Documentation </h1>
🌟Overview
ASU Events Platform is a comprehensive university event management system that:

Showcases upcoming university events (scientific, cultural, athletic, etc.)

Provides secure admin dashboard for event management

Tracks visitor statistics and user registrations

Features responsive design for all devices

## 🛠️ Tech Stack
## Category Technologies Used :
Frontend :	HTML5, CSS3, JavaScript, Bootstrap 5, jQuery
Backend :	PHP 7+, MySQL
Security :	Session-based authentication, Input sanitization
Libraries :	Chart.js, Slick Slider, Font Awesome

## ✨ Key Features
## 🎯 Public Features
Interactive Event Showcase: Filter events by type (scientific, cultural, etc.)

Responsive Banner: Auto-adjusting hero section with smooth animations

Visitor Tracking: Records unique visitors with IP tracking

Contact Form: Secure message submission system

## 🔐 Admin Features
Event Management: Add/edit events with expiry dates

User Analytics: View registration data and visitor stats

About Section Editor: Customize about page content

Responsive Dashboard: Charts and data visualization

## 🚀 Installation Guide
Prerequisites
Web server (Apache/Nginx)

PHP 7.0+

MySQL 5.7+

## Setup Steps
Clone the repository:

```bash
git clone https://github.com/yourusername/ASU-Events.git
```
## Database Setup:

Import asu.sql to your MySQL server

Update credentials in includes/conn.php

## Configure Admin Access:

Default admin credentials are set in login system

Change password after first login

File Permissions:

```bash
chmod -R 755 uploads/
```
## 🧑‍💻 Usage Examples
Adding New Event (Admin)
Navigate to /admin/events.php

Fill event details (title, image, expiry date)

Submit form - events appear automatically on main page

Viewing Statistics
Login to admin dashboard

View real-time charts for:

Daily unique visitors

Total event participation

User registration trends

## 📊 Database Schema
Main tables include:

events - Stores all event data

event_users - Tracks user registrations

visitors - Records website traffic

daily_visitors - Aggregates daily stats

about - Manages about page content

## 🛡️ Security Measures
Session-based authentication

Prepared statements for all SQL queries

Input sanitization

CSRF protection (implemented in forms)

Secure file upload validation
