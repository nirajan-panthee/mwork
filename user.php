<?php
	
	include 'connection.php';
	$timezone="Asia/Kathmandu";
	date_default_timezone_set($timezone);
	$curtime=Date('Y-m-d H:i:s',time());
	//var_dump($_POST);
	
	if(isset($_POST['json'])){
		//$data=json_decode(urldecode($_POST['json']),true);
		
		if(isset($_POST['email'],$_POST['password'])){
			$email=mysql_real_escape_string($_POST['email']);
			$password=mysql_real_escape_string($_POST['password']);
			
			$sql=mysql_query("SELECT user_id,user_email FROM user WHERE user_email='$email' AND user_password='$password'");
			$user_id=mysql_fetch_array($sql);
				
			
			
			if(isset($user_id['user_id'])){
			
				//$multiplelogin=mysql_fetch_array(mysql_query("SELECT token FROM session WHERE user_email='$email' AND valid_upto>'$curtime'"));
				
				//if(!isset($multiplelogin['token'])){
				
					$tokenid=$user_id['user_id'];
					$user_email=$user_id['user_email'];
					
					
					$time=Date('Y-m-d H:i:s',strtotime('+10 min'));
					
					$token=uniqid('',true);
					mysql_query("INSERT INTO `session` (`user_email`,`token`,`valid_upto`) VALUES ('$user_email', '$token','$time')");
					$curtime=Date('Y-m-d H:i:s',time());
					$token=mysql_fetch_array(mysql_query("SELECT token FROM session WHERE user_email='$user_email' AND valid_upto>'$curtime' ORDER BY ID DESC"));
					$data_auth['token']= $token['token'];
					$utoken=$token['token'];
					echo json_encode($data_auth);
				/* }
				else{
					
					$message['message']="You are already login";
					$message['code']=0;
					echo json_encode($message);
				} */
			}
			else{
				
				$message['message']="invalid user name or password";
				$message['code']=0;
				echo json_encode($message);
			
			}
		}
		else
		{
			echo json_encode("error:0");
		}
		
		//logout
		//$data['logout']="5052fa209fc285.32976091";
		if(isset($data['logout'])){
			$token=$data['token'];
			mysql_query("UPDATE `session` SET  `valid_upto`='$curtime' WHERE `token`='$token'");
			
				$message['message']="logout sucess";
				$message['code']=1;
				echo json_encode($message);
		}
		
		//end
	}
	else 
	{
			echo json_encode("invalid data format");
		
	}
	mysql_close($con);
	
?>