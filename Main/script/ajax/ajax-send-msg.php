<?php
session_start();
require "../../function.php";

$currentId =  $_SESSION["currentId"];

$msgStatus = sendMessage($_GET["msgValue"], $currentId, $_GET["userDestId"]);
if($msgStatus === "message sent"){
    echo "";
}else {
    echo $msgStatus;
}


?>