-- Drop tables if they exist (for dev/testing purposes)
DROP TABLE IF EXISTS favorites;

DROP TABLE IF EXISTS adoption_applications;

DROP TABLE IF EXISTS pet_images;

DROP TABLE IF EXISTS pets;

DROP TABLE IF EXISTS users;

-- Users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  phone VARCHAR(20) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM ('adopter', 'lister') NOT NULL DEFAULT 'adopter',
  address VARCHAR(255) NOT NULL,
  city VARCHAR(100) NOT NULL,
  state VARCHAR(100) NOT NULL,
  profile_image VARCHAR(255) DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Pets
CREATE TABLE pets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  species VARCHAR(100) NOT NULL,
  breed VARCHAR(100),
  age VARCHAR(50), -- e.g., "2 years", "6 months" pretty flexible
  gender ENUM ('male', 'female', 'unknown') NOT NULL DEFAULT 'unknown',
  description TEXT,
  vaccinated BOOLEAN DEFAULT FALSE,
  vaccination_details TEXT,
  special_needs TEXT,
  location VARCHAR(255) NOT NULL,
  status ENUM ('available', 'adopted') NOT NULL DEFAULT 'available',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Pet Images
CREATE TABLE pet_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pet_id INT NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  caption VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (pet_id) REFERENCES pets (id) ON DELETE CASCADE
);

-- Adoption Applications
CREATE TABLE adoption_applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pet_id INT NOT NULL,
  user_id INT NOT NULL,
  message TEXT,
  has_other_pets BOOLEAN DEFAULT FALSE,
  other_pets_details TEXT,
  living_conditions TEXT,
  status ENUM ('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
  reviewed_at DATETIME DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (pet_id) REFERENCES pets (id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Favorites
CREATE TABLE favorites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  pet_id INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY unique_favorite (user_id, pet_id),
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  FOREIGN KEY (pet_id) REFERENCES pets (id) ON DELETE CASCADE
);
