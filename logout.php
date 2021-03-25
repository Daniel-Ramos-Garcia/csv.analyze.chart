<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["userid"]);
   unset($_SESSION["user_status"]);

   header('Refresh: 2; URL = login.php');
?>