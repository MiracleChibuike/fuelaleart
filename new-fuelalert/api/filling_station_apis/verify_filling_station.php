<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$PUT_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// prepare filling_station object
$filling_station = new FillingStation($db);
  
// get filling_station id
$data = json_decode(file_get_contents("php://input"));
  
// set filling_station id to be deleted
$filling_station->id = htmlspecialchars(strip_tags($data->id));

// Check if filling_station_id provided is valid
if($filling_station->id == null || !is_numeric($filling_station->id)){
    // No valid filling_station id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the filling_station no products found
    echo json_encode(
        array("message" => "Plaese provide a valid filling_station ID")
    );

    return;
}

// Check if filling_station exists
$filling_station_verified = $filling_station->Verify_filling_station();

if(!$filling_station_verified){
    // No valid filling_station id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the filling_station no products found
    echo json_encode(
        array("message" => "filling_station with ID:$filling_station->id was not verified. Try again")
    );

    return;
}
else{
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the filling_station
    echo json_encode(array("message" => "filling_station verified successfully."));
}

?>