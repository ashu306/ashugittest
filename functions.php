<?php
function my_theme_enqueue_styles() {

    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
/*insert data in wp-user table*/
 add_action( 'wp_ajax_nopriv_user_login', 'user_login' );
add_action( 'wp_ajax_user_login', 'user_login' );

function user_login(){
	global $wpdb; 
	$username = $wpdb->escape($_POST['username']);
	$password = $wpdb->escape($_POST['password']);
	
	$remember = false;
	if($username ==''){
		$responsedata = array("status"=>'error','message'=>'Required field missing');
		echo json_encode($responsedata);
		die;
	}
	$creds = array();
    $creds['user_login'] = $username;
    $creds['user_password'] = $password;
$creds['remember'] = false;
    $user = wp_signon( $creds, false );
	
    if ( !is_wp_error($user) ){
		
			$responsedata = array("status"=>'sucess','message'=>'Login Success');
			echo json_encode($responsedata);
			die;
		}
	else{
		//echo $user->get_error_message();
		wp_logout();
		$responsedata = array("status"=>'error','message'=>'Invalid Username or password!');
		echo json_encode($responsedata);
		die;
	}
}

/*create login shortcode*/
function login_shortcode_function(){
	$html = '<div class="col-sm-4">
 <h1>Login Form</h1>
 <div class="alert alert_hide_show" >
		  </div>
<form name="loginForm" id="loginForm" method="POST">
<input type="hidden" name="action" value="user_login">
<div class="form-group">
    <label for="email">User Name:</label>
    <input type="text" class="form-control" name="username" id="username">
  </div>
  <div class="form-group">
    <label for="pass">Password:</label>
    <input type="password" class="form-control" name="password" id="password">
  </div>
   <button type="submit" name="login_button" id="login_button" class="login" data-loading-text="Loading---"> LOGIN 
			</button>
  </form>
  </div>';
  return $html;
}
add_shortcode('login', 'login_shortcode_function' );

/*create login shortcode*/
function register_shortcode_function(){
	$html= '<div class="col-sm-4">
 <h1>Registration Form</h1>
<form method="POST" name="registerForm" id="registerForm">
<input type="hidden" name="action" value="user_register">
<div class="form-group">
    <label for="firstname">First Name:</label>
    <input type="text" class="form-control" name="firstname" id="firstname">
  </div>
  <div class="form-group">
    <label for="lastname">Last Name:</label>
    <input type="text" class="form-control" name="lastname" id="lastname">
  </div>
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" class="form-control" name="user_email" id="email">
  </div>
  <div class="form-group">
  	<label for="username">Username</label>
  	<input type="text" name="username" class="form-control" id="username">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" name="password" id="pwd">
  </div>
  <div class="form-group">                                                                                                                               
    <label for="phone">Phone no.:</label>
    <input type="text" class="form-control" name="phone" id="phone">
  </div>
   <button type="submit" name="submit" class="btn btn-default" id="reg">Submit</button>
</form>
 </div>';
 return $html;
}

add_shortcode('register', 'register_shortcode_function');

 add_action( 'wp_ajax_nopriv_user_register', 'user_register' );
add_action( 'wp_ajax_user_register', 'user_register' );

function user_register(){
	if(isset($_POST['submit'])){

	$default_newuser = array(
		'user_pass' => trim($_POST['password']),
		'user_login' => sanitize_user($_POST['username']),
		'user_email' =>sanitize_user($_POST['user_email'])
	);
	$user_id = wp_insert_user($default_newuser);
if ( $user_id && !is_wp_error( $user_id ) ) {
	add_user_meta($user_id, "first_name", $_POST['firstname']);
	add_user_meta($user_id, "last_name", $_POST['lastname']);
	add_user_meta($user_id, "phone_number", $_POST['phone']);

	 $responsedata = array("status"=>'sucess','message'=>'Registration Success');
			echo json_encode($responsedata);
			die;

}

else{
		$responsedata = array("status"=>'error','message'=>'register fail');
			echo json_encode($responsedata);
			die;
	}
}
}



?>
