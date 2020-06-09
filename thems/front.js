$(document).ready(function(){
    'use strict';
    
    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');

    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });
    //live prveiw to the text
    $('.live').keyup(function(){
        //take the text you write in the input and put it in the h5 with live prveiw
        $($(this).data('class')).text($(this).val());
    });
});