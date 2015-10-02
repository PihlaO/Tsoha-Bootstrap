<?php

class TehtavaController extends BaseController {

    public static function index() {
        $kayttaja_id = self::get_user_logged_in()->get_kauttaja_id();
        $tehtavat = Tehtava::all($kayttaja_id);
        View::make('tehtava/listaus.html', array('tehtavat' => $tehtavat));
    }

    public static function show($id) {
        $tehtava = Tehtava::find($id);
        $luokat = Tehtava::tehtavan_luokat($id);

        View::make('tehtava/esittely.html', array('tehtava' => $tehtava, 'luokat' => $luokat));
    }

    public static function create() {
        $kayttaja_id = self::get_user_logged_in()->get_kauttaja_id();
        $luokat = Luokka::all($kayttaja_id);
        $tarkeysasteet = Tarkeysaste::all();
        View::make('tehtava/lisays.html', array('luokat' => $luokat, 'tarkeysasteet' => $tarkeysasteet));
    }

    public static function store() {

        $params = $_POST;
        $attributes = array(
            'otsikko' => $params['otsikko'],
            'kuvaus' => $params['kuvaus'],
            'suoritettu' => $params['suoritettu'],
            'ajankohta' => $params['ajankohta'],
            'tarkeysaste' => $params['tarkeysaste'],
            'kayttaja_id' => self::get_user_logged_in()->get_kauttaja_id()
        );
        $tehtava = new Tehtava($attributes);

        $errors = $tehtava->errors();
        $tarkeysasteet = Tarkeysaste::all();
        $luokat = Luokka::all(self::get_user_logged_in()->get_kauttaja_id());



        if (count($errors) == 0) {
            $tehtava->save();

            if (!(empty($params['luokat']))) {
                $tehtava->lisaa_luokat($params['luokat']);
            }


            Redirect::to('/tehtava/' . $tehtava->id, array('message' => 'Tehtavä on lisätty muistilistaasi!'));
        } else {
            View::make('tehtava/lisays.html', array('errors' => $errors, 'attributes' => $attributes, 'tarkeysasteet' => $tarkeysasteet, 'luokat' => $luokat));
        }
    }

    public static function edit($id) {
        $luokat = Luokka::all(self::get_user_logged_in()->get_kauttaja_id());
        $tarkeysasteet = Tarkeysaste::all();
        $tehtava = Tehtava::find($id);

        $tehtavanLuokat = array_map(function($luokka) {
            return $luokka->id;
        }, Tehtava::tehtavan_luokat($id));

        foreach ($luokat as $luokka) {
            $luokka->valittu = in_array($luokka->id, $tehtavanLuokat);
        }


        View::make('tehtava/muokkaus.html', array('attributes' => $tehtava, 'luokat' => $luokat, 'tarkeysasteet' => $tarkeysasteet));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'otsikko' => $params['otsikko'],
            'kuvaus' => $params['kuvaus'],
            'suoritettu' => $params['suoritettu'],
            'ajankohta' => $params['ajankohta'],
            'tarkeysaste' => $params['tarkeysaste'],
            'id' => $id
        );


        $tehtava = new Tehtava($attributes);

        $errors = $tehtava->errors();
        if (count($errors) > 0) {
            $luokat = Luokka::all(self::get_user_logged_in()->get_kauttaja_id());
            $tarkeysasteet = Tarkeysaste::all();
            View::make('tehtava/muokkaus.html', array('errors' => $errors, 'attributes' => $attributes, 'luokat' => $luokat, 'tarkeysasteet' => $tarkeysasteet));
        } else {

            $tehtava->update();

            $tehtava->destroy_tehtava_tehtavaluokasta();
            if (!(empty($params['luokat']))) { //tee metodi
                $tehtava->lisaa_luokat($params['luokat']);
            }

            Redirect::to('/tehtava/' . $tehtava->id, array('message' => 'Tehtävä on muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {

        $tehtava = new Tehtava(array('id' => $id));
        $tehtava->destroy();
        Redirect::to('/tehtavien_listaus', array('message' => 'Tehtävä on poistettu onnistuneesti!')); // viesti ei tule näkyviin!
    }

}
