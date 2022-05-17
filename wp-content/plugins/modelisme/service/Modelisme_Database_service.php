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

        $count_addresses = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}addresses;"); // count all existing rows and avoids to create the table each time we deactivate and activate the plugin if it already exists

        // insert the value if the table is empty
        if ( $count_addresses == 0 ) {
            $wpdb->insert( "{$wpdb->prefix}addresses", [
                 'street' => 'Rue Remparts',
                 'city' => 'Perpignan',
                 'zip_code' => '66000'
            ] );

            $wpdb->insert( "{$wpdb->prefix}addresses", [
                'street' => 'Rue Arago',
                'city' => 'Perpignan',
                'zip_code' => '66000'
           ] );
        }

        // TABLE COMPETITIONS
        $wpdb->query( "CREATE TABLE IF NOT EXISTS ". 
                            "{$wpdb->prefix}competitions ( " . 
                            "id INT AUTO_INCREMENT PRIMARY KEY, " . 
                            "name VARCHAR(255) NOT NULL, " .
                            "course_number INT(10) NOT NULL, " . 
                            "category_id INT NOT NULL " . 
                            ");"
        );

        $count_categories = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}competitions;"); // count all existing rows and avoids to create the table each time we deactivate and activate the plugin if it already exists

        // insert the value if the table is empty
        if ( $count_categories == 0 ) {
            $wpdb->insert( "{$wpdb->prefix}competitions", [
                 'name' => 'Course de modèles réduits automobiles à moteurs thermiques',
                 'course_number' => 1,
                 'category_id' => 1
            ] );
            $wpdb->insert( "{$wpdb->prefix}competitions", [
                'name' => 'Course de drones à 3 rotors',
                'course_number' => 1,
                'category_id' => 2
           ] );
           $wpdb->insert( "{$wpdb->prefix}competitions", [
            'name' => 'Course de drones à 4 rotors',
            'course_number' => 1,
            'category_id' => 2
       ] );
        }

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

        $count_clubs = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}clubs;"); // count all existing rows and avoids to create the table each time we deactivate and activate the plugin if it already exists

        // insert the value if the table is empty
        if ( $count_clubs == 0 ) {
            $wpdb->insert( "{$wpdb->prefix}clubs", [
                 'name' => 'Perpignan Moteurs Thermiques Club',
                 'email' => 'moteurs_perpi@email.fr',
                 'phone' => '0756412399',
                 'domain' => 'Course de modèles réduits automobiles à moteurs thermiques',
                 'participant' => 1,
                 'address_id' => 1

            ] );
        }

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

        $count_adherents = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}adherents;"); // count all existing rows and avoids to create the table each time we deactivate and activate the plugin if it already exists

        // insert the value if the table is empty
        if ( $count_adherents == 0 ) {
            $wpdb->insert( "{$wpdb->prefix}adherents", [
                 'last_name' => 'Miau',
                 'first_name' => 'Jean',
                 'email' => 'jean@email.fr',
                 'phone' => '0756412399',
                 'club_number' => 250,
                 'address_id' => 2,
                 'club_id' => 1,
            ] );
        }

        // TABLE POINTS
        $wpdb->query( "CREATE TABLE IF NOT EXISTS ". 
                        "{$wpdb->prefix}points ( " . 
                        "id INT AUTO_INCREMENT PRIMARY KEY, " . 
                        "point_value VARCHAR(255) NOT NULL, " .
                        "id_competition INT NOT NULL " .
                        ");"
        );

        // $count_points= $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}points;"); // count all existing rows and avoids to create the table each time we deactivate and activate the plugin if it already exists

        // // insert the value if the table is empty
        // if ( $count_points == 0 ) {
        //     $wpdb->insert( "{$wpdb->prefix}points", [
        //          'point_value' => 50,
        //          'id_competition' => '1',
        //     ] );
        // }

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

        // $count_rank= $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}ranks;"); // count all existing rows and avoids to create the table each time we deactivate and activate the plugin if it already exists

        // // insert the value if the table is empty
        // if ( $count_rank == 0 ) {
        //     $wpdb->insert( "{$wpdb->prefix}ranks", [
        //         'rank' => 50,
        //         'id_adherent' => 1,
        //         'id_competition' => 1,
        //         'id_points' => 1,
        //     ] );
        // }

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

    public function findAllClubs() {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}clubs;");

        return $result;
    }
        // method to save client
        public function save_category() {
            global $wpdb;
            // aray com recuperaçao os dados passados atraves do metodo post (do form)
            $values = [
                'name' => $_POST['name'],
            ];
    
            $row = $wpdb->get_row("SELECT id FROM {$wpdb->prefix}categories;"); // query para saber se o email ja existe
    
            if(is_null($row)) {
                $wpdb->insert("{$wpdb->prefix}categories", $values); // inserir na base de dados
            }
    
        }
    
        // delete clients from DB
        public function delete_category( $ids ) {
            global $wpdb;
    
            //
            if(!is_array($ids)) { // if the parameter is not an array
                $ids = array($ids);
            }
    
            $wpdb->query("DELETE FROM {$wpdb->prefix}categories" . "WHERE id IN (" . implode(',', $ids) . ")");
        }
    

}
