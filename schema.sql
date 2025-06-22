-- Drop tables if they exist (for dev/testing purposes)
DROP TABLE IF EXISTS favorites;

DROP TABLE IF EXISTS adoption_applications;

DROP TABLE IF EXISTS pet_images;

DROP TABLE IF EXISTS pets;

DROP TABLE IF EXISTS users;

-- Users
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM ('adopter', 'lister') NOT NULL DEFAULT 'adopter',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Pets
CREATE TABLE pets (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  species VARCHAR(50) NOT NULL,
  breed VARCHAR(50),
  age INT,
  gender ENUM ('male', 'female', 'unknown') NOT NULL DEFAULT 'unknown',
  description TEXT,
  status ENUM ('available', 'adopted', 'fostered') NOT NULL DEFAULT 'available',
  location VARCHAR(100) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Pet Images
CREATE TABLE pet_images (
  id INT PRIMARY KEY AUTO_INCREMENT,
  pet_id INT NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  caption VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (pet_id) REFERENCES pets (id) ON DELETE CASCADE
);

-- Adoption Applications
CREATE TABLE adoption_applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pet_id INT NOT NULL,
  user_id INT NOT NULL,
  message TEXT,
  has_other_pets BOOLEAN DEFAULT FALSE,
  living_conditions VARCHAR(255),
  status ENUM ('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
  submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (pet_id) REFERENCES pets (id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Favorites
CREATE TABLE favorites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  pet_id INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_fav_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT fk_fav_pet FOREIGN KEY (pet_id) REFERENCES pets (id) ON DELETE CASCADE,
  CONSTRAINT unique_fav UNIQUE (user_id, pet_id)
);
