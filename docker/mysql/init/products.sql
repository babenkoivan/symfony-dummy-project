CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `products` WRITE;

INSERT INTO `products` (`id`, `name`, `price`)
VALUES
	(1,'Product 1',100),
	(2,'Product 2',200),
	(3,'Product 3',300);

UNLOCK TABLES;
