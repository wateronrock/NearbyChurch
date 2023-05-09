<?php
require_once "functions.php";
session_start_if_none();
unset($_SESSION['uid']);
unset($_SESSION['uname']);
unset($_SESSION['grade']);

goNow(MAIN_PAGE);
?>
