<?php

class Luokka extends BaseModel {

    public $id, $nimi, $kuvaus, $kayttaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validoi_nimi', 'validoi_kuvaus');
    }

    public static function all($kayttaja_id) {
        $query = DB::connection()->prepare('SELECT * FROM Luokka WHERE kayttaja_id=:kayttaja_id');
        $query->execute(array('kayttaja_id' => $kayttaja_id));

        $rivit = $query->fetchAll();
        $luokat = array();

        foreach ($rivit as $rivi) {
            $luokat[] = new Luokka(array(
                'id' => $rivi['id'],
                'nimi' => $rivi['nimi'],
                'kuvaus' => $rivi['kuvaus'],
                'kayttaja_id' => $rivi['kayttaja_id']
            ));
        }

        return $luokat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Luokka WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $rivi = $query->fetch();

        if ($rivi) {
            $luokka = new Luokka(array(
                'id' => $rivi['id'],
                'nimi' => $rivi['nimi'],
                'kuvaus' => $rivi['kuvaus'],
                'kayttaja_id' => $rivi['kayttaja_id']
            ));

            return $luokka;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Luokka (nimi, kuvaus, kayttaja_id) VALUES (:nimi, :kuvaus,  :kayttaja_id) RETURNING id');
        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'kayttaja_id' => $this->kayttaja_id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {

        $query = DB::connection()->prepare('UPDATE Luokka SET nimi = :nimi, kuvaus=:kuvaus, kayttaja_id =:kayttaja_id WHERE id=:id');
        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'kayttaja_id' => $this->kayttaja_id, 'id' => $this->id));
    }

    public function destroy() {
        $this->poista_luokka_tehtavaluokasta();
        $query = DB::connection()->prepare('DELETE FROM Luokka WHERE id=:id');
        $query->execute(array('id' => $this->id));
    }

    public function poista_luokka_tehtavaluokasta() {
        $query = DB::connection()->prepare('DELETE FROM Tehtavaluokka WHERE luokka_id=:id');
        $query->execute(array('id' => $this->id));
    }

    public static function etsi_luokan_nimella_ja_kayttajalla($nimi, $kayttaja_id) {
        $query = DB::connection()->prepare('SELECT * FROM Luokka WHERE nimi = :nimi AND kayttaja_id=:kayttaja_id LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'kayttaja_id' => $kayttaja_id));
        $rivi = $query->fetch();

        if ($rivi) {
            $luokka = new Luokka(array(
                'id' => $rivi['id'],
                'nimi' => $rivi['nimi'],
                'kuvaus' => $rivi['kuvaus'],
                'kayttaja_id' => $rivi['kayttaja_id'],
            ));

            return $luokka;
        }
        return null;
    }

    public function validoi_nimi() {
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->nimi) < 2) {
            $errors[] = 'Nimen pituuden tulee olla vähintään kaksi merkkiä!';
        }
        if (strlen($this->nimi) > 50) {
            $errors[] = 'Nimi saa olla enintään 50 merkkiä!';
        }

        return $errors;
    }

    public function validoi_nimen_uniikkisuus() {

        if (self::etsi_luokan_nimella_ja_kayttajalla($this->nimi, $this->kayttaja_id) != NULL) {
            $error = 'Luokan nimi on jo käytössä!';
            return $error;
        } else {
            return null;
        }
    }

    public function validoi_kuvaus() {
        $errors = array();
        if (strlen($this->kuvaus) > 500) {
            $errors[] = 'Kuvaus saa olla enintään 500 merkkiä!';
        }
        
         $pieces = explode(" ", $this->kuvaus);
         foreach ($pieces as $piece){
             if(strlen($piece)> 120){
                 $errors[] = 'Kuvauksessasi on ainakin yksi sana, joka on yli 120 merkkiä. Tarkista kuvauksen oikeinkirjoitus ja korjaa virheet.';
                 break;
             }
         }

        return $errors;
    }

}
