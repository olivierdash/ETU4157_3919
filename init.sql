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

-- ajout d'une colone
CREATE TABLE dons(
    id INT AUTO_INCREMENT PRIMARY KEY,
    quantite INT NOT NULL,
    id_ressource INT,
    date_don DATE DEFAULT CURRENT_DATE
);

CREATE OR REPLACE view v_ressources_lib as 
SELECT v.nom as 'nom_ville', r.nom, r.ville_id, t.nom as 'type_ressource', r.prixUnitaire, d.quantite, d.date_don
FROM ressources r
JOIN type t ON r.type_id = t.id
JOIN ville v ON v.id = r.ville_id
JOIN dons d ON d.id_ressource = r.id;

CREATE OR REPLACE view v_dons_lib_comple as
SELECT r.nom, v.nom, date_don

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

INSERT INTO ville (nom) VALUES 
('Bordeaux'), 
('Lille'), 
('Strasbourg');

INSERT INTO ressources (nom, ville_id, type_id, prixUnitaire) VALUES 
('Couvertures de laine', 4, 2, 15.00), -- Bordeaux (Materiaux)
('Kit de premier secours', 5, 2, 45.00),-- Lille (Materiaux)
('Bouteilles d''eau (pack)', 6, 1, 3.50), -- Strasbourg (Nature)
('Riz (sac 5kg)', 1, 1, 7.20),          -- Paris (Nature)
('Subvention Exceptionnelle', 2, 3, 1.00),-- Lyon (Argent)
('10000', 2, 3, 1.00);-- Lyon (Argent)

INSERT INTO dons (quantite, id_ressource, date_don) VALUES 
(30, 6, '2024-06-15'),  -- 30 kits secours à Lille
(200, 8, '2024-12-20'), -- 200 packs d'eau à Strasbourg
(150, 9, '2025-01-10'), -- 150 sacs de riz à Paris
(1000, 10, '2025-02-01'), -- Gros don d'argent à Lyon
(15, 7, '2025-02-14'),  -- 15 couvertures à Bordeaux
(80, 1, '2025-02-15');  -- Nouveau don de conserves à Paris