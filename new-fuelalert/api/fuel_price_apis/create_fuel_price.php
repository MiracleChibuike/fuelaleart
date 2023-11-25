<?php
include('../config/autoload.php');
// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$POST_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);

$fuel_report = new FuelPriceReport($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->user_id) &&
    !empty($data->station_id) &&
    !empty($data->fuel_price)
){
  
    // Sanitize & set fuel_report property values
    $fuel_report->user_id = htmlspecialchars(strip_tags($data->user_id));
    $fuel_report->station_id = htmlspecialchars(strip_tags($data->station_id));
    $fuel_report->fuel_price = htmlspecialchars(strip_tags($data->fuel_price));
    // $fuel_report->verified = 0;
    // $fuel_report->created_at = date("d-m-Y H:s:ia");
    // $fuel_report->updated_at = date("d-m-Y H:s:ia");

    // print_r($fuel_report->created_at);
    // return;
  
    // create the fuel_report
    if($fuel_report->create_fuel_price_report()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the fuel_report
        echo json_encode(array("message" => "fuel_report was created successfully."));

    }
    else{

        // if unable to create the fuel_report, tell the fuel_report
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the fuel_report
        echo json_encode(array("message" => "Unable to create fuel_report."));

    }

}
else{

    // tell the fuel_report data is incomplete
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the fuel_report
    echo json_encode(array("message" => "Unable to create fuel_report. Data is incomplete."));

}

