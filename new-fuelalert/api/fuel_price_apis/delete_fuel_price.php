<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$DEL_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
// prepare fuel_price object
$fuel_price = new FuelPriceReport($db);
  
// get fuel_price id
$data = json_decode(file_get_contents("php://input"));
  
// set fuel_price id to be deleted
$fuel_price->id = htmlspecialchars(strip_tags($data->id));

// Check if fuel_price_id provided is valid
if($fuel_price->id == null || !is_numeric($fuel_price->id)){
    // No valid fuel_price id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the fuel_price no products found
    echo json_encode(
        array("message" => "Plaese provide a valid fuel_price ID")
    );

    return;
}

// Check if fuel_price exists
$fuel_priceCheck = $fuel_price->get_fuel_price_report();

$fuel_price_to_delete = $fuel_priceCheck->fetch(PDO::FETCH_ASSOC);
// var_dump($fuel_price_to_delete);
// return;

if(!$fuel_price_to_delete){
    // No valid fuel_price id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the fuel_price no products found
    echo json_encode(
        array("message" => "fuel_price with ID:$fuel_price->id does not exist")
    );

    return;
}
  
// delete the fuel_price
if($fuel_price->delete_fuel_price_report()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the fuel_price
    echo json_encode(array("message" => "fuel_price was deleted successfully."));
}
  
// if unable to delete the fuel_price
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the fuel_price
    echo json_encode(array("message" => "Unable to delete fuel_price."));
}

?>