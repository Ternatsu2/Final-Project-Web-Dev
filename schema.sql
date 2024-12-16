CREATE DATABASE IF NOT EXISTS bugme;
USE bugme;

CREATE TABLE IF NOT EXISTS Users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(100) NOT NULL,
  lastname VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  created_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS Issues (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  type VARCHAR(50) NOT NULL,
  priority VARCHAR(50) NOT NULL,
  status VARCHAR(50) NOT NULL,
  assigned_to INT NOT NULL,
  created_by INT NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  FOREIGN KEY (assigned_to) REFERENCES Users(id),
  FOREIGN KEY (created_by) REFERENCES Users(id)
);

INSERT INTO Users (firstname, lastname, password, email, created_at)
VALUES ('Admin', 'User', '$2y$10$CZsILBXa1xD4AcMD0TRJsO1PE6uf7vXMPmn6ZX/5ghh8Q2kIYFT5q', 'admin@project2.com', NOW());
