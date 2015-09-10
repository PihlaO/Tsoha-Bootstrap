
CREATE TABLE Kayttaja(
id SERIAL PRIMARY KEY NOT NULL,
kayttajatunnus VARCHAR(50) NOT NULL,
salasana VARCHAR(50) NOT NULL,
etunimi VARCHAR(50) NOT NULL,
sukunimi VARCHAR(50) NOT NULL,
sahkoposti VARCHAR(100) NOT NULL
);

CREATE TABLE Tarkeysaste(
id SERIAL PRIMARY KEY NOT NULL,
nimi VARCHAR(100) NOT NULL,
kuvaus VARCHAR(1000)
);

CREATE TABLE Luokka(
id SERIAL PRIMARY KEY NOT NULL,
nimi VARCHAR(100) NOT NULL,
kuvaus VARCHAR(1000),
kayttaja_id INTEGER NOT NULL,
CONSTRAINT fk_kayttaja_id FOREIGN KEY(kayttaja_id) REFERENCES Kayttaja(id) 
);

CREATE TABLE Tehtava(
id SERIAL PRIMARY KEY NOT NULL,
otsikko VARCHAR(200) NOT NULL,
kuvaus VARCHAR(2000),
suoritettu BOOLEAN DEFAULT FALSE NOT NULL,
ajankohta TIMESTAMP,
tarkeysaste_id INTEGER, 
kayttaja_id INTEGER NOT NULL,
CONSTRAINT fk_kayttaja_id FOREIGN KEY(kayttaja_id) REFERENCES Kayttaja(id),
CONSTRAINT fk_tarkeysaste_id FOREIGN KEY(tarkeysaste_id) REFERENCES Tarkeysaste(id)
); 

CREATE TABLE Tehtavaluokka(
tehtava_id INTEGER NOT NULL,
luokka_id INTEGER NOT NULL,
CONSTRAINT fk_tehtava_id FOREIGN KEY(tehtava_id) REFERENCES Tehtava(id),
CONSTRAINT fk_luokka_id FOREIGN KEY(luokka_id) REFERENCES Luokka(id),
CONSTRAINT pk_tehtavaluokka PRIMARY KEY(tehtava_id, luokka_id)
);