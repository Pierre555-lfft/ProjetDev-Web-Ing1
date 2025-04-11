CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    type_compte ENUM('simple', 'complexe', 'admin') NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insertion d'un utilisateur "simple" test
INSERT INTO utilisateurs (username, password, type_compte) 
VALUES ('simple_user', '$2y$10$YourHashedPassword', 'simple'); 