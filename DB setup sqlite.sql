CREATE TABLE Sprzet(
id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
nazwa VARCHAR(512) NOT NULL,
data_zakupu DATE NOT NULL,
data_uruchom DATE,
wartosc BIGINT UNSIGNED NOT NULL,
opis TEXT NOT NULL,
projekt INTEGER,
laboratorium INTEGER,
CHECK (data_zakupu<=date('now')),
CHECK (data_uruchom<=date('now')),
CHECK (data_uruchom>=data_zakupu),
CHECK (wartosc>=0),
CHECK (length(nazwa)<=512),
FOREIGN KEY (projekt) REFERENCES Projekt(id) ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (laboratorium) REFERENCES Laboratorium(id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Projekt(
id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
nazwa VARCHAR(64) NOT NULL UNIQUE,
data_rozp DATE NOT NULL,
data_zakoncz DATE,
opis TEXT NOT NULL,
logo VARCHAR(128) NOT NULL UNIQUE,
CHECK (data_rozp<=date('now')),
CHECK (data_zakoncz<=date('now')),
CHECK (data_zakoncz>=data_rozp),
CHECK (length(nazwa)<=64),
CHECK (length(logo)<=128)
);

CREATE TABLE Osoba(
id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
imie VARCHAR(16) NOT NULL,
nazwisko VARCHAR(32) NOT NULL,
email VARCHAR(254) NOT NULL UNIQUE,
CHECK (length(imie)<=16),
CHECK (length(nazwisko)<=32),
CHECK (length(email)<=254)
);

CREATE TABLE Kontakt(
sprzet INTEGER NOT NULL,
osoba INTEGER NOT NULL,
FOREIGN KEY (sprzet) REFERENCES Sprzet(id) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (osoba) REFERENCES Osoba(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Zdjecie(
id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
sprzet INTEGER NOT NULL,
link VARCHAR(128) NOT NULL,
CHECK (length(link)<=128),
FOREIGN KEY (sprzet) REFERENCES Sprzet(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Tag(
id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
nazwa VARCHAR(32) NOT NULL UNIQUE,
CHECK (length(nazwa)<=32)
);

CREATE TABLE Tagi_sprzetu(
sprzet INTEGER NOT NULL,
tag INTEGER NOT NULL,
FOREIGN KEY (sprzet) REFERENCES Sprzet(id) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (tag) REFERENCES Tag(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Laboratorium(
id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
nazwa VARCHAR(64) NOT NULL,
zespol INTEGER,
CHECK (length(nazwa)<=64),
FOREIGN KEY (zespol) REFERENCES Zespol(id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Zespol(
id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
nazwa VARCHAR(64) NOT NULL UNIQUE,
CHECK (length(nazwa)<=64)
);

CREATE TABLE Laborat_w_zaklad(
zaklad INTEGER NOT NULL,
laboratorium INTEGER NOT NULL,
FOREIGN KEY (zaklad) REFERENCES Zaklad(id) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (laboratorium) REFERENCES Laboratorium(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Zaklad(
id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
nazwa VARCHAR(64) NOT NULL UNIQUE,
CHECK (length(nazwa)<=64)
);