<?php

class Luokka extends BaseModel {

    public $id, $nimi, $kuvaus, $kayttaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Luokka');
        $query->execute();

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
        $query = DB::connection()->prepare('INSERT INTO Luokka (nimi, kuvaus, kayttaja_id) VALUES (:nimi, :kuvaus,  1) RETURNING id');
        /// HUOM!! kayttaja_id=1
        $query->execute(array('nimi' => $this->nimi, 'kuvaus'=> $this->kuvaus));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
