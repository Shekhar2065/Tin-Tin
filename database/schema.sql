CREATE DATABASE IF NOT EXISTS tin_tin_trekking CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tin_tin_trekking;

CREATE TABLE IF NOT EXISTS inquiries (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(190) NOT NULL,
  phone VARCHAR(60) NOT NULL DEFAULT '',
  whatsapp VARCHAR(60) NOT NULL DEFAULT '',
  country VARCHAR(100) NOT NULL DEFAULT '',
  trek VARCHAR(190) NOT NULL DEFAULT '',
  travel_month VARCHAR(30) NOT NULL DEFAULT '',
  travel_dates VARCHAR(120) NOT NULL DEFAULT '',
  flexible_dates VARCHAR(10) NOT NULL DEFAULT 'No',
  group_size INT UNSIGNED NOT NULL DEFAULT 1,
  group_type VARCHAR(80) NOT NULL DEFAULT '',
  trekking_experience VARCHAR(100) NOT NULL DEFAULT '',
  fitness_level VARCHAR(100) NOT NULL DEFAULT '',
  altitude_experience VARCHAR(100) NOT NULL DEFAULT '',
  additional_health_notes TEXT NOT NULL,
  accommodation VARCHAR(100) NOT NULL DEFAULT '',
  hotel_level VARCHAR(50) NOT NULL DEFAULT '',
  room_type VARCHAR(50) NOT NULL DEFAULT '',
  interests TEXT NOT NULL,
  budget_range VARCHAR(80) NOT NULL DEFAULT '',
  additional_notes TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_created_at (created_at),
  INDEX idx_email (email)
) ENGINE=InnoDB;
