<?php

function u_enqueue(){
    // Enqueue Poppins font
    wp_enqueue_style( 'poppins-font', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap' );
    // Enqueue Raleway Semi font
    wp_enqueue_style( 'raleway-semi-font', 'https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap' );
    
    wp_register_style(
        'u_css',
        get_theme_file_uri('assets/custom.css'),
        array(), // Dependencies. In this case, none.
        null // Version number. Null, in this case.
    );
    wp_enqueue_style('poppins-font');
    wp_enqueue_style('raleway-semi-font');
    wp_enqueue_style('u_css');
}