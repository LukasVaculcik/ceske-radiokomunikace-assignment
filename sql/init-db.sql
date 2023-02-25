-- MySQL Script generated by MySQL Workbench
-- Sat Feb 25 13:44:55 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema default_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema default_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `default_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `default_db` ;

-- -----------------------------------------------------
-- Table `default_db`.`animal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `default_db`.`animal` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `sort` INT(4) NOT NULL DEFAULT 0,
  `is_visible` TINYINT NOT NULL DEFAULT 1,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `default_db`.`animal_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `default_db`.`animal_type` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `default_db`.`animal_has_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `default_db`.`animal_has_type` (
  `animal_id` INT UNSIGNED NOT NULL,
  `animal_type_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`animal_id`, `animal_type_id`),
  INDEX `idx_animal_has_type_animal_type1` (`animal_type_id` ASC) INVISIBLE,
  INDEX `idx_animal_has_type_animal1` (`animal_id` ASC) VISIBLE,
  CONSTRAINT `fk_animal_has_type_animal1`
    FOREIGN KEY (`animal_id`)
    REFERENCES `default_db`.`animal` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_animal_has_type_animal_type1`
    FOREIGN KEY (`animal_type_id`)
    REFERENCES `default_db`.`animal_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
