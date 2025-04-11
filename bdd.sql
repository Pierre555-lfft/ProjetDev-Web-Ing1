-- Suppression et création de la base de données
DROP DATABASE IF EXISTS bdd;
CREATE DATABASE bdd;
USE bdd;

-- Table des membres (utilisateurs)
CREATE TABLE membres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    mdp VARCHAR(255) NOT NULL
);

-- Table des profils visiteurs
CREATE TABLE profils_visiteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    taille INT NOT NULL,
    sexe ENUM('M', 'F', 'Autre') NOT NULL,
    age INT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES membres(id)
);

-- Table des réservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date_visite DATE NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    qr_code VARCHAR(255),
    statut ENUM('en_attente', 'payee', 'utilisee') DEFAULT 'en_attente',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES membres(id)
);

CREATE TABLE visiteurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    reservation_id INT,
    type ENUM('adult', 'child', 'senior'),
    nom VARCHAR(100),
    prenom VARCHAR(100),
    age INT,
    taille INT,
    date_visite DATE,
    qr_code VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id)
);

-- Insertion des utilisateurs de test
INSERT INTO membres (login, mdp) VALUES 
('simple', 'simple123'),
('complexe', 'complexe123'),
('admin', 'admin123'); 

-- Création des tables nécessaires
CREATE TABLE IF NOT EXISTS reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    date_visite DATE NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    statut VARCHAR(20) NOT NULL DEFAULT 'payee',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES membres(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS visiteurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    reservation_id INT NOT NULL,
    type ENUM('adult', 'child', 'senior') NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    taille INT NOT NULL,
    date_visite DATE NOT NULL,
    qr_code VARCHAR(255),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id)
) ENGINE=InnoDB;

-- Vérifier que la table membres existe et a la bonne structure
CREATE TABLE IF NOT EXISTS membres (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Accorder les permissions nécessaires (à exécuter en tant qu'administrateur MySQL)
GRANT SELECT, INSERT, UPDATE ON bdd.* TO 'Lucas'@'localhost';
FLUSH PRIVILEGES;

ALTER TABLE visiteurs
ADD COLUMN qr_code VARCHAR(255) NULL;