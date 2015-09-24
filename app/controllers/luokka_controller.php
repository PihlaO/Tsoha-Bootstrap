<?php

class LuokkaController extends BaseController {

    public static function index() {

        $luokat = Luokka::all();

        View::make('luokka/listaus.html', array('luokat' => $luokat));
    }

    public static function show($id) {
        $luokka = Luokka::find($id);
        View::make('luokka/esittely.html', array('luokka' => $luokka));
    }

    public static function create() {
        $luokat = Luokka::all(); //kokeilu
        View::make('luokka/lisays.html', array('luokat' => $luokat));

        /////////////////////    View::make('luokka/lisays.html');
    }

    public static function store() {

        $params = $_POST;

        $luokka = new Luokka(array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
        ));
        $luokka->save();

        Redirect::to('/luokka/' . $luokka->id, array('message' => 'Luokka on lisätty tehtäväluokkiisi!'));
    }

}
