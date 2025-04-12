-- Réinitialisation de la base
DROP DATABASE IF EXISTS parc;
CREATE DATABASE parc;
USE parc;

-- Suppression des tables si elles existent
DROP TABLE IF EXISTS visiteurs;
DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS profils_visiteurs;
DROP TABLE IF EXISTS membres;
DROP TABLE IF EXISTS admin;

-- Table admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL,
    mdp VARCHAR(255) NOT NULL
);

-- Donnée de test admin
INSERT INTO admin (login, mdp) VALUES ('admin', MD5('1234'));

-- Table membres fusionnée
CREATE TABLE membres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    mdp VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    adresse VARCHAR(255),
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Donnée de test membre
INSERT INTO membres (login, mdp, email, nom, prenom, adresse)
VALUES ('membre', MD5('admin'), 'admin@example.com', 'admin', 'admin', '123 rue des Fleurs');

-- Table profils_visiteurs
CREATE TABLE profils_visiteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    taille INT NOT NULL,
    sexe ENUM('M', 'F', 'Autre') NOT NULL,
    age INT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES membres(id) ON DELETE CASCADE
);

-- Table reservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date_visite DATE NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    qr_code VARCHAR(255),
    statut ENUM('en_attente', 'payee', 'utilisee') DEFAULT 'en_attente',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES membres(id) ON DELETE CASCADE
);

-- Table visiteurs
CREATE TABLE visiteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    type ENUM('adult', 'child', 'senior') NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    taille INT NOT NULL,
    date_visite DATE NOT NULL,
    qr_code VARCHAR(255),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE
);
