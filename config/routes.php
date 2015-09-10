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