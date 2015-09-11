<?php

class TehtavaController extends BaseController {

    public static function index() {

        $tehtavat = tehtava::all();
        View::make('tehtava/index.html', array('tehtava' => $tehtavat));
    }

}
