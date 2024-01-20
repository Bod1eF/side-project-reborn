CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `isAdmin` boolean,
  `email` text,
  `password` text,
  `schoolyear` int,
  
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `player_character` (
`id` int NOT NULL AUTO_INCREMENT,
`character_name` varchar(16),
`class` varchar(16),
`combat` int,
`charisma` int,
`celerity` int,
`position` int,
`user_id` int,
`isActive` boolean,
 PRIMARY KEY (`id`)
);