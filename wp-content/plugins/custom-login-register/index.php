<?php
/*
Plugin Name: Custom Login/Register Form
Plugin URI: http://nagel.com/
Description: This is a custom plugin for Login/Register form
Version: 1.0
Author: Mohamed
Author URI: http://nagel.com/
*/

// Shortcode for login form
// Shortcode for custom login form
function custom_login_form() {
    if (!is_user_logged_in()) {
        // $form = '<form method="post">
        //     <label for="username">Username</label>
        //     <input type="text" id="username" name="log" required>

        //     <label for="password">Password</label>
        //     <input type="password" id="password" name="pwd" required>

        //     <input type="submit" name="submit" value="Login">
        // </form>';
        $form = '
        <form method="post" class="login-form">
            <div class="input-group">
            <h2>Login please</h2>
            </div>
            <div class="input-group emailbox">
                <input type="email" id="email"  name="email" placeholder="Input your user ID or Email">
            </div>
            
            <div class="input-group passwordbox">
                <input type="password" id="password" name="password" placeholder="Input your password">
            </div>
            <div class="rfgroup">
            <div class="checkbox">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            <div class="forgot-password">
                <a href="#">Forgot password?</a>
            </div>
            </div>
            <div class="input-group login-btn">
                <input type="submit" value="Log In">
            </div>
            </form>
        ';

        return $form;
    }
    return '<p>You are already logged in.</p>';
}
add_shortcode('custom-login', 'custom_login_form');
function custom_handle_login() {
    if (isset($_POST['submit'])) {
        $creds = array();
        $creds['user_login'] = sanitize_user($_POST['log']);
        $creds['user_password'] = $_POST['pwd'];
        $creds['remember'] = true;

        $user = wp_signon($creds, false);

        if (!is_wp_error($user)) {
            // The user has been logged in
            $redirect_url = home_url('/custom-dashboard/');
            wp_redirect($redirect_url);
            exit;
        } else {
            // Something went wrong
            echo $user->get_error_message();
            exit;
        }
    }
}
add_action('init', 'custom_handle_login');


// Shortcode for registration form
function custom_registration_form() {
    if (!is_user_logged_in()) {
        $form = '<div class="container">
        <div class="image-container">
        </div>
        <div class="form-container">
        <form action="' . wp_registration_url() . '" method="POST">
          <div>
            <h2>New user?</h2>
            <p>Use the form below to create your account.</p>
          </div>
            <div class="inline-input">
              <input type="text" id="first-name" name="first-name" placeholder="First Name">
              <input type="text" id="last-name" name="last-name" placeholder="Last Name">
            </div>
      
            <input type="email" id="email" name="email" placeholder="Email">
      
            <div class="inline-input">
              <input type="password" id="password" name="password" placeholder="Password">
              <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
            </div>
      <div>
            <input type="checkbox" id="agree" name="agree">
            <label for="agree">Agreed to Terms and Conditions</label>
      </div>
            <button type="submit">Sign Up</button>
      <div class="login-link">Have an account? <a href="/login">Login</a></div>
          </form>
        </div>
      </div>';

        return $form;
    }
    return '<p>You are already logged in.</p>';
}
add_shortcode('custom-register', 'custom_registration_form');

function custom_handle_registration() {
    if (isset($_POST['submit'])) {
        $username = sanitize_user($_POST['user_login']);
        $email = sanitize_email($_POST['user_email']);

        $errors = register_new_user($username, $email);

        if (!is_wp_error($errors)) {
            // The user has been created
            $redirect_url = home_url('/custom-dashboard/');
            wp_redirect($redirect_url);
            exit;
        } else {
            // Something went wrong
            echo $errors->get_error_message();
            exit;
        }
    }
}
add_action('init', 'custom_handle_registration');
