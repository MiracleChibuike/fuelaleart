<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$PATCH_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// prepare product object
$blog = new blog($db);
  
// get id of blog to be edited
$data = json_decode(file_get_contents("php://input"));

// Check for valid ID
if($data->id == null || $data->id == '' || !is_numeric($data->id)){
      // set response code - 503 service unavailable
      http_response_code(403);
  
      // tell the blog
      echo json_encode(array("message" => "Please provide a valid blog ID"));

      return;
}
  
// set ID property of blog to be edited
$blog->id = $data->id;

// Get the blog whose details are to be updated 
$blog_stmt = $blog->get_blog();
    
$blog_to_update = $blog_stmt->fetch(PDO::FETCH_ASSOC);

 
// set blog property values
$blog->user_id = ($data->user_id == null || $data->user_id == "") ? $blog_to_update['user_id'] : $data->user_id;
$blog->title = ($data->title == null || $data->title == "") ? $blog_to_update['title'] : $data->title;
$blog->content = ($data->content == null || $data->content == "") ? $blog_to_update['content'] : $data->content;
$blog->image = ($data->image == null || $data->image == "") ? $blog_to_update['image'] : $data->image;
$blog->verified = ($data->verified == null || $data->verified == "") ? $blog_to_update['verified'] : $data->verified;
$blog->created_at = ($data->created_at == null || $data->created_at == "") ? $blog_to_update['created_at'] : $data->created_at;
$blog->updated_at = date("d-m-Y H:s:ia");

 
// update the blog
if($blog->update_blog()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the blog
    echo json_encode(array("message" => "blog was updated successfully."));
}
  
// if unable to update the blog, tell the blog
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the blog
    echo json_encode(array("message" => "Unable to update blog. Please try again."));
}

?>