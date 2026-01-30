<?php
/**
 * Plugin Name: Volunteer Opportunity Plugin
 * Description: Volunteering plugin that gives users the Admin the ability to add and delete volunteering opportunities.
 * Author: Jesung Hwang
 */

function myPlugin_Activate(){
    global $wpdb;
    $table = 'opportunities';
    $wpdb->query("DROP TABLE IF EXISTS $table");
    $wpdb->query("CREATE TABLE opportunities (
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
                    VALUES('Indigenous Event Labourer',
                           'Indigenous Voice',
                           'Temporary',
                           'IndigenousVoice@Gmail.com',
                           'Need a labourer assistent to help set up the stalls and tables.',
                           'Markham',
                           '8',
                           'Strength, Independence')");
    $wpdb -> query("INSERT INTO opportunities (position, organization, type, email, description, location, hours, skills) 
                    VALUES('Wellness Program Co-ordinator',
                           'Global Womenhood',
                           'Seasonal',
                           'GlobWomen@Hotmail.com',
                           'Lead classes/sessions of yoga, pilates and zumba. Massage and reiki therapists welcome.',
                           'Emmanuel House',
                           '16',
                           'Teaching, Listening, Cooperative, Sympathetic')");
    $wpdb -> query("INSERT INTO opportunities (position, organization, type, email, description, location, hours, skills) 
                    VALUES('YWCA IT Administrator',
                           'YWCA Burlington Branch',
                           'Recurring',
                           'YWCABurlington@Gmail.com',
                           'Use skills to make an impact through supporting administrative area of our organization. Resposnsibilities include: IT, Communications, and Finance.',
                           'YWCA Centre of Burlington',
                           '200',
                           'Self-reliant, Competent, Tech, Degree')");
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
                <option value="temporary">Temporary</option>
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

function volunteer_short_code(){
    global $wpdb;

    $table = 'opportunities';
    $results = $wpdb->get_results("SELECT * from $table");

    $html_table = '<table>
                   <tr>
                      <th> Position </th>
                      <th> Organization </th>
                      <th> Type </th>
                      <th> Email </th>
                      <th> Description </th>
                      <th> Location </th>
                      <th> Hours </th>
                      <th> Skills </th>';
    foreach($results as $rows){
        if($rows->hours < 10){
            $html_table .= '<tr style="background-color: green;">';
        } elseif($rows->hours >= 10 && $rows->hours < 100){
            $html_table .= '<tr style="background-color: yellow;">';
        } elseif($rows->hours > 100){
            $html_table .= '<tr style="background-color: red";>';
        } else {
            $html_table .- '<tr>';
        }
        $html_table .= '<td>'. esc_html ($rows->position) .'</td>
                        <td>'. esc_html ($rows->organization) .'</td>
                        <td>'. esc_html ($rows->type) .'</td>
                        <td>'. esc_html ($rows->email) .'</td>
                        <td>'. esc_html ($rows->description) .'</td>
                        <td>'. esc_html ($rows->location) .'</td>
                        <td>'. esc_html ($rows->hours) .'</td>
                        <td>'. esc_html ($rows->skills) .'</td>
                        </tr>';
    }
    $html_table .= '</table>';
    return $html_table;
}
add_shortcode('volunteer', 'volunteer_short_code');