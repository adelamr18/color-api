CREATE TABLE `colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `color_name` varchar(255) NOT NULL,
  `hex_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `colors` (`id`, `color_name`,`hex_value` ) VALUES
(1, 'Blue', '#fgrtz'),
(2, 'Red', '#ghzxh'),
(3, 'Black', '#fgrop');
