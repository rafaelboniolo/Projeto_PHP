-- MySQL Script generated by MySQL Workbench
-- Thu Nov  8 11:05:39 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema utfundos
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema utfundos
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `utfundos` DEFAULT CHARACTER SET utf8 ;
USE `utfundos` ;

-- -----------------------------------------------------
-- Table `utfundos`.`tb_pessoa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `utfundos`.`tb_pessoa` (
  `id_pessoa` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `cpf` VARCHAR(45) NOT NULL,
  `rg` VARCHAR(45) NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `tipo` ENUM('ADM', 'INV', 'GES') NOT NULL,
  PRIMARY KEY (`id_pessoa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `utfundos`.`tb_investidor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `utfundos`.`tb_investidor` (
  `id_investidor` INT NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT NOT NULL,
  `saldo` DECIMAL(14,4) NULL,
  PRIMARY KEY (`id_investidor`),
  INDEX `fk_tb_investidor_tb_pessoa1_idx` (`id_pessoa` ASC) VISIBLE,
  CONSTRAINT `fk_tb_investidor_tb_pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `utfundos`.`tb_pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `utfundos`.`tb_administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `utfundos`.`tb_administrador` (
  `id_administrador` INT NOT NULL AUTO_INCREMENT,
  `id_pessoa` INT NOT NULL,
  INDEX `fk_tb_administrador_tb_pessoa1_idx` (`id_pessoa` ASC) VISIBLE,
  PRIMARY KEY (`id_administrador`),
  CONSTRAINT `fk_tb_administrador_tb_pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `utfundos`.`tb_pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `utfundos`.`tb_config_taxa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `utfundos`.`tb_config_taxa` (
  `id_config_taxa` INT NOT NULL AUTO_INCREMENT,
  `id_administrador` INT NOT NULL,
  `taxasaque` DOUBLE(3,3) NULL DEFAULT 0.2,
  `taxafundo` DOUBLE(3,3) NULL DEFAULT 0.8,
  `data` DATE NULL,
  PRIMARY KEY (`id_config_taxa`),
  INDEX `fk_tb_config_taxa_tb_administrador1_idx` (`id_administrador` ASC) VISIBLE,
  CONSTRAINT `fk_tb_config_taxa_tb_administrador1`
    FOREIGN KEY (`id_administrador`)
    REFERENCES `utfundos`.`tb_administrador` (`id_administrador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `utfundos`.`tb_transacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `utfundos`.`tb_transacao` (
  `id_transacao` INT NOT NULL AUTO_INCREMENT,
  `id_investidor` INT NOT NULL,
  `id_config_taxa` INT NOT NULL,
  `tipo` ENUM('+', '-') NOT NULL,
  `data` DATE NOT NULL,
  `valor` DECIMAL(14,4) NOT NULL,
  `status` ENUM('ATIVO', 'INATIVO') NOT NULL,
  `datasaque` DATE NULL,
  PRIMARY KEY (`id_transacao`),
  INDEX `fk_tb_operacao_tb_investidor1_idx` (`id_investidor` ASC) VISIBLE,
  INDEX `fk_tb_transacao_tb_config_taxa1_idx` (`id_config_taxa` ASC) VISIBLE,
  CONSTRAINT `fk_tb_operacao_tb_investidor1`
    FOREIGN KEY (`id_investidor`)
    REFERENCES `utfundos`.`tb_investidor` (`id_investidor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_transacao_tb_config_taxa1`
    FOREIGN KEY (`id_config_taxa`)
    REFERENCES `utfundos`.`tb_config_taxa` (`id_config_taxa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `utfundos`.`tb_gestor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `utfundos`.`tb_gestor` (
  `id_gestor` VARCHAR(45) NOT NULL,
  `id_pessoa` INT NOT NULL,
  `meta` DECIMAL(14,4) NULL,
  `giromaximo` DECIMAL(14,4) NULL,
  PRIMARY KEY (`id_gestor`),
  INDEX `fk_tb_gestor_tb_pessoa1_idx` (`id_pessoa` ASC) VISIBLE,
  CONSTRAINT `fk_tb_gestor_tb_pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `utfundos`.`tb_pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `utfundos`.`tb_aplicacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `utfundos`.`tb_aplicacoes` (
  `id_aplicacoes` INT NOT NULL AUTO_INCREMENT,
  `id_gestor` VARCHAR(45) NOT NULL,
  `datacompra` DATE NULL,
  `datavenda` DATE NULL,
  `status` ENUM('ATIVO', 'INATIVO') NULL,
  PRIMARY KEY (`id_aplicacoes`),
  INDEX `fk_tb_aplicacoes_tb_gestor1_idx` (`id_gestor` ASC) VISIBLE,
  CONSTRAINT `fk_tb_aplicacoes_tb_gestor1`
    FOREIGN KEY (`id_gestor`)
    REFERENCES `utfundos`.`tb_gestor` (`id_gestor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `utfundos`.`tb_acao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `utfundos`.`tb_acao` (
  `id_acao` INT NOT NULL,
  `id_aplicacoes` INT NOT NULL,
  `valor` DECIMAL(14,4) NULL,
  `descricao` VARCHAR(45) NULL,
  `tipo` VARCHAR(45) NULL,
  `rendimento` DECIMAL(14,4) NULL,
  `status` ENUM('ATIVO', 'VENDIDA') NULL,
  `valorcompra` VARCHAR(45) NULL,
  PRIMARY KEY (`id_acao`),
  INDEX `fk_tb_acao_tb_aplicacoes1_idx` (`id_aplicacoes` ASC) VISIBLE,
  CONSTRAINT `fk_tb_acao_tb_aplicacoes1`
    FOREIGN KEY (`id_aplicacoes`)
    REFERENCES `utfundos`.`tb_aplicacoes` (`id_aplicacoes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `utfundos`.`tb_historico_acao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `utfundos`.`tb_historico_acao` (
  `id_historico_acao` INT NOT NULL AUTO_INCREMENT,
  `id_acao` INT NOT NULL,
  `data` DATE NULL,
  `valor` DECIMAL(14,4) NULL,
  PRIMARY KEY (`id_historico_acao`),
  INDEX `fk_tb_historico_acao_tb_acao1_idx` (`id_acao` ASC) VISIBLE,
  CONSTRAINT `fk_tb_historico_acao_tb_acao1`
    FOREIGN KEY (`id_acao`)
    REFERENCES `utfundos`.`tb_acao` (`id_acao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `utfundos`.`tb_solicitacao_saque`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `utfundos`.`tb_solicitacao_saque` (
  `id_solicitacao_saque` INT NOT NULL AUTO_INCREMENT,
  `id_investidor` INT NOT NULL,
  `valor` DECIMAL(14,4) NULL,
  `data` DATE NULL,
  `status` ENUM('AGUARDANDO', 'APROVADO') NULL,
  PRIMARY KEY (`id_solicitacao_saque`),
  INDEX `fk_tb_solicitacao_saque_tb_investidor1_idx` (`id_investidor` ASC) VISIBLE,
  CONSTRAINT `fk_tb_solicitacao_saque_tb_investidor1`
    FOREIGN KEY (`id_investidor`)
    REFERENCES `utfundos`.`tb_investidor` (`id_investidor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `utfundos`;

-- DELIMITER $$
-- USE `utfundos`$$
-- CREATE DEFINER = CURRENT_USER TRIGGER `utfundos`.`atualiza_saldos` AFTER INSERT ON `tb_operacao` FOR EACH ROW
-- BEGIN
-- 	-- atualizar saldo do investidor
--     -- e do fundo de investimentos
-- END$$


-- DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
