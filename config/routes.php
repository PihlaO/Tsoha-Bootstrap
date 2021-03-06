<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

//Tehtävä

$routes->get('/tehtavien_listaus/:id', 'check_logged_in', function($id) {
    TehtavaController::nayta_tehtavat_tietysta_luokasta($id);
});

$routes->get('/tehtavien_listaus', 'check_logged_in', function() {
    TehtavaController::tehtavien_listaus();
});


$routes->post('/tehtava', function() {
    TehtavaController::store();
});

$routes->get('/tehtava/uusi', 'check_logged_in', function() {
    TehtavaController::create();
});

$routes->get('/tehtava/:id', 'check_logged_in', function($id) {
    TehtavaController::show($id);
});

// Muokkauslomakkeen esittäminen
$routes->get('/tehtava/:id/muokkaus', 'check_logged_in', function($id) {
    TehtavaController::edit($id);
});

// Tehtävän muokkaus 
$routes->post('/tehtava/:id/muokkaus', 'check_logged_in', function($id) {
    TehtavaController::update($id);
});

// Tehtävän poisto
$routes->post('/tehtava/:id/poisto', 'check_logged_in', function($id) {
    TehtavaController::destroy($id);
});


// Luokka

$routes->post('/luokka', function() {
    LuokkaController::store();
});

$routes->get('/luokka/uusi', 'check_logged_in', function() {
    LuokkaController::create();
});

$routes->get('/luokka/:id', 'check_logged_in', function($id) {
    LuokkaController::show($id);
});


$routes->get('/luokkien_listaus', 'check_logged_in', function() {
    LuokkaController::luokkien_listaus();
});

// Luokan muokkaus 
$routes->post('/luokka/:id/muokkaus', function($id) {
    LuokkaController::update($id);
});

// Muokkauslomakkeen esittäminen
$routes->get('/luokka/:id/muokkaus', 'check_logged_in', function($id) {
    LuokkaController::edit($id);
});

// luokan poisto
$routes->post('/luokka/:id/poisto', function($id) {
    LuokkaController::destroy($id);
});

// Käyttäjä

$routes->get('/login', function() {
    // Kirjautumislomakkeen esittäminen
    KayttajaController::login();
});
$routes->post('/login', function() {
    // Kirjautumisen käsittely
    KayttajaController::handle_login();
});

$routes->post('/logout', function() {
    KayttajaController::logout();
});

$routes->get('/kayttaja/rekisteroityminen', function() {
    KayttajaController::create();
    KayttajaController::handle_login();
});
$routes->post('/kayttaja', function() {
    KayttajaController::store();
});
$routes->get('/kayttaja/:id', 'check_logged_in', function($id) {
    KayttajaController::show($id);
});

///Etusivu/Muistilista
$routes->get('/', function() {
    TehtavaController::index();
});


