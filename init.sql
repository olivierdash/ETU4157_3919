CREATE DATABASE magasin;

\c magasin;

CREATE TABLE produits (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    alt VARCHAR(255),
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255)
);

CREATE TABLE historique_prix (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    produit_id INT UNSIGNED NOT NULL,
    ancien_prix DECIMAL(10,2) NOT NULL,
    nouveau_prix DECIMAL(10,2) NOT NULL,
    daty TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE
);

CREATE TABLE historique_nom (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    produit_id INT UNSIGNED NOT NULL,
    ancien_nom VARCHAR(255) NOT NULL,
    nouveau_nom VARCHAR(255) NOT NULL,
    daty TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE
);

CREATE TRIGGER trg_update_prix
BEFORE UPDATE ON produits
FOR EACH ROW
BEGIN
    IF OLD.price != NEW.price THEN
        INSERT INTO historique_prix(produit_id, ancien_prix, nouveau_prix)
        VALUES (OLD.id, OLD.price, NEW.price);
    END IF;
END;

CREATE TRIGGER trg_update_nom
BEFORE UPDATE ON produits
FOR EACH ROW
BEGIN
    IF OLD.name != NEW.name THEN
        INSERT INTO historique_nom(produit_id, ancien_nom, nouveau_nom)
        VALUES (OLD.id, NEW.name, NEW.name);
    END IF;
END;
