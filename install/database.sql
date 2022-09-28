/*
 Vytvoříme databázi s názvem "zamestnanci_systém" pokud neexistuje a nastavíme kódování na "utf8_czech_ci"
 */
CREATE DATABASE IF NOT EXISTS zamestnanci_system
DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci;

USE zamestnanci_system; /* Použijeme databázi s názvem "zaměstnanci_system" k nahrání tabulek */

/* Vytvoříme tabulku "uzivatele", pokud neexistuje */
CREATE TABLE IF NOT EXISTS uzivatele (
    uzivatele_id INT(10) AUTO_INCREMENT,
    jmeno VARCHAR(10),
    heslo VARCHAR(255),
    admin INT(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (uzivatele_id)
);

/* Nastavíme unikátní klíč na "jmeno", aby jsme nemohli mít dvě stejné přihlaš.jména v databázi */
ALTER TABLE uzivatele ADD UNIQUE (jmeno);

/* Vytvoříme si uživatele s přihlaš.jménem "Snecek", heslem "123456" a rolí administrátora "1" */
INSERT INTO  uzivatele (
    uzivatele_id,
    jmeno,
    heslo,
    admin
)
VALUES (NULL, 'Snecek', '$2y$10$0vCT.05SrVZ8XrZFbfE9HORw7wwteczWVzUaZTZHvg6V3YTeVFNi2', 1);

/* Vytvoříme tabulku "zamestnanci", pokud neexistuje */
CREATE TABLE IF NOT EXISTS zamestnanci (
    zamestnanci_id INT(10) AUTO_INCREMENT,
    jmeno VARCHAR(10),
    prijmeni VARCHAR(50),
    osobni_cislo VARCHAR(10),
    adresa VARCHAR(255),
    telefon INT(9),
    datum_narozeni DATE NOT NULL,
    datum_nastupu DATE NOT NULL,
    pracovni_pozice VARCHAR(20),
    hodinova_mzda INT(10),
    PRIMARY KEY (zamestnanci_id)
);

/* Nastavíme unikátní klíč na "osobni_cislo", aby jsme nemohli mít dvě stejná osobní čísla v databázi */
ALTER TABLE zamestnanci ADD UNIQUE (osobni_cislo);

/* Vytvoříme tabulku "dochazka", pokud neexistuje */
CREATE TABLE IF NOT EXISTS dochazka (
    dochazka_id INT(10) AUTO_INCREMENT,
    osobni_cislo VARCHAR(10),
    rok INT(4),
    mesic VARCHAR(10),
    den INT(2),
    zacatek VARCHAR(10),
    konec VARCHAR(10),
    prestavka VARCHAR(10),
    odpracovano VARCHAR(10),
    produktivita VARCHAR(10),
    PRIMARY KEY (dochazka_id)
);