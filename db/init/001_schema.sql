-- 001_schema.sql
-- Creates the core tables for users, events, and bookings.

CREATE TABLE IF NOT EXISTS users (
  userid INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  firstname VARCHAR(255) NOT NULL,
  lastname VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS events (
  eventid INT AUTO_INCREMENT PRIMARY KEY,
  category VARCHAR(255) NOT NULL,
  event_type VARCHAR(50) NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  event_date DATETIME NOT NULL,
  location VARCHAR(255) NOT NULL,
  image_path VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bookings (
    bookingid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    eventid INT NOT NULL,

    booked_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE,
    FOREIGN KEY (eventid) REFERENCES events(eventid) ON DELETE CASCADE,

    UNIQUE KEY unique_booking (userid, eventid)
);