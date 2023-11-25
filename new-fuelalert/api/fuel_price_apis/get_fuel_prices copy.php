<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
  
// initialize object
$fuel_price = new FuelPriceReport($db);
  
// read fuel_prices will be here
// query fuel_prices
$stmt = $fuel_price->get_fuel_price_reports();
    
if($stmt){

  
    // fuel_prices array
    $fuel_prices_arr=array();
    $fuel_prices_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $fuel_price_item=array(
            "id" => $id,
            "user_id" => $user_id,
            "station_id" => $station_id,
            "fuel_price" => $fuel_price,
            "verified" => $verified,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );
  
        array_push($fuel_prices_arr["records"], $fuel_price_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show fuel_prices data in json format
    echo json_encode($fuel_prices_arr);
}
else{
    // no fuel_prices found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the fuel_price no products found
    echo json_encode(
        array("message" => "No fuel_prices found.")
    );
}
  

