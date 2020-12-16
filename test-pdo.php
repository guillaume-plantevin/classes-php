<?php
    require_once('user-pdo.php');

    echo 'User1: ';
    $user1 = new userpdo();
    // echo '<br />User2: ';
    // $user2 = new userpdo();
    // echo '<br />User3: ';
    // $user3 = new userpdo();

    // $user1->register('MSardou', 'lesRicains', 'sardou@gmail.com', 'Michel', 'Sardou');
    // $user2->register('johnDoe', '123', 'johndoe@gmail.com', 'John', 'Doe');
    // $user3->register('janeDoe', '123123', 'janedoe@gmail.com', 'Jane', 'Doe');
    
    print_r_pre($user1->connect('MSardou', 'lesRicains'), '$user1->connect:');
    print_r_pre($user1->delete(), '$user1->delete():');
    // print_r_pre($user2-> connect('janeDoe', '123123'), '$user2->connect:');
    
    // echo '$user3->disconnect​():  ';
    // var_dump_pre($user3->disconnect​(), 'USER3:');

    // echo '$user2->disconnect​():  ';
    // var_dump_PRE($user2->disconnect​(), 'USER2');   
?>