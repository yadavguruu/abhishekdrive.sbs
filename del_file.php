<?php


session_start();
$user_email = $_SESSION['user'];
require("db.php");

$id = $_POST['id'];
$folder = $_POST['folder'];
$file = $_POST['file'];


$del = unlink("../data/".$folder."/".$file);

if($del)

{
	$del_sql = $db->query("DELETE FROM $folder WHERE id='$id'");

	if($del_sql)

	{

		 $fs_sql = "SELECT sum(file_size) AS uds FROM $folder";
          
          $response = $db->query($fs_sql);
          
         $aa = $response->fetch_assoc();
          
        $total_used_file_size = round($aa['uds'],2);


        $update = "UPDATE users SET use_storage = '$total_used_file_size'

        WHERE email = '$user_email'";

        if($db->query($update))

        {
            echo json_encode(array("msg"=>"file Delete Successfully","use_storage"=>$total_used_file_size));
        }

        else
        {
           echo json_encode(array("msg"=>"Storage not updated"));

        }

	}

	else 
	{

		 echo json_encode(array("msg"=>"failed"));
	}
}

else

{

	 echo json_encode(array("msg"=>"file not deleted"));
}	

?>