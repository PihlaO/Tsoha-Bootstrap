-- Lisää INSERT INTO lauseet tähän tiedostoon

--KÄYTTÄJÄ

INSERT INTO Kayttaja (kayttajatunnus, salasana, etunimi, sukunimi, sahkoposti)
VALUES('Testi', 'abc123', 'Testaaja', 'Testaus', 'abc@sähköposti.fi');

INSERT INTO Kayttaja (kayttajatunnus, salasana, etunimi, sukunimi, sahkoposti) 
VALUES ('Testi2', 'asd123','Testaaja2', 'Testaus2', 'abc2@sähköposti.fi');

--TÄRKEYSASTE

INSERT INTO Tarkeysaste(nimi) VALUES('Erittäin tärkeä');

-- TEHTÄVÄ

INSERT INTO Tehtava(otsikko, kuvaus, tarkeysaste_id,ajankohta, kayttaja_id)
VALUES('Tsoha', 'Palauta harjoitustyo', 1, '18-10-2015 23:59', 1);

--LUOKKA
INSERT INTO Luokka(nimi, kuvaus,kayttaja_id) VALUES('Opiskelu', 'Opinnot Helsingin yliopistossa', 1);

INSERT INTO Luokka(nimi,kayttaja_id) VALUES('Työ', 1);

INSERT INTO Luokka(nimi, kayttaja_id) VALUES('Vapaa-aika',2);

--TEHTÄVÄLUOKKA

INSERT INTO Tehtavaluokka(tehtava_id, luokka_id) VALUES(1,1);

INSERT INTO Tehtavaluokka(tehtava_id, luokka_id) VALUES(1,2);

