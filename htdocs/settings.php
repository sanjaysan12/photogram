<?php

include 'libs/load.php';
if(!Session::isAuthenticated()) {
    Session::ensureLogin();
}

Session::renderPage();
