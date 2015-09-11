<?php

class Tehtava extends BaseModel {

    public $id, $otsikko, $kuvaus, $suoritettu, $ajankohta, $tarkeysaste_id, $kayttaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Tehtava');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rivit = $query->fetchAll();
        $tehtavat = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rivit as $rivi) {
            $tehtavat[] = new Tehtava(array(
                'id' => $rivi['id'],
                'otsikko' => $rivi['otsikko'],
                'kuvaus' => $rivi['kuvaus'],
                'suoritettu' => $rivi['suoritettu'],
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

}
