-- Création de la base de données
CREATE OR REPLACE DATABASE Collectes_et_dons;

USE Collectes_et_dons;

-- Tables de base
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
    type_id INT NOT NULL,
    prixUnitaire DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (type_id) REFERENCES type(id)
);

CREATE TABLE besoins(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_ressource INT NOT NULL,
    quantite INT NOT NULL,
    ville_id INT NOT NULL,
    FOREIGN KEY (id_ressource) REFERENCES ressources(id),
    FOREIGN KEY (ville_id) REFERENCES ville(id)
);

CREATE TABLE dons(
    id INT AUTO_INCREMENT PRIMARY KEY,
    quantite INT NOT NULL,
    id_besoins INT,
    id_ressource INT NOT NULL,
    date_don DATE DEFAULT CURRENT_DATE,
    dons_argent DECIMAL(10, 2) DEFAULT NULL,
    FOREIGN KEY (id_besoins) REFERENCES besoins(id),
    FOREIGN KEY (id_ressource) REFERENCES ressources(id)
);

CREATE TABLE mouvement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_don INT NOT NULL,
    type_action ENUM('AJOUT', 'ANNULATION', 'MODIFICATION') NOT NULL,
    quantite_mouvement INT NOT NULL,
    date_mouvement DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_don) REFERENCES dons(id) ON DELETE CASCADE
);
-- ============================================================
-- VUES CORRIGÉES
-- ============================================================

-- Vue 1 : Récapitulatif des dons avec détails complets
CREATE OR REPLACE VIEW v_ressources_lib AS
SELECT 
    d.id as id_don, -- <--- IMPORTANT : Ajoutez ceci
    v.nom as nom_ville,
    v.id as ville_id,
    r.nom as nom_ressource,
    t.nom as type_ressource,
    r.prixUnitaire,
    d.quantite as quantite_don,
    d.date_don,
    (d.quantite * r.prixUnitaire) as montant_total
FROM dons d
JOIN ressources r ON d.id_ressource = r.id
JOIN type t ON r.type_id = t.id
JOIN besoins b ON d.id_besoins = b.id
JOIN ville v ON b.ville_id = v.id;
-- Vue 2 : Résumé des dons par ressource et ville
CREATE OR REPLACE VIEW v_dons_lib_comple AS
SELECT 
    r.nom AS nom_ressource,
    v.nom AS nom_ville,
    t.nom AS type_ressource,
    SUM(d.quantite) AS total_quantite,
    MAX(d.date_don) AS derniere_date,
    SUM(d.quantite * r.prixUnitaire) AS valeur_totale
FROM dons d
JOIN ressources r ON d.id_ressource = r.id
JOIN type t ON r.type_id = t.id
JOIN besoins b ON d.id_besoins = b.id
JOIN ville v ON b.ville_id = v.id
GROUP BY r.id, v.id, t.id;

-- ============================================================
-- DONNÉES DE TEST
-- ============================================================

-- Types de ressources
INSERT INTO type (nom) VALUES 
('nature'),
('materiaux'),
('argent');

-- Villes de test
INSERT INTO ville (nom) VALUES 
('Paris'), 
('Lyon'), 
('Nantes'),
('Bordeaux'), 
('Lille'), 
('Strasbourg');

-- Ressources de test
INSERT INTO ressources (nom, type_id, prixUnitaire) VALUES 
('Lot de Conserves', 1, 2.50),      -- Nature
('Sac de Ciment 25kg', 2, 8.50),    -- Materiaux
('Don numéraire', 3, 1.00),         -- Argent
('Briques (palette)', 2, 120.00),   -- Materiaux
('Farine (vrac)', 1, 1.20),         -- Nature
('Couvertures de laine', 2, 15.00), -- Materiaux
('Kit de premier secours', 2, 45.00),-- Materiaux
('Bouteilles d''eau (pack)', 1, 3.50), -- Nature
('Riz (sac 5kg)', 1, 7.20),         -- Nature
('Subvention Exceptionnelle', 3, 1.00); -- Argent

-- Besoins (liaisons ressources-villes)
INSERT INTO besoins (id_ressource, quantite, ville_id) VALUES 
(1, 100, 1),  -- 100 conserves à Paris
(2, 50, 2),   -- 50 sacs ciment à Lyon
(3, 500, 3),  -- 500 unités argent à Nantes
(4, 20, 2),   -- 20 briques à Lyon
(6, 30, 5),   -- 30 couvertures à Lille
(8, 200, 6),  -- 200 packs eau à Strasbourg
(9, 150, 1),  -- 150 sacs riz à Paris
(10, 1000, 2), -- 1000 subvention à Lyon
(5, 80, 1);   -- 80 farine à Paris

-- Dons
INSERT INTO dons (quantite, id_besoins, id_ressource, date_don, dons_argent) VALUES 
(100, 1, 1, '2024-03-01', NULL),    -- Conserves Paris
(50, 2, 2, '2024-03-05', 425.00),   -- Ciment Lyon
(500, 3, 3, '2024-03-10', NULL),    -- Argent Nantes
(20, 4, 4, '2024-03-12', 2400.00),  -- Briques Lyon
(30, 6, 6, '2024-06-15', NULL),     -- Couvertures Lille
(200, 7, 8, '2024-12-20', NULL),    -- Eau Strasbourg
(150, 8, 9, '2025-01-10', NULL),    -- Riz Paris
(1000, 9, 10, '2025-02-01', NULL),  -- Subvention Lyon
(80, 10, 5, '2025-02-15', NULL);    -- Farine Paris
