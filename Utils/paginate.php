<?php
   $currentPage = isset($_GET["page"]) ? (int)$_GET["page"] : (int)1;
   $perPage = 5; 
   $startAt = $perPage * ($currentPage - 1);
?>