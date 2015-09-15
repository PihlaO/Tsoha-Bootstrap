<?php

class TehtavaController extends BaseController {

    public static function index() {

        $tehtavat = Tehtava::all();

        View::make('tehtava/listaus.html', array('tehtavat' => $tehtavat));
    }

    public static function show($id) {
        $tehtava = Tehtava::find($id);
        View::make('tehtava/esittely.html', array('tehtava' => $tehtava));
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

        Redirect::to('/tehtava/' . $tehtava->id, array('message' => 'Tehtavä on lisätty muistilistaasi!'));
    }

}
