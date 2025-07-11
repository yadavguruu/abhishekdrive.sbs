<? php

    $check = mail("stptask@gmail.com","Testing puropse","This is a Testing email from xampp server","from: rajpalyadav9699@gmail.com");

    if($check == true)
    {
    	echo "email send successfully";
    }
    else
    {
    	echo "email not send successfully";
    }

?>