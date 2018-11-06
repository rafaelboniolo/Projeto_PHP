-- MySQL Script generated by MySQL Workbench
-- 11/06/18 08:12:15
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`tb_pessoa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tb_pessoa` (
  `id_pessoa` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `nome` VARCHAR(45) NOT NULL COMMENT '',
  `cpf` VARCHAR(45) NOT NULL COMMENT '',
  `rg` VARCHAR(45) NOT NULL COMMENT '',
  `login` VARCHAR(45) NOT NULL COMMENT '',
  `senha` VARCHAR(45) NOT NULL COMMENT '',
  `tipo` ENUM('ADM', 'INV', 'GES') NOT NULL COMMENT '',
  PRIMARY KEY (`id_pessoa`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tb_investidor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tb_investidor` (
  `id_investidor` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `id_pessoa` INT NOT NULL COMMENT '',
  `saldo` DECIMAL(14,4) NULL COMMENT '',
  PRIMARY KEY (`id_investidor`)  COMMENT '',
  INDEX `fk_tb_investidor_tb_pessoa1_idx` (`id_pessoa` ASC)  COMMENT '',
  CONSTRAINT `fk_tb_investidor_tb_pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `mydb`.`tb_pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tb_administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tb_administrador` (
  `id_administrador` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `id_pessoa` INT NOT NULL COMMENT '',
  INDEX `fk_tb_administrador_tb_pessoa1_idx` (`id_pessoa` ASC)  COMMENT '',
  PRIMARY KEY (`id_administrador`)  COMMENT '',
  CONSTRAINT `fk_tb_administrador_tb_pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `mydb`.`tb_pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tb_config_taxa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tb_config_taxa` (
  `id_config_taxa` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `id_administrador` INT NOT NULL COMMENT '',
  `taxa_saque` DOUBLE(3,3) NULL DEFAULT 0,2 COMMENT '',
  `taxa_fundo` DOUBLE(3,3) NULL DEFAULT 0,8 COMMENT '',
  `data` DATE NULL COMMENT '',
  PRIMARY KEY (`id_config_taxa`)  COMMENT '',
  INDEX `fk_tb_config_taxa_tb_administrador1_idx` (`id_administrador` ASC)  COMMENT '',
  CONSTRAINT `fk_tb_config_taxa_tb_administrador1`
    FOREIGN KEY (`id_administrador`)
    REFERENCES `mydb`.`tb_administrador` (`id_administrador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tb_transacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tb_transacao` (
  `id_transacao` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `id_investidor` INT UNSIGNED NOT NULL COMMENT '',
  `id_config_taxa` INT NOT NULL COMMENT '',
  `tipo` ENUM('+', '-') NOT NULL COMMENT '',
  `data` DATE NOT NULL COMMENT '',
  `valor` DECIMAL(14,4) NOT NULL COMMENT '',
  `status` ENUM('ATIVO', 'INATIVO') NOT NULL COMMENT '',
  `data_para_saque` DATE NULL COMMENT '',
  PRIMARY KEY (`id_transacao`)  COMMENT '',
  INDEX `fk_tb_operacao_tb_investidor1_idx` (`id_investidor` ASC)  COMMENT '',
  INDEX `fk_tb_transacao_tb_config_taxa1_idx` (`id_config_taxa` ASC)  COMMENT '',
  CONSTRAINT `fk_tb_operacao_tb_investidor1`
    FOREIGN KEY (`id_investidor`)
    REFERENCES `mydb`.`tb_investidor` (`id_investidor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_transacao_tb_config_taxa1`
    FOREIGN KEY (`id_config_taxa`)
    REFERENCES `mydb`.`tb_config_taxa` (`id_config_taxa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tb_gestor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tb_gestor` (
  `id_gestor` VARCHAR(45) NOT NULL COMMENT '',
  `id_pessoa` INT NOT NULL COMMENT '',
  `meta` DECIMAL(14,4) NULL COMMENT '',
  `giro_maximo` DECIMAL(14,4) NULL COMMENT '',
  PRIMARY KEY (`id_gestor`)  COMMENT '',
  INDEX `fk_tb_gestor_tb_pessoa1_idx` (`id_pessoa` ASC)  COMMENT '',
  CONSTRAINT `fk_tb_gestor_tb_pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `mydb`.`tb_pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tb_aplicacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tb_aplicacoes` (
  `id_aplicacoes` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `id_gestor` VARCHAR(45) NOT NULL COMMENT '',
  `data_compra` DATE NULL COMMENT '',
  `data_venda` DATE NULL COMMENT '',
  `status` ENUM('ATIVO', 'INATIVO') NULL COMMENT '',
  PRIMARY KEY (`id_aplicacoes`)  COMMENT '',
  INDEX `fk_tb_aplicacoes_tb_gestor1_idx` (`id_gestor` ASC)  COMMENT '',
  CONSTRAINT `fk_tb_aplicacoes_tb_gestor1`
    FOREIGN KEY (`id_gestor`)
    REFERENCES `mydb`.`tb_gestor` (`id_gestor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tb_acao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tb_acao` (
  `id_acao` INT NOT NULL COMMENT '',
  `id_aplicacoes` INT NOT NULL COMMENT '',
  `valor` DECIMAL(14,4) NULL COMMENT '',
  `descricao` VARCHAR(45) NULL COMMENT '',
  `tipo` VARCHAR(45) NULL COMMENT '',
  `rendimento` DECIMAL(14,4) NULL COMMENT '',
  `status` ENUM('ATIVO', 'VENDIDA') NULL COMMENT '',
  `valor_compra` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`id_acao`)  COMMENT '',
  INDEX `fk_tb_acao_tb_aplicacoes1_idx` (`id_aplicacoes` ASC)  COMMENT '',
  CONSTRAINT `fk_tb_acao_tb_aplicacoes1`
    FOREIGN KEY (`id_aplicacoes`)
    REFERENCES `mydb`.`tb_aplicacoes` (`id_aplicacoes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tb_historico_acao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tb_historico_acao` (
  `id_historico_acao` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `id_acao` INT NOT NULL COMMENT '',
  `data` DATE NULL COMMENT '',
  `valor` DECIMAL(14,4) NULL COMMENT '',
  PRIMARY KEY (`id_historico_acao`)  COMMENT '',
  INDEX `fk_tb_historico_acao_tb_acao1_idx` (`id_acao` ASC)  COMMENT '',
  CONSTRAINT `fk_tb_historico_acao_tb_acao1`
    FOREIGN KEY (`id_acao`)
    REFERENCES `mydb`.`tb_acao` (`id_acao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tb_solicitacao_saque`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tb_solicitacao_saque` (
  `id_solicitacao_saque` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `valor` DECIMAL(14,4) NULL COMMENT '',
  `data` DATE NULL COMMENT '',
  `status` ENUM('AGUARDANDO', 'APROVADO') NULL COMMENT '',
  `id_transacao` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id_solicitacao_saque`)  COMMENT '',
  INDEX `fk_tb_solicitacao_saque_tb_transacao1_idx` (`id_transacao` ASC)  COMMENT '',
  CONSTRAINT `fk_tb_solicitacao_saque_tb_transacao1`
    FOREIGN KEY (`id_transacao`)
    REFERENCES `mydb`.`tb_transacao` (`id_transacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `mydb`;

DELIMITER $$
USE `mydb`$$
CREATE DEFINER = CURRENT_USER TRIGGER `mydb`.`atualiza_saldos` AFTER INSERT ON `tb_operacao` FOR EACH ROW
BEGIN
	-- atualizar saldo do investidor
    -- e do fundo de investimentos
END$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
