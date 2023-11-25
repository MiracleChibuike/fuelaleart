<?php
class Blog
{

    // database connection and table user_id
    private $conn;
    private $table_name = "blogs";

    // object properties
    public $id;
    public $user_id;
    public $title;
    public $content;
    public $image;
    public $verified;
    public $created_at;
    public $updated_at;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    // read a single blog
    function get_blog()
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE id=" . $this->id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // read blogs
    function get_blogs()
    {

        // select all query
        $query = "SELECT * FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    // create a blog
    function create_blog()
    {

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " (user_id, title, content, image, verified, created_at, updated_at) VALUES (:user_id, :title, :content, :image, :verified, :created_at, :updated_at) ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":verified", $this->verified);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":updated_at", $this->updated_at);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // update a filling station
    function update_blog()
    {

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                    user_id = :user_id,
                    title = :title,
                    content = :content,
                    image = :image,
                    verified = :verified,
                    created_at = :created_at,
                    updated_at = :updated_at
                WHERE
                    id = :id";

        // prepare query statement
        $update_stmt = $this->conn->prepare($query);


        // Set and sanitize
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->verified = htmlspecialchars(strip_tags($this->verified));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));
        $this->updated_at = date('d-m-Y H:s:ia');


        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $update_stmt->bindParam(':user_id', $this->user_id);
        $update_stmt->bindParam(':title', $this->title);
        $update_stmt->bindParam(':content', $this->content);
        $update_stmt->bindParam(':image', $this->image);
        $update_stmt->bindParam(':verified', $this->verified);
        $update_stmt->bindParam(':created_at', $this->created_at);
        $update_stmt->bindParam(':updated_at', $this->updated_at);


        $update_stmt->bindParam(':id', $this->id);

        // execute the query
        if ($update_stmt->execute()) {
            return true;
        }

        return false;
    }

    // delete a blog
    function delete_blog()
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
    public function verify_blog()
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

    // Email verification handler
    public function unverify_blog()
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
