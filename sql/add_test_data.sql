-- Lisää INSERT INTO lauseet tähän tiedostoon

--KÄYTTÄJÄ

INSERT INTO Kayttaja (kayttajatunnus, salasana, etunimi, sukunimi, sahkoposti)
VALUES('Testi', 'abc123', 'Testaaja', 'Testaus', 'abc@sähköposti.fi');

INSERT INTO Kayttaja (kayttajatunnus, salasana, etunimi, sukunimi, sahkoposti) 
VALUES ('Testi2', 'asd123','Testaaja2', 'Testaus2', 'abc2@sähköposti.fi');

INSERT INTO Kayttaja (kayttajatunnus, salasana, etunimi, sukunimi, sahkoposti) 
VALUES ('Testi3', 'asd123','Testaaja3', 'Testaus3', 'abc2@posti.fi');

--TÄRKEYSASTE

INSERT INTO Tarkeysaste(nimi) VALUES('Normaali');
INSERT INTO Tarkeysaste(nimi) VALUES('Tärkeä');
INSERT INTO Tarkeysaste(nimi) VALUES('Erittäin tärkeä');

-- TEHTÄVÄ

INSERT INTO Tehtava(otsikko, kuvaus, tarkeysaste,ajankohta, kayttaja_id)
VALUES('Tsoha', 'Palauta harjoitustyo','Erittäin tärkeä',  '18-10-2015', 1);
INSERT INTO Tehtava(otsikko, kuvaus, tarkeysaste,ajankohta, kayttaja_id)
VALUES('Ohjaus', 'Kurssin ohjaaminen', 'Tärkeä','10-10-2015', 1);
INSERT INTO Tehtava(otsikko, kuvaus, tarkeysaste,ajankohta, kayttaja_id)
VALUES('Testi', 'Testi tehtävä', 'Tärkeä','1-10-2015', 2);


--LUOKKA

INSERT INTO Luokka(nimi, kuvaus,kayttaja_id) VALUES('Opiskelu', 'Opinnot Helsingin yliopistossa', 1);

INSERT INTO Luokka(nimi,kayttaja_id) VALUES('Työ', 1);

INSERT INTO Luokka(nimi, kayttaja_id) VALUES('Vapaa-aika',2);

--TEHTÄVÄLUOKKA

INSERT INTO Tehtavaluokka(tehtava_id, luokka_id) VALUES(1,1);

INSERT INTO Tehtavaluokka(tehtava_id, luokka_id) VALUES(1,2);

INSERT INTO Tehtavaluokka(tehtava_id, luokka_id) VALUES(2,3);
