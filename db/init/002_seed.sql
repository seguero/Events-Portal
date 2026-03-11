-- 002_seed.sql
-- Inserts 1 admin user + a few events for testing.
-- Hash generated with password_hash('Admin123!', PASSWORD_DEFAULT);

-- ADMIN USER (role=admin)
INSERT INTO users (firstname, lastname, email, password, role)
VALUES (
  'SUPER',
  'USER',
  'admin@csym019.test',
  '$2y$10$.TK8ewqJ9czX58GgZKT1SumEiBEZgi0O3TS9FqhHWghoz52CNvoO6',
  'admin'
);

-- DUMMY EVENTS
INSERT INTO events (event_type, title, description, event_date, location, image_path)
VALUES
('Workshop','Web Development Workshop', 'Hands-on workshop covering modern PHP structure and routing.', '2026-03-10 18:00:00', 'Northampton', '/assets/placeholder.jpg'),
('Webinar','Docker for Beginners', 'Learn container basics and how to run reproducible dev environments.', '2026-03-15 17:30:00', 'Wellingborough', '/assets/placeholder.jpg'),
('Conference','Web App Security Basics', 'Intro to common vulnerabilities like XSS and how to mitigate them.', '2026-03-20 19:00:00', 'Kettering', '/assets/placeholder.jpg');