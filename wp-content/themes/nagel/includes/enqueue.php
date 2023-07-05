<?php

function u_enqueue(){
    wp_register_style(
        'u_font', '',[], null
    );
    wp_register_style(
        'u_css',
        get_theme_file_uri('assets/custom.css'),
        array(), // Dependencies. In this case, none.
        null // Version number. Null, in this case.
    );
    wp_enqueue_style('u_css');
}