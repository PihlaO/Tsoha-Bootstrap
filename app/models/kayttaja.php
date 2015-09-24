<?php

class Kayttaja extends BaseModel {

    public $id, $kayttajatunnus, $salasana, $etunimi, $sukunimi, $sahkoposti;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validoi_kayttajatunnus');
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

    public static function get_kauttaja_id() {
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
    
        public function validoi_kayttajatunnus() {
        $errors = array();
        if ($this->kayttajatunnus == '' || $this->kayttajatunnus== null) {
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

}
