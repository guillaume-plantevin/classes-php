<?php
    require_once('lpdo.php');
    // require_once('functions/functions.php');

    $user = new lpdo;
    // $user->constructeur('localhost', 'root', '', 'classes');
    $user->connect('localhost', 'root', '', 'classes');
    $user->destructeur();
?>