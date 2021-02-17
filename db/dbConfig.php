<?php
    //database configration details
    $servername = "localhost";  // dont change this most of hosting work with "localhost" only cloud work with ip address
    $database = "agGrid";
    $username = "root";
    $password = "";
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    mysqli_query($conn,"SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");
    
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    if($_GET["p"] == "test"){
        $data = array();
        $query = mysqli_query($conn, "select cities.name as city_name, states.name as state_name, countries.name as country_name from cities join states on states.id = cities.state_id join countries on countries.id = states.country_id order by cities.id asc");
        while ($row = mysqli_fetch_array($query)) {
            $data[] = array(
                'country' => $row['country_name'],
                'state' => $row['state_name'],
                'city' => $row['city_name']
            );
        }
        echo json_encode($data);
    }
    else if($_GET["p"] == "pagination"){ 
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        if(is_array($decoded)) {
            $data = array();
            $orderByQuery = "";
            if(count($decoded['sortModel'])){
                $sortby = $decoded['sortModel'][0]['sort'];
                $sortColumn = $decoded['sortModel'][0]['colId'];
                if($sortColumn == 'country'){
                    $sortByColumn = 'countries.name'; 
                }
                elseif ($sortColumn == 'state') {
                    $sortByColumn = 'states.name'; 
                }
                elseif ($sortColumn == 'city') {
                    $sortByColumn = 'cities.name'; 
                }
                $orderByQuery = "order by ".$sortByColumn." ".$sortby;
            }
            
            $blockSize = ( $decoded['endRow'] - $decoded['startRow'] ) + 1;
            $query = mysqli_query($conn, "select cities.name as city_name, states.name as state_name, countries.name as country_name from cities join states on states.id = cities.state_id join countries on countries.id = states.country_id ".$orderByQuery." limit ".$decoded['startRow']. ", ".$blockSize);
            while ($row = mysqli_fetch_array($query)) {
            array_push($data, array(
                  'country' => $row['country_name'],
                  'state' => $row['state_name'],
                  'city' => $row['city_name']
              ));
            }
            echo json_encode($data);
        } 
    }
    else{
        $arr = array("Error"=>"End point not found");
        echo json_encode($arr);
    }
 ?>  