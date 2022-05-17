<?php
class Modelisme_Database_service
{
    public function __construct() {  }

    public static function create_db()
    {
        global $wpdb;

        // TABLE CATEGORIES
        // database creation request execution
        $wpdb->query("CREATE TABLE IF NOT EXISTS " . 
                    "{$wpdb->prefix}categories ( " . 
                    "id INT AUTO_INCREMENT PRIMARY KEY, " . 
                    "name VARCHAR(150) NOT NULL " . 
                    ");"
        );

        $count_categories = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}categories;"); // count all existing rows and avoids to create the table each time we deactivate and activate the plugin if it already exists

        // insert the value if the table is empty
        if ( $count_categories == 0 ) {
            $wpdb->insert( "{$wpdb->prefix}categories", [
                 'name' => 'Course d’automobiles radio commandées',
            ] );
            $wpdb->insert( "{$wpdb->prefix}categories", [
                 'name' => 'Modélisme Aérien'
            ] );
            $wpdb->insert( "{$wpdb->prefix}categories", [
                 'name' => 'Modélisme Naval',
            ] );
        }

        // TABLE ADDRESSES
        $wpdb->query("CREATE TABLE IF NOT EXISTS " .   
                        "{$wpdb->prefix}addresses ( ". 
                        "id INT AUTO_INCREMENT PRIMARY KEY, " .
                        "street VARCHAR(255) NOT NULL, " . 
                        "city VARCHAR(150) NOT NULL, " . 
                        "zip_code VARCHAR(150) NOT NULL " .
                        ");"
        );

        // TABLE COMPETITIONS
        $wpdb->query( "CREATE TABLE IF NOT EXISTS ". 
                            "{$wpdb->prefix}competitions ( " . 
                            "id INT AUTO_INCREMENT PRIMARY KEY, " . 
                            "name VARCHAR(255) NOT NULL, " .
                            "course_number INT(10) NOT NULL, " . 
                            "category_id INT NOT NULL " . 
                            ");"
        );

        // TABLE CLUBS
        $wpdb->query( "CREATE TABLE IF NOT EXISTS ". 
                        "{$wpdb->prefix}clubs ( " . 
                        "id INT AUTO_INCREMENT PRIMARY KEY, " . 
                        "name VARCHAR(255) NOT NULL, " .
                        "email VARCHAR(255) NOT NULL, " .
                        "phone VARCHAR(100) NOT NULL, " .
                        "domain VARCHAR(150) NOT NULL, " .
                        "participant BOOLEAN NOT NULL, " . 
                        "address_id INT NOT NULL " . 
                        ");"
        );

        // TABLE ADHERENTS
        $wpdb->query( "CREATE TABLE IF NOT EXISTS ". 
                        "{$wpdb->prefix}adherents ( " . 
                        "id INT AUTO_INCREMENT PRIMARY KEY, " . 
                        "last_name VARCHAR(255) NOT NULL, " .
                        "first_name VARCHAR(255) NOT NULL, " .
                        "email VARCHAR(255) NOT NULL, " .
                        "phone VARCHAR(100) NOT NULL, " .
                        "club_number INT(15) NOT NULL, " .
                        "address_id INT NOT NULL, " .
                        "club_id INT NOT NULL " .
                        ");"
        );

        // TABLE POINTS
        $wpdb->query( "CREATE TABLE IF NOT EXISTS ". 
                        "{$wpdb->prefix}points ( " . 
                        "id INT AUTO_INCREMENT PRIMARY KEY, " . 
                        "point_value VARCHAR(255) NOT NULL, " .
                        "id_competition INT NOT NULL " .
                        ");"
        );

        // TABLE RANKS
        $wpdb->query( "CREATE TABLE IF NOT EXISTS ". 
                        "{$wpdb->prefix}ranks ( " . 
                        "id INT AUTO_INCREMENT PRIMARY KEY, " . 
                        "rank INT(10) NOT NULL, " .
                        "id_adherent INT NOT NULL, " .
                        "id_competition INT NOT NULL, " .
                        "id_points INT NOT NULL " .
                        ");"
        );

