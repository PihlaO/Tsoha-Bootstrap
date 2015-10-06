<?php

class Tarkeysaste extends BaseModel {

    public $id, $nimi, $kuvaus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tarkeysaste');
        $query->execute();

        $rivit = $query->fetchAll();
        $tarkeysasteet = array();

        foreach ($rivit as $rivi) {
            $tarkeysasteet[] = new Tarkeysaste(array(
                'id' => $rivi['id'],
                'nimi' => $rivi['nimi'],
                'kuvaus' => $rivi['kuvaus'],
            ));
        }

        return $tarkeysasteet;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tarkeysaste WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $rivi = $query->fetch();

        if ($rivi) {
            $tarkeysaste = new Tarkeysaste(array(
                'id' => $rivi['id'],
                'nimi' => $rivi['nimi'],
                'kuvaus' => $rivi['kuvaus']
            ));

            return $tarkeysaste;
        }

        return null;
    }

    public static function etsi_tarkeysaste_nimella($nimi) {
        $query = DB::connection()->prepare('SELECT * FROM Tarkeysaste WHERE nimi = :nimi LIMIT 1');
        $query->execute(array('nimi' => $nimi));
        $rivi = $query->fetch();

        if ($rivi) {
            $tarkeysaste = new Tarkeysaste(array(
                'id' => $rivi['id'],
                'nimi' => $rivi['nimi'],
                'kuvaus' => $rivi['kuvaus']
            ));

            return $tarkeysaste;
        }

        return null;
    }

}
