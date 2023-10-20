alter table komentare drop predmet;
alter table komentare add stav CHAR (1) DEFAULT '0' not null after id_clanek;
alter table komentare add cislo INT UNSIGNED not null after stav;
alter table clanky add seouri VARCHAR (255) after nadpis;
alter table clanky add zobrazeni CHAR (1) DEFAULT '1' after stav;
alter table clanky add komentare CHAR (1) DEFAULT '1' after zobrazeni;
alter table clanky add forma CHAR (1) DEFAULT '1' after komentare;
