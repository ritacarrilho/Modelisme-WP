<?php
class Modelisme_Database_service
{
    public function __construct() {  }

    public static function create_db()
    {
        global $wpdb;
        
// TABLE COMPETITIONS
        $wpdb->query( "CREATE TABLE IF NOT EXISTS ". 
                            "{$wpdb->prefix}competitions ( " . 
                            "id INT AUTO_INCREMENT PRIMARY KEY, " . 
                            "name VARCHAR(255) NOT NULL, " .
                            "total_courses INT(10) NOT NULL, " . 
                            "category_id INT NOT NULL " . 
                            ");"
        );

        $count_categories = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}competitions;"); // count all existing rows and avoids to create the table each time we deactivate and activate the plugin if it already exists

        // insert the value if the table is empty
        if ( $count_categories == 0 ) {
            $wpdb->insert( "{$wpdb->prefix}competitions", [
                 'name' => 'Course de modèles réduits automobiles à moteurs thermiques',
                 'total_courses' => 10,
                 'category_id' => 1
            ] );
            
            $wpdb->insert( "{$wpdb->prefix}competitions", [
                'name' => 'Course de drones à 3 rotors',
                'total_courses' => 15,
                'category_id' => 2
           ] );

           $wpdb->insert( "{$wpdb->prefix}competitions", [
            'name' => 'Course de drones à 4 rotors',
            'total_courses' => 15,
            'category_id' => 2
            ] );
        }

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
                 'name' => 'Modélisme Automobile',
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

           $wpdb->insert( "{$wpdb->prefix}addresses", [
            'street' => 'Quoi Vouban',
            'city' => 'Montpelier',
            'zip_code' => '34000'
       ] );
        }



// TABLE CLUBS
        $wpdb->query( "CREATE TABLE IF NOT EXISTS ". 
                        "{$wpdb->prefix}clubs ( " . 
                        "id INT AUTO_INCREMENT PRIMARY KEY, " . 
                        "name VARCHAR(255) NOT NULL, " .
                        "email VARCHAR(255) NOT NULL, " .
                        "phone VARCHAR(100) NOT NULL, " .
                        "domain INT NOT NULL, " .
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
                 'domain' => 1,
                 'participant' => 1,
                 'address_id' => 1
            ] );

            $wpdb->insert( "{$wpdb->prefix}clubs", [
                'name' => 'Les Dragons',
                'email' => 'dragons@email.fr',
                'phone' => '071465398',
                'domain' => 1,
                'participant' => 1,
                'address_id' => 3
           ] );

            $wpdb->insert( "{$wpdb->prefix}clubs", [
                'name' => 'Les Catalans',
                'email' => 'catalans@email.fr',
                'phone' => '0752365412',
                'domain' => 2,
                'participant' => 0,
                'address_id' => 2
            ] );

            $wpdb->insert( "{$wpdb->prefix}clubs", [
                'name' => 'Rouge',
                'email' => 'rouge@email.fr',
                'phone' => '07523654442',
                'domain' => 2,
                'participant' => 1,
                'address_id' => 4
            ] );
        }

// TABLE MEMBERS
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
                        "point_value INT(10) NOT NULL, " .
                        "place INT NOT NULL, " .
                        "id_competition INT NOT NULL " .
                        ");"
        );

        $count_points = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}points;"); // count all existing rows and avoids to create the table each time we deactivate and activate the plugin if it already exists

        // insert the value if the table is empty
        if ( $count_points == 0 ) {
        // course de modèles réduits automobiles à moteurs
            $wpdb->insert( "{$wpdb->prefix}points", [
                 'point_value' => 8,
                 'place' => 1,
                 'id_competition' => 1,
            ]);
            
            $wpdb->insert( "{$wpdb->prefix}points", [
                'point_value' => 6,
                'place' => 2,
                'id_competition' => 1,
           ]);            
           
           $wpdb->insert( "{$wpdb->prefix}points", [
            'point_value' => 4,
            'place' => 3,
            'id_competition' => 1,
            ]);           
       
            $wpdb->insert( "{$wpdb->prefix}points", [
                'point_value' => 2,
                'place' => 4,
                'id_competition' => 1,
            ]);            
   
            $wpdb->insert( "{$wpdb->prefix}points", [
                'point_value' => 1,
                'place' => 5,
                'id_competition' => 1,
            ]);

        // course de drones à 3 rotors
            $wpdb->insert( "{$wpdb->prefix}points", [
                'point_value' => 50,
                'place' => 1,
                'id_competition' => 2,
           ]);            
           
           $wpdb->insert( "{$wpdb->prefix}points", [
            'point_value' => 25,
            'place' => 2,
            'id_competition' => 2,
            ]);           
       
            $wpdb->insert( "{$wpdb->prefix}points", [
                'point_value' => 10,
                'place' => 3,
                'id_competition' => 2,
            ]);            
   
            $wpdb->insert( "{$wpdb->prefix}points", [
                'point_value' => 5,
                'place' => 4,
                'id_competition' => 2,
            ]);

        // course de drones à 4 rotors
             $wpdb->insert( "{$wpdb->prefix}points", [
                'point_value' => 50,
                'place' => 1,
                'id_competition' => 3,
           ]);            
           
           $wpdb->insert( "{$wpdb->prefix}points", [
                'point_value' => 25,
                'place' => 2,
                'id_competition' => 3,
            ]);           
       
            $wpdb->insert( "{$wpdb->prefix}points", [
                'point_value' => 10,
                'place' => 3,
                'id_competition' => 3,
            ]);            
   
            $wpdb->insert( "{$wpdb->prefix}points", [
                'point_value' => 5,
                'place' => 4,
                'id_competition' => 3,
            ]);
        }

