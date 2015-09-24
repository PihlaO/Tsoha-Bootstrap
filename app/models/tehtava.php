<?php

class Tehtava extends BaseModel {

    public $id, $otsikko, $kuvaus, $suoritettu, $ajankohta, $tarkeysaste, $kayttaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validoi_otsikko', 'validoi_ajankohta');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tehtava');
        $query->execute();

        $rivit = $query->fetchAll();
        $tehtavat = array();

        foreach ($rivit as $rivi) {
            $tehtavat[] = new Tehtava(array(
                'id' => $rivi['id'],
                'otsikko' => $rivi['otsikko'],
                'kuvaus' => $rivi['kuvaus'],
                'suoritettu' => $rivi['suoritettu'],
                'ajankohta' => $rivi['ajankohta'],
                'tarkeysaste' => $rivi['tarkeysaste'],
                'kayttaja_id' => $rivi['kayttaja_id']
            ));
        }

        return $tehtavat;
    }
    
        public static function kayttaja_all($kayttaja_id) {
        $query = DB::connection()->prepare('SELECT * FROM Tehtava  WHERE kayttaja_id=:kayttaja_id');
        $query->execute(array('kayttaja_id' => $kayttaja_id));

        $rivit = $query->fetchAll();
        $tehtavat = array();

        foreach ($rivit as $rivi) {
            $tehtavat[] = new Tehtava(array(
                'id' => $rivi['id'],
                'otsikko' => $rivi['otsikko'],
                'kuvaus' => $rivi['kuvaus'],
                'suoritettu' => $rivi['suoritettu'],
                'ajankohta' => $rivi['ajankohta'],
                'tarkeysaste' => $rivi['tarkeysaste'],
                'kayttaja_id' => $rivi['kayttaja_id']
            ));
        }

        return $tehtavat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tehtava WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $rivi = $query->fetch();

        if ($rivi) {
            $tehtava = new Tehtava(array(
                'id' => $rivi['id'],
                'otsikko' => $rivi['otsikko'],
                'kuvaus' => $rivi['kuvaus'],
                'suoritettu' => $rivi['suoritettu'],
                'ajankohta' => $rivi['ajankohta'],
                'tarkeysaste' => $rivi['tarkeysaste'],
                'kayttaja_id' => $rivi['kayttaja_id']
            ));

            return $tehtava;
        }

        return null;
    }

    public function lisaa_luokat($id_array) {

        $tehtava_id = $this->id;
        foreach ($id_array as $id) {
            $query = DB::connection()->prepare('INSERT INTO Tehtavaluokka (tehtava_id, luokka_id) VALUES(:tehtava_id, :luokka_id)');
            $query->execute(array('tehtava_id' => $tehtava_id, 'luokka_id' => $id));
        }
    }

    // Etsitään tehtavan id:llä kyseiseen tehtävään liittyvät luokat
    public static function tehtavan_luokat($id) {
        $query = DB::connection()->prepare('SELECT * FROM Luokka WHERE id IN (SELECT luokka_id FROM Tehtavaluokka WHERE tehtava_id = :id)');
        $query->execute(array('id' => $id));
        $rivit = $query->fetchAll();
        $luokat = array();
        foreach ($rivit as $row) {
            $luokat[] = new Luokka(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus']//,
                    //'Kayttaja_id' => $row['Kayttaja_id']
            ));
        }
        return $luokat;
    }

    //  MUOKKAA TALLENTAMAAN KÄYTTÄJÄ_ID !!!!
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tehtava (otsikko, kuvaus, suoritettu, ajankohta, tarkeysaste, kayttaja_id) VALUES (:otsikko, :kuvaus, :suoritettu, :ajankohta, :tarkeysaste,  1) RETURNING id');
        /// HUOM!! kayttaja_id=1
        $query->execute(array('otsikko' => $this->otsikko, 'kuvaus' => $this->kuvaus, 'suoritettu' => $this->suoritettu, 'ajankohta' => $this->ajankohta, 'tarkeysaste' => $this->tarkeysaste));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {

        $query = DB::connection()->prepare('UPDATE Tehtava SET otsikko = :otsikko, kuvaus=:kuvaus, suoritettu= :suoritettu, ajankohta= :ajankohta, tarkeysaste= :tarkeysaste, kayttaja_id=1 WHERE id=:id');
        /// HUOM!! kayttaja_id=1
        $query->execute(array('otsikko' => $this->otsikko, 'kuvaus' => $this->kuvaus, 'suoritettu' => $this->suoritettu, 'ajankohta' => $this->ajankohta, 'tarkeysaste' => $this->tarkeysaste, 'id' => $this->id));
    }

    public function destroy() { // Miten tehtavaluokasta pois tehtava???
        $this->destroy_tehtava_tehtavaluokasta();
        $query = DB::connection()->prepare('DELETE FROM Tehtava WHERE id=:id');
        $query->execute(array('id' => $this->id));
    }

    public function destroy_tehtava_tehtavaluokasta() {
        $query = DB::connection()->prepare('DELETE FROM Tehtavaluokka WHERE tehtava_id=:id');
        $query->execute(array('id' => $this->id));
    }

    public function validoi_otsikko() {
        $errors = array();
        if ($this->otsikko == '' || $this->otsikko == null) {
            $errors[] = 'Otsikko ei saa olla tyhjä!';
        }
        if (strlen($this->otsikko) < 2) {
            $errors[] = 'Otsikon pituuden tulee olla vähintään kaksi merkkiä!';
        }
        if (strlen($this->otsikko) > 50) {
            $errors[] = 'Otsikko saa olla enintään 50 merkkiä!';
        }

        return $errors;
    }

    public function validoi_ajankohta() {
        $errors = array();
        if ($this->ajankohta == '' || $this->ajankohta == null) {
            $errors[] = 'Ajankohta ei saa olla tyhjä!';
        }
//        if ($this->ajankohta->is_numeric()) {
//            $errors[] = 'Ajankohta tulee olla numeerinen!';
//        }
        return $errors;
    }



}
