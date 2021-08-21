<?php
//Child Theme Functions File
add_action( "wp_enqueue_scripts", "enqueue_wp_child_theme" );
function enqueue_wp_child_theme() 
{
    if((esc_attr(get_option("childthemewpdotcom_setting_x")) != "Yes")) 
    {
		//This is your parent stylesheet you can choose to include or exclude this by going to your Child Theme Settings under the "Settings" in your WP Dashboard
		wp_enqueue_style("parent-css", get_template_directory_uri()."/style.css");
    }

	//This is your child theme stylesheet = style.css
	wp_enqueue_style("child-css", get_stylesheet_uri(), '', time());

	//This is your child theme js file = js/script.js
	wp_enqueue_script("child-js", get_stylesheet_directory_uri() . "/js/script.js", array( "jquery" ), time(), true );
}

add_action('wp_head', 'setAjaxUrlFrontEnd');

/**
 * @return void
 */
function setAjaxUrlFrontEnd(): void
{
    echo '<script>
           const ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";
         </script>';
}

add_action('wp_ajax_send_form_data', 'send_form_data');
add_action('wp_ajax_nopriv_send_form_data', 'send_form_data');

function send_form_data()
{
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $photos_keys = ['photo_0', 'photo_1', 'photo_2', 'photo_3'];
    $photos = [];

    foreach ($photos_keys as $key) {
        if (isset($_POST[$key])){
            $photos[] = $_POST[$key];
        }
    }

    $result_array = [
        'first_name' => $name,
        'last_name' => $last_name,
        'phone' => $phone,
        'email' => $email,
        'photos' => $photos
    ];

    $result_data = json_encode($result_array);

    $API_URL = ' https://enyb0b22v7ttjfm.m.pipedream.net';
    $ch = curl_init($API_URL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $result_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    print_r(curl_exec($ch));
    curl_close( $ch );

    exit();
}

