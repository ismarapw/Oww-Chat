<?php
session_start();
require "../../function.php";

$currentId =  $_SESSION["currentId"];
$fetchStatus = liveMessage($currentId, $_GET["userId"]);

if($fetchStatus === "no message yet"){
    echo "";
}else {
    echo $fetchStatus;
}

?>