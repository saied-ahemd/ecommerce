<?php
function lan($par){
    static $lang= array(
        'Home'=>'مصر',
        'age'=> 'ثمانيه عشر',

    );
    return $lang[$par];
}
?>