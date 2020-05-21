$(function(){
    'use strict';
    
    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');

    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });
    //confirm the delete member
    // $('.confirm').click(function() {
    //     return confirm('Are You Sure ?');
    //   });
    
    //add star after each required input
    // $('input').each(function(){
    //     if($(this).attr("required")==="required"){
    //         $(this).after('<span class="star">*</span>');
    //     }
    // });

    
   
});