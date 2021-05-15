<?php 
    include "./Db/Config.php";
    include "./../Db/Factory.php";
    include "./../Db/Adapter/AdapterInterface.php";
    include "./../Db/Adapter/Pdo.php";
    require '../vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if($data["action"] == 'add_task'){
        $title  =  filter_var($data["title"], FILTER_SANITIZE_STRING);
        $desc   = filter_var($data["desc"],  FILTER_SANITIZE_STRING);
        
        

    }
    

}

?>