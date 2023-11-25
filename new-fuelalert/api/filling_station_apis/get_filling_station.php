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
  
// read filling_station id will be here
$filling_station_id = $_GET['filling_station_id'] ?? null;

if($filling_station_id == null || !is_numeric($filling_station_id)){
    // No valid filling_station id provided
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the filling_station no products found
    echo json_encode(
        array("message" => "Plaese provide a valid filling_station ID")
    );

    return;
}

// query filling_stations
$filling_station->id = $filling_station_id;
$stmt = $filling_station->get_filling_station();
// $num = $stmt->rowCount();
  
// check if more than 0 record found
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
//  print_r(count($filling_stations_arr['records']));
//   return;
    if(count($filling_stations_arr['records']) == 0){
        // set response code - 200 OK
        http_response_code(200);
    
        // show filling_stations data in json format
        echo json_encode(array("message" => "No filling_station found with this ID."));

        return;
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
        array("message" => "Something went wrong. Not able to fetch filling_station.")
    );
}
  
