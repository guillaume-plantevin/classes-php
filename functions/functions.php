<?php
    function print_r_pre($array, $name) {
        echo '<pre>';
        echo $name . '<br />';
        print_r($array);
        echo '</pre>';
    }
    function var_dump_pre($array, $name) {
        echo '<pre>';
        echo $name . ':';
        var_dump($array);
        echo '</pre>';
    }