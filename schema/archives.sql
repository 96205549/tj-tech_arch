-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 21 Juillet 2017 à 15:42
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `archives`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `fulname` varchar(250) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `email` varchar(250) NOT NULL,
  `idgroupe` int(11) DEFAULT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `contact`
--

INSERT INTO `contact` (`id`, `fulname`, `mobile`, `email`, `idgroupe`, `iduser`) VALUES
(5, '    bouraima joezer', 22996205549, 'bouraimajoezer@gmail.com', 2, 1),
(6, 'oke josué', 22997656612, 'rent@benin.com', 8, 1),
(7, ' Eric Kagonbe', 23565884289, 'erickagonbe@gmail.com', 0, 1),
(8, ' bouraima fèmi', 22996122400, 'bouraimafemi@gmail.com', 8, 1),
(9, ' kertis', 23565884287, 'kertis@gmail.com', 0, 1),
(10, ' Mary', 2348167031146, 'mary@gmail.com', 0, 1),
(11, ' Mr Lorel', 22961183526, 'lorel@gmail.com', 0, 1),
(12, ' festus Codjo', 22962812063, 'festus@gmail.com', 0, 1),
(13, ' gabriel biodoun', 2349030328622, 'gabriel@gmail.com', 0, 1),
(14, '  Avihoue Sidoine', 22996813170, 'sido@gmail.com', 8, 6),
(15, '  clotoe rodrigue', 22996826393, 'clotoeromaric@gmail.com', 8, 6),
(16, 'mounir', 22996089960, 'mounir@gmail.com', 0, 1),
(17, 'Adriel', 22997160460, 'adriel@gmail.com', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `corbeille`
--

CREATE TABLE `corbeille` (
  `idcorb` int(11) NOT NULL,
  `nomfile` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `typefile` varchar(50) DEFAULT NULL,
  `taille` int(11) DEFAULT NULL,
  `iddos` int(11) DEFAULT NULL,
  `date` bigint(20) NOT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `corbeille`
--

INSERT INTO `corbeille` (`idcorb`, `nomfile`, `description`, `typefile`, `taille`, `iddos`, `date`, `iduser`) VALUES
(12, 'femilog.png', 'logo d\'entreprise', NULL, NULL, 31, 1493987934, 1),
(16, 'FAQ_Oracle.pdf', 'xvbxcbd', NULL, NULL, 18, 1494241075, 1),
(17, 'spec.pdf', 'narcice file', NULL, NULL, 18, 1494240584, 1),
(18, 'Architecture _harold.docx', 'architechture harold', NULL, NULL, 18, 1494241202, 1),
(19, NULL, 'dossier impôt 2009', NULL, NULL, 18, 1494937098, 1),
(20, 'Oracle_PL_SQL.pdf', 'oracle PL_SQL', NULL, NULL, 31, 1494583726, 1);

-- --------------------------------------------------------

--
-- Structure de la table `couriel`
--

CREATE TABLE `couriel` (
  `idcouriel` int(11) NOT NULL,
  `message` varchar(250) NOT NULL,
  `iddos` int(11) NOT NULL,
  `type` varchar(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `actif` int(11) NOT NULL DEFAULT '0',
  `lu` int(11) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `exp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `couriel`
--

INSERT INTO `couriel` (`idcouriel`, `message`, `iddos`, `type`, `iduser`, `actif`, `lu`, `date`, `exp`) VALUES
(1, 'dossier transaction 2009', 31, 'doc', 6, 0, 0, NULL, 1),
(2, 'ceci est un dossier vide', 32, 'doc', 6, 0, 0, NULL, 1),
(3, 'cfcnf', 40, 'file', 1, 0, 1, NULL, 7),
(4, 'sdghdffhfjhrrr', 40, 'file', 6, 0, 0, NULL, 7),
(5, 'tzetgezzg sdgsdg egsdg', 17, 'doc', 6, 0, 0, NULL, 7),
(6, 'sdh sdg h dsh s sdh', 44, 'file', 6, 0, 0, NULL, 7),
(7, 'voici le document que vous avez demandé', 32, 'doc', 1, 0, 1, NULL, 6),
(8, 'fichier du retrait des agréments au service administratif des impôts', 40, 'file', 6, 0, 0, NULL, 1),
(9, 'erhjrjf', 31, 'file', 6, 0, 1, NULL, 1),
(10, 'ccncvn', 32, 'doc', 1, 0, 1, NULL, 7),
(11, 'salut voici le document pour litiges et règle', 101, 'doc', 1, 0, 1, NULL, 6),
(12, 'couriel envoyé', 101, 'doc', 6, 0, 0, NULL, 1),
(13, 'couriel envoyé', 101, 'doc', 7, 0, 0, NULL, 6),
(14, 'salut c\'est joe. veillez reçevoir ci joins le document que vous m\'avez demandé', 41, 'file', 7, 0, 0, NULL, 1),
(15, 'salut c\'est joe. veillez reçevoir ci joins le document que vous m\'avez demandé', 41, 'file', 1, 0, 0, NULL, 6),
(16, 'bingo', 44, 'file', 7, 0, 0, '2017-07-18 12:10:01', 1),
(17, 'bingo', 44, 'file', 1, 0, 1, '2017-07-18 12:10:01', 7);

-- --------------------------------------------------------

--
-- Structure de la table `dossier`
--

CREATE TABLE `dossier` (
  `iddos` int(11) NOT NULL,
  `nomdos` varchar(250) NOT NULL,
  `date` bigint(15) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `permission` varchar(250) DEFAULT NULL,
  `idserv` int(11) DEFAULT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dossier`
--

INSERT INTO `dossier` (`iddos`, `nomdos`, `date`, `parent`, `permission`, `idserv`, `iduser`) VALUES
(10, 'impôt course', 1489426363, 0, NULL, NULL, 1),
(11, 'couriel', 1489254558, 0, NULL, NULL, 1),
(12, '2011s', 1489427837, 11, NULL, NULL, 1),
(13, 'big joe', 1489252460, 12, 'read', NULL, 1),
(14, 'courses31', 1489427858, 10, NULL, NULL, 1),
(15, 'better doc', 1490608435, 11, 'read,readWrite', NULL, 1),
(17, 'courses 2014', 1490870438, 16, NULL, 1, 1),
(19, 'suprise doc', 1490871050, 17, NULL, 1, 1),
(21, 'recours', 1490868598, 20, NULL, 1, 1),
(30, 'best folder', 1494496961, 18, 'read,readWrite', 1, 1),
(31, 'cours oracle 2011', 1494583663, 0, 'read,readWrite', 1, 1),
(32, 'dossiercoursier 2006', 1494496916, 31, 'read,readWrite', 1, 1),
(35, 'premier doc', 1494499751, 0, NULL, 2, 1),
(36, 'Dossier sinistre', 1494496316, 32, 'read,readWrite', 1, 1),
(37, 'paiement facture', 1494496449, 30, 'read,readWrite', 1, 1),
(38, 'COURRIER 2017', 1494938911, 0, NULL, 2, 1),
(39, 'COURRIER SORTANT', 1494938972, 38, NULL, 2, 1),
(40, 'COURRIER ARRIVE', 1494938989, 38, NULL, 2, 1),
(41, 'PROPOSITIONS DE SERVICES', 1494939090, 0, NULL, 4, 1),
(42, 'REQUETES', 1494939112, 0, NULL, 4, 1),
(43, 'REQUETES RECUS', 1494939133, 42, NULL, 4, 1),
(44, 'REQUETES TRAITES ET REPONSES', 1494939155, 42, NULL, 4, 1),
(45, 'RESSOURCES HUMAINES', 1494939194, 0, NULL, 2, 1),
(46, 'PERSONNELS', 1494939212, 45, NULL, 2, 1),
(47, 'DEMANDE DE PERMISSION', 1494939238, 46, NULL, 2, 1),
(48, 'AUTORISATION ACCORDEE', 1494939282, 46, NULL, 2, 1),
(49, 'DEMANDE DE CONGE', 1494939297, 46, NULL, 2, 1),
(50, 'TITRES DE CONGE', 1494939324, 46, NULL, 2, 1),
(51, 'CONGE MALADIE', 1494939365, 46, NULL, 2, 1),
(52, 'DEMANDE D\'EXPLICATION', 1494939524, 46, NULL, 2, 1),
(53, 'DEMANDE EMISE', 1494939575, 52, NULL, 2, 1),
(54, 'REPONSE TRANSMISE', 1494939593, 52, NULL, 2, 1),
(55, 'DEMANDE D\'EMPLOI', 1494939645, 45, NULL, 2, 1),
(56, 'DEMANDE DE STAGE', 1494939659, 45, NULL, 2, 1),
(57, 'AVIS DE RECRUTEMENT', 1494939676, 45, NULL, 2, 1),
(58, 'GESTION COMPTABLE ET FISCALE', 1494939719, 0, NULL, 3, 1),
(59, 'GCF 2014', 1494939746, 58, NULL, 3, 1),
(60, 'GFC 2015', 1494939756, 58, NULL, 3, 1),
(61, 'GCF 2016', 1494939769, 58, NULL, 3, 1),
(62, 'GCF 2017', 1494939782, 58, NULL, 3, 1),
(63, 'FACTURES', 1494939799, 0, NULL, 3, 1),
(64, 'PROFORMA', 1494939814, 63, NULL, 3, 1),
(65, 'ACOMPTE', 1494939826, 63, NULL, 3, 1),
(66, 'DEFINITIVES', 1494939838, 63, NULL, 3, 1),
(67, 'PROFORMA 2014', 1494939860, 64, NULL, 3, 1),
(68, 'PROFORMA 2015', 1494939871, 64, NULL, 3, 1),
(69, 'PROFORMA 2016', 1494939884, 64, NULL, 3, 1),
(70, 'PROFORMA 2017', 1494939896, 64, NULL, 3, 1),
(71, 'ACOMPTE 2014', 1494939930, 65, NULL, 3, 1),
(72, 'ACOMPTE 2015', 1494939945, 65, NULL, 3, 1),
(73, 'ACOMPTE 2016', 1494939960, 65, NULL, 3, 1),
(74, 'ACOMPTE 2017', 1494939975, 65, NULL, 3, 1),
(75, 'FACTURES DEF 2014', 1494940017, 66, NULL, 3, 1),
(76, 'FACTURES DEF 2015', 1494940029, 66, NULL, 3, 1),
(77, 'FACTURES DEF 2016', 1494940045, 66, NULL, 3, 1),
(78, 'FACTURES DEF 2017', 1494940055, 66, NULL, 3, 1),
(79, 'REGLEMENT FACTURES', 1494940085, 0, NULL, 3, 1),
(80, 'TVA COLLECTEE 2014', 1494940149, 59, NULL, 3, 1),
(81, 'TVA RECUPERABLE 2014', 1494940172, 59, NULL, 3, 1),
(82, 'TVA REVERSEE 2014', 1494940191, 59, NULL, 3, 1),
(83, 'TVA RESTE A REVERSER 2014', 1494940219, 59, NULL, 3, 1),
(84, 'CA DECLARE 2014', 1494940242, 59, NULL, 3, 1),
(85, 'CA 1ER TRIMESTRE DECLARE 2014', 1494940298, 84, NULL, 3, 1),
(86, 'CA 2E TRIMESTRE DECLARE 2014', 1494940321, 84, NULL, 3, 1),
(87, 'CA 3E TRIMESTRE DECLARE 2014', 1494940336, 84, NULL, 3, 1),
(88, 'CA 4E TRIMESTRE DECLARE 2014', 1494940351, 84, NULL, 3, 1),
(89, 'AUTRES IMPOTS 2014', 1494940451, 59, NULL, 3, 1),
(90, 'AUTRES IMPOTS PAYES 2014', 1494940493, 89, NULL, 3, 1),
(91, 'AUTRES IMPOTS RESTES A PAYER 2014', 1494940526, 89, NULL, 3, 1),
(92, 'FACTURES DEF AVEC TVA', 1494940583, 75, NULL, 3, 1),
(93, 'FACTURES DEF SANS TVA', 1494940606, 75, NULL, 3, 1),
(94, 'AIB 2014', 1494940674, 75, NULL, 3, 1),
(95, 'AIB ENCAISSE 2014', 1494940691, 75, NULL, 3, 1),
(96, 'AIB RETENU 2014', 1494940712, 75, NULL, 3, 1),
(97, 'AIB REVERSE', 1494940730, 75, NULL, 3, 1),
(98, 'AIB RESTE A REVERSE 2014', 1494940771, 75, NULL, 3, 1),
(99, 'MARCHE CONCLU', 1494940908, 0, NULL, 4, 1),
(100, 'LITIGES ENCOURS', 1494940949, 0, NULL, 1, 1),
(101, 'LITIGES REGLES', 1494940959, 0, NULL, 1, 1),
(102, 'LITIGES FAVORABLES', 1494940986, 101, NULL, 1, 1),
(103, 'LITIGES DEFAVORABLES', 1494941001, 101, NULL, 1, 1),
(104, '2014', 1494941027, 102, NULL, 1, 1),
(105, '2015', 1494941036, 102, NULL, 1, 1),
(106, '2016', 1494941047, 102, NULL, 1, 1),
(107, '2017', 1494941056, 102, NULL, 1, 1),
(108, '2014', 1494941090, 103, NULL, 1, 1),
(109, '2015', 1494941101, 103, NULL, 1, 1),
(110, '2016', 1494941112, 103, NULL, 1, 1),
(111, '2017', 1494941130, 103, NULL, 1, 1),
(112, '2017', 1494941278, 43, NULL, 4, 1),
(113, 'SMSING', 1494941493, 41, NULL, 4, 1),
(114, 'DAO', 1494941504, 41, NULL, 4, 1),
(115, 'AUTRES PRESTATIONS SPONTANEES', 1494941535, 41, NULL, 4, 1),
(116, 'TRAITEMENT SALARIAL', 1494941631, 45, NULL, 2, 1),
(117, 'new folder', 1498550996, 0, NULL, 1, 8),
(118, 'trans', 1498551008, 117, NULL, 1, 8);

-- --------------------------------------------------------

--
-- Structure de la table `fichier`
--

CREATE TABLE `fichier` (
  `idfile` int(11) NOT NULL,
  `nomfile` varchar(250) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `iddos` int(11) NOT NULL DEFAULT '0',
  `date` bigint(15) NOT NULL,
  `taille` int(11) DEFAULT NULL,
  `extension` varchar(50) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `idserv` int(11) DEFAULT NULL,
  `permission` varchar(250) DEFAULT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fichier`
--

INSERT INTO `fichier` (`idfile`, `nomfile`, `description`, `iddos`, `date`, `taille`, `extension`, `type`, `idserv`, `permission`, `iduser`) VALUES
(16, 'BOURAIMA Estelle.rar', 'archive 2010', 0, 1488367126, 47424, 'rar', 2, NULL, NULL, 1),
(17, 'Audacity_tutoriel.zip', 'archive 2012', 0, 1488533966, 1698264, 'zip', 2, NULL, NULL, 1),
(20, 'attributype.pdf', 'depot de 700mil', 10, 1490701665, NULL, NULL, 0, 1, NULL, 1),
(21, 'eglise.docx', 'radio king doc', 10, 1490701672, 14246, 'docx', 0, 1, NULL, 1),
(22, 'Cdcharges.docx', 'contrat  de maintenance', 10, 1490701678, NULL, NULL, 0, 1, NULL, 1),
(24, 'mama  adressip.txt', 'document cv de estelle log de jam', 0, 1488384872, 224, 'txt', 1, NULL, NULL, 1),
(25, 'La Saisie de la déclaration.docx', 'contrat  de maintenance', 0, 1488380636, 11695, 'docx', 1, NULL, NULL, 1),
(26, 'Joezer Bouraima candidature analyste programmeur.pdf', 'fichier entrer 2011', 11, 1490701738, NULL, NULL, 0, 1, NULL, 1),
(27, 'JoezerBouraima_manuscrite.pdf', 'fichier sortie 2011 ', 11, 1490701745, NULL, NULL, 0, 1, NULL, 1),
(28, 'ATTESTATION 001.jpg', 'depot de 700mil', 12, 1489252448, NULL, NULL, NULL, NULL, NULL, 1),
(29, 'ACTE DE NAISSANCE 001.jpg', 'contrat  de maintenancui', 12, 1489424055, NULL, NULL, 0, NULL, NULL, 1),
(30, 'tof.jpg', 'fichier course', 14, 1489424154, NULL, NULL, NULL, NULL, NULL, 1),
(31, 'logo.fw.png', 'Mosaly hotel', 15, 1490608465, NULL, NULL, NULL, NULL, NULL, 1),
(40, 'FAQ_Oracle.pdf', 'documentation oracle expresse', 31, 1494583688, 610483, 'pdf', 0, 1, 'read,readWrite', 1),
(41, 'Cotisation 200f.docx', 'cotisation 200f', 31, 1498843868, 13972, 'docx', 0, 1, 'read,readWrite', 1),
(44, 'BOURAIMA Estelle.docx', 'mémoire Estelle Bouraima', 31, 1494583759, 53680, 'docx', 0, 1, 'read,readWrite', 1),
(49, 'Oracle_PL_SQL.pdf', 'facture impot 2018', 31, 1494238733, NULL, NULL, 0, 1, 'read,readWrite', 1),
(52, 'Budget2017 hetin.docx', 'fiche de declaration sinistre', 36, 1498844950, 14116, 'docx', 0, 1, 'read,readWrite', 1),
(53, 'fiche_declaration_sinistre.pdf', 'facture mois octobre 2005', 30, 1494496426, NULL, NULL, NULL, 1, 'read,readWrite', 1),
(54, 'fiche_declaration_sinistre.pdf', 'facture mois novembre 2005', 30, 1494496426, NULL, NULL, NULL, 1, 'read,readWrite', 1),
(55, 'fiche_declaration_sinistre.pdf', 'facture mois decembre 2005', 30, 1494496426, NULL, NULL, NULL, 1, 'read,readWrite', 1),
(56, 'Audacity_tutoriel.pdf', 'paiement facture octobre 2005', 37, 1494496527, NULL, NULL, NULL, 1, 'read,readWrite', 1),
(57, 'guidePapier_lin.pdf', 'paiement facture novembre  2005', 37, 1494496527, NULL, NULL, NULL, 1, 'read,readWrite', 1),
(59, 'boite d\'envoie de message.JPG', 'projet', 104, 1498550813, NULL, NULL, NULL, 1, NULL, 1),
(60, 'Capture.PNG', 'point 1', 118, 1498551021, NULL, NULL, NULL, 1, NULL, 8);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `idgroupe` int(11) NOT NULL,
  `nomgroupe` varchar(250) NOT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`idgroupe`, `nomgroupe`, `iduser`) VALUES
(2, 'La roche', 1),
(8, 'joefree', 1),
(9, 'CLIENTS 2017', 1),
(10, ' FOURNISSEUR 2017', 1);

-- --------------------------------------------------------

--
-- Structure de la table `modelesms`
--

CREATE TABLE `modelesms` (
  `idmodel` int(11) NOT NULL,
  `sms` text NOT NULL,
  `date` bigint(20) NOT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `modelesms`
--

INSERT INTO `modelesms` (`idmodel`, `sms`, `date`, `iduser`) VALUES
(1, 'je suis la ', 1486926726, 1),
(2, 'nous somme roi de la programmation', 1486926896, 1),
(3, 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra.', 1488878616, 1),
(4, 'bonjour mr lorel c\'est joezer , ceci est un test de mon application  electra. et concernant la messagerie pour benin challenge n\' hesiter pas a me faire confiance ', 1488883029, 1),
(5, 'hello gabriel confirm me this message is dele from benin', 1488906319, 1),
(6, 'bonjour sido, stp vend moi 1000f de credit sur mon mtn et 1000 f aussi sur ma moov', 1498211456, 1),
(7, 'bonjour oui didier demain je suis dispo. on maintien le programme', 1498213803, 1),
(8, 'Salut Adriel. Ok on met le rendez-vous pour ce soir à 19h au carrefour PK10. \r\njoezer', 1498221484, 1);

-- --------------------------------------------------------

--
-- Structure de la table `profile`
--

CREATE TABLE `profile` (
  `idprofile` int(11) NOT NULL,
  `nomprofile` varchar(250) NOT NULL,
  `permission` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `profile`
--

INSERT INTO `profile` (`idprofile`, `nomprofile`, `permission`) VALUES
(1, 'administrateur', 'juridique,administratif,comptabilite,commercial,contact,systeme,corbeille,sms,permission'),
(2, 'utilisateur simple', 'juridique,administratif,comptabilite,contact,corbeille,sms'),
(3, 'utilisateur juridique', 'juridique,contact,systeme,corbeille,sms'),
(8, 'caisse', 'administratif,comptabilite,commercial');

-- --------------------------------------------------------

--
-- Structure de la table `recentactivity`
--

CREATE TABLE `recentactivity` (
  `id` int(11) NOT NULL,
  `activite` varchar(250) NOT NULL,
  `date` bigint(20) NOT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `recentactivity`
--

INSERT INTO `recentactivity` (`id`, `activite`, `date`, `iduser`) VALUES
(1, 'jojoa modifier un fichier', 1488497835, 1),
(2, ' a ajouter un nouveau fichier', 1488498064, 1),
(3, 'jojo a ajouter a ajout? des fichiers au dossierimpôt 2008', 1488498778, 1),
(4, 'jojo a modifier un fichier', 1488499826, 1),
(5, 'jojo a supprimer un fichier', 1488499828, 1),
(6, 'jojo a modifier un fichier', 1488499828, 1),
(7, 'jojo a supprimer un fichier', 1488499840, 1),
(8, 'jojo a modifier un fichier', 1488499840, 1),
(9, 'jojo a modifier un fichier', 1488499926, 1),
(10, 'jojo a modifier un fichier', 1488499926, 1),
(11, 'jojo a modifier un fichier', 1488500018, 1),
(12, 'jojo a modifier un fichier', 1488533907, 1),
(13, 'jojo a modifier un fichier', 1488533949, 1),
(14, 'jojo a modifier un fichier', 1488533964, 1),
(15, 'jojo a modifier un fichier', 1488533966, 1),
(16, 'jojo a supprimer un fichier', 1489066712, 1),
(17, 'jojo a ajouter le dossier ', 1489252354, 1),
(18, 'jojo a ajouter le dossier ', 1489252448, 1),
(19, 'jojo a ajouter le dossier ', 1489424155, 1),
(20, 'jojo a ajouter le dossier ', 1490608466, 1),
(21, 'jojo a ajouter le dossier ', 1490700679, 1),
(22, 'jojo a ajouter le dossier ', 1490794938, 1),
(23, 'jojo a ajouter le dossier ', 1490871076, 1),
(24, 'jojo a ajouter le dossier ', 1490871125, 1),
(25, 'jojo a ajouter le dossier ', 1490871139, 1),
(26, 'jojo a ajouter le dossier ', 1490873231, 1),
(27, 'jojo a ajouter le dossier ', 1490958172, 1),
(28, 'jojo a ajouter le dossier ', 1490958439, 1),
(29, 'jojo a ajouter le dossier ', 1490958564, 1),
(30, 'jojo a ajouter le dossier ', 1491846562, 1),
(31, 'jojo a ajouter le dossier ', 1491846879, 1),
(32, 'jojo a ajouter le dossier ', 1494238316, 1),
(33, 'jojo a ajouter le dossier ', 1494238542, 1),
(34, 'jojo a ajouter le dossier ', 1494241075, 1),
(35, 'jojo a ajouter le dossier ', 1494241202, 1),
(36, 'jojorup a ajouter le dossier ', 1494496277, 1),
(37, 'jojorup a ajouter le dossier ', 1494496426, 1),
(38, 'jojorup a ajouter le dossier ', 1494496527, 1),
(39, 'jojorup a ajouter le dossier ', 1498550781, 1),
(40, 'jojorup a ajouter le dossier ', 1498550813, 1),
(41, 'Abigail a ajouter le dossier ', 1498551021, 8);

-- --------------------------------------------------------

--
-- Structure de la table `sendsms`
--

CREATE TABLE `sendsms` (
  `idsms` int(11) NOT NULL,
  `expediteur` varchar(250) NOT NULL,
  `destinataire` text NOT NULL,
  `message` text NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'en cours',
  `date` bigint(20) NOT NULL,
  `iduser` int(11) NOT NULL,
  `archiver` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `sendsms`
--

INSERT INTO `sendsms` (`idsms`, `expediteur`, `destinataire`, `message`, `status`, `date`, `iduser`, `archiver`) VALUES
(1, 'joe free', '+22996813170', 'merci seigneur', 'En cour d\'envoi', 1486926311, 1, 1),
(2, 'joe free', '+22996205549', 'merci seigneur', 'En cour d\'envoi', 1486926311, 1, 1),
(3, 'joe free', '+22997656612', 'je suis la ', 'En cour d\'envoi', 1486926725, 1, 1),
(4, 'joe free', '+22997656612', 'nous somme roi de la programmation', 'En cour d\'envoi', 1486926895, 1, 1),
(5, 'joe free', '+22997122400', 'nous somme roi de la programmation', 'En cour d\'envoi', 1486926896, 1, 1),
(6, 'joe free', '+22996096632', 'nous somme roi de la programmation', 'En cour d\'envoi', 1486926896, 1, 1),
(7, 'joe free', '+22996813170', 'nous somme roi de la programmation', 'En cour d\'envoi', 1487154468, 1, 1),
(8, 'joe free', '+22996205549', 'nous somme roi de la programmation', 'En cour d\'envoi', 1487154468, 1, 1),
(9, 'joe free', '+22996205549', 'test de l app', 'En cour d\'envoi', 1488378501, 1, 1),
(10, 'joe free', '+22996205549', 'test deux tuto', 'En cour d\'envoi', 1488378542, 1, 1),
(11, 'joe free', '+22996205549', 'nous somme roi de la programmation', 'En cour d\'envoi', 1488378651, 1, 1),
(12, 'joe free', '+22996205549', 'nous somme roi de la programmation', 'En cour d\'envoi', 1488378913, 1, 0),
(13, 'BIG JOE ets', '0022996205549', 'nous somme roi de la programmation', 'En cour d\'envoi', 1488379065, 1, 1),
(14, 'BIG JOE ets', '+22996205549', 'nous somme roi de la programmation', 'En cour d\'envoi', 1488379301, 1, 1),
(15, 'joe free', '+22996205549', 'yktkk kktyktykty jtjttyk', 'En cour d\'envoi', 1488547347, 1, 1),
(16, 'joe free', '+22996813170', 'rutirtiti  ttit tiiri ii ', 'En cour d\'envoi', 1488547371, 1, 1),
(17, 'joe free', '+22996205549', 'rutirtiti  ttit tiiri ii ', 'En cour d\'envoi', 1488547372, 1, 1),
(18, 'joe free', '0022996205549', 'je suis la ', 'En cour d\'envoi', 1488817315, 1, 1),
(19, 'joe free', '0022996205549', 'nous somme roi de la programmation', 'En cour d\'envoi', 1488817733, 1, 1),
(20, 'BIG JOE ets', '+22996205549', 'test', 'En cour d\'envoi', 1488817981, 1, 1),
(21, 'Joeff', '0022996205549', 'hello', 'En cour d\'envoi', 1488818045, 1, 1),
(22, 'BIG JOE ets', '+22996205549', 'cc', 'En cour d\'envoi', 1488818207, 1, 1),
(23, 'BIG JOE ets', '+22996205549', 'cc', 'En cour d\'envoi', 1488818237, 1, 1),
(24, 'love u HBD', '22996813170', 'miss', 'En cour d\'envoi', 1488818310, 1, 1),
(25, 'love u HBD', '+22996205549', 'miss', 'En cour d\'envoi', 1488818311, 1, 1),
(26, 'joe free', '0022996205549', 'valider', 'En cour d\'envoi', 1488818420, 1, 1),
(27, 'rico', '0022996205549', 'test', 'En cour d\'envoi', 1488818489, 1, 1),
(28, 'BENINCHALL', '0022996205549', 'testb', 'En cour d\'envoi', 1488818537, 1, 1),
(29, 'B-challenge', '+22996205549', 'hellojoe', 'En cour d\'envoi', 1488819053, 1, 1),
(30, 'tweeceJoe', '+22997656612', 'testServeur', 'En cour d\'envoi', 1488821923, 1, 1),
(31, 'tweeceJoe', '+22996205549', 'testServeur', 'En cour d\'envoi', 1488821925, 1, 1),
(32, 'Electra', '+23565884289', 'benin_test_electra', 'En cour d\'envoi', 1488876851, 1, 1),
(33, 'Electra', '+22996205549', 'benin_test_electra', 'En cour d\'envoi', 1488876852, 1, 0),
(34, 'Electra', '23565884289', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra. ', 'En cour d\'envoi', 1488877896, 1, 1),
(35, 'Electra', '22997656612', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra. ', 'En cour d\'envoi', 1488877897, 1, 1),
(36, 'Electra', '22996205549', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra. ', 'En cour d\'envoi', 1488877898, 1, 1),
(37, 'Electra', '22996205549', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra.', 'En cour d\'envoi', 1488878472, 1, 1),
(38, 'joe+free', '22996205549', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra.', 'En cour d\'envoi', 1488878615, 1, 1),
(39, 'Electra', '2348167031146', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra.', 'En cour d\'envoi', 1488878722, 1, 1),
(40, 'Electra', '23565884287', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra.', 'En cour d\'envoi', 1488878723, 1, 1),
(41, 'Electra', '22996122400', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra.', 'En cour d\'envoi', 1488878724, 1, 1),
(42, 'Electra', '22996205549', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra.', 'En cour d\'envoi', 1488878725, 1, 1),
(43, 'Electra', '22961183526', 'bonjour mr lorel c\'est joezer , ceci est un test de mon application  electra. et concernant la messagerie pour benin challenge n\' hesiter pas a me faire confiance ', 'En cour d\'envoi', 1488883028, 1, 1),
(44, 'Electra', '22996205549', 'bonjour mr lorel c\'est joezer , ceci est un test de mon application  electra. et concernant la messagerie pour benin challenge n\' hesiter pas a me faire confiance ', 'En cour d\'envoi', 1488883029, 1, 1),
(45, 'Electra', '22962812063', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra.', 'En cour d\'envoi', 1488886989, 1, 1),
(46, 'Electra', '22996205549', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joezer depuis le benin, ceci est un test de l\' application electra.', 'En cour d\'envoi', 1488886992, 1, 1),
(47, 'Electra', '2348167031146', 'test depuis le serveur from benin', 'En cour d\'envoi', 1488904687, 1, 1),
(48, 'Electra', '22996205549', 'test depuis le serveur from benin', 'En cour d\'envoi', 1488904688, 1, 1),
(49, 'Electra', '2348167031146', 'test depuis le serveur from benin', 'En cour d\'envoi', 1488904694, 1, 1),
(50, 'Electra', '22996205549', 'test depuis le serveur from benin', 'En cour d\'envoi', 1488904695, 1, 1),
(51, 'Electra', '2349030328622', 'hello gabriel confirm me this message is dele from benin', 'Envoyer', 1488906313, 1, 1),
(52, 'Electra', '22996205549', 'hello gabriel confirm me this message is dele from benin', 'Envoyer', 1488906316, 1, 1),
(53, 'Electra', '22996205549', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joe depuis le benin, ceci est un test de l\' application electra.', 'Envoyer', 1488915623, 1, 1),
(54, 'Electra', '22996813170', 'bonjour les amis veuillez me confirmer la reception de ce message c\'est joe depuis le benin, ceci est un test de l\' application electra.', 'Envoyer', 1488915626, 1, 1),
(55, 'Electra', '22996205549', 'mot de passe joefree', 'Envoyer', 1488916889, 1, 1),
(56, 'Electra', '22966615117', 'mot de passe joefree', 'Envoyer', 1488916891, 1, 1),
(57, 'Electra', '22996089960', 'ceci est un test de l\'application electra', 'Envoyer', 1488972354, 1, 1),
(58, 'Electra', '22996205549', 'ceci est un test de l\'application electra', 'Envoyer', 1488972355, 1, 1),
(59, 'joe+free', '22962812063', '19h je vais passe ', 'Envoyer', 1489074348, 1, 1),
(60, 'joe+free', '22996205549', '19h je vais passe ', 'Envoyer', 1489074349, 1, 1),
(61, 'jojo', '22996813170', 'bonjour sido, stp vend moi 1000f de credit sur mon mtn et 1000 f aussi sur ma moov', 'Envoyer', 1498210982, 1, 1),
(62, 'jojo', '22996205549', 'bonjour sido, stp vend moi 1000f de credit sur mon mtn et 1000 f aussi sur ma moov', 'Envoyer', 1498210986, 1, 1),
(63, 'joefree', '22996813170', 'bonjour sido, stp vend moi 1000f de credit sur mon mtn et 1000 f aussi sur ma moov', 'Envoyer', 1498211450, 1, 1),
(64, 'joefree', '22996205549', 'bonjour sido, stp vend moi 1000f de credit sur mon mtn et 1000 f aussi sur ma moov', 'Envoyer', 1498211453, 1, 1),
(65, 'joezer', '+22994439674', 'bonjour oui didier demain je suis dispo. on maintien le programme', 'Envoyer', 1498213797, 1, 1),
(66, 'joezer', '96205549', 'bonjour oui didier demain je suis dispo. on maintien le programme', 'Envoyer', 1498213800, 1, 1),
(67, 'dele', '+22961306523', 'foumi vend moi 500f de credit sur mon numero 94748280', 'Envoyer', 1498214091, 1, 1),
(68, 'Tj-tech', '22997160460', 'Salut Adriel. Ok on met le rendez-vous pour ce soir à 19h au carrefour PK10. \r\njoezer', 'Envoyer', 1498221473, 1, 1),
(69, 'Tj-tech', '22997656612', 'Salut Adriel. Ok on met le rendez-vous pour ce soir à 19h au carrefour PK10. \r\njoezer', 'Envoyer', 1498221477, 1, 1),
(70, 'Tj-tech', '22996205549', 'Salut Adriel. Ok on met le rendez-vous pour ce soir à 19h au carrefour PK10. \r\njoezer', 'Envoyer', 1498221480, 1, 1),
(71, 'Electra', '22996205549', 'je suis la ', 'Envoyer', 1498232164, 1, 1),
(72, 'Electra', '22997656612', 'je suis la ', 'Envoyer', 1498232167, 1, 1),
(73, 'Electra', '22996205549', 'je suis la ', 'Envoyer', 1498232613, 1, 1),
(74, 'Electra', '22996205549', 'je suis la ok', 'Envoyer', 1498232775, 1, 1),
(75, 'tj-tech', '22997656612', 'test alpha', 'Envoyer', 1498232867, 1, 1),
(76, 'tj-tech', '22996122400', 'test alpha', 'Envoyer', 1498232868, 1, 1),
(77, 'tj-tech', '22996813170', 'test alpha', 'Envoyer', 1498232869, 1, 1),
(78, 'tj-tech', '22996826393', 'test alpha', 'Envoyer', 1498232870, 1, 1),
(79, 'tj-tech', '22996205549', 'test alpha', 'Envoyer', 1498232871, 1, 1),
(80, 'joezer', '+22996138021', 'salut gg je l\'ai call mais il m\'a dit qu\'il na pas d\'argent.', 'Envoyer', 1500538875, 1, 0),
(81, 'joezer', '+22996205549', 'salut gg je l\'ai call mais il m\'a dit qu\'il na pas d\'argent.', 'Envoyer', 1500538884, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `idserv` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `keyword` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `service`
--

INSERT INTO `service` (`idserv`, `description`, `keyword`) VALUES
(1, 'Service juridique', 'juridique'),
(2, 'Service administratif', 'administratif'),
(3, 'Service comptabilite', 'comptabilite'),
(4, 'Service commercial', 'commercial');

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `data` varchar(250) DEFAULT NULL,
  `module` text,
  `logo` varchar(250) DEFAULT NULL,
  `icone` varchar(250) DEFAULT NULL,
  `structure` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `settings`
--

INSERT INTO `settings` (`id`, `data`, `module`, `logo`, `icone`, `structure`) VALUES
(1, 'electra', 'juridique,administratif,comptabilite,commercial,contact,messagerie', 'logo.png', 'original.jpg', 'oceanic');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `fulname` varchar(250) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `idprofile` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`iduser`, `fulname`, `pseudo`, `email`, `idprofile`, `password`, `actif`) VALUES
(1, 'bouraima joezer', 'jojorup', 'bouraimajoezer@gmail.com', 1, '89e495e7941cf9e40e6980d14a16bf023ccd4c91', 1),
(6, 'Bouraima ayodele', 'demo', 'demo@gmail.com', 2, '89e495e7941cf9e40e6980d14a16bf023ccd4c91', 1),
(7, 'oke jouse', 'admin', 'admin@gmail.com', 1, '33f83e5857345f1ea502ba26bd4ec1c88b2259be', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `corbeille`
--
ALTER TABLE `corbeille`
  ADD PRIMARY KEY (`idcorb`);

--
-- Index pour la table `couriel`
--
ALTER TABLE `couriel`
  ADD PRIMARY KEY (`idcouriel`);

--
-- Index pour la table `dossier`
--
ALTER TABLE `dossier`
  ADD PRIMARY KEY (`iddos`);

--
-- Index pour la table `fichier`
--
ALTER TABLE `fichier`
  ADD PRIMARY KEY (`idfile`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`idgroupe`);

--
-- Index pour la table `modelesms`
--
ALTER TABLE `modelesms`
  ADD PRIMARY KEY (`idmodel`);

--
-- Index pour la table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`idprofile`);

--
-- Index pour la table `recentactivity`
--
ALTER TABLE `recentactivity`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sendsms`
--
ALTER TABLE `sendsms`
  ADD PRIMARY KEY (`idsms`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`idserv`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `corbeille`
--
ALTER TABLE `corbeille`
  MODIFY `idcorb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `couriel`
--
ALTER TABLE `couriel`
  MODIFY `idcouriel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `dossier`
--
ALTER TABLE `dossier`
  MODIFY `iddos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;
--
-- AUTO_INCREMENT pour la table `fichier`
--
ALTER TABLE `fichier`
  MODIFY `idfile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `idgroupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `modelesms`
--
ALTER TABLE `modelesms`
  MODIFY `idmodel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `profile`
--
ALTER TABLE `profile`
  MODIFY `idprofile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `recentactivity`
--
ALTER TABLE `recentactivity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT pour la table `sendsms`
--
ALTER TABLE `sendsms`
  MODIFY `idsms` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `idserv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
