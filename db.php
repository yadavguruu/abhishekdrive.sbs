<?php

  $db = new mysqli("localhost","root","","abhishek_drive");

   if($db->connect_error)

   {
   	  die("connection not established");
   }

?>