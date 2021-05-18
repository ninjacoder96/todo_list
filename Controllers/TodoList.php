<?php
namespace Controllers;

use Datetime;

header('Content-Type: application/json');
/*
*
* 
*/
include "./../Db/Config.php"; 
include "./../Db/Factory.php"; 
include "./../Db/Adapter/AdapterInterface.php";
include "./../Db/Adapter/Mysql.php";
include "./../Db/Adapter/Pdo.php";
require '../vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $config = new \Db\Config();
    $db = \Db\Factory::connect($config);

    $now = new DateTime();
    $today = $now->format('Y-m-d H:i:s');

    $errors = [];
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data["action"] == 'add_task') {

        $title = (!empty($data["title"])) ? filter_var($data["title"], FILTER_SANITIZE_STRING) : $errors[] = "title is required!";
        $desc = (!empty($data["desc"])) ? filter_var($data["desc"], FILTER_SANITIZE_STRING) : $errors[] = "Description is required!";

        if (sizeof($errors) == 0) {

            $params = array(
                "column1" => $title,
                "column2" => $desc,
                "column3" => $today,
                "column4" => $today
            );
            $sql = $db->insert($params);

            if ($sql) {
                http_response_code(200);
                echo json_encode(["status" => 'success', 'msg' => "Successfully Added"]);
                exit;
            }
        }
        echo json_encode(["status" => 'failed', 'msg' => $errors]);

    }

    if($data["action"] == 'find_list'){
        $id = $data["id"];

        $params = array(
            "column1" => $id,
        );
        $sql = $db->find($params);

        json_encode($sql,true);
        echo json_encode(["status" => 'success','data' => $sql]);
    }

    if($data["action"] == 'update_task'){

        $id = $data["id"];
        $title = (!empty($data["title"])) ? filter_var($data["title"], FILTER_SANITIZE_STRING) : $errors[] = "title is required!";
        $desc = (!empty($data["desc"])) ? filter_var($data["desc"], FILTER_SANITIZE_STRING) : $errors[] = "Description is required!";
        

        if (sizeof($errors) == 0) {
            $params = array(
                "column1" => $title,
                "column2"=> $desc,
                "column3" => $today,
                "column4" => $id
            );
            
            $sql = $db->update($params);

            if ($sql) {
                http_response_code(200);
                echo json_encode(["status" => 'success', 'msg' => "Successfully Updated"]);
                exit;
            }
        }
        echo json_encode(["status" => 'failed', 'msg' => $errors]);

    }

    if($data["action"] == 'delete_task'){
        $id = $data["id"];

        $params = array(
            "column1" => $id  
        );

        $sql = $db->delete($params);

        if ($sql) {
            http_response_code(200);
            echo json_encode(["status" => 'success', 'msg' => "Successfully Deleted"]);
            exit;
        }
    



    }

}
