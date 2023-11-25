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
  
// read fuel_price id will be here
$fp_id = $_GET['fuel_price_id'] ?? null;

if($fp_id == null || !is_numeric($fp_id)){
    // No valid fuel_price id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the fuel_price no products found
    echo json_encode(
        array("message" => "Plaese provide a valid fuel_price ID")
    );

    return;
}

// query fuel_prices
$fuel_price->id = $fp_id;
$stmt = $fuel_price->get_fuel_price_report();
// $num = $stmt->rowCount();
  
// check if more than 0 record found
if($stmt){
  
    // fuel_prices array
    $fuel_prices_arr=array();
    $fuel_prices_arr["records"]=array();

        // "id" => $id,
    // "user_id" => $user_id,
    // "station_id" => $station_id,
    // "fuel_price" => $fuel_price,
    // "verified" => $verified,
    // "created_at" => $created_at,
    // "updated_at" => $updated_at
    
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $fuel_price_item=array(
            "fuel_price" => $fuel_price,
            "name" => $name,
            "address" => $address,
            "area" => $area,
            "state" => $state
        );
  
        array_push($fuel_prices_arr["records"], $fuel_price_item);
    }
//  print_r(count($fuel_prices_arr['records']));
//   return;
    if(count($fuel_prices_arr['records']) == 0){
        // set response code - 200 OK
        http_response_code(200);
    
        // show fuel_prices data in json format
        echo json_encode(array("message" => "No fuel_price found with this ID."));

        return;
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
        array("message" => "Something went wrong. Not able to fetch fuel_price.")
    );
}
  
