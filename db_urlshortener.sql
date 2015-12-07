Create schema db_urlshortener;

CREATE TABLE `db_urlshortener`.`tbl_urls` (
  `id` INT NOT NULL  AUTO_INCREMENT,
  `url` TEXT NULL,
  `createdon` DATETIME NOT NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `db_urlshortener`.`tbl_urls` AUTO_INCREMENT = 1001;