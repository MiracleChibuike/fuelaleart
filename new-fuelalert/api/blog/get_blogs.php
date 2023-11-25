<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
  
// initialize object
$blog = new Blog($db);
  
// read blogs will be here
// query blogs
$stmt = $blog->get_blogs();
    
if($stmt){

  
    // blogs array
    $blogs_arr=array();
    $blogs_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $blog_item=array(
            "id" => $id,
            "user_id" => $user_id,
            "title" => $title,
            "content" => $content,
            "image" => $image,
            "verified" => $verified,
            "created_at" => $created_at,
            "updated_at" => $updated_at,
        );
  
        array_push($blogs_arr["records"], $blog_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show blogs data in json format
    echo json_encode($blogs_arr);
}
else{
    // no blogs found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the blog no products found
    echo json_encode(
        array("message" => "No blogs found.")
    );
}
  

