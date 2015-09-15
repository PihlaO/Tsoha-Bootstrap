<?php

class TehtavaController extends BaseController {

    public static function index() {

        $tehtavat = Tehtava::all();

        View::make('tehtava/index.html', array('tehtavat' => $tehtavat));
    }

    public static function show($id) {
        $tehtava = Tehtava::find($id);
        View::make('tehtava/show.html', array('tehtava' => $tehtava));
    }

        public static function create() {
        View::make('tehtava/new.html');
    }
    public static function store() {

        $params = $_POST;

        $tehtava = new Tehtava(array(
            'otsikko' => $params['otsikko'],
            'kuvaus' => $params['kuvaus'],
            'suoritettu' => $params['suoritettu'],
            'ajankohta' => $params['ajankohta'],
            'tarkeysaste_id' => $params['tarkeysaste_id'],
            'kayttaja_id' => $params['kayttaja_id'],
		
        ));
       // Kint::dump($params);
        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $tehtava->save();

        Redirect::to('/tehtava/' . $tehtava->id, array('message' => 'Tehtavä on lisätty muistilistaasi!'));
    }


}
