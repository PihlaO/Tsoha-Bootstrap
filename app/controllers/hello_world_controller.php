<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make('helloworld.html');
    }
    
        public static function rekisteroidy() {
        View::make('suunnitelmat/rekisteroidy.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function tehtavat_list() {
        View::make('suunnitelmat/tehtavat_list.html');
    }

    public static function etusivu() {
        View::make('suunnitelmat/etusivu.html');
    }

    public static function muokkaus() {
        View::make('suunnitelmat/muokkaus.html');
    }
    public static function nayta_tehtava() {
        View::make('suunnitelmat/nayta_tehtava.html');
    }
}
