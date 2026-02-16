CREATE OR REPLACE DATABASE Collectes_et_dons;

USE Collectes_et_dons;

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
    type_id INT,
    prixUnitaire DECIMAL(10, 2) NOT NULL
);

CREATE TABLE dons(
    id INT AUTO_INCREMENT PRIMARY KEY,
    quantite INT NOT NULL,
    id_ressource INT,
    date_don DATE NOT NULL
);

CREATE OR REPLACE view v_ressources_lib as 
SELECT v.nom as 'nom_ville', r.nom, r.ville_id, t.nom as 'type_ressource', r.prixUnitaire
FROM ressources r
JOIN type t ON r.type_id = t.id
JOIN ville v ON v.id = r.ville_id;

INSERT INTO type (nom) VALUES 
('nature'),
('materiaux'),
('argent');

-- Villes de test
INSERT INTO ville (nom) VALUES 
('Paris'), 
('Lyon'), 
('Nantes');

-- Ressources de test (liées aux villes)
INSERT INTO ressources (nom, ville_id, type_id, prixUnitaire) VALUES 
('Lot de Conserves', 1, 1, 2.50),  -- Nature (Paris)
('Sac de Ciment 25kg', 2, 2, 8.50), -- Materiaux (Lyon)
('Don numéraire', 3, 3, 1.00),      -- Argent (Marseille)
('Briques (palette)', 2, 2, 120.00),-- Materiaux (Lyon)
('Farine (vrac)', 1, 1, 1.20);      -- Nature (Paris)
-- Dons de test
INSERT INTO dons (quantite, id_ressource, date_don) VALUES 
(100, 1, '2024-03-01'), -- 100 kg de farine à Paris (nature)
(50, 2, '2024-03-05'),  -- 50 sacs de ciment à Lyon (materiaux)
(500, 3, '2024-03-10'), -- 500 unités d'argent à Nantes (argent)
(20, 4, '2024-03-12');  -- 20 couvertures à Paris (materiaux)