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

    
    /// HUOM!! kayttaja_id=1, tarkeysate_id=1 HUOM!!!
    public function save() {
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Tehtava (otsikko, kuvaus, suoritettu, ajankohta, tarkeysaste_id, kayttaja_id) VALUES (:otsikko, :kuvaus, :suoritettu, :ajankohta, 1,  1) RETURNING id');
        // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('otsikko' => $this->otsikko, 'kuvaus' => $this->kuvaus, 'suoritettu'=> $this->suoritettu, 'ajankohta'=> $this->ajankohta, tarkeysaste_id=> $this->tarkeysaste_id, kayttaja_id=> $this->kayttaja_id));
        // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
        // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->id = $row['id'];
    }

}
