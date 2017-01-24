

CREATE TABLE IF NOT EXISTS `byteme_no`.`prosjektweb_person` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NOT NULL,
  `tlf` VARCHAR(20) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `bio` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `byteme_no`.`prosjektweb_diary` (
  `postID` INT NOT NULL AUTO_INCREMENT,
  `owner` INT NOT NULL,
  `title` VARCHAR(255) NULL,
  `date` DATE NULL,
  `content` VARCHAR(5000) NULL,
  PRIMARY KEY (`postID`),
  INDEX `fk_Dagbok_Deltaker_idx` (`owner` ASC),
  CONSTRAINT `fk_Dagbok_Deltaker`
    FOREIGN KEY (`owner`)
    REFERENCES `byteme_no`.`prosjektweb_person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `byteme_no`.`prosjektweb_links` (
  `text` VARCHAR(255) NOT NULL,
  `link` VARCHAR(255) NOT NULL,
  `postID` INT NOT NULL,
  PRIMARY KEY (`link`, `postID`),
  INDEX `fk_Links_Dagbok1_idx` (`postID` ASC),
  CONSTRAINT `fk_Links_Dagbok1`
    FOREIGN KEY (`postID`)
    REFERENCES `byteme_no`.`prosjektweb_diary` (`postID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB