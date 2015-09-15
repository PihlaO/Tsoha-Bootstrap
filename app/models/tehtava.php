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

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tehtava (otsikko, kuvaus, suoritettu, ajankohta, tarkeysaste_id, kayttaja_id) VALUES (:otsikko, :kuvaus, :suoritettu, :ajankohta, 1,  1) RETURNING id');
        /// HUOM!! kayttaja_id=1, tarkeysate_id=1 
        $query->execute(array('otsikko' => $this->otsikko, 'kuvaus' => $this->kuvaus, 'suoritettu' => $this->suoritettu, 'ajankohta' => $this->ajankohta));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
