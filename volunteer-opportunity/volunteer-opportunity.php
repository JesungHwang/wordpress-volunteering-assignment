<?php
/**
 * Plugin Name: Volunteer Opportunity
 * Description: Assignment Plugin for Wordpress
 * Author: Jesung Hwang
 */

function myPlugin_Activate(){
    global $wpdb;
    $wpdb -> query("CREATE TABLE opportunities (
    id INT NOT NULL AUTO_INCREMENT,
    position VARCHAR(255),
    organization VARCHAR(255),
    type VARCHAR(50),
    email VARCHAR(100),
    description TEXT,
    location VARCHAR(255),
    hours INT,
    skills VARCHAR(255),
    PRIMARY KEY (id)
    );");

    $wpdb -> query("INSERT INTO opportunities (position) VALUES('test-poisiton')");
    $wpdb -> query("INSERT INTO opportunities (organization) VALUES('test-organization')");
    $wpdb -> query("INSERT INTO opportunities (type) VALUES('test-opportunities')");
    $wpdb -> query("INSERT INTO opportunities (email) VALUES('test-email')");
    $wpdb -> query("INSERT INTO opportunities (description) VALUES('test-descriptions')");
    $wpdb -> query("INSERT INTO opportunities (location) VALUES('test-location')");
    $wpdb -> query("INSERT INTO opportunities (hours) VALUES('9999')");
    $wpdb -> query("INSERT INTO opportunities (skills) VALUES('test-skills')");
}

register_activation_hook( __FILE__, 'myPlugin_Activate' );

 function myPlugin_Deactivate()
 {
    global $wpdb;

    $wpdb->query("DROP TABLE opportunities");
 }

 register_deactivation_hook(__FILE__, "myPlugin_Deactivate");

 function wp_opportunities_adminpage_html() {
// check user capabilities
if ( ! current_user_can( 'manage_options' ) ) {
return;
}
?>
<div class="wrap">
<h1><?php esc_html( get_admin_page_title() ); ?></h1>
<form action="<?php admin_url('options-general.php?page=events/events.php')?>"
method="post">
<label for="someinput">Some Input</label>
<input type="text" name="someinput">
<input type="submit">
</form>
<p><a href="<?php admin_url('options-
general.php?page=events/events.php')?>?page=events&amp;somekey=somevalue">my link
action</a></p>
<p>POST array: <?php var_dump($_POST) ?></p>
<p>GET array: <?php var_dump($_GET) ?></p>
</div>
<?php
}
function wp_opportunities_adminpage() {
add_menu_page(
'opportunities',
'opportunities',
'manage_options',
'opportunities',
'wp_opportunities_adminpage_html',
'', // could give a custom icon here
20
);
}
add_action( 'admin_menu', 'wp_opportunities_adminpage' );