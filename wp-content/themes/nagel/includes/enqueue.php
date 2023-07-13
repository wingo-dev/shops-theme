<?php

function u_enqueue(){
   
    wp_enqueue_style( 'poppins-font', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap' );
   
    wp_enqueue_style( 'raleway-semi-font', 'https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap' );
    
    wp_register_style(
        'u_css',
        get_theme_file_uri('assets/custom.css'),
        array(), 
        null 
    );
    wp_register_style(
        'fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        array(),
        null
    );
    wp_register_script(
        'u_js',
        get_theme_file_uri('assets/custom.js'), 
        array('jquery'), 
        null, 
        true 
    );
    wp_enqueue_style('poppins-font');
    wp_enqueue_style('raleway-semi-font');
    wp_enqueue_style('u_css');
    wp_enqueue_style('fontawesome');
    wp_enqueue_script('u_js');
}