<?php

///ETUSIVU/muistilista
$routes->get('/', function() {   
    HelloWorldController::etusivu();
});
///
$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/tehtavat_list', function() {
    HelloWorldController::tehtavat_list();
});

//$routes->get('/login', function() {
//    HelloWorldController::login();
//});

$routes->get('/muokkaus', function() {
    HelloWorldController::muokkaus();
});

$routes->get('/nayta_tehtava', function() {
    HelloWorldController::nayta_tehtava();
});
$routes->get('/rekisteroidy', function() {
    HelloWorldController::rekisteroidy();
});

$routes->get('/lisaa_tehtava', function() {
    HelloWorldController::lisaa_tehtava();
});

$routes->get('/luokan_muokkaus', function() {
    HelloWorldController::luokan_muokkaus();
});
$routes->get('/luokan_lisays', function() {
    HelloWorldController::luokan_lisays();
});

//Tehtävä

//$routes->get('/tehtavien_listaus', function() {
//    TehtavaController::index();
//});


// kokeilu // TOIMIII
$routes->get('/tehtavien_listaus', function() {
    TehtavaController::index();
});



$routes->post('/tehtava', function() {
    TehtavaController::store();
});

$routes->get('/tehtava/uusi', function() {
    TehtavaController::create();
});

$routes->get('/tehtava/:id', function($id) {
    TehtavaController::show($id);
});

// Muokkauslomakkeen esittäminen
$routes->get('/tehtava/:id/muokkaus', function($id) {
    TehtavaController::edit($id);
});

// Tehtävän muokkaus 
$routes->post('/tehtava/:id/muokkaus', function($id) {
    TehtavaController::update($id);
});

// Tehtävän poisto
$routes->post('/tehtava/:id/poisto', function($id) {
    TehtavaController::destroy($id);
});

// Käyttäjä

$routes->get('/login', function(){
  // Kirjautumislomakkeen esittäminen
  KayttajaController::login();
});
$routes->post('/login', function(){
  // Kirjautumisen käsittely
  KayttajaController::handle_login();
});

$routes->post('/logout', function(){
  KayttajaController::logout();
});

$routes->get('/kayttaja/rekisteroityminen', function() {
    KayttajaController::create();
});
$routes->post('/kayttaja', function() {
    KayttajaController::store();
});
$routes->get('/kayttaja/:id', function($id) {
    KayttajaController::show($id);
});
// Luokka

$routes->get('/luokkien_listaus', function() {
    LuokkaController::index();
});
$routes->get('/luokka/uusi', function() {
    LuokkaController::create();
});
$routes->post('/luokka', function() {
    LuokkaController::store();
});

$routes->get('/luokka/:id', function($id) {
    LuokkaController::show($id);
});



