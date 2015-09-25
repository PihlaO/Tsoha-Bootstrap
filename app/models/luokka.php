<?php



class Luokka extends BaseModel {

    public $id, $nimi, $kuvaus, $kayttaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validoi_nimi');
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
        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'kayttaja_id'=> $this->kayttaja_id));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {

        $query = DB::connection()->prepare('UPDATE Luokka SET nimi = :nimi, kuvaus=:kuvaus, kayttaja_id =:kayttaja_id WHERE id=:id');

        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'kayttaja_id'=> $this->kayttaja_id, 'id' => $this->id));
    }

    public function destroy() {
        $this->destroy_luokka_tehtavaluokasta();
        $query = DB::connection()->prepare('DELETE FROM Luokka WHERE id=:id');
        $query->execute(array('id' => $this->id));
    }
    
        public function destroy_luokka_tehtavaluokasta() {
        $query = DB::connection()->prepare('DELETE FROM Tehtavaluokka WHERE luokka_id=:id');
        $query->execute(array('id' => $this->id));
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

}
