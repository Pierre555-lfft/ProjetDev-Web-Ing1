-- Réinitialisation de la base
DROP DATABASE IF EXISTS parc;
CREATE DATABASE parc;
USE parc;

-- Suppression des anciennes tables si elles existent
DROP TABLE IF EXISTS visiteurs;
DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS profils_visiteurs;
DROP TABLE IF EXISTS utilisateurs;

-- Table utilisateurs avec les types de comptes ajustés (sans 'gestionnaire')
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    mdp VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    nom VARCHAR(100),
    prenom VARCHAR(100),
    adresse VARCHAR(255),
    type_compte ENUM('client', 'client_complet', 'employe', 'admin') NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Exemples d'insertion
INSERT INTO utilisateurs (login, mdp, type_compte)
VALUES ('admin', MD5('1234'), 'admin');

INSERT INTO utilisateurs (login, mdp, email, nom, prenom, adresse, type_compte)
VALUES ('client1', MD5('client123'), 'laforestpierre1@gmail.com', 'Doe', 'John', '123 rue des Fleurs', 'client');

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
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
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
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
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
