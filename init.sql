CREATE OR REPLACE DATABASE Collectes_et_dons;

USE collectes_et_dons;

CREATE TABLE ville(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE type(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE ressources(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    ville_id INT,
    prixUnitaire DECIMAL(10, 2) NOT NULL
);

CREATE TABLE dons(
    id INT AUTO_INCREMENT PRIMARY KEY,
    quantite INT NOT NULL,
    id_ressource INT,
    date_don DATE NOT NULL
);