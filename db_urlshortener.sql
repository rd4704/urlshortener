CREATE TABLE `db_urlshortener`.`tbl_urls` (
  `id` INT NOT NULL  AUTO_INCREMENT,
  `url` TEXT NULL,
  `createdon` DATETIME NOT NULL,
  PRIMARY KEY (`id`));