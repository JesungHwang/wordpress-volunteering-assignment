<?php
/**
 * Plugin Name: Volunteer Opportunity
 * Description: Volunteering plugin that gives users the Admin the ability to add and delete volunteering opportunities.
 * Author: Jesung Hwang
 */

function myPlugin_Activate(){
    global $wpdb;
    $wpdb -> query("CREATE TABLE opportunities (
    id           INT NOT NULL AUTO_INCREMENT,
    position     VARCHAR(255),
    organization VARCHAR(255),
    type         VARCHAR(50),
    email        VARCHAR(100),
    description  TEXT,
    location     VARCHAR(255),
    hours        INT,
    skills       VARCHAR(255),
    PRIMARY KEY  (id)
    );");

    $wpdb -> query("INSERT INTO opportunities (position, organization, type, email, description, location, hours, skills) 
                    VALUES('test-positon',
                           'test-organizaion',
                           'test-type',
                           'test-email',
                           'test-description',
                           'test-location',
                           '9999',
                           'test-skills')");
}

register_activation_hook( __FILE__, 'myPlugin_Activate' );

 function myPlugin_Deactivate()
 {
    global $wpdb;

    $wpdb->query("DROP TABLE opportunities");
 }

register_deactivation_hook(__FILE__, "myPlugin_Deactivate");

function wp_opportunities_adminpage_html() {
    global $wpdb;
    $table = 'opportunities';

    if (isset($_GET['delete'])) {
        $wpdb->delete($table, ['id' => intval($_GET['delete'])]);
    }

    if (isset($_POST['create_opportunity'])) {
        if (
            !empty($_POST['position']) &&
            !empty($_POST['organization']) &&
            is_numeric($_POST['hours'])
        ) {
            $wpdb->insert($table, [
                'position'     => sanitize_text_field($_POST['position']),
                'organization' => sanitize_text_field($_POST['organization']),
                'type'         => sanitize_text_field($_POST['type']),
                'email'        => sanitize_text_field($_POST['email']),
                'description'  => sanitize_text_field($_POST['description']),
                'location'     => sanitize_text_field($_POST['location']),
                'hours'        => intval($_POST['hours']),
                'skills'       => sanitize_text_field($_POST['skills'])
            ]);
        }
    }

    ?>
    <div class="wrap">
        <h1>Volunteer Opportunities</h1>

        <h2>Add Opportunity</h2>
        <form method="post">
            <input name="position" placeholder="Position" required><br><br>
            <input name="organization" placeholder="Organization" required><br><br>

            <select name="type">
                <option value="temporary">Temperory</option>
                <option value="recurring">Recurring</option>
                <option value="seasonal">Seasonal</option>
            </select><br><br>

            <input type="email" name="email" placeholder="Email"><br><br>
            <input name="location" placeholder="Location"><br><br>
            <input type="number" name="hours" placeholder="Hours" required><br><br>
            <input name="skills" placeholder="Skills (comma-separated)"><br><br>
            <textarea name="description" placeholder="Description"></textarea><br><br>

            <button name="create_opportunity">Add Opportunity</button>
        </form>
    </div>
<?php
}

function wp_opportunities_adminpage() {
    add_menu_page(
        'Volunteer',
        'Volunteer',
        'manage_options',
        'opportunities',
        'wp_opportunities_adminpage_html',
        '',
        20
    );
}
add_action( 'admin_menu', 'wp_opportunities_adminpage' );
