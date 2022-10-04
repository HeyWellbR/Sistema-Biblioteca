SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `db_biblioteca` DEFAULT CHARACTER SET utf8 ;
USE `db_biblioteca` ;

CREATE TABLE IF NOT EXISTS `db_biblioteca`.`alunos` (
  `id_aluno` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `cpf` VARCHAR(45) NOT NULL,
  `telefone` VARCHAR(255) NULL DEFAULT NULL,
  `sexo` VARCHAR(255) NULL DEFAULT NULL,
  `multa` DOUBLE NULL DEFAULT 0,
  PRIMARY KEY (`id_aluno`),
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC) ,
  UNIQUE INDEX `telefone_UNIQUE` (`telefone` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `db_biblioteca`.`livros` (
  `id_livro` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `editora` VARCHAR(255) NULL DEFAULT NULL,
  `genero` VARCHAR(255) NULL DEFAULT NULL,
  `emprestado` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_livro`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `db_biblioteca`.`usuarios` (
  `id_usuario` INT(11) NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  `usuario` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `db_biblioteca`.`emprestimos` (
  `id_emprestimo` INT(11) NOT NULL AUTO_INCREMENT,
  `data_retirada` DATETIME NOT NULL,
  `data_devolucao` DATETIME NULL DEFAULT NULL,
  `situacao` INT(11) NULL DEFAULT NULL,
  `id_aluno` INT(11) NOT NULL,
  `id_livro` INT(11) NOT NULL,
  `id_usuario` INT(11) NOT NULL,
  PRIMARY KEY (`id_emprestimo`),
  INDEX `fk_emprestimos_alunos_idx` (`id_aluno` ASC) ,
  INDEX `fk_emprestimos_livros1_idx` (`id_livro` ASC) ,
  INDEX `fk_emprestimos_usuarios1_idx` (`id_usuario` ASC) ,
  CONSTRAINT `fk_emprestimos_alunos`
    FOREIGN KEY (`id_aluno`)
    REFERENCES `db_biblioteca`.`alunos` (`id_aluno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_emprestimos_livros1`
    FOREIGN KEY (`id_livro`)
    REFERENCES `db_biblioteca`.`livros` (`id_livro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_emprestimos_usuarios1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `db_biblioteca`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO usuarios (id_usuario, nome, usuario, senha) VALUES ('1, welinton, admin, abc123')