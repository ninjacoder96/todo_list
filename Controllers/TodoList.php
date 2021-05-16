<?php
namespace Controllers;

use Datetime;

include "./../Db/Config.php";
include "./../Db/Factory.php";
include "./../Db/Adapter/AdapterInterface.php";
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
            $sql = $db->insert("INSERT INTO tasks(title,description,created_at,updated_at) VALUES(:column1,:column2,:column3,:column4)", [
                'column1' => $title,
                'column2' => $desc,
                'column3' => $today,
                'column4' => $today,
            ]);

            if ($sql) {
                http_response_code(200);
                echo json_encode(["status" => 'success', 'msg' => "Successfully Added"]);
                exit;
            }
        }
        echo json_encode(["status" => 'failed', 'msg' => $errors]);

    }

}
