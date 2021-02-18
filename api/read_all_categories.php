<?php 
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //initializing our api
    include_once('../core/initialize.php');

    //instantiate categories
    $categories = new Categories($db);

    //blog categories query
    $result =  $categories->read();
    //get the row count
    $num = $result->rowCount();

    if($num > 0){
        $categories_arr = array();
        $categories_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $categories_item = array(
                'id' => $id,
                'name' => $name,
                'created_at' => $created_at
            );
            array_push($categories_arr['data'], $categories_item);
        }
        // Mengubah array ke string JSON / objek variabel, 
        // jika mengubah string JSON ke array dengan function json_decode();
        // Convert to JSON and output
        echo json_encode($categories_arr);
        // Testing output dengan sofware categoriesman GET:localhost/phprestapi/api/read.php
    }else{
        echo json_encode(array('message' => 'No categoriess Found'));
    }

?>