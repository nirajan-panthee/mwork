<?php
	include 'connection.php';
	$timezone="Asia/Kathmandu";
	date_default_timezone_set($timezone);
	$curtime=Date('Y-m-d H:i:s',time());
	
	
	
	$timezone="Asia/Kathmandu";
	date_default_timezone_set($timezone);
	$curtime=Date('Y-m-d H:i:s',time());
	$mktime=Date('Y-m-d H:i:s',strtotime('+10 min'));
	
	if(isset($_POST)){
		//$data=json_decode(urldecode($_POST['json']),true);
		
		//for uncompleted job
		$delaytime=Date('Y-m-d H:i:s',strtotime('-15 min'));
		
		$undoneJob=mysql_query("SELECT project_id FROM project WHERE job_type='process' AND asign_on<'$delaytime'");
		while($row=mysql_fetch_array($undoneJob)){
			if(isset($row['project_id']))
			{
				$project_id=$row['project_id'];
				
				mysql_query("UPDATE `project` SET  `job_type`='open',  `asign_to`='',  `asign_on`='' WHERE `project_id` = $project_id ");
			}
		}
		//end
		
		
		
		//for image upload
		if(isset($_POST['token'],$_POST['image'])){
			
			$token=$_POST['token'];

			
		
			$valid=mysql_fetch_array(mysql_query("SELECT user_email FROM session WHERE token='$token' AND valid_upto>'$curtime'"));
			
			if(isset($valid['user_email'])){
				$token=$_POST['token'];
				$user_email=$valid['user_email'];
				
			//mkdir('img');
			$imagename=mysql_fetch_array(mysql_query("SELECT MAX(project_id) AS id FROM project"));
			$filename="img/".($imagename['id']+1).".jpg";
			$img_location=$_POST['image'];
			$fp      = fopen($img_location, 'r+');
			$content = fread($fp, filesize($img_location)); //reads $fp, to end of file length
			fclose($fp);
			// get originalsize of image
			$im = imagecreatefromstring($content);
			$width = imagesx($im);
			$height = imagesy($im); 
			
			// Set thumbnail-height to 180 pixels                                    
			$imgh = 700;                                          
			// calculate thumbnail-height from given width to maintain aspect ratio
			$imgw = $width / $height * $imgh;                                          
			// create new image using thumbnail-size
			$thumb=imagecreatetruecolor($imgw,$imgh);                  
			// copy original image to thumbnail
			imagecopyresampled($thumb,$im,0,0,0,0,$imgw,$imgh,ImageSX($im),ImageSY($im)); //makes thumb
			imagejpeg($thumb, $filename, 80);  //imagejpeg($resampled, $fileName, $quality);
			$instr = fopen($filename,"rb");  //need to move this to a safe directory
			$image = addslashes(fread($instr,filesize($filename)));
			  
			  //unlink($filename);
			  //rmdir('img');
				
				mysql_query("INSERT INTO `project` (`Image`,`created_by`,`created_on`) VALUES ('$image','$user_email', '$curtime')");
				mysql_query("UPDATE `session` SET  `valid_upto`='$mktime' WHERE `token`='$token'");
				
				$message['message']="image is uploaded";
				$message['code']=1;
				echo json_encode($message);
			}
			else{
			
				
				$message['message']="you are not log in";
				$message['code']=0;
				echo json_encode($message);
				
			}
		
		}
		//end
		
		//test data
		
		
		//for job request
		//else if(isset($_POST['jobrequest'],$_POST['token'])){
		else if(isset($_POST['jobrequest'])){
			
			//$token=$_POST['token'];
			//$test=mysql_fetch_array(mysql_query("SELECT user_email FROM session WHERE token='$token' AND valid_upto>'$curtime'"));
			
			//if(isset($test['user_email'])){
				
				
				//$user_email=$test['user_email'];
				//mysql_query("UPDATE `session` SET  `valid_upto`='$mktime' WHERE `token`='$token'");
				//$job=mysql_fetch_array(mysql_query("SELECT project_id FROM project WHERE job_type='process' AND asign_to='$user_email' ORDER BY created_on ASC LIMIT 1"));
				//if(isset($job['project_id'])){
					//$job_request['project_id']=$job['project_id'];
					//echo json_encode($job_request);
				//}
				//else
				//{
					$new_job=mysql_fetch_array(mysql_query("SELECT project_id FROM project WHERE job_type='open' ORDER BY created_on ASC LIMIT 1"));
					
					
					if(isset($new_job['project_id']))
					{
						$job_id=$new_job['project_id'];
						mysql_query("UPDATE `project` SET `job_type` = 'process',`asign_on` = '$curtime' WHERE `project_id` = '$job_id'");
						
						$job_request['project_id']=$job_id;
						echo json_encode($job_request);
						
					}
					else
					{
						//echo json_encode("no work to be done");
						$message['message']="no work to be done";
						$message['code']=1;
						echo json_encode($message);
					}
				//}
				
			/* }
			else{
			
				//echo json_encode("you are not log in");
				$message['message']="you are not log in";
				$message['code']=0;
				echo json_encode($message);
				
			} */
		}
		//end
		
		//for job submit
		 
		//else if(isset($_POST['jobsubmit'],$_POST['token'],$_POST['project_id']))
		else if(isset($_POST['jobsubmit'],$_POST['project_id']))
		{
			//$token=$_POST['token'];
			$project_id=$_POST['project_id'];
			//$token=mysql_fetch_array(mysql_query("SELECT token FROM session WHERE token='$token' AND valid_upto>'$curtime'"));
			
			//if(isset($token['token'])){
				//$token=$_POST['token'];
				//mysql_query("UPDATE `session` SET  `valid_upto`='$mktime' WHERE `token`='$token'");
				
				$ownerName=$_POST['owner_name'];
				$regd=$_POST['regd'];
				$address=null;
				$gurdains=null;
				$grandGurdains=null;
				$citizenshipNo=null;
				$issueddate=null;
				$issuedby=null;
				
				
				mysql_query("INSERT INTO `owner` (`owner_registrationNo`,`owner_name`, `address`, `father/mother/husband`, `grandfather/fatherinlaw`, `citizenshipNo`, `issuedDate`, `issuedBy`) VALUES ('$regd','$ownerName', '$address', '$gurdains', '$grandGurdains', '$citizenshipNo', '$issueddate', '$issuedby')");
				$owner_id=mysql_fetch_array(mysql_query("SELECT MAX(id) As id FROM owner"));
				$id=$owner_id['id'];
				
				$proof_id=$_POST['proof_id'];
				$district=null;
				$vdc=null;
				$wardNo=null;
				$kittaNo=$_POST['kittaNo'];
				$details=null;
				$ownership=null;
				$mohi=null;
				$landtype=null;
				$area=$_POST['area'];
				$documentRecordNo=$_POST['documentRecordNo'];
				$remarks=null;
				
				
				mysql_query("INSERT INTO `land` (`id`, `proof_id`, `district`, `vdc/municiplity`, `wardNo`, `kittaNo`, `details`, `ownership`, `mohiName/type`, `landtype`, `area`, `documentRecordNo`, `Remarks`) VALUES ('$id', '$proof_id', '$district', '$vdc', '$wardNo', '$kittaNo', '$details', '$ownership', '$mohi', '$landtype', '$area', '$documentRecordNo', '$remarks')");
				
				
				mysql_query("UPDATE `project` SET  `job_type`='close',completed_on='$curtime' WHERE `project_id`='$project_id'");
				//echo json_encode("Data entry sucess");
				$message['message']="Data entry sucess";
				$message['code']=1;
				echo json_encode($message);
				
			/* }
			else{
			
				//echo json_encode("you are not log in");
				$message['message']="you are not log in";
				$message['code']=0;
				echo json_encode($message);
			} */
		}
		
		//for viewing data
		
		else if(isset($_POST['search'],$_POST['token']))
		{
			$token=$_POST['token'];
			$name=$_POST['search'];
			$token=mysql_fetch_array(mysql_query("SELECT token FROM session WHERE token='$token' AND valid_upto>'$curtime'"));
			
			if(isset($token['token']))
			{
				$token=$_POST['token'];
				mysql_query("UPDATE `session` SET  `valid_upto`='$mktime' WHERE `token`='$token'");
				$info['owner']=mysql_fetch_array(mysql_query("SELECT * FROM owner WHERE owner_name LIKE '$name%'"));
				
				if(isset($info['owner']['id']))
				{
					$ownerid=$info['owner']['id'];
					$info['land']=mysql_fetch_array(mysql_query("SELECT * FROM land WHERE id='$ownerid'"));
					echo json_encode($info);
				}
				else 
				{
					//echo json_encode("no data to display");
					$message['message']="no data to display";
					$message['code']=0;
					echo json_encode($message);
				}
			}
			else
			{
				//echo json_encode("you are not login");
				$message['message']="you are not log in";
				$message['code']=0;
				echo json_encode($message);
			}
		
		}
	}
	else
	{
		echo json_encode("invalid format");
	}


	mysql_close($con);

?>