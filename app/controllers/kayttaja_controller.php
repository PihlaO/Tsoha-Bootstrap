<?php

class KayttajaController extends BaseController {

    public static function index() {

        $kayttajat = Kayttaja::all();

        View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function show($id) {
        $kaytttaja = Kayttaja::find($id);
        View::make('kayttaja/show.html', array('kayttaja' => $kaytttaja));
    }

    public static function create() {
        View::make('kayttaja/rekisteroityminen.html');
    }

    public static function store() {

        $params = $_POST;

        $kayttaja = new Kayttaja(array(
            'etunimi' => $params['etunimi'],
            'sukunimi' => $params['sukunimi'],
            'kayttajatunnus' => $params['kayttajatunnus'],
            'salasana' => $params['salasana'],
            'sahkoposti' => $params['sahkoposti']
        ));

        $kayttaja->save();

        Redirect::to('/kayttaja/' . $kayttaja->id, array('message' => 'Rekisteröityminen onnistui'));
    }

}
