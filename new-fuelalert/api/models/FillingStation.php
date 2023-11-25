<?php
class FillingStation
{

    // database connection and table name
    private $conn;
    private $table_name = "filling_stations";

    // object properties
    public $id;
    public $user_id;
    public $name;
    public $address;
    public $area;
    public $city;
    public $state;
    public $verified;
    public $active;
    public $country;
    public $created_at;
    public $updated_at;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    // read a single filling_station
    function get_filling_station()
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE id=" . $this->id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // read filling_stations
    function get_filling_stations()
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    // create a filling_station
    function create_filling_station()
    {
        $this->verified = 0;
        $this->active = 0;
        $this->created_at = date("d-m-Y H:s:ia");
        $this->updated_at = date("d-m-Y H:s:ia");

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (user_id, name, address, area, city, state, verified, created_at, updated_at, active, country) VALUES (:user_id, :name, :address, :area, :city, :state, :verified, :created_at, :updated_at, :active, :country) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":area", $this->area);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":verified", $this->verified);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":updated_at", $this->updated_at);
        $stmt->bindParam(":active", $this->active);
        $stmt->bindParam(":country", $this->country);



        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // update a filling station
    function update_filling_station()
    {

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                    user_id = :user_id,
                    name = :name,
                    address = :address,
                    area = :area,
                    city = :city,
                    state = :state,
                    country = :country,
                    verified = :verified,
                    active = :active,
                    created_at = :created_at,
                    updated_at = :updated_at
                WHERE
                    id = :id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);


        // Set and sanitize
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->area = htmlspecialchars(strip_tags($this->area));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));
        $this->country = htmlspecialchars(strip_tags($this->country));
        $this->verified = htmlspecialchars(strip_tags($this->verified));
        $this->active = htmlspecialchars(strip_tags($this->active));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));
        $this->updated_at = date('d-m-Y H:s:ia');
       

        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $update_stmt->bindParam(':user_id', $this->user_id);
        $update_stmt->bindParam(':name', $this->name);
        $update_stmt->bindParam(':address', $this->address);
        $update_stmt->bindParam(':area', $this->area);
        $update_stmt->bindParam(':city', $this->city);
        $update_stmt->bindParam(':state', $this->state);
        $update_stmt->bindParam(':country', $this->country);
        $update_stmt->bindParam(':verified', $this->verified);
        $update_stmt->bindParam(':active', $this->active);
        $update_stmt->bindParam(':created_at', $this->created_at);
        $update_stmt->bindParam(':updated_at', $this->updated_at);

        $update_stmt->bindParam(':id', $this->id);

        // execute the query
        if ($update_stmt->execute()) {
            return true;
        }

        return false;
    }

    // delete a filling_station
    function delete_filling_station()
    {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Email verification handler
    public function verify_filling_station()
    {

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                    verified = 1
                WHERE
                    id = :id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);


        // Set and sanitize
        $this->verified = htmlspecialchars(strip_tags($this->verified));

        // bind new values
        $update_stmt->bindParam(':id', $this->id);

        // execute the query
        if ($update_stmt->execute()) {
            return true;
        }

        return false;
    }

       // Unverify filling station
       public function unverify_filling_station()
       {
   
           // update query
           $query = "UPDATE " . $this->table_name . " SET
                       verified = 0
                   WHERE
                       id = :id";
   
           // prepare query statement
           $update_stmt = $this->conn->prepare($query);
   
   
           // Set and sanitize
           $this->verified = htmlspecialchars(strip_tags($this->verified));
   
           // bind new values
           $update_stmt->bindParam(':id', $this->id);
   
           // execute the query
           if ($update_stmt->execute()) {
               return true;
           }
   
           return false;
       }

}
