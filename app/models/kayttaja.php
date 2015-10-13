<?php

class Kayttaja extends BaseModel {

    public $id, $kayttajatunnus, $salasana, $etunimi, $sukunimi, $sahkoposti;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validoi_kayttajatunnuksen_uniikkisuus', 'validoi_kayttajatunnus', 'validoi_salasana', 'validoi_etunimi', 'validoi_sukunimi', 'validoi_sahkoposti');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();
        $rivit = $query->fetchAll();
        $kayttajat = array();

        foreach ($rivit as $rivi) {
            $kayttajat[] = new Kayttaja(array(
                'id' => $rivi['id'],
                'kayttajatunnus' => $rivi['kayttajatunnus'],
                'salasana' => $rivi['salasana'],
                'etunimi' => $rivi['etunimi'],
                'sukunimi' => $rivi['sukunimi'],
                'sahkoposti' => $rivi['sahkoposti']
            ));
        }
        return $kayttajat;
    }

    public static function hae_kayttaja_id() {
        $kayttaja = TehtavaController::get_user_logged_in();
        $kayttaja_id = $kayttaja->id;
        return $kayttaja_id;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $rivi = $query->fetch();

        if ($rivi) {
            $kayttaja = new Kayttaja(array(
                'id' => $rivi['id'],
                'kayttajatunnus' => $rivi['kayttajatunnus'],
                'salasana' => $rivi['salasana'],
                'etunimi' => $rivi['etunimi'],
                'sukunimi' => $rivi['sukunimi'],
                'sahkoposti' => $rivi['sahkoposti']
            ));

            return $kayttaja;
        }

        return null;
    }

    public static function etsi_kayttajatunnuksella($kayttajatunnus) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajatunnus = :kayttajatunnus LIMIT 1');
        $query->execute(array('kayttajatunnus' => $kayttajatunnus));
        $rivi = $query->fetch();

        if ($rivi) {
            $kayttaja = new Kayttaja(array(
                'id' => $rivi['id'],
                'kayttajatunnus' => $rivi['kayttajatunnus'],
                'salasana' => $rivi['salasana'],
                'etunimi' => $rivi['etunimi'],
                'sukunimi' => $rivi['sukunimi'],
                'sahkoposti' => $rivi['sahkoposti']
            ));

            return $kayttaja;
        }

        return null;
    }

    public static function authenticate($kayttajatunnus, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajatunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1;');
        $query->execute(array('kayttajatunnus' => $kayttajatunnus, 'salasana' => $salasana));
        $rivi = $query->fetch();
        if ($rivi) {
            $kayttaja = new Kayttaja(array(
                'id' => $rivi['id'],
                'kayttajatunnus' => $rivi['kayttajatunnus'],
                'salasana' => $rivi['salasana'],
                'etunimi' => $rivi['etunimi'],
                'sukunimi' => $rivi['sukunimi'],
                'sahkoposti' => $rivi['sahkoposti']
            ));

            return $kayttaja;
        } else {
            return null;
        }
    }

    public function save() {

        $query = DB::connection()->prepare('INSERT INTO Kayttaja (kayttajatunnus, salasana, etunimi, sukunimi, sahkoposti) VALUES (:kayttajatunnus, :salasana, :etunimi, :sukunimi, :sahkoposti) RETURNING id');
        $query->execute(array('kayttajatunnus' => $this->kayttajatunnus, 'salasana' => $this->salasana, 'etunimi' => $this->etunimi, 'sukunimi' => $this->sukunimi, 'sahkoposti' => $this->sahkoposti));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function validoi_kayttajatunnuksen_uniikkisuus() {
        $errors = array();
        if (self::etsi_kayttajatunnuksella($this->kayttajatunnus) != NULL) {
            $errors[] = 'Käyttäjätunnus on varattu!';
        }
        return $errors;
    }

    public function validoi_kayttajatunnus() {
        $errors = array();
        if ($this->kayttajatunnus == '' || $this->kayttajatunnus == null) {
            $errors[] = 'Käyttäjätunnus ei saa olla tyhjä!';
        }
        if (strlen($this->kayttajatunnus) < 2) {
            $errors[] = 'Käyttäjätunnuksen pituuden tulee olla vähintään kaksi merkkiä!';
        }
        if (strlen($this->kayttajatunnus) > 20) {
            $errors[] = 'Käyttäjätunnus saa olla enintään 20 merkkiä!';
        }
        return $errors;
    }

    public function validoi_salasana() {
        $errors = array();
        if ($this->salasana == '' || $this->salasana == null) {
            $errors[] = 'Salasana ei saa olla tyhjä!';
        }
        if (strlen($this->salasana) < 10) {
            $errors[] = 'Salasanan pituuden tulee olla vähintään 10 merkkiä!';
        }
        if (strlen($this->salasana) > 25) {
            $errors[] = 'Salasana saa olla enintään 25 merkkiä!';
        }

        return $errors;
    }

    public function validoi_etunimi() {
        $errors = array();
        if ($this->etunimi == '' || $this->etunimi == null) {
            $errors[] = 'Etunimi ei saa olla tyhjä!';
        }
        if (strlen($this->etunimi) < 2) {
            $errors[] = 'Etunimen pituuden tulee olla vähintään 2 merkkiä!';
        }
        if (strlen($this->etunimi) > 30) {
            $errors[] = 'Etunimi saa olla enintään 30 merkkiä!';
        }

        return $errors;
    }

    public function validoi_sukunimi() {
        $errors = array();
        if ($this->sukunimi == '' || $this->sukunimi == null) {
            $errors[] = 'Sukunimi ei saa olla tyhjä!';
        }
        if (strlen($this->sukunimi) < 2) {
            $errors[] = 'Sukunimen pituuden tulee olla vähintään 2 merkkiä!';
        }
        if (strlen($this->sukunimi) > 30) {
            $errors[] = 'Sukunimi saa olla enintään 30 merkkiä!';
        }

        return $errors;
    }

    public function validoi_sahkoposti() {
        $errors = array();
        if ($this->sahkoposti == '' || $this->sahkoposti == null) {
            $errors[] = 'Sähköposti ei saa olla tyhjä!';
        }
        if (strlen($this->sahkoposti) < 2) {
            $errors[] = 'Sähköpostin pituuden tulee olla vähintään 2 merkkiä!';
        }
        if (strlen($this->sahkoposti) > 30) {
            $errors[] = 'Sähköposti saa olla enintään 40 merkkiä!';
        }

        return $errors;
    }

}