// TABLE RANKS
        $wpdb->query( "CREATE TABLE IF NOT EXISTS ". 
                        "{$wpdb->prefix}ranks ( " . 
                        "id INT AUTO_INCREMENT PRIMARY KEY, " . 
                        "id_club INT NOT NULL, " .
                        "id_points INT NOT NULL, " .
                        "course_nb INT NOT NULL, " .
                        "compet_date DATE NOT NULL " .
                        ");");

        $count_ranks = $wpdb->get_var("SELECT count(*) FROM {$wpdb->prefix}ranks;"); // count all existing rows and avoids to create the table each time we deactivate and activate the plugin if it already exists

        // insert the value if the table is empty
        if ( $count_ranks == 0 ) {
            $wpdb->insert( "{$wpdb->prefix}ranks", [
                 'id_club' => 1,
                 'id_points' => 1,
                 'course_nb' => 1,
                 'compet_date' => '2022-04-23'
            ]);
        }
// create foreign keys
        $wpdb->query("ALTER TABLE {$wpdb->prefix}clubs " . 
                        "ADD CONSTRAINT fk_club_address " .
                        "FOREIGN KEY (address_id) " .
                        "REFERENCES {$wpdb->prefix}addresses(id);");

        $wpdb->query("ALTER TABLE {$wpdb->prefix}clubs " . 
                        "ADD CONSTRAINT fk_club_categories " .
                        "FOREIGN KEY (domain) " .
                        "REFERENCES {$wpdb->prefix}categories(id);");

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
                        "ADD CONSTRAINT fk_club_rank " .
                        "FOREIGN KEY (id_club) " .
                        "REFERENCES {$wpdb->prefix}clubs(id);");

        $wpdb->query("ALTER TABLE {$wpdb->prefix}ranks " . 
                        "ADD CONSTRAINT fk_points_rank " .
                        "FOREIGN KEY (id_points) " .
                        "REFERENCES {$wpdb->prefix}points(id);");
    }

// EMPTY DB
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

// DROP DB
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

// FIND ALL FROM A TABLE
    public function findAll($table) {
        global $wpdb;
        $result = $wpdb->get_results(sprintf("SELECT * FROM {$wpdb->prefix}%s;", $table));

        return $result;
    }
// FIND DOMAIN OF EACH CLUB
    public function findClubDomain() {
        global $wpdb;
        $result = $wpdb->get_results("SELECT {$wpdb->prefix}clubs.*, {$wpdb->prefix}categories.name AS cat_domain FROM {$wpdb->prefix}clubs JOIN {$wpdb->prefix}categories ON {$wpdb->prefix}clubs.domain = {$wpdb->prefix}categories.id;");

        // echo '<pre>'; var_dump($result); echo '</pre>';
        return $result;
    }
    
// FIND ADDRESS
    public function findAddressPerClub($id) {
        global $wpdb;        
        // var_dump($id);
        $result = $wpdb->get_results(sprintf("SELECT {$wpdb->prefix}clubs.*, {$wpdb->prefix}addresses.city, {$wpdb->prefix}addresses.street, {$wpdb->prefix}addresses.zip_code  from {$wpdb->prefix}clubs join {$wpdb->prefix}addresses on {$wpdb->prefix}clubs.address_id = {$wpdb->prefix}addresses.id WHERE {$wpdb->prefix}clubs.id = %s;", $id));
    // var_dump($result);
        return $result[0];
    }

