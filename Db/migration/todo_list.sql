CREATE DATABASE IF NOT EXISTS `todo_list`;


CREATE  TABLE IF NOT EXISTS `todo_list`.`tasks` (
  `id` INT  AUTO_INCREMENT ,
  `title` varchar(255) NOT NULL ,
  `description` varchar(255) NOT NULL ,
  `created_at` DATETIME,
  `updated_at` DATETIME,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;