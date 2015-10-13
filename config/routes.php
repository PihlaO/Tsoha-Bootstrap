<?php


function check_logged_in(){
  BaseController::check_logged_in();
}

///ETUSIVU/muistilista
$routes->get('/', function() {
    TehtavaController::etusivu();
});
///
$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});


//Tehtävä

////Kokeilu
$routes->get('/tehtavien_listaus/:id','check_logged_in', function($id) {
    TehtavaController::nayta_tehtavat_tietysta_luokasta($id);
});
/////

$routes->get('/tehtavien_listaus','check_logged_in', function() {
    TehtavaController::index();
});


$routes->post('/tehtava', function() {
    TehtavaController::store();
});

$routes->get('/tehtava/uusi','check_logged_in', function() {
    TehtavaController::create();
});

$routes->get('/tehtava/:id','check_logged_in', function($id) {
    TehtavaController::show($id);
});

// Muokkauslomakkeen esittäminen
$routes->get('/tehtava/:id/muokkaus','check_logged_in', function($id) {
    TehtavaController::edit($id);
});

// Tehtävän muokkaus 
$routes->post('/tehtava/:id/muokkaus','check_logged_in',function($id) {
    TehtavaController::update($id);
});

// Tehtävän poisto
$routes->post('/tehtava/:id/poisto','check_logged_in', function($id) {
    TehtavaController::destroy($id);
});


// Luokka

$routes->post('/luokka', function() {
    LuokkaController::store();
});

$routes->get('/luokka/uusi','check_logged_in', function() {
    LuokkaController::create();
});

$routes->get('/luokka/:id','check_logged_in', function($id) {
    LuokkaController::show($id);
});



$routes->get('/luokkien_listaus','check_logged_in', function() {
    LuokkaController::index();
});

// Luokan muokkaus 
$routes->post('/luokka/:id/muokkaus', function($id) {
    LuokkaController::update($id);
});

// Muokkauslomakkeen esittäminen
$routes->get('/luokka/:id/muokkaus','check_logged_in', function($id) {
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
$routes->get('/kayttaja/:id','check_logged_in', function($id) {
    KayttajaController::show($id);
});


//$routes->get('/tehtavat_list', function() {
//    HelloWorldController::tehtavat_list();
//});
//
////$routes->get('/login', function() {
////    HelloWorldController::login();
////});
//
//$routes->get('/muokkaus', function() {
//    HelloWorldController::muokkaus();
//});
//
//$routes->get('/nayta_tehtava', function() {
//    HelloWorldController::nayta_tehtava();
//});
//$routes->get('/rekisteroidy', function() {
//    HelloWorldController::rekisteroidy();
//});
//
//$routes->get('/lisaa_tehtava', function() {
//    HelloWorldController::lisaa_tehtava();
//});
//
//$routes->get('/luokan_muokkaus', function() {
//    HelloWorldController::luokan_muokkaus();
//});
//$routes->get('/luokan_lisays', function() {
//    HelloWorldController::luokan_lisays();
//});