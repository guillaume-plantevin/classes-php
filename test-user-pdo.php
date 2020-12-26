<?php
    require_once('user-pdo.php');
    // Utilisation de fonctions personnelles pour afficher les données en return
    // toutes les fonctions ne sont plus affichées

    // $user1 = new userpdo();
    // $user2 = new userpdo();
    $user3 = new userpdo();
    // $user4 = new userpdo();

    // $user1->register('MSardou', 'lesRicains', 'sardou@gmail.com', 'Michel', 'Sardou');
    // $user2->register('johnDoe', '123', 'johndoe@gmail.com', 'John', 'Doe');
    // $user3->register('foetus', 'HOLE', 'foetus@gmail.com', 'Jim', 'Thirwell');
    // $user4->register('janeDoe', '123123', 'janedoe@gmail.com', 'Jane', 'Doe');

    $user3->connect('foetus', 'HOLE');
    // $user3->disconnect​();
    $user3->update​('foetus', 'HOLE', 'foetus@gmail.com', 'Clint', 'Ruin');
    $user3->refresh();
    print_r_pre($user3->getAllInfos(), '$user3->getAllInfos(): ');
    // CREATION de plusieurs utilisateurs
    // Ne fonctionne qu'une seule fois


    // $user2->register('mDuchamp', 'lhooq', 'ducygne@gmail.com', 'marcel', 'duchamp');
    
    // print_r_pre($user2->connect('mDuchamp', 'lhooq'), '$user2->connect: ');

    // chgt du firstname
    // $user2->update​('mDuchamp', 'lhooq', 'ducygne@gmail.com', 'mireille', 'duchamp');
    
    // $user2->refresh();
    // retour bool
    // var_dump_pre($user2->isConnected​(), '$user2->isConnected​(): ');

    // return d'un associative array
    // var_dump_pre($user2->getAllInfos(), '$user2->getAllInfos(): ');

    // print_r_pre($user2->getEmail(), '$user2->getEmail(): ');

    // print_r_pre($user2->getFirstname(), '$user2->getFirstname(): ');

    // recupere les donnes de la DB

    // $user2->disconnect​();
?>