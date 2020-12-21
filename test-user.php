<?php
    require_once('user.php');
    
    // require_once('functions/functions.php');

    // echo 'OK Computer';

    $user1 = new user();
    // $user1->register('avida_dollars', 'pognon', 'sdali@yahoo.es', 'salvador', 'dali');
    // $user1->register('johnCage', '433', 'jcage@silence.org', 'john', 'cage');
    // print_r_pre($user1->register('KStockhausen', 'mantra', 'KS@deutschland.org', 'Karlheinz', 'Stockhausen'), '$user1->register');
    
    // print_r_pre($user1->connect('KStockhausen', 'mantra'), '$user1->connect:');
    // $user1->disconnect​();
    // print_r_pre($user1->connect('KStockhausen', 'mantras'), '$user1->connect:');
    // print_r_pre($user1->update​('KStockhausen', 'mantra', 'KS@deutschland.org', 'Karlheinz', 'Stockhausen'), '$user1->update');
    // $user1->delete();


    // print_r_pre($user1->register('newUser', '123', 'g@gmail.com', 'new', 'user'), '$user1->register:');
    print_r_pre($user1->connect('incognito', 'machina'), '$user1->connect');
    var_dump_pre($user1->isConnected​(), 'IS_CONNECTED: ');
    print_r_pre($user1->getLastname(), 'GET_LASTNAME: ');
    // $user1->disconnect​();
    print_r_pre($user1->getFirstname(), 'GET_FIRSTNAME: ');
    print_r_pre($user1->getEmail(), 'GET_EMAIL: ');
    print_r_pre($user1->getAllInfos(), 'GET_ALLINFOS: ');
    // $user1->update​('Incognito', 'machina', 'totoschkaya@gmail.com', 'Billy', 'Corgan');
    $user1->refresh();
    print_r_pre($user1->getAllInfos(), 'GET_ALLINFOS: ');

?>