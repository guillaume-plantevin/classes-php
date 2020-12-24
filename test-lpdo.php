<?php
    require_once('lpdo.php');
    // require_once('functions/functions.php');

    $user1 = new lpdo;

    // J'ai changé le nom de la fonction, ça me semblait plus logique
    // $user1->constructeur('localhost', 'root', '', 'classes');

    // $user1->connect('localhost', 'root', '', 'classes');

    // print_r_pre($user1->execute("SELECT * FROM utilisateurs WHERE id = 343"), 'execute($query):');
    // print_r_pre($user1->execute("SELECT * FROM utilisateurs"), 'execute($query):');
    // print_r_pre($user1->getTables(), '$user1->getTables(): ');
    print_r_pre($user1->getFields('utilisateurs'), '$user1->getFields(): ');
    print_r_pre($user1->getFields2('utilisateurs'), '$user1->getFields2(): ');
?>