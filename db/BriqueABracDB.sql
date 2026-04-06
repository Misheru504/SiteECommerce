DROP DATABASE IF EXISTS BriqueABrac;

CREATE DATABASE IF NOT EXISTS BriqueABrac;
USE BriqueABrac;

CREATE TABLE IF NOT EXISTS Utilisateur (
    idUtilisateur INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(50) UNIQUE NOT NULL,
    motDePasse VARCHAR(256) NOT NULL,

    CONSTRAINT pk_utilisateur PRIMARY KEY (idUtilisateur)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS Client (
    idClient INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    ville VARCHAR(50),
    adresse VARCHAR(50),
    codePostal CHAR(5),
    numeroTelephone CHAR(10),
    dateInscription DATE NOT NULL,

    idUtilisateur INT NOT NULL,

    CONSTRAINT pk_client PRIMARY KEY (idClient),
    CONSTRAINT fk_client_utilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS Commande (
    idCommande INT NOT NULL AUTO_INCREMENT,
    dateCommande DATETIME,
    dateLivraison DATETIME,

    idClient INT NOT NULL,

    CONSTRAINT pk_commande PRIMARY KEY (idCommande),
    CONSTRAINT fk_commande_client FOREIGN KEY (idClient) REFERENCES Client(idClient)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS TypeAge (
    idAge INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(50),

    CONSTRAINT pk_typeAge PRIMARY KEY (idAge)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS Franchise (
    idFranchise INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(50),

    CONSTRAINT pk_franchise PRIMARY KEY (idFranchise)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS TypeProduit (
    idType INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(50),

    CONSTRAINT pk_typeProduit PRIMARY KEY (idType)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS Produit (
    idProduit INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50),
    description VARCHAR(512),
    nbPieces INT,
    prix DECIMAL(15, 2),
    promo DECIMAL(5, 2),

    idType INT,
    idFranchise INT,
    idAge INT,

    CONSTRAINT pk_produit PRIMARY KEY (idProduit),
    CONSTRAINT fk_produit_typeProduit FOREIGN KEY (idType) REFERENCES TypeProduit(idType),
    CONSTRAINT fk_produit_franchise FOREIGN KEY (idFranchise) REFERENCES Franchise(idFranchise),
    CONSTRAINT fk_produit_typeAge FOREIGN KEY (idAge) REFERENCES TypeAge(idAge)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS DetailCommande (
    idProduit INT NOT NULL,
    idCommande INT NOT NULL,
    qte INT,

    CONSTRAINT pk_detaiCommande PRIMARY KEY (idProduit, idCommande),
    CONSTRAINT fk_detailCommande_produit FOREIGN KEY (idProduit) REFERENCES Produit(idProduit),
    CONSTRAINT fk_detailCommande_commande FOREIGN KEY (idCommande) REFERENCES Commande(idCommande)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS Panier (
    idProduit INT NOT NULL,
    idClient INT NOT NULL,
    qte INT,

    CONSTRAINT pk_panier PRIMARY KEY (idProduit, idClient),
    CONSTRAINT fk_panier_produit FOREIGN KEY (idProduit) REFERENCES Produit(idProduit),
    CONSTRAINT fk_panier_client FOREIGN KEY (idClient) REFERENCES Client(idClient)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

START TRANSACTION;
INSERT INTO TypeAge (libelle) VALUES
('1+'), ('4+'), ('6+'), ('9+'), ('14+'), ('18+');
INSERT INTO Franchise (libelle) VALUES
('NASA'), ('Disney'), ('Star Wars'), ('Pokémon'), ('City'), ('Marvel'), ('Ninjago'),
('Technic'), ('Icons'), ('Creator'), ('Architecture'), ('Harry Potter'),
('Speed Champions'), ('Botanicals'), ('Sonic');
INSERT INTO TypeProduit (libelle) VALUES
('Set'), ('Figurine'), ('Collector'), ('Sachet'), ('Technic'),
('Casque'), ('UCS'), ('BrickHeadz'), ('Modulaire'), ('Mech');

INSERT INTO Produit (nom, description, nbPieces, prix, promo, idAge, idType, idFranchise) VALUES
('Apollo Saturn V', 'Revivez les missions lunaires habitées Apollo.', 1969, 299.99, 10.00, (SELECT idAge FROM TypeAge WHERE libelle = '14+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'), (SELECT idFranchise FROM Franchise WHERE libelle = 'NASA')),
('SLS Artémis', 'Recréez le lancement des missions Artémis I et II !', 632, 59.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '9+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Technic'), (SELECT idFranchise FROM Franchise WHERE libelle = 'NASA')),
('Flash McQueen', 'Préparez vous pour la course !', 270, 27.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '9+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Set'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Disney')),
('WALL-E et EVE', 'Exprimez votre passion pour le film WALL-E.', 811, 69.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Set'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Disney')),
('Anna et Elsa miniatures', 'Offrez les deux protagonistes de la Reine des Neiges à votre enfant', 65, 9.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '4+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Sachet'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Disney')),
('Navette spatiale Discovery', 'La navette Discovery et le télescope Hubble à construire.', 2354, 219.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'), (SELECT idFranchise FROM Franchise WHERE libelle = 'NASA')),
('Château de la Belle au Bois Dormant', 'Recréez le château emblématique de Disney avec ce set détaillé.', 4080, 399.99, 5.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Disney')),
('Stitch', 'Construisez le personnage adorable de Lilo & Stitch.', 730, 64.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Disney')),
('Grogu', 'Construisez Grogu dans son landau flottant. Un set détaillé pour les fans.', 1048, 99.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
('UCS Jango Fett Firespray', 'Le vaisseau de Jango Fett en version Ultimate Collector Series.', 2970, 299.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'UCS'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
('Casque AT-AT Driver', 'Ajoutez ce casque iconique à votre collection Star Wars.', 730, 69.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Casque'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
('Intercepteur Jedi d''Ahsoka', 'Le chasseur Jedi d''Ahsoka Tano de la série Clone Wars.', 290, 44.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '9+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Set'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
('ARC-170 Starfighter', 'Recréez le chasseur ARC-170 vu dans les guerres cloniques.', 497, 69.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),

('N-1 Starfighter Mando et Grogu', 'Le vaisseau de Din Djarin avec Grogu et R5-D4.', 92, 29.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '4+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),

('Chopper (C1-10P)', 'Le droïde astromech Chopper de Star Wars Rebels à construire.', 1039, 99.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),

('Casque Jango Fett', 'Le casque Mandalorien de Jango Fett à exposer.', 616, 69.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Casque'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),

('UCS AT-ST', 'Le marcheur AT-ST en version Ultimate Collector Series avec socle.', 1513, 199.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'UCS'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),

('Juggernaut de la République', 'Le tank turbo des clones avec ses 10 roues massives.', 813, 159.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),

('Vaisseau de Jango Fett', 'Version playscale du vaisseau Firespray avec Jango et jeune Boba.', 707, 69.99, 5.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),

('AT-AT en pain d''épices', 'Un AT-AT décoré pour les fêtes avec glaçage et guirlandes.', 697, 59.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),

('Acclamator Star Destroyer', 'Modèle midi-scale du croiseur d''assaut de la République.', 580, 79.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '14+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),

-- === POKÉMON ===
('Pikachu géant', 'Un Pikachu à grande échelle à construire et exposer.', 1547, 129.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Pokémon')),

('Évoli', 'Le Pokémon Évoli en version à construire.', 757, 69.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Pokémon')),

('Centre Pokémon', 'Recréez le Centre Pokémon emblématique avec infirmière Joëlle.', 2339, 259.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Pokémon')),

('Dracaufeu', 'Le Pokémon de type Feu en version à construire et exposer.', 1663, 129.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Pokémon')),

-- === CITY ===
('Commissariat de Police', 'Le commissariat de police avec véhicules et figurines.', 668, 69.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '6+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'City')),

('Caserne de Pompiers', 'La caserne avec camion, hélicoptère et équipe de pompiers.', 843, 79.99, 10.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '6+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'City')),

('Course de Moto de Police', 'Poursuite en moto à travers la ville.', 59, 9.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '4+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Sachet'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'City')),

('Train Arctique télécommandé', 'Train motorisé avec télécommande et décor polaire.', 1186, 209.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'City')),

('Hôpital de la ville', 'L''hôpital avec ambulance, salle d''opération et hélicoptère.', 1045, 99.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '6+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'City')),

-- === MARVEL ===
('Tour des Avengers', 'La tour Stark avec multiples étages et détails du MCU.', 5201, 499.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

('Gant de l''Infini', 'Recréez le Gant de l''Infini de Thanos avec les pierres.', 590, 79.99, 15.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

('Spider-Verse Miles Morales vs The Spot', 'Scène de combat tirée de Across the Spider-Verse.', 375, 49.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

('Quinjet des Avengers', 'Le Quinjet bleu d''Age of Ultron avec 5 figurines.', 1131, 129.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

('Oscorp Building', 'Le bâtiment Oscorp avec laboratoire et bureau d''Eddie Brock.', 808, 139.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

('Spider-Man vs Doc Ock Train', 'La scène du métro de Spider-Man 2 avec Tobey Maguire.', 520, 54.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

('Iron Man et War Machine vs Hammer Drones', 'Pack de combat Iron Man 2 avec deux drones Hammer.', 204, 22.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '6+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

('Galactus vs Les Quatre Fantastiques', 'Galactus à construire avec les Quatre Fantastiques.', 427, 59.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

-- === NINJAGO ===
('Ninjago City Workshops', 'Extension modulaire de la ville Ninjago avec 4 étages et mech.', 3244, 249.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '14+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Modulaire'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Ninjago')),

('Le Dragon Gardien', 'Dragon majestueux sur socle d''exposition en roche.', 1650, 149.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '14+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Ninjago')),

('Le Mech Chevalier de Feu', 'Mech géant de Kai avec monstre marin à combattre.', 996, 99.99, 5.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '14+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Mech'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Ninjago')),

('Le Bounty du Temple', 'Le vaisseau Destiny''s Bounty en version display avec support incliné.', 2000, 199.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '14+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Ninjago')),

-- === TECHNIC ===
('Lamborghini Countach', 'La Countach 5000 Quattrovalvole avec portes en ciseaux et moteur V12.', 1506, 179.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Technic'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Technic')),

('Corvette Chevrolet', 'La Corvette avec direction fonctionnelle et moteur V8.', 732, 59.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Technic'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Technic')),

('Excavatrice Volvo EC500', 'Excavatrice motorisée avec fonctions télécommandées.', 2359, 429.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Technic'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Technic')),

('Sous-marin d''exploration', 'Sous-marin de recherche en eaux profondes.', 842, 49.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Technic'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Technic')),

('F1 Red Bull Racing RB21', 'La monoplace Red Bull F1 avec détails réalistes.', 810, 59.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Technic'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Speed Champions')),

-- === ICONS / CREATOR ===
('Place Médiévale', 'Place de ville médiévale avec auberge, fromagerie et tour de guet.', 3304, 249.99, 5.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Modulaire'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Icons')),

('Bouquet de fleurs', 'Bouquet de 15 fleurs à construire : roses, marguerites, dahlia.', 756, 59.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Botanicals')),

('Train Express des Fêtes', 'Train festif avec locomotive et wagon pour décoration de Noël.', 956, 119.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Icons')),

-- === ARCHITECTURE ===
('Château de Neuschwanstein', 'Le célèbre château bavarois en 3455 pièces.', 3455, 259.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Architecture')),

-- === HARRY POTTER ===
('Le Terrier', 'La maison des Weasley avec cheminée du Réseau de Cheminette et 10 figurines.', 2405, 249.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '18+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Harry Potter')),

-- === SPEED CHAMPIONS ===
('Ferrari F1', 'La monoplace Ferrari de Formule 1 avec pilote.', 280, 26.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Speed Champions')),

('McLaren F1', 'La monoplace McLaren de Formule 1 avec pilote.', 275, 26.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Speed Champions')),

('Mercedes F1', 'La monoplace Mercedes AMG de Formule 1 avec pilote.', 282, 26.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Speed Champions')),

-- === SONIC ===
('Camion de Commande de Sonic', 'Le camion de Sonic avec accessoires et personnages.', 750, 69.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Sonic')),

('Mech du Dr. Eggman', 'Le robot géant du Dr. Eggman à combattre.', 450, 44.99, 0.00,
    (SELECT idAge FROM TypeAge WHERE libelle = '9+'),
    (SELECT idType FROM TypeProduit WHERE libelle = 'Mech'),
    (SELECT idFranchise FROM Franchise WHERE libelle = 'Sonic'));
COMMIT;


CREATE VIEW IF NOT EXISTS v_Produits (IdProduit, NomProduit, Description, NbPieces, Prix, Promotion, Type, Franchise, Age) AS
    SELECT idProduit, nom, description, nbPieces, prix, promo, TP.libelle, F.libelle, TA.libelle FROM Produit P
    LEFT JOIN TypeAge TA ON TA.idAge = P.idAge
    LEFT JOIN TypeProduit TP ON TP.idType = P.idType
    LEFT JOIN Franchise F ON F.idFranchise = P.idFranchise
    ORDER BY idProduit;

CREATE VIEW IF NOT EXISTS v_Users (IdClient, NomClient, PrenomClient, MailClient, NumeroTelClient, Adresse, Ville, CodePostal, DateInscription, MotDePasse) AS
    SELECT C.idClient, C.nom, C.prenom, U.email, C.numeroTelephone, C.adresse, C.ville, C.codePostal, C.dateInscription, U.motDePasse FROM Client C
    JOIN Utilisateur U ON C.idUtilisateur = U.idUtilisateur;

DROP USER IF EXISTS site@localhost;
CREATE USER site@localhost IDENTIFIED BY 'P@ssw0rd';
GRANT SELECT ON v_Produits TO site@localhost;
GRANT SELECT ON TypeAge TO site@localhost;
GRANT SELECT ON TypeProduit TO site@localhost;
GRANT SELECT ON Franchise TO site@localhost;

DROP USER IF EXISTS client@localhost;
CREATE USER client@localhost IDENTIFIED BY 'P@ssw0rd2';
GRANT SELECT ON v_Users TO client@localhost;
GRANT SELECT, UPDATE, INSERT, DELETE ON Utilisateur TO client@localhost;
GRANT SELECT, UPDATE, INSERT, DELETE ON Client TO client@localhost;
GRANT SELECT, UPDATE, INSERT, DELETE ON Panier TO client@localhost;

DROP USER IF EXISTS admin@localhost;
CREATE USER admin@localhost IDENTIFIED BY 'password';
GRANT ALL ON BriqueABrac.* TO admin@localhost WITH GRANT OPTION;
GRANT CREATE USER ON *.* TO admin@localhost;
FLUSH PRIVILEGES;

INSERT INTO Utilisateur (email, motDePasse) VALUES ('cedric@email.com', '$2y$12$Pzozvyatd3KbaUF2Q5/QQu4fUMcSFeFns6EBXBctkGz1x9NBuDCFK'); -- Mot de passe est 'passwd'. Obtenu avec password_hash
INSERT INTO Client (nom, prenom, ville, adresse, codePostal, numeroTelephone, dateInscription, idUtilisateur) VALUES ('Pluh', 'Cédric', 'Montpellier', '15 Rue des Oliviers', '34000', '0612345678', '2025-12-15', 1);

INSERT INTO Panier (idProduit, idClient, qte) VALUES ((SELECT idProduit FROM Produit WHERE nom = 'Mercedes F1'), 1, 3);
INSERT INTO Panier (idProduit, idClient, qte) VALUES ((SELECT idProduit FROM Produit WHERE nom = 'Château de Neuschwanstein'), 1, 1);
INSERT INTO Panier (idProduit, idClient, qte) VALUES ((SELECT idProduit FROM Produit WHERE nom = 'Dracaufeu'), 1, 2);

INSERT INTO Commande (dateCommande, dateLivraison, idClient) VALUES
('2026-02-15 14:30:25', ADDDATE(dateCommande, INTERVAL 15 DAY), 1),
(NOW(), null, 1);

INSERT INTO DetailCommande (idProduit, idCommande, qte) VALUES
((SELECT idProduit FROM Produit WHERE nom = 'Apollo Saturn V'), 1, 2),
((SELECT idProduit FROM Produit WHERE nom = 'Camion de Commande de Sonic'), 1, 1),

((SELECT idProduit FROM Produit WHERE nom = 'Bouquet de fleurs'), 2, 1),
((SELECT idProduit FROM Produit WHERE nom = 'Train Arctique télécommandé'), 2, 3),
((SELECT idProduit FROM Produit WHERE nom = 'WALL-E et EVE'), 2, 1);