        // create foreign keys
        $wpdb->query("ALTER TABLE {$wpdb->prefix}clubs " . 
                        "ADD CONSTRAINT fk_club_address " .
                        "FOREIGN KEY (address_id) " .
                        "REFERENCES {$wpdb->prefix}addresses(id);");

        $wpdb->query("ALTER TABLE {$wpdb->prefix}adherents " . 
                        "ADD CONSTRAINT fk_adherents_address " .
                        "FOREIGN KEY (address_id) " .
                        "REFERENCES {$wpdb->prefix}addresses(id);");

        $wpdb->query("ALTER TABLE {$wpdb->prefix}adherents " . 
                        "ADD CONSTRAINT fk_ahderent_club " .
                        "FOREIGN KEY (club_id) " .
                        "REFERENCES {$wpdb->prefix}clubs(id);");

        $wpdb->query("ALTER TABLE {$wpdb->prefix}competitions " . 
                        "ADD CONSTRAINT fk_competition_category " .
                        "FOREIGN KEY (category_id) " .
                        "REFERENCES {$wpdb->prefix}categories(id);");

        $wpdb->query("ALTER TABLE {$wpdb->prefix}points " . 
                        "ADD CONSTRAINT fk_competition_points " .
                        "FOREIGN KEY (id_competition) " .
                        "REFERENCES {$wpdb->prefix}competitions(id);");
                        
        $wpdb->query("ALTER TABLE {$wpdb->prefix}ranks " . 
                        "ADD CONSTRAINT fk_adherent_rank " .
                        "FOREIGN KEY (id_adherent) " .
                        "REFERENCES {$wpdb->prefix}adherents(id);");

        $wpdb->query("ALTER TABLE {$wpdb->prefix}ranks " . 
                        "ADD CONSTRAINT fk_competition_rank " .
                        "FOREIGN KEY (id_competition) " .
                        "REFERENCES {$wpdb->prefix}competitions(id);");

        $wpdb->query("ALTER TABLE {$wpdb->prefix}ranks " . 
                        "ADD CONSTRAINT fk_rank_points " .
                        "FOREIGN KEY (id_points) " .
                        "REFERENCES {$wpdb->prefix}points(id);");
    }

    public static function empty_db() {
        global $wpdb;

        $wpdb->query("SET FOREIGN_KEY_CHECKS = 0;");
        $wpdb->query("TRUNCATE clubs;");
        $wpdb->query("TRUNCATE categories;");
        $wpdb->query("TRUNCATE addresses;");
        $wpdb->query("TRUNCATE adherents;");
        $wpdb->query("TRUNCATE competitions;");
        $wpdb->query("TRUNCATE points;");
        $wpdb->query("TRUNCATE ranks;");
        $wpdb->query("SET FOREIGN_KEY_CHECKS = 1;");
    }

    public static function drop_db() {
        global $wpdb;
        $wpdb->query("SET FOREIGN_KEY_CHECKS = 0;");
        $wpdb->query("DROP TABLE {$wpdb->prefix}clubs;");
        $wpdb->query("DROP TABLE {$wpdb->prefix}categories;");
        $wpdb->query("DROP TABLE {$wpdb->prefix}addresses;");
        $wpdb->query("DROP TABLE {$wpdb->prefix}adherents;");
        $wpdb->query("DROP TABLE {$wpdb->prefix}competitions;");
        $wpdb->query("DROP TABLE {$wpdb->prefix}points;");
        $wpdb->query("DROP TABLE {$wpdb->prefix}ranks;");
        $wpdb->query("SET FOREIGN_KEY_CHECKS = 1;");
    }

    public function findAll() {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}categories;");

        return $result;
    }

}
