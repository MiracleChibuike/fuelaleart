<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$POST_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);

$filling_station = new FillingStation($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->user_id) &&
    !empty($data->name) &&
    !empty($data->address) &&
    !empty($data->area) &&
    !empty($data->city) &&
    !empty($data->state) &&
    !empty($data->country)
){
  
    // Sanitize & set filling_station property values
    $filling_station->user_id = htmlspecialchars(strip_tags($data->user_id));
    $filling_station->name = htmlspecialchars(strip_tags($data->name));
    $filling_station->address = htmlspecialchars(strip_tags($data->address));
    $filling_station->area = htmlspecialchars(strip_tags($data->area));
    $filling_station->city = htmlspecialchars(strip_tags($data->city));
    $filling_station->state = htmlspecialchars(strip_tags($data->state));
    $filling_station->country = htmlspecialchars(strip_tags($data->country));


    // print_r($filling_station->created_at);
    // return;
  
    // create the filling_station
    if($filling_station->create_filling_station()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the filling_station
        echo json_encode(array("message" => "filling_station was created successfully."));

    }
    else{

        // if unable to create the filling_station, tell the filling_station
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the filling_station
        echo json_encode(array("message" => "Unable to create filling_station."));

    }

}
else{

    // tell the filling_station data is incomplete
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the filling_station
    echo json_encode(array("message" => "Unable to create filling_station. Data is incomplete."));

}

