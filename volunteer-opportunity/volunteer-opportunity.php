<?php
/**
 * Plugin Name: Volunteer Opportunity
 * Description: Assignment Plugin for Wordpress
 * Author: Jesung Hwang
 */

function myPlugin_Activate(){
    global $wpdb;
    $wpdb -> query("CREATE TABLE opportunities (
    id INT AUTO_INCREMENT,
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