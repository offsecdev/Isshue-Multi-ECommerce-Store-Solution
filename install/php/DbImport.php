<?php
namespace Php;
require_once __DIR__.'/Helper.php'; //Include helper

class DbImport 
{ 
    private $table_name = 'user_login';      //Login Table Name
    private $table_fields = array('username', 'password', 'user_id','store_id','user_type','security_code', 'status'); // Table Field Names
    private $field_values = array('{input}', '{input}',1,1,1, 1, 1); // Table Field Values


    /* 
    Intruction : 
    ============
    IF YOU HAVE MORE COLUMNS,ADD THE FILED IT IN $table_fields AND THE VALUE IN $field_values BY THE SEQUENCE OF FIELDS.e.g. 
    
    private $table_fields = array('username', 'password', 'user_type', 'status'); 
    private $field_values = array('{input}', '{input}', 1, 1); 

    */
    // Function to the database and tables and fill them with the default data
    function createDatabase($data = [])
    {
        $hostname = filterInput($data['hostname']);
        $username = filterInput($data['username']);
        $password = filterInput($data['password']);
        $database = filterInput($data['database']);

        // Connect to the database
        @$mysqli = new \mysqli($hostname, $username, $password, '');

        // Check for errors
        if (mysqli_connect_errno()){
            return false;
        }
        $database = $mysqli->real_escape_string($database);
        // Create the prepared statement
        $createDb = $mysqli->query("CREATE DATABASE IF NOT EXISTS ".$database);

        // Close the connection
        $mysqli->close();

        if($createDb) {
            return true;
        } else {
            return false;
        }
    }

    // Function to create the tables and fill them with the default data
    function createTables($data = [])
    {
        $hostname = filterInput($data['hostname']);
        $username = filterInput($data['username']);
        $password = filterInput($data['password']);
        $database = filterInput($data['database']);

        // Connect to the database
        @$mysqli = new \mysqli(
            $hostname,
            $username,
            $password,
            $database
        );

        // Check for errors
        if (mysqli_connect_errno())
            return false;

        // Open the default SQL file
        $query = file_get_contents('sql/install.sql');

        // Execute a multi query
        $multi_query = $mysqli->multi_query($query);

        // Close the connection
        $mysqli->close();

         // Store Database information into session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['hostname'] = $hostname;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['database'] = $database;

        if ($multi_query){
            return true;
        } else {
            return false;
        }
    }

    // Insert Login info
    function insert_login($data = [])
    {

        $email = filterInput($data['email']);
        $password = filterInput($data['password']);


        // Connect to the database
        @$mysqli = new \mysqli(
            $_SESSION['hostname'],
            $_SESSION['username'],
            $_SESSION['password'],
            $_SESSION['database']
        );

        // Check for errors
        if (mysqli_connect_errno())
            return false;

        $email = $mysqli->real_escape_string($email);
        $password = $mysqli->real_escape_string($password);
        $password = md5('gef'.$password);

        $fields_num = count($this->table_fields);
        $fields = '';
        $values = '';
        for($i=0; $i<$fields_num; $i++){

            $fields .= "`".$this->table_fields[$i]."`,"; // set field values

            if($i==0){

                $values .= "'".$email."',"; // Set Email values

            }else if($i==1){

                 $values .= "'".$password."',"; // Set Password Values

            }else{

                 $values .= ((gettype($this->field_values[$i])=='integer')?$this->field_values[$i]:"'".$this->field_values[$i]."'").",";

            }
        }

         // Make Query
        $query = "INSERT INTO `$this->table_name` (".rtrim($fields,',').") VALUES (".rtrim($values,',').")"; //user login table data store

        $query2 = 'INSERT INTO `users` (`user_id`, `last_name`, `first_name`, `gender`, `date_of_birth`, `logo`, `status`) VALUES ("1", "Admin", "Super", "1", "", NULL, "1")';// users table data store
        

        // Run Query
        $insert_query = $mysqli->query($query);
        $insert_query2 = $mysqli->query($query2);

        // Close the connection
        $mysqli->close();

        if ($insert_query){
            return true;
        } else {
            return false;
        }
    }

}
    