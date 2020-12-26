<?php
    require_once('lpdo.php');
    // require_once('functions/functions.php');

    $user = new lpdo;
    // $user->constructeur('localhost', 'root', '', 'classes');
    $user->connect('localhost', 'root', '', 'classes');
    // $user->__destruct();
    print_r_pre($user->execute('SELECT email FROM utilisateurs'), '$user->execute:(email) ');
    // var_dump_pre($user->execute('SELECT login FROM utilisateurs2'), 'execute:(login) ');
    // print_r_pre($user->execute('SELECT firstname FROM utilisateurs'), 'execute:(firstName) ');

    var_dump_pre($user->getlastQuery(), '$user->getlastQuery');

    var_dump_pre($user->getLastResult(), '$user->getLastResult: ');
    var_dump_pre($user->getFields('utilisateurs2'), '$user->getFields:')
?>