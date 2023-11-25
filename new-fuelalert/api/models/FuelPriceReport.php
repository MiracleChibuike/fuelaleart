<?php
class FuelPriceReport
{

    // database connection and table user_id
    private $conn;
    private $table_name = "fuel_price_reports";

    // object properties
    public $id;
    public $user_id;
    public $station_id;
    public $fuel_price;
    public $created_at;
    public $updated_at;
    public $verified;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
      
    }


    // read a single fuel_price_report
    function get_fuel_price_report()
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE id=" . $this->id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // read fuel_price_reports
    function get_fuel_price_reports()
    {

        // // select all query
        // $query = "SELECT * FROM " . $this->table_name;

        // // prepare query statement
        // $stmt = $this->conn->prepare($query);

        // // execute query
        // $stmt->execute();

        // return $stmt;

        // select all query
        $query = "SELECT fuel_price_reports.fuel_price, filling_stations.name, filling_stations.address, filling_stations.area, filling_stations.state FROM filling_stations Left JOIN fuel_price_reports ON fuel_price_reports.station_id=filling_stations.id ORDER BY fuel_price";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    // create a fuel_price_report
    function create_fuel_price_report()
    {
        $this->created_at = date("d-m-Y H:s:ia");
        $this->updated_at = date("d-m-Y H:s:ia");
        $this->verified = 0;
        
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (user_id, station_id, fuel_price, created_at, updated_at, verified) VALUES (:user_id, :station_id, :fuel_price, :created_at, :updated_at, :verified) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":station_id", $this->station_id);
        $stmt->bindParam(":fuel_price", $this->fuel_price);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":updated_at", $this->updated_at);
        $stmt->bindParam(":verified", $this->verified);



        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // update a filling station
    function update_fuel_price_report()
    {

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                    user_id = :user_id,
                    station_id = :station_id,
                    fuel_price = :fuel_price,
                    verified = :verified,
                    created_at = :created_at,
                    updated_at = :updated_at
                WHERE
                    id = :id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);


        // Set and sanitize
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->station_id = htmlspecialchars(strip_tags($this->station_id));
        $this->fuel_price = htmlspecialchars(strip_tags($this->fuel_price));
        $this->created_at = date('d-m-Y H:s:ia');
        $this->updated_at = date('d-m-Y H:s:ia');
        $this->verified = htmlspecialchars(strip_tags($this->verified));



        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $update_stmt->bindParam(':user_id', $this->user_id);
        $update_stmt->bindParam(':station_id', $this->station_id);
        $update_stmt->bindParam(':fuel_price', $this->fuel_price);
        $update_stmt->bindParam(':created_at', $this->created_at);
        $update_stmt->bindParam(':updated_at', $this->updated_at);
        $update_stmt->bindParam(':verified', $this->verified);


        $update_stmt->bindParam(':id', $this->id);

        // execute the query
        if ($update_stmt->execute()) {
            return true;
        }

        return false;
    }

    // delete a fuel_price_report
    function delete_fuel_price_report()
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

    // Verify Fuel Price report by admin
    public function verify_fuel_price_report()
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

        // Unverify Fuel Price report by admin
        public function unverify_fuel_price_report()
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
