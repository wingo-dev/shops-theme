<?php

// varialbles

// includes

include(get_theme_file_path('/includes/enqueue.php'));
// Hooks
add_action('wp_enqueue_scripts','u_enqueue');