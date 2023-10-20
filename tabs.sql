CREATE TABLE clanky (
id INT UNSIGNED not null AUTO_INCREMENT,
id_autor INT UNSIGNED not null,
id_rubrika INT UNSIGNED not null,
datum INT UNSIGNED not null,
counter INT UNSIGNED DEFAULT '0' not null,
nadpis VARCHAR (255),
seouri VARCHAR (255),
perex TEXT,
obsah TEXT,
stav CHAR (1) DEFAULT 'n',
zobrazeni CHAR (1) DEFAULT '1',
komentare CHAR (1) DEFAULT '1',
forma CHAR (1) DEFAULT '1',
PRIMARY KEY (id)
);

CREATE TABLE novinky (
id INT UNSIGNED not null AUTO_INCREMENT,
autor INT UNSIGNED not null,
titulek VARCHAR (255),
novinka TEXT,
datum VARCHAR (20) not null,
stav CHAR (1) DEFAULT 'n' not null,
PRIMARY KEY (id)
);

CREATE TABLE autori (
id INT UNSIGNED not null AUTO_INCREMENT,
login VARCHAR (20) not null,
heslo VARCHAR (20) not null,
jmeno VARCHAR (30) not null,
email VARCHAR (30) not null,
informace TEXT not null,
prava TINYINT UNSIGNED DEFAULT '1' not null,
PRIMARY KEY (id)
);

INSERT INTO autori VALUES (0, "admin", "admin", "Administrátor", 0, 0, "1");

CREATE TABLE rubriky (
id INT UNSIGNED not null AUTO_INCREMENT,
rubrika VARCHAR (50) not null,
PRIMARY KEY (id)
);

CREATE TABLE boxy (
id INT UNSIGNED not null AUTO_INCREMENT,
strana INT UNSIGNED not null,
pozice INT UNSIGNED not null,
head VARCHAR (255),
body TEXT,
PRIMARY KEY (id)
);

CREATE TABLE soubory (
id INT UNSIGNED not null AUTO_INCREMENT,
nazev VARCHAR (255),
typ VARCHAR (255),
velikost VARCHAR (255),
PRIMARY KEY (id)
);

CREATE TABLE komentare (
id int(10) unsigned NOT NULL auto_increment,
id_clanek int(10) unsigned NOT NULL default '0',
stav CHAR (1) DEFAULT '0' not null,
cislo INT UNSIGNED not null,
datum varchar(20) NOT NULL,
jmeno varchar(30) NOT NULL,
email varchar(30) NOT NULL,
text text NOT NULL,
PRIMARY KEY  (id)
);
