<?php
    require_once('user.php');
    
    // require_once('functions/functions.php');

    // echo 'OK Computer';

    $user1 = new user();
    // $user1->register('avida_dollars', 'pognon', 'sdali@yahoo.es', 'salvador', 'dali');
    // $user1->register('johnCage', '433', 'jcage@silence.org', 'john', 'cage');
    print_r_pre($user1->register('KStockhausen', 'mantra', 'KS@deutschland.org', 'Karlheinz', 'Stockhausen'), '$user1->register');

?>