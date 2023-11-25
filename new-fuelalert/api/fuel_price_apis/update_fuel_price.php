<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$PATCH_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// prepare product object
$fuel_price = new FuelPriceReport($db);
  
// get id of fuel_price to be edited
$data = json_decode(file_get_contents("php://input"));

// Check for valid ID
if($data->id == null || $data->id == '' || !is_numeric($data->id)){
      // set response code - 503 service unavailable
      http_response_code(403);
  
      // tell the fuel_price
      echo json_encode(array("message" => "Please provide a valid fuel_price ID"));

      return;
}
  
// set ID property of fuel_price to be edited
$fuel_price->id = htmlspecialchars(strip_tags($data->id));

// Get the fuel_price whose details are to be updated 
$fuel_price_stmt = $fuel_price->get_fuel_price_report();
    
$fuel_price_to_update = $fuel_price_stmt->fetch(PDO::FETCH_ASSOC);

 
// set fuel_price property values
$fuel_price->user_id = ($data->user_id == null || $data->user_id == "") ? $fuel_price_to_update['user_id'] : $data->user_id;
$fuel_price->station_id = ($data->station_id == null || $data->station_id == "") ? $fuel_price_to_update['station_id'] : $data->station_id;
$fuel_price->fuel_price = ($data->fuel_price == null || $data->fuel_price == "") ? $fuel_price_to_update['fuel_price'] : $data->fuel_price;
$fuel_price->verified = ($data->verified == null || $data->verified == "") ? $fuel_price_to_update['verified'] : $data->verified;
$fuel_price->created_at = ($data->created_at == null || $data->created_at == "") ? $fuel_price_to_update['created_at'] : $data->created_at;
$fuel_price->updated_at = date("d-m-Y H:s:ia");

 
// update the fuel_price
if($fuel_price->update_fuel_price_report()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the fuel_price
    echo json_encode(array("message" => "fuel_price was updated successfully."));
}
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the fuel_price
    echo json_encode(array("message" => "Unable to update fuel_price. Please try again."));
}

?>