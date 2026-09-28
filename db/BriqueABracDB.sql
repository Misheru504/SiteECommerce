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

CREATE TABLE IF NOT EXISTS Token (
    idToken INT NOT NULL AUTO_INCREMENT,
    tokenHash CHAR(64) NOT NULL UNIQUE,
    dateExpiration DATETIME NOT NULL,
    nomAppareil VARCHAR(50),

    idUtilisateur INT NOT NULL,

    CONSTRAINT pk_token PRIMARY KEY (idToken),
    CONSTRAINT fk_token_utilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
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
    codeSet VARCHAR(10) UNIQUE,
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
INSERT INTO TypeAge (idAge, libelle) VALUES
(1, '1+'), (2, '4+'), (3, '6+'), (4, '9+'), (5, '14+'), (6, '18+');
INSERT INTO Franchise (idFranchise, libelle) VALUES
(1, 'NASA'), (2, 'Disney'), (3, 'Star Wars'), (4, 'Pokémon'), (5, 'City'), (6, 'Marvel'), (7, 'Ninjago'),
(8, 'Technic'), (9, 'Icons'), (10, 'Creator'), (11, 'Architecture'), (12, 'Harry Potter'),
(13, 'Speed Champions'), (14, 'Botanicals'), (15, 'Sonic'), (16, 'Friends');
INSERT INTO TypeProduit (idType, libelle) VALUES
(1, 'Set'), (2, 'Figurine'), (3, 'Collector'), (4, 'Sachet'), (5, 'Technic'),
(6, 'Casque'), (7, 'UCS'), (8, 'BrickHeadz'), (9, 'Modulaire'), (10, 'Mech');

INSERT INTO Produit (idProduit, codeSet, nom, description, nbPieces, prix, promo, idAge, idType, idFranchise) VALUES
(1, '92176', 'Apollo Saturn V', 'Revivez les missions lunaires habitées Apollo.', 1969, 119.99, 10.00, (SELECT idAge FROM TypeAge WHERE libelle = '14+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'), (SELECT idFranchise FROM Franchise WHERE libelle = 'NASA')),
(2, '42221', 'SLS Artémis', 'Recréez le lancement des missions Artémis I et II !', 632, 59.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '9+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Technic'), (SELECT idFranchise FROM Franchise WHERE libelle = 'NASA')),
(3, '77255', 'Flash McQueen', 'Préparez vous pour la course !', 270, 27.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '9+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Set'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Disney')),
(4, '43279', 'WALL-E et EVE', 'Exprimez votre passion pour le film WALL-E.', 811, 69.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Set'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Disney')),
(5, '43284', 'Anna et Elsa miniatures', 'Offrez les deux protagonistes de la Reine des Neiges à votre enfant', 65, 9.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '4+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Sachet'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Disney')),
(6, '10283', 'Navette spatiale Discovery', 'La navette Discovery et le télescope Hubble à construire.', 2354, 199.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'), (SELECT idFranchise FROM Franchise WHERE libelle = 'NASA')),
(7, '71040', 'Château de la Belle au Bois Dormant', 'Recréez le château emblématique de Disney avec ce set détaillé.', 4080, 349.99, 5.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Disney')),
(8, '43249', 'Stitch', 'Construisez le personnage adorable de Lilo & Stitch.', 730, 64.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Disney')),
(9, '75403', 'Grogu', 'Construisez Grogu dans son landau flottant. Un set détaillé pour les fans.', 1048, 99.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(10, '75409', 'UCS Jango Fett Firespray', 'Le vaisseau de Jango Fett en version Ultimate Collector Series.', 2970, 299.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'UCS'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(11, '75429', 'Casque AT-AT Driver', 'Ajoutez ce casque iconique à votre collection Star Wars.', 730, 79.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Casque'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(12, '75401', 'Intercepteur Jedi d''Ahsoka', 'Le chasseur Jedi d''Ahsoka Tano de la série Clone Wars.', 290, 44.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '9+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Set'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(13, '75402', 'ARC-170 Starfighter', 'Recréez le chasseur ARC-170 vu dans les guerres cloniques.', 497, 69.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '9+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Set'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(14, '75410', 'N-1 Starfighter Mando et Grogu', 'Le vaisseau de Din Djarin avec Grogu et R5-D4.', 92, 29.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '4+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Set'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(15, '75416', 'Chopper (C1-10P)', 'Le droïde astromech Chopper de Star Wars Rebels à construire.', 1039, 109.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(16, '75408', 'Casque Jango Fett', 'Le casque Mandalorien de Jango Fett à exposer.', 616, 79.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Casque'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(17, '75417', 'UCS AT-ST', 'Le marcheur AT-ST en version Ultimate Collector Series avec socle.', 1513, 199.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '18+'), (SELECT idType FROM TypeProduit WHERE libelle = 'UCS'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(18, '75413', 'Juggernaut de la République', 'Le tank turbo des clones avec ses 10 roues massives.', 813, 149.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '9+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Set'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(19, '75433', 'Vaisseau de Jango Fett', 'Version playscale du vaisseau Firespray avec Jango et jeune Boba.', 707, 69.99, 5.00, (SELECT idAge FROM TypeAge WHERE libelle = '9+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Set'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(20, '40806', 'AT-AT en pain d''épices', 'Un AT-AT décoré pour les fêtes avec glaçage et guirlandes.', 697, 59.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '9+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Set'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),
(21, '75404', 'Acclamator Star Destroyer', 'Modèle midi-scale du croiseur d''assaut de la République.', 450, 49.99, 0.00, (SELECT idAge FROM TypeAge WHERE libelle = '14+'), (SELECT idType FROM TypeProduit WHERE libelle = 'Collector'), (SELECT idFranchise FROM Franchise WHERE libelle = 'Star Wars')),

-- === POKÉMON ===
(22, '72152', 'Pikachu et Poké Ball', 'Un Pikachu à grande échelle à construire et exposer.', 2050, 199.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Pokémon')),

(23, '72151', 'Évoli', 'Le Pokémon Évoli en version à construire.', 587, 59.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Pokémon')),

(24, '40911', 'Mini Centre Pokémon', 'Une version miniature du Centre Pokémon à construire et exposer.', 233, 24.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Pokémon')),

(25, '72167', 'Dracaufeu vs Voltali : le combat ultime', 'Affrontement entre Dracaufeu et Voltali dans une arène de combat Pokémon.', 751, 119.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '6+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Pokémon')),

-- === CITY ===
(26, '60316', 'Commissariat de Police', 'Le commissariat de police avec véhicules et figurines.', 668, 64.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '6+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'City')),

(27, '60414', 'Caserne de Pompiers', 'La caserne avec camion, hélicoptère et équipe de pompiers.', 843, 79.99, 10.00,
(SELECT idAge FROM TypeAge WHERE libelle = '6+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'City')),

(28, '60392', 'Course de Moto de Police', 'Poursuite en moto à travers la ville.', 59, 9.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '4+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Sachet'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'City')),

(29, '60470', 'Train Arctique télécommandé', 'Train motorisé avec télécommande et décor polaire.', 1517, 199.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'City')),

(30, '42621', 'Hôpital de Heartlake City', 'L''hôpital avec ambulance, salle d''opération et hélicoptère.', 1045, 99.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '6+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Friends')),

-- === MARVEL ===
(31, '76269', 'Tour des Avengers', 'La tour Stark avec multiples étages et détails du MCU.', 5201, 499.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

(32, '76191', 'Gant de l''Infini', 'Recréez le Gant de l''Infini de Thanos avec les pierres.', 590, 89.99, 15.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

(33, '76311', 'Spider-Verse Miles Morales vs The Spot', 'Scène de combat tirée de Across the Spider-Verse.', 375, 49.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

(34, '76325', 'Quinjet des Avengers', 'Le Quinjet bleu d''Age of Ultron avec 5 figurines.', 1131, 119.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

(35, '76324', 'Oscorp Building', 'Le bâtiment Oscorp avec laboratoire et bureau d''Eddie Brock.', 808, 129.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

(36, '76321', 'Spider-Man vs Doc Ock Train', 'La scène du métro de Spider-Man 2 avec Tobey Maguire.', 393, 49.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

(37, '76320', 'Iron Man et War Machine vs Hammer Drones', 'Pack de combat Iron Man 2 avec deux drones Hammer.', 204, 19.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '6+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

(38, '76316', 'Galactus vs Les Quatre Fantastiques', 'Galactus à construire avec les Quatre Fantastiques.', 427, 59.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Figurine'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Marvel')),

-- === NINJAGO ===
(39, '71837', 'Ninjago City Workshops', 'Extension modulaire de la ville Ninjago avec 4 étages et mech.', 3244, 249.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '14+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Modulaire'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Ninjago')),

(40, '71847', 'Le Dragon Gardien', 'Dragon majestueux sur socle d''exposition en roche.', 1650, 149.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '14+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Ninjago')),

(41, '71846', 'Le Mech Chevalier de Feu', 'Mech géant de Kai avec monstre marin à combattre.', 996, 119.99, 5.00,
(SELECT idAge FROM TypeAge WHERE libelle = '14+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Mech'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Ninjago')),

(42, '71848', 'Le Bounty du Temple', 'Le vaisseau Destiny''s Bounty en version display avec support incliné.', 2387, 199.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '14+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Ninjago')),

-- === TECHNIC ===
(43, '10337', 'Lamborghini Countach', 'La Countach 5000 Quattrovalvole avec portes en ciseaux et moteur V12.', 1506, 179.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Technic'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Technic')),

(44, '42205', 'Corvette Chevrolet', 'La Corvette avec direction fonctionnelle et moteur V8.', 732, 59.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Technic'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Technic')),

(45, '42215', 'Excavatrice Volvo EC500', 'Excavatrice motorisée avec fonctions télécommandées.', 2359, 399.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Technic'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Technic')),

(46, '60379', 'Sous-marin d''exploration', 'Sous-marin de recherche en eaux profondes.', 842, 104.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'City')),

(47, '42206', 'F1 Oracle Red Bull Racing RB20', 'La monoplace de Formule 1 Oracle Red Bull Racing RB20 en version Technic à exposer.', 1639, 229.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Technic'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Technic')),

-- === ICONS / CREATOR ===
(48, '10332', 'Place Médiévale', 'Place de ville médiévale avec auberge, fromagerie et tour de guet.', 3304, 229.99, 5.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Modulaire'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Icons')),

(49, '10280', 'Bouquet de fleurs', 'Bouquet de 15 fleurs à construire : roses, marguerites, dahlia.', 756, 59.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Botanicals')),

(50, '10361', 'Train Express des Fêtes', 'Train festif avec locomotive et wagon pour décoration de Noël.', 956, 119.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Icons')),

-- === ARCHITECTURE ===
(51, '21063', 'Château de Neuschwanstein', 'Le célèbre château bavarois en 3455 pièces.', 3455, 269.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Architecture')),

-- === HARRY POTTER ===
(52, '76437', 'Le Terrier', 'La maison des Weasley avec cheminée du Réseau de Cheminette et 10 figurines.', 2405, 259.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '18+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Collector'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Harry Potter')),

-- === SPEED CHAMPIONS ===
(53, '77242', 'Ferrari F1', 'La monoplace Ferrari de Formule 1 avec pilote.', 275, 26.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Speed Champions')),

(54, '77251', 'McLaren F1', 'La monoplace McLaren de Formule 1 avec pilote.', 269, 26.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Speed Champions')),

(55, '77244', 'Mercedes F1', 'La monoplace Mercedes AMG de Formule 1 avec pilote.', 267, 26.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Speed Champions')),

-- === SONIC ===
(56, '77006', 'Camion de Commande de Sonic', 'Le camion de Sonic avec accessoires et personnages.', 747, 69.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Set'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Sonic')),

(57, '77005', 'Knuckles vs Mech Egg Crusher du Dr. Eggman', 'Le robot géant du Dr. Eggman à combattre.', 350, 39.99, 0.00,
(SELECT idAge FROM TypeAge WHERE libelle = '9+'),
(SELECT idType FROM TypeProduit WHERE libelle = 'Mech'),
(SELECT idFranchise FROM Franchise WHERE libelle = 'Sonic'));
COMMIT;


CREATE VIEW IF NOT EXISTS v_Produits (IdProduit, CodeSet, NomProduit, Description, NbPieces, Prix, Promotion, Type, Franchise, Age) AS
    SELECT idProduit, codeSet, nom, description, nbPieces, prix, promo, TP.libelle, F.libelle, TA.libelle FROM Produit P
    LEFT JOIN TypeAge TA ON TA.idAge = P.idAge
    LEFT JOIN TypeProduit TP ON TP.idType = P.idType
    LEFT JOIN Franchise F ON F.idFranchise = P.idFranchise
    ORDER BY idProduit;

CREATE VIEW IF NOT EXISTS v_Users (IdClient, IdUtilisateur, NomClient, PrenomClient, MailClient, NumeroTelClient, Adresse, Ville, CodePostal, DateInscription, MotDePasse) AS
    SELECT C.idClient, C.idUtilisateur, C.nom, C.prenom, U.email, C.numeroTelephone, C.adresse, C.ville, C.codePostal, C.dateInscription, U.motDePasse FROM Client C
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
GRANT SELECT, UPDATE, INSERT, DELETE ON Commande TO client@localhost;
GRANT SELECT, UPDATE, INSERT, DELETE ON DetailCommande TO client@localhost;

DROP USER IF EXISTS BAB_app@localhost;
CREATE USER BAB_app@localhost IDENTIFIED BY 'P@ssw0rd';
GRANT ALL ON BriqueABrac.* TO BAB_app@localhost WITH GRANT OPTION;
GRANT CREATE USER ON *.* TO BAB_app@localhost;
FLUSH PRIVILEGES;

INSERT INTO Utilisateur (idUtilisateur, email, motDePasse) VALUES (1, 'cedric@email.com', '$2y$12$Pzozvyatd3KbaUF2Q5/QQu4fUMcSFeFns6EBXBctkGz1x9NBuDCFK'); -- Mot de passe est 'passwd'. Obtenu avec password_hash
INSERT INTO Client (idClient, nom, prenom, ville, adresse, codePostal, numeroTelephone, dateInscription, idUtilisateur) VALUES (1, 'Perez', 'Cédric', 'Montpellier', '15 Rue des Oliviers', '34000', '0612345678', '2025-12-15', 1);

INSERT INTO Panier (idProduit, idClient, qte) VALUES (55, 1, 3); -- Mercedes F1
INSERT INTO Panier (idProduit, idClient, qte) VALUES (51, 1, 1); -- Château de Neuschwanstein
INSERT INTO Panier (idProduit, idClient, qte) VALUES (25, 1, 2); -- Dracaufeu vs Voltali : le combat ultime

INSERT INTO Commande (idCommande, dateCommande, dateLivraison, idClient) VALUES
(1, '2026-02-15 14:30:25', ADDDATE(dateCommande, INTERVAL 15 DAY), 1),
(2, NOW(), null, 1);

INSERT INTO DetailCommande (idProduit, idCommande, qte) VALUES
(1, 1, 2),  -- Apollo Saturn V
(56, 1, 1), -- Camion de Commande de Sonic

(49, 2, 1), -- Bouquet de fleurs
(29, 2, 3), -- Train Arctique télécommandé
(4, 2, 1);  -- WALL-E et EVE
