<?php
    require_once('user-pdo.php');

    // $user1 = new userpdo();
    $user2 = new userpdo();
    // $user3 = new userpdo();

    // $user1->register('MSardou', 'lesRicains', 'sardou@gmail.com', 'Michel', 'Sardou');
    // $user2->register('johnDoe', '123', 'johndoe@gmail.com', 'John', 'Doe');
    // $user3->register('janeDoe', '123123', 'janedoe@gmail.com', 'Jane', 'Doe');
    // $user2->register('mDuchamp', 'lhooq', 'ducygne@gmail.com', 'marcel', 'duchamp');
    
    print_r_pre($user2->connect('mDuchamp', 'lhooq'), '$user2->connect: ');
    $user2->update​('mDuchamp', 'lhooq', 'ducygne@gmail.com', 'mireille', 'duchamp');

    var_dump_pre($user2->isConnected​(), '$user2->isConnected​(): ');
    var_dump_pre($user2->getAllInfos(), '$user2->getAllInfos(): ');
    print_r_pre($user2->getEmail(), '$user2->getEmail(): ');
    print_r_pre($user2->getFirstname(), '$user2->getFirstname(): ');
    $user2->refresh();
    $user2->disconnect​();
?>