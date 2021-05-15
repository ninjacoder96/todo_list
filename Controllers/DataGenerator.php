<?php 
   namespace Controllers;
   
   include "./../Db/Config.php";
   include "./../Db/Factory.php";
   include "./../Db/Adapter/AdapterInterface.php";
   include "./../Db/Adapter/Pdo.php";

   use Datetime;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $config =  new \Db\Config();
    $db =  \Db\Factory::connect($config);

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if($data["action"] == 'generate_data'){
        $data  =  filter_var($data["data"], FILTER_SANITIZE_STRING);

        $now = new DateTime();
 


        $today = $now->format('Y-m-d H:i:s'); 
        
        for ($i = 0; $i < $data; $i++) {
            $count = $db->insert("INSERT INTO tasks(title,description,created_at,updated_at) VALUES(:column1,:column2,:column3,:column4)",[
                'column1' => random_bytes(16),
                'column2' => random_bytes(16),
                'column3' => $today,
                'column4' => $today,
            ]);
        }
        
        echo json_encode(["status" => 'success', 'msg' => "Data Generated"]);


        

            
        
    }

    

}



?>