<?php
/*
Plugin Name: Custom Login/Register Form
Plugin URI: http://nagel.com/
Description: This is a custom plugin for Login/Register form
Version: 1.0
Author: Mohamed
Author URI: http://nagel.com/
*/

// Shortcode for custom login form
function custom_login_form() {
    if (!is_user_logged_in()) {
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
                <input type="submit" name="login" value="Log In">
            </div>
            </form>
        ';

        return $form;
    }
    return '<p>You are already logged in.</p>';
}
add_shortcode('custom-login', 'custom_login_form');

function custom_handle_login() {
    if (isset($_POST['login'])) {
        $creds = array();
        $creds['user_login'] = sanitize_user($_POST['email']);  // Change 'email' to 'user_login'
        $creds['user_password'] = $_POST['password'];
        $creds['remember'] = true;

        $user = wp_signon($creds, false);

        if (!is_wp_error($user)) {
            // The user has been logged in
            $redirect_url = home_url();
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
        <form action="" method="POST">
          <div>
            <h2>New user?</h2>
            <p>Use the form below to create your account.</p>
          </div>
            <div class="inline-input">
              <input type="text" id="first-name" name="firstName" placeholder="First Name" required>
              <input type="text" id="last-name" name="lastName" placeholder="Last Name" required>
            </div>
      
            <input type="email" id="email" name="email" placeholder="Email" required>
      
            <div class="inline-input">
              <input type="password" id="password" name="password" placeholder="Password" required>
              <input type="password" id="confirm-password" name="confirmPassword" placeholder="Confirm Password" required>
            </div>
      <div>
            <input type="checkbox" id="agree" name="agree" required>
            <label for="agree">Agreed to Terms and Conditions</label>
      </div>
            <button type="submit" name="register">Sign Up</button>
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
    // print_r($_POST);
    if (isset($_POST['register'])) {
        $username = sanitize_user($_POST['firstName']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirmPassword'];
        $last_name = sanitize_text_field($_POST['lastName']);

        if($password != $confirm_password) {
            // Passwords don't match
            echo 'The passwords do not match.';
            exit;
        }
        echo "Username: $username<br>";
        echo "Email: $email<br>";

        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            // The user has been created successfully
            // We update the last name here. WordPress does not support last name in the wp_create_user function
            wp_update_user(
                array(
                    'ID' => $user_id,
                    'last_name' => $last_name
                )
            );

            $redirect_url = home_url();
            wp_redirect($redirect_url);
            exit;
        } else {
            // Something went wrong
            echo $user_id->get_error_message();
            exit;
        }
    }
}
add_action('init', 'custom_handle_registration');


function custom_dashboard(){
    $plugin_url = plugin_dir_url(__FILE__);
    $image_url = $plugin_url . '/assets/default-avatar.png';
    $form = '
    <div class="dashboard-container">
        <div class="first-column">
            <h2>Your Name</h2>
            <p>@yourname</p>
            <div class="avatar">
                <img src="'.esc_url($image_url) .'" alt="User Image">
                <a href="" class="delete-avatar"><img src="'.plugin_dir_url(__FILE__).'/assets/delete-button.png"/></a>
            </div>
            <input type="file" id="upload-photo" accept="image/*" style="display: none;">
            <button id="upload-photo-button">Upload New Photo</button>
            <div id="upload-description">
                <p>Upload a new avatar. Larger image will be resized automatically.<br>
                Maximum upload size is 1 MB</p>
            </div>
            <p>Member since:  29 July 2023</p>
        </div>
        <div class="second-column">
            <div class="edit-profile">
                <h2>Edit Profile</h2>
            </div>
            <div class="tabs">
                
                <div class="tab active" data-tab="user-info">
                    <h3>User Info</h3>
                </div>
                <div class="tab" data-tab="billing-info">
                    <h3>Billing Information</h3>
                </div>
                </div>
                <div id="user-info" class="tab-content active">
                    <form class="edit-profile-form">
                        <div class="row">
                            <div>
                                <label for="full-name">Full Name:</label>
                                <input type="text" id="full-name">
                            </div>
                            <div>
                                <label for="user-name">User Name:</label>
                                <input type="text" id="user-name">
                            </div>
                        </div>
                        <div class="row">
                            <div>
                                <label for="company-name">Company Name:</label>
                                <input type="text" id="company-name">
                            </div>
                            <div>
                                <label for="address">Address:</label>
                                <input type="text" id="address">
                            </div>
                        </div>
                        <div class="row">
                            <div>
                                <label for="email">Email Address:</label>
                                <input type="email" id="email">
                            </div>
                            <div>
                                <label for="phone">Phone Number:</label>
                                <input type="tel" id="phone">
                            </div>
                        </div>
                        <p>Social Profiles:</p>
                        <div class="row">
                            <div class="facebook">
                                <input type="text" id="facebook-username">
                            </div>
                            <div class="twitter">
                                <input type="text" id="twitter-username">
                            </div>
                        </div>
                        <button type="submit" style="background-color: #9a7cbd;">Update Info</button>
                    </form>
                </div>
        
            <div id="billing-info" class="tab-content">
                
            </div>
        </div>  
    </div>';
    return $form;
}

add_shortcode('custom-dashboard', 'custom_dashboard');