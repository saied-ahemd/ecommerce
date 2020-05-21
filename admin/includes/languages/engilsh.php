<?php
function lan($par){
    static $lang= array(
        'Home'=>'Egypt',
        'age'=> '18',

    );
    return $lang[$par];
}
?>