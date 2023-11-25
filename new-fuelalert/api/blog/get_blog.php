<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// initialize object
$blog = new blog($db);
  
// read blog id will be here
$blog_id = $_GET['blog_id'] ?? null;

if($blog_id == null || !is_numeric($blog_id)){
    // No valid blog id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the blog no products found
    echo json_encode(
        array("message" => "Plaese provide a valid blog ID")
    );

    return;
}

// query blogs
$blog->id = $blog_id;
$stmt = $blog->get_blog();
// $num = $stmt->rowCount();
  
// check if more than 0 record found
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
//  print_r(count($blogs_arr['records']));
//   return;
    if(count($blogs_arr['records']) == 0){
        // set response code - 200 OK
        http_response_code(200);
    
        // show blogs data in json format
        echo json_encode(array("message" => "No blog found with this ID."));

        return;
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
        array("message" => "Something went wrong. Not able to fetch blog.")
    );
}
  
