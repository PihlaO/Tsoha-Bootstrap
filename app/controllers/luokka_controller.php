<?php

class LuokkaController extends BaseController {

    public static function luokkien_listaus() {
        $kayttaja_id = self::get_user_logged_in()->hae_kayttaja_id();
        $luokat = Luokka::all($kayttaja_id);
        View::make('luokka/listaus.html', array('luokat' => $luokat));
    }

    public static function show($id) {
        $luokka = Luokka::find($id);
        View::make('luokka/esittely.html', array('luokka' => $luokka));
    }

    public static function create() {

        $kayttaja_id = self::get_user_logged_in()->hae_kayttaja_id();
        $luokat = Luokka::all($kayttaja_id);
        View::make('luokka/lisays.html', array('luokat' => $luokat));
    }

    public static function store() {
        $params = $_POST;
        $attributes = (array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'kayttaja_id' => self::get_user_logged_in()->hae_kayttaja_id()
        ));

        $luokka = new Luokka($attributes);
        $errors = self::get_errors($luokka);
        if (count($errors) == 0) {
            $luokka->save();
            Redirect::to('/luokka/' . $luokka->id, array('message' => 'Luokka on lisätty tehtäväluokkiisi!'));
        } else {
            View::make('luokka/lisays.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function get_errors($luokka) {
        $errors = $luokka->errors();
        $error = $luokka->validoi_nimen_uniikkisuus();
        if ($error != NULL) {
            array_push($errors, $error);
        }
        return $errors;
    }

    public static function edit($id) {
        $luokka = Luokka::find($id);

        View::make('luokka/muokkaus.html', array('attributes' => $luokka));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'kayttaja_id' => self::get_user_logged_in()->hae_kayttaja_id(),
            'id' => $id
        );

        $luokka = new Luokka($attributes);
        $errors = $luokka->errors();

        if (count($errors) > 0) {
            View::make('luokka/muokkaus.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $luokka->update();
            Redirect::to('/luokka/' . $luokka->id, array('message' => 'Luokka on muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        $luokka = new Luokka(array('id' => $id));
        $luokka->destroy();
        Redirect::to('/luokkien_listaus', array('message' => 'Luokka on poistettu onnistuneesti!'));
    }

}
