<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$POST_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);

$blog = new blog($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->user_id) &&
    !empty($data->title) &&
    !empty($data->content) &&
    !empty($data->image)
){
  
    // Sanitize & set blog property values
    $blog->user_id = htmlspecialchars(strip_tags($data->user_id));
    $blog->title = htmlspecialchars(strip_tags($data->title));
    $blog->content = htmlspecialchars(strip_tags($data->content));
    $blog->image = htmlspecialchars(strip_tags($data->image));
    $blog->verified = 0;
    $blog->created_at = date("d-m-Y H:s:ia");
    $blog->updated_at = date("d-m-Y H:s:ia");

    // print_r($blog->created_at);
    // return;
  
    // create the blog
    if($blog->create_blog()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the blog
        echo json_encode(array("message" => "blog was created successfully."));

    }
    else{

        // if unable to create the blog, tell the blog
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the blog
        echo json_encode(array("message" => "Unable to create blog."));

    }

}
else{

    // tell the blog data is incomplete
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the blog
    echo json_encode(array("message" => "Unable to create blog. Data is incomplete."));

}

