<?php

class TehtavaController extends BaseController {

    public static function index() {

        $tehtavat = Tehtava::all();

        View::make('tehtava/listaus.html', array('tehtavat' => $tehtavat));
    }

    public static function show($id) {
        $tehtava = Tehtava::find($id);
        $luokat = Tehtava::tehtavan_luokkat($id);
        View::make('tehtava/esittely.html',  array('tehtava' => $tehtava, 'luokat' => $luokat));
    }

    public static function create() {

        View::make('tehtava/lisays.html');
    }

    public static function store() {

        $params = $_POST;

        $tehtava = new Tehtava(array(
            'otsikko' => $params['otsikko'],
            'kuvaus' => $params['kuvaus'],
            'suoritettu' => $params['suoritettu'],
            'ajankohta' => $params['ajankohta']
        ));
        // Kint::dump($params);
        $tehtava->save();
        $tehtava->lisaa_luokat($params['luokat']);

        Redirect::to('/tehtava/' . $tehtava->id, array('message' => 'Tehtavä on lisätty muistilistaasi!'));
    }

    public static function edit($id) {
        $tehtava = Tehtava::find($id);
        View::make('tehtava/muokkaus.html', array('attributes' => $tehtava));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'otsikko' => $params['otsikko'],
            'kuvaus' => $params['kuvaus'],
            'suoritettu' => $params['suoritettu'],
            'ajankohta' => $params['ajankohta'],
            'id' => $id
        );

        //Kint::dump($params);

        $tehtava = new Tehtava($attributes);
//        $errors = $tehtava->errors();

//        if (count($errors) > 0) {
//            View::make('tehtava/muokkaus.html', array('errors' => $errors, 'attributes' => $attributes));
//        } else {
//            // Kutsutaan alustetun olion update-metodia, joka päivittää tehtävän tiedot tietokannassa
//            $tehtava->update();
//
//            Redirect::to('/tehtava/' . $tehtava->id, array('message' => 'Tehtävä on muokattu onnistuneesti!'));
//        }
        $tehtava->update();
        Redirect::to('/tehtava/' . $tehtava->id, array('message' => 'Tehtävä on muokattu onnistuneesti!'));
    }

    public static function destroy($id) {

        $tehtava = new Tehtava(array('id' => $id));

        $tehtava->destroy();

        Redirect::to('/tehtavien_listaus', array('message' => 'Tehtävä on poistettu onnistuneesti!'));
    }

}