// FIND ONE MEMBER
    public function findMember($id) {
        global $wpdb;        
        // var_dump($id);
        $result = $wpdb->get_results(sprintf("SELECT {$wpdb->prefix}adherents.*, {$wpdb->prefix}clubs.name, {$wpdb->prefix}addresses.city, {$wpdb->prefix}addresses.street, {$wpdb->prefix}addresses.zip_code 
                                            FROM {$wpdb->prefix}adherents 
                                            JOIN {$wpdb->prefix}addresses 
                                            ON {$wpdb->prefix}adherents.address_id = {$wpdb->prefix}addresses.id 
                                            JOIN {$wpdb->prefix}clubs 
                                            ON {$wpdb->prefix}adherents.club_id = {$wpdb->prefix}clubs.id 
                                            WHERE {$wpdb->prefix}adherents.id = %s ;", $id));
    // var_dump($result);
        return $result[0];
    }

// FIND ALL MEMBERS
    public function findMembers() {
        global $wpdb;        
        // var_dump($id);
        $result = $wpdb->get_results("SELECT {$wpdb->prefix}adherents.*, {$wpdb->prefix}clubs.name, {$wpdb->prefix}addresses.city, {$wpdb->prefix}addresses.street, {$wpdb->prefix}addresses.zip_code 
                                            FROM {$wpdb->prefix}adherents 
                                            JOIN {$wpdb->prefix}addresses 
                                            ON {$wpdb->prefix}adherents.address_id = {$wpdb->prefix}addresses.id 
                                            JOIN {$wpdb->prefix}clubs 
                                            ON {$wpdb->prefix}adherents.club_id = {$wpdb->prefix}clubs.id;");
    // echo '<pre>'; var_dump($result);
        return $result;
    }

// FIND ALL COMPETITIONS
    public function findCompetitions() {
        global $wpdb;        
        // var_dump($id);
        $result = $wpdb->get_results("SELECT {$wpdb->prefix}competitions.*, {$wpdb->prefix}categories.id as category_id, {$wpdb->prefix}categories.name as category_name 
                                            FROM {$wpdb->prefix}competitions 
                                            JOIN {$wpdb->prefix}categories 
                                            ON {$wpdb->prefix}competitions.category_id = {$wpdb->prefix}categories.id 
                                    ;");

    // echo '<pre>'; var_dump($result); echo '</pre>';
        return $result;
    }

// FIND ALL POINTS
public function findPoints() {
    global $wpdb;        
    // var_dump($id);
    $result = $wpdb->get_results("SELECT {$wpdb->prefix}points.*, {$wpdb->prefix}competitions.name as competition
                                        FROM {$wpdb->prefix}points 
                                        JOIN {$wpdb->prefix}competitions
                                        ON {$wpdb->prefix}points.id_competition = {$wpdb->prefix}competitions.id 
                                ;");

// echo '<pre>'; var_dump($result); echo '</pre>';
    return $result;
}

// FIND ALL Points
public function findRank() {
    global $wpdb;        
    // var_dump($id);
    $result = $wpdb->get_results("SELECT {$wpdb->prefix}ranks.*, {$wpdb->prefix}points.*, {$wpdb->prefix}clubs.name as club_name, {$wpdb->prefix}competitions.name as competition_name
                                        FROM {$wpdb->prefix}ranks 
                                        JOIN {$wpdb->prefix}clubs
                                        ON {$wpdb->prefix}ranks.id_club = {$wpdb->prefix}clubs.id
                                        JOIN {$wpdb->prefix}points
                                        ON {$wpdb->prefix}ranks.id_points = {$wpdb->prefix}points.id  
                                        JOIN {$wpdb->prefix}competitions
                                        ON {$wpdb->prefix}points.id_competition = {$wpdb->prefix}competitions.id
                                ;");

// echo '<pre>'; var_dump($result); echo '</pre>';
    return $result;
}

public function findPointsCompetitions() {
    global $wpdb;        
    // var_dump($id);
    $result = $wpdb->get_results("SELECT {$wpdb->prefix}points.*, {$wpdb->prefix}points.id as points_id, {$wpdb->prefix}competitions.* 
                                    FROM {$wpdb->prefix}points 
                                    JOIN {$wpdb->prefix}competitions 
                                    ON {$wpdb->prefix}points.id_competition = {$wpdb->prefix}competitions.id
                                    -- WHERE {$wpdb->prefix}competitions.id = %s
                                ;");

// echo '<pre>'; var_dump($result); echo '</pre>';
    return $result;
}

// SAVE CLUB IN TABLE
    public function save_club() {
        global $wpdb;

        $address_id = $this->save_address();

    //  recover data from method post 
        $values = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'domain' => intval($_POST['domain']),
            'participant' => filter_var(intval($_POST['participant']), FILTER_VALIDATE_BOOLEAN),
            'address_id' => intval($address_id)
        ];

        // var_dump($values);
        $row = $wpdb->get_row("SELECT id FROM {$wpdb->prefix}clubs WHERE email=" . $values['email'].";");
    
        if(is_null($row)) {
            $wpdb->insert("{$wpdb->prefix}clubs", $values);
        }
    }
    
//SAVE ADDRESS IN TABLE
    public function save_address() {
        global $wpdb;
    
        $values = [
            'street' => $_POST['street'],
            'city' => $_POST['city'],
            'zip_code' => $_POST['zip_code'],
        ];

        $row = $wpdb->get_row("SELECT id FROM {$wpdb->prefix}addresses WHERE street=" . $values['street']. " city=" . $values['street']. " zip-code=". $values['zip_code'].";");
    
        if(empty($row)) {
            $wpdb->insert("{$wpdb->prefix}addresses", $values);
            return $wpdb->insert_id;
        }
            // var_dump($row);
        return $row->id;
    }

// DELETE ROW FROM TABLE
    public function delete_row($table, $ids) {
        global $wpdb;

        if(!is_array($ids)) {
            $ids = array($ids);
        }
    
        $wpdb->query("DELETE FROM {$wpdb->prefix}$table " .
                    "WHERE id IN ( " . implode(',', $ids) . 
                    ")");
    }

// SAVE NEW MEMBER
    public function save_member() {
        global $wpdb;

        $address_id = $this->save_address();

        //  recover data from method post 
        $values = [
            'last_name' => $_POST['last_name'],
            'first_name' => $_POST['first_name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'club_number' => $_POST['club_number'],
            'address_id' => intval($address_id),
            'club_id' => $_POST['name'],
        ];

        // var_dump($values);
        $row = $wpdb->get_row("SELECT id FROM {$wpdb->prefix}adherents WHERE email=" . $values['email'].";");
    
        if(is_null($row)) {
            $wpdb->insert("{$wpdb->prefix}adherents", $values);
        }
    }
   
// SAVE CATEGORY 
    public function save_category() {
        global $wpdb;

        $values = [
            'name' => $_POST['name'],
        ];

        // var_dump($values);
        $row = $wpdb->get_row("SELECT id FROM {$wpdb->prefix}categories WHERE name=" . $values['name'].";");

        if(is_null($row)) {
            $wpdb->insert("{$wpdb->prefix}categories", $values);
        }
    }

// SAVE COMPETITION
    public function save_competition() {
        global $wpdb;

        //  recover data from method post 
        $values = [
            'name' => $_POST['competition_name'],
            'total_courses' => $_POST['total_courses'],
            'category_id' => $_POST['category_id'],
        ];

        // $row = $wpdb->get_row("SELECT id FROM {$wpdb->prefix}categories WHERE category_name=" . $values['category_name'] . ";");

        // if(is_null($row)) {
            $wpdb->insert("{$wpdb->prefix}competitions", $values);
        // }
    }

// SAVE RANK
    public function save_rank() {
        global $wpdb;

        //  recover data from method post 
        $values = [
            'id_club' => $_POST['id_club'],
            'id_points' => $_POST['id_points'],
            'course_nb' => $_POST['course_nb'],
            'compet_date' => $_POST['compet_date']
        ];

         $wpdb->insert("{$wpdb->prefix}ranks", $values);
    }

// SAVE POINTS 
    public function save_points() {
        global $wpdb;

    //  recover data from method post 
        $values = [
            'point_value' => $_POST['point_value'],
            'place' => $_POST['place'],
            'id_competition' => $_POST['id_competition'],
        ];
        // echo '<pre>'; var_dump($values);


        $wpdb->insert("{$wpdb->prefix}points", $values);
    }
}
