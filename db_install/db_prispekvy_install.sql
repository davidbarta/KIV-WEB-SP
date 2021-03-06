-- Generated by Oracle SQL Developer Data Modeler 17.2.0.188.1104
--   at:        2017-12-09 15:09:58 CET
--   site:      Oracle Database 11g
--   type:      Oracle Database 11g

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `prispevek`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `prispevek` ;

CREATE TABLE IF NOT EXISTS `prispevek` (
    `id_prispevek`   INTEGER NOT NULL AUTO_INCREMENT,
    `nazev`          VARCHAR(50) NOT NULL,
    `autor`         VARCHAR(100) NOT NULL,
    `abstract`       VARCHAR(300) NOT NULL,
    `pdf_soubor`     VARCHAR(50) NOT NULL,
    `rozhodnuti`     VARCHAR(4) NOT NULL,
    `post`     VARCHAR(4) NOT NULL,
    PRIMARY KEY (`id_prispevek`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `posudek`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `posudek` ;

CREATE TABLE IF NOT EXISTS `posudek` (
    `id_posudek`               INT NOT NULL AUTO_INCREMENT,
    `autor`                    VARCHAR(100) NOT NULL,
    `originalita`              INTEGER NOT NULL,
    `tema`                     INTEGER NOT NULL,
    `technicka_kvalita`        INTEGER NOT NULL,
    `jazykova_kvalita`         INTEGER NOT NULL,
    `doporuceni`               INTEGER NOT NULL,
    `poznamky`                 VARCHAR(300) NOT NULL,
    `id_prispevek`   INTEGER NOT NULL,
    PRIMARY KEY (`id_posudek`),
    INDEX `fk_posudek_prispevek_idx` (`id_prispevek` ASC),
    CONSTRAINT `fk_posudek_prispevek`
      FOREIGN KEY (`id_prispevek`)
      REFERENCES `prispevek` (`id_prispevek`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `prispevek`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `prispevek` (`id_prispevek`, `nazev`, `autor`, `abstract`, `pdf_soubor`, `rozhodnuti`, `post`) VALUES (1, 'První test', 'Honza', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus faucibus molestie nisl. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos.', 'prvni.pdf', 'ne', 'ne');
INSERT INTO `prispevek` (`id_prispevek`, `nazev`, `autor`, `abstract`, `pdf_soubor`, `rozhodnuti`, `post`) VALUES (2, 'Druhý test', 'Autor číslo 1', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus faucibus molestie nisl.', 'druhy.pdf', 'ne', 'ne');
INSERT INTO `prispevek` (`id_prispevek`, `nazev`, `autor`, `abstract`, `pdf_soubor`, `rozhodnuti`, `post`) VALUES (3, 'Třetí test', 'Autor číslo 2', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus faucibus molestie nisl.', 'treti.pdf', 'ne', 'ne');

COMMIT;

-- -----------------------------------------------------
-- Data for table `posudek`
-- -----------------------------------------------------

START TRANSACTION;
INSERT INTO `posudek` (`id_posudek`, `autor`, `originalita`, `tema`, `technicka_kvalita`, `jazykova_kvalita`, `doporuceni`, `poznamky`, `id_prispevek`) VALUES (1, 'Pokusný uživatel', 2, 3, 4, 1, 2, 'Dobré, uvidíme, co se s tím dá dělat.', 1);
INSERT INTO `posudek` (`id_posudek`, `autor`, `originalita`, `tema`, `technicka_kvalita`, `jazykova_kvalita`, `doporuceni`, `poznamky`, `id_prispevek`) VALUES (2, 'Recenzent 1', 2, 2, 2, 3, 4, 'Vypadá to zajímavě.', 1);
INSERT INTO `posudek` (`id_posudek`, `autor`, `originalita`, `tema`, `technicka_kvalita`, `jazykova_kvalita`, `doporuceni`, `poznamky`, `id_prispevek`) VALUES (3, 'Recenzent 2', 1, 1, 1, 1, 2, 'Skvělé, není co vytknout.', 1);
INSERT INTO `posudek` (`id_posudek`, `autor`, `originalita`, `tema`, `technicka_kvalita`, `jazykova_kvalita`, `doporuceni`, `poznamky`, `id_prispevek`) VALUES (4, 'Recenzent 1', 3, 5, 4, 2, 3, 'Ale jo, jde to.', 2);
INSERT INTO `posudek` (`id_posudek`, `autor`, `originalita`, `tema`, `technicka_kvalita`, `jazykova_kvalita`, `doporuceni`, `poznamky`, `id_prispevek`) VALUES (5, 'Pokusný uživatel', 5, 5, 3, 5, 5, 'Tohle je bohužel neakceptovatelné!', 3);

COMMIT;

