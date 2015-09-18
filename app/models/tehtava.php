<?php

class Tehtava extends BaseModel {

    public $id, $otsikko, $kuvaus, $suoritettu, $ajankohta, $tarkeysaste_id, $kayttaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
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
                'tarkeysaste_id' => $rivi['tarkeysaste_id'],
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
                'tarkeysaste_id' => $rivi['tarkeysaste_id'],
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
    public static function tehtavan_luokkat($id) {
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

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tehtava (otsikko, kuvaus, suoritettu, ajankohta, tarkeysaste_id, kayttaja_id) VALUES (:otsikko, :kuvaus, :suoritettu, :ajankohta, 1,  1) RETURNING id');
        /// HUOM!! kayttaja_id=1, tarkeysate_id=1 
        $query->execute(array('otsikko' => $this->otsikko, 'kuvaus' => $this->kuvaus, 'suoritettu' => $this->suoritettu, 'ajankohta' => $this->ajankohta));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {

        $query = DB::connection()->prepare('UPDATE Tehtava SET otsikko = :otsikko, kuvaus=:kuvaus, suoritettu= :suoritettu, ajankohta= :ajankohta, tarkeysaste_id=1, kayttaja_id=1 WHERE id=:id');
        /// HUOM!! kayttaja_id=1, tarkeysate_id=1 
        $query->execute(array('otsikko' => $this->otsikko, 'kuvaus' => $this->kuvaus, 'suoritettu' => $this->suoritettu, 'ajankohta' => $this->ajankohta, 'id' => $this->id));
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Tehtava WHERE id=:id');
        $query->execute(array('id' => $this->id));
    }

}
