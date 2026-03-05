-- ============================================================
--  FOREVER HOME — Database Schema (UPDATED)
-- ============================================================

CREATE DATABASE IF NOT EXISTS forever_home CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE forever_home;

CREATE TABLE IF NOT EXISTS animals (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100)  NOT NULL,
    species     VARCHAR(100)  NOT NULL,
    age         INT           NOT NULL DEFAULT 0,
    description TEXT,
    status VARCHAR(50) NOT  NULL DEFAULT 'available',
    -- TODO #14 — The animals table is missing a column that tracks
    -- whether an animal is 'available', 'pending', or 'adopted'.
    -- Add it here as: VARCHAR(50) NOT NULL DEFAULT 'available'.
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    email         VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    is_admin      TINYINT(1)   NOT NULL DEFAULT 0,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS adoption_requests(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    animal_id INT NOT NULL,
    message TEXT,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user_id_adopt_req FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_animal_id_adopt_req FOREIGN KEY (animal_id) REFERENCES animals(id)
);

-- TODO #15 — The adoption_requests table is completely missing.
-- Create it with these columns:
--   id         INT AUTO_INCREMENT PRIMARY KEY
--   user_id    INT NOT NULL (foreign key → users.id)
--   animal_id  INT NOT NULL (foreign key → animals.id)
--   message    TEXT
--   status     VARCHAR(20) NOT NULL DEFAULT 'pending'
--   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- Don't forget the two FOREIGN KEY constraints.

INSERT INTO animals (name, species, age, description) VALUES
    ('Biscuit', 'Dog',    3, 'Friendly golden mix, loves fetch.'),
    ('Mango',   'Cat',    1, 'Playful kitten, great with kids.'),
    ('Peanut',  'Rabbit', 2, 'Calm and cuddly, litter trained.');
