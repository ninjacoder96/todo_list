<?php 
    require_once('views/layouts/header.php');
    include "./Db/Config.php";
    include "./Db/Factory.php";
    include "./Db/Adapter/AdapterInterface.php";
    include "./Db/Adapter/Pdo.php";
    require 'vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('views');
    $twig = new \Twig\Environment($loader);

    
    
    $config =  new \Db\Config();
    $db =  \Db\Factory::connect($config);

    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $perPage = 5; 
    $startAt = $perPage * ($currentPage - 1);

    $count = $db->count("SELECT COUNT(*) FROM tasks");


    $users = $db->fetchAll("SELECT * FROM tasks limit  $startAt, $perPage",[
        'column1' => $currentPage,
        'column2' => $perPage,   
    ]);

    $totalItems = count($users); // total items
    $totalPages = ceil($count / $perPage);


    echo $twig->render('data.twig', [
        'currentFilters' => [],
        'data'=> $users,
        'currentPage' => $currentPage,
        'lastPage' =>  $totalPages,
        'paginationPath' => 'index.php'
    ]);





    require_once('views/layouts/footer.php');
?>