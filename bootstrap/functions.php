<?php
function printr(...$args) {
    foreach($args as $arg) {
        echo "<pre>";
        if(is_integer($arg)) {
            var_dump($arg);
        } else {
            print_r($arg);
        }
        echo "</pre>\n";
    }
}
function printrx(...$args) {
    die(printr(...$args));
}