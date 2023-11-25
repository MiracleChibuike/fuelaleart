<?php
include('../config/autoload.php');

// required headers
header("Access-Control-Allow-Origin:".$ORIGIN);
header("Content-Type:".$CONTENT_TYPE);
header("Access-Control-Allow-Methods:".$GET_METHOD);
header("Access-Control-Max-Age:".$MAX_AGE);
header("Access-Control-Allow-Headers:".$ALLOWED_HEADERS);
  
  
// initialize object
$filling_station = new FillingStation($db);
  
// read filling_stations will be here
// query filling_stations
$stmt = $filling_station->get_filling_stations();
    
if($stmt){

  
    // filling_stations array
    $filling_stations_arr=array();
    $filling_stations_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $filling_station_item=array(
            "id" => $id,
            "user_id" => $user_id,
            "name" => $name,
            "address" => $address,
            "area" => $area,
            "city" => $city,
            "state" => $state,
            "country" => $country,
            "verified" => $verified,
            "active" => $active,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );
  
        array_push($filling_stations_arr["records"], $filling_station_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show filling_stations data in json format
    echo json_encode($filling_stations_arr);
}
else{
    // no filling_stations found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the filling_station no products found
    echo json_encode(
        array("message" => "No filling_stations found.")
    );
}
  

