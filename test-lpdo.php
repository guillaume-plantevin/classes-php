<?php
    require_once('lpdo.php');
    $user1 = new lpdo;

    // $user1->constructeur('localhost', 'root', '', 'classes');

    $user1->connect('localhost', 'root', '', 'classes');

    print_r_pre($user1->execute("SELECT * FROM utilisateurs WHERE id = 343"), 'execute($query):');
    // print_r_pre($user1->execute("SELECT * FROM utilisateurs"), 'execute($query):');
?>