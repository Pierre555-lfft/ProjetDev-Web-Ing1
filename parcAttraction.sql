-- Création de la base
CREATE DATABASE IF NOT EXISTS parcAttraction;
USE parcAttraction;

-- Table admin
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL,
    mdp VARCHAR(255) NOT NULL
);

-- Donnée de test admin (login: admin | mdp: 1234)
INSERT INTO admin (login, mdp) VALUES ('admin', MD5('1234'));

-- Table membres
CREATE TABLE IF NOT EXISTS membres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    adresse VARCHAR(255),
    login VARCHAR(50) NOT NULL,
    mdp VARCHAR(255) NOT NULL
);

-- Donnée de test membre (login: membre1 | mdp: abcd)
INSERT INTO membres (nom, prenom, email, adresse, login, mdp)
VALUES ('admin', 'admin', 'admin@example.com', '123 rue des Fleurs', 'membre', MD5('admin'));
