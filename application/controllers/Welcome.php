<?php

/**
 * Our homepage.
 *
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show home-y stuff
    //-------------------------------------------------------------

    function index() {
        $this->data['pagebody'] = 'homepage';
        $this->data['menubar']  = $this->makemenu();

        $this->render();
    }

    function makemenu() {
        // get role & name from session
        $userRole = $this->session->userdata('userRole');
        $userName = $this->session->userdata('userName');

        // make array, with menu choice for alpha

        // if not logged in, add menu choice to login
        // if()
        // if user, add menu choice for beta and logout
        // if admin, add menu choices for beta, gamma and logout
        // return the choices array
    }
}
