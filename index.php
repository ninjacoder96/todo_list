<?php 
    include "./Db/Config.php";
    include "./Db/Factory.php";
    include "./Db/Adapter/AdapterInterface.php";
    include "./Db/Adapter/Mysql.php";
    include "./Db/Adapter/Pdo.php";
    include "./Utils/paginate.php";
    require 'vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('views');
    $twig = new \Twig\Environment($loader);

    
    
    $config =  new \Db\Config();
    $db =  \Db\Factory::connect($config);


    $count = $db->count();

    $users = $db->fetchAll($startAt,$perPage);


    $totalItems = count($users); // total items
    $totalPages = ceil($count / $perPage);


    echo $twig->render('data.twig', [
        'currentFilters' => [],
        'data'=> $users,
        'currentPage' => $currentPage,
        'lastPage' =>  $totalPages,
        'paginationPath' => 'index.php'
    ]);


?>