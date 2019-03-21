<?php session_start(); 

set_time_limit(300);

if($_POST["uploadFile"] != "")
{
	$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
	
	if(($ext == "jpg") || ($ext == "gif") || ($ext == "png"))
	{
		$name = $_FILES['userfile']['name'];
		
		if(!is_uploaded_file($_FILES['userfile']['tmp_name']))
		{
			echo "Failed to upload file - upload did not match sent information.";
			exit;
		}
		
		$counter = date("YmdHis");
		
		$upfile = "../../backend/upload/".$_POST["category"].$counter.'.'.$ext;
		
		if(!copy($_FILES['userfile']['tmp_name'], $upfile))
		{
			echo "Failed to upload file - upload directory not found."
			exit;
		}
		
		$_SESSION["error"] = "Success!";
	}
	else
	{
		$_SESSION["error"] = "You can't upload a ".$ext." file.";
	}
}
else
{
	$_SESSION["error"] = "";
}

header("Location: uploadtest.php");

?>