<?php
class Modelisme_Database_service
{
    public function __construct() {  }

    public function create_db()
    {
        global $wpdb;

        // table creation request
        $req = "CREATE TABLE IF NOT EXISTS" . 
                "{$wpdb->prefix}categories(" .
                "id INT AUTO_INCREMENT PRIMARY KEY, ".
                "name VARCHAR(150) NOT NULL ".
                ");";

        // database creation request execution
        $wpdb->query($req);

        $count = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}categories;"); // count all existing rows and avoids to create the table each time we deactivate and activate the plugin if it already exists

        // insert the value if the table is empty
        if($count) {
            $wpdb->insert("{$wpdb->prefix}categories", [
                'name' => 'Course d’automobiles radio commandées'
            ]);
        }
    }
}

