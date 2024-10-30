<?php
session_start();
$_SESSION = [];

session_destroy();


header("Location: ../user_pages/index.php");
exit();
