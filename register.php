<?php
	
	include 'connection.php';
	//test input data
	/* $data['email']="nirajan.panthee@gmail.com";
	$data['password']=md5("nirajan");
	$data['username']="Nirajan Panthee";
	$data=json_encode($data); */
	//
	if(isset($_POST)){
		//$data=json_decode(urldecode($_POST['json']),true);
		
		if(isset($_POST['email'])&&isset($_POST['password'])&&isset($_POST['fullname']))
		{
			$email=$_POST['email'];
			$password=$_POST['password'];
			$name=$_POST['fullname'];
			
			//check the validation of email
			$valid=mysql_fetch_array(mysql_query("SELECT user_email FROM user WHERE user_email='$email'"));
			
			if(!isset($valid['user_email']))
			{
				mysql_query("INSERT INTO `user` (`user_email`,`user_name`,`user_password`) VALUES ('$email', '$name','$password')");
				$message['message']="Register sucessfully";
				$message['code']=1;
				echo json_encode($message);
			}
			else
			{
				
				$message['message']="email is already register";
				$message['code']=0;
				echo json_encode($message);
			}
		
		
		}
	}
	else
	{
		echo json_encode("Invalid data format");
	
	}
	mysql_close($con);


?>