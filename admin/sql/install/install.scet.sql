CREATE TABLE IF NOT EXISTS `#__scet_categories` (
   `id` INT NOT NULL AUTO_INCREMENT,
   `category`       varChar(80) character set utf8 ,
   `ordering`       SMALLINT NOT NULL default 0,
   `publiccategory` SMALLINT NOT NULL,
   `published`      SMALLINT NOT NULL,
   `preamble`       TEXT character set utf8 ,
   PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `#__scet_events` (
     `id`              INT NOT NULL AUTO_INCREMENT,
     `event`           VarChar(80) character set utf8 ,
     `rule`            varChar(80) character set utf8 ,
     `datum`           date,
     `uhrzeit`         time,
     `endezeit`        time,
     `location`        VarChar(80) character set utf8 ,
     `mandatory`       tinyint,
     `anniversary`     tinyint,
     `inserted`        date,
     `updated`         date,
	 `publicevent`     SMALLINT NOT NULL,
     `published`       tinyint not null,
     `ordering`        SMALLINT NOT NULL default 0,
     `fk_category`     int not null,
     PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__scet_visits` (
   `id`             INT NOT NULL AUTO_INCREMENT,
   `juserid`        INT ,
   `lastvisitdate`  DATE,
   PRIMARY KEY (`id`)
);

