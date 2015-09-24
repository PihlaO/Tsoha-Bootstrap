<?php

class KayttajaController extends BaseController {

    public static function login() {
        View::make('kayttaja/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $kayttaja = Kayttaja::authenticate($params['kayttajatunnus'], $params['salasana']);

        if (!$kayttaja) {
            View::make('kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'kayttajatunnus' => $params['kayttajatunnus']));
        } else {
            $_SESSION['kayttaja'] = $kayttaja->id;

            Redirect::to('/', array('message' => 'Tervetuloa ' . $kayttaja->etunimi . '!'));
        }
    }

    public static function logout() {
        $_SESSION['kayttaja'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

    public static function index() {

        $kayttajat = Kayttaja::all();

        View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function show($id) {
        $kaytttaja = Kayttaja::find($id);
        View::make('kayttaja/esittely.html', array('kayttaja' => $kaytttaja));
    }

    public static function create() {
        View::make('kayttaja/rekisteroityminen.html');
    }

    public static function store() {

        $params = $_POST;

        $attributes = array(
            'etunimi' => $params['etunimi'],
            'sukunimi' => $params['sukunimi'],
            'kayttajatunnus' => $params['kayttajatunnus'],
            'salasana' => $params['salasana'],
            'sahkoposti' => $params['sahkoposti']
        );

        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();
        if (count($errors) == 0) {
            $kayttaja->save();


            Redirect::to('/kayttaja/' . $kayttaja->id, array('message' => 'Rekisteröityminen onnistui'));
        } else {
            View::make('kayttaja/rekisteroityminen.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

}
