<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$PUT_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// prepare blog object
$blog = new Blog($db);
  
// get blog id
$data = json_decode(file_get_contents("php://input"));
  
// set blog id to be deleted
$blog->id = htmlspecialchars(strip_tags($data->id));

// Check if blog_id provided is valid
if($blog->id == null || !is_numeric($blog->id)){
    // No valid blog id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the blog no products found
    echo json_encode(
        array("message" => "Plaese provide a valid blog ID")
    );

    return;
}

// Check if blog exists
$blog_verified = $blog->verify_blog();

if(!$blog_verified){
    // No valid blog id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the blog no products found
    echo json_encode(
        array("message" => "blog with ID:$blog->id was not verified. Try again")
    );

    return;
}
else{
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the blog
    echo json_encode(array("message" => "blog verified successfully."));
}

?>