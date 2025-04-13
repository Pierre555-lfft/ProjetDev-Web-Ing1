USE parcAttraction;
-- Suppression des tables si elles existent déjà
DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS profils_visiteurs;

-- Création de la table profils_visiteurs
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

-- Création de la table reservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date_visite DATE NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    qr_code VARCHAR(100) UNIQUE NOT NULL,
    statut ENUM('en_attente', 'payee', 'utilisee') DEFAULT 'en_attente',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES membres(id)
);

SELECT * FROM profils_visiteurs;

-- Ou pour voir plus de détails avec le nom d'utilisateur
SELECT m.login, p.* 
FROM profils_visiteurs p 
JOIN membres m ON p.user_id = m.id;

-- Pour voir les réservations
SELECT * FROM reservations;

-- Pour voir tout en détail (profil, réservation et utilisateur)
SELECT m.login, p.*, r.* 
FROM membres m 
JOIN profils_visiteurs p ON m.id = p.user_id 
JOIN reservations r ON m.id = r.user_id;