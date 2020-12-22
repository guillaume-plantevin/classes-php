<?php
    require_once('lpdo.php');
    $user1 = new lpdo;

    $user1->constructeur('localhost', 'root', '', 'classes');

    $user1->connect('localhost', 'root', '', 'classes');

?>