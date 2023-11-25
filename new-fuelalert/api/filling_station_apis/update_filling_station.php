<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$PATCH_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// prepare product object
$filling_station = new FillingStation($db);
  
// get id of filling_station to be edited
$data = json_decode(file_get_contents("php://input"));

// Check for valid ID
if($data->id == null || $data->id == '' || !is_numeric($data->id)){
      // set response code - 503 service unavailable
      http_response_code(403);
  
      // tell the filling_station
      echo json_encode(array("message" => "Please provide a valid filling_station ID"));

      return;
}
  
// set ID property of filling_station to be edited
$filling_station->id = htmlspecialchars(strip_tags($data->id));

// Get the filling_station whose details are to be updated 
$filling_station_stmt = $filling_station->get_filling_station();
    
$filling_station_to_update = $filling_station_stmt->fetch(PDO::FETCH_ASSOC);

 
// set filling_station property values
$filling_station->user_id = ($data->user_id == null || $data->user_id == "") ? $filling_station_to_update['user_id'] : $data->user_id;
$filling_station->name = ($data->name == null || $data->name == "") ? $filling_station_to_update['name'] : $data->name;
$filling_station->address = ($data->address == null || $data->address == "") ? $filling_station_to_update['address'] : $data->address;
$filling_station->area = ($data->area == null || $data->area == "") ? $filling_station_to_update['area'] : $data->area;
$filling_station->city = ($data->city == null || $data->city == "") ? $filling_station_to_update['city'] : $data->city;
$filling_station->state = ($data->state == null || $data->state == "") ? $filling_station_to_update['state'] : $data->state;
$filling_station->country = ($data->country == null || $data->country == "") ? $filling_station_to_update['country'] : $data->country;
$filling_station->verified = ($data->verified == null || $data->verified == "") ? $filling_station_to_update['verified'] : $data->verified;
$filling_station->active = ($data->active == null || $data->active == "") ? $filling_station_to_update['active'] : $data->active;
$filling_station->created_at = ($data->created_at == null || $data->created_at == "") ? $filling_station_to_update['created_at'] : $data->created_at;
$filling_station->updated_at = date("d-m-Y H:s:ia");

 
// update the filling_station
if($filling_station->update_filling_station()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the filling_station
    echo json_encode(array("message" => "filling_station was updated successfully."));
}
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the filling_station
    echo json_encode(array("message" => "Unable to update filling_station. Please try again."));
}

?>