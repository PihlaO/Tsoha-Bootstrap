<?php

$routes->get('/', function() {
    HelloWorldController::etusivu();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/tehtavat_list', function() {
    HelloWorldController::tehtavat_list();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

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

$routes->get('/tehtava', function() {
    TehtavaController::index();
});


$routes->post('/tehtava', function() {
    TehtavaController::store();
});

$routes->get('/tehtava/new', function() {
    TehtavaController::create();
});

$routes->get('/tehtava/:id', function($id) {
    TehtavaController::show($id);
});

// Käyttäjä

$routes->get('/kayttaja/rekisteroityminen', function() {
    KayttajaController::create();
});
$routes->post('/kayttaja', function() {
    KayttajaController::store();
});

$routes->get('/kayttaja/:id', function($id) {
    KayttajaController::show($id);
});

