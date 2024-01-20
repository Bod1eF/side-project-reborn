CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `isAdmin` boolean,
  `email` text,
  `password` text,
  `schoolyear` int,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `posts` (
`id` int NOT NULL AUTO_INCREMENT,
`title` varchar(64),
`body` varchar(300),
`coding` boolean,
`research` boolean,
`hobby` boolean,
`num_collaborators` int,
`date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
`user_id` int,

 PRIMARY KEY (`id`)
);