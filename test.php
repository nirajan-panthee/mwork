
<?php
	/********test data for registration**********/
	
	  /* $data['email']="nirajan.panthee@yipl.com.np";
	$data['password']=md5("nirajan");
	$data['username']="Nirajan Panthee";
	$url="http://localhost/mwork/register.php";  */
	
	//end
	
	/***********test for login***************/
	     $url="http://localhost/mwork/user.php";
	$data['email']="nirajan.panthee@yipl.com.np";
	$data['password']=md5("nirajan");     
	//end
	
	/**************logout*******/
	  /* $url="http://localhost/mwork/user.php";
	$data['logout']=true;
	$data['token']="50554f0114dd78.64993849";  */ 
	//end
	
	/******for upload image********/
	   /* $url="http://localhost/mwork/api.php";
	$data['token']='50554f0114dd78.64993849';
	$data['image']='lal.jpg';  */  
	//end
	
	/*******for job request**********/
		       /* $url="http://localhost/mwork/api.php";
		$data['jobrequest']=true;
		$data['token']='50554f587fbb92.37034121';   */    
		
	//
	
	/**************For search data************/
		  /* $url="http://localhost/mwork/api.php";
		$data['search']="muna";
		$data['token']='50554cfa05b229.67957377';  */ 
	//end
	
	/**************submitting data********************/
		  /*   $url="http://localhost/mwork/api.php";
		$data['jobsubmit']=true;
		$data['token']='50554f587fbb92.37034121';
		$data['project_id']="5";
		
		$data['owner_name']="Muna maharjhan";
		$data['address']="Baneshwor-10,Kathmandu";
		$data['gurdains']="Cp Panthee";
		$data['grandGurdains']="Np panthee";
		$data['citizenshipNo']="895320";
		$data['issueddate']=Date('Y-m-d');
		$data['issuedby']="Ram Kirishna Pandey";
		
		$data['proof_id']="8976/09";
		$data['district']="kathmandu";
		$data['vdc']="kathmandu";
		$data['wardNo']="10";
		$data['kittaNo']="9851";
		$data['details']="House/land";
		$data['ownership']="Single";
		$data['mohi']="none";
		$data['landtype']="Abbal";
		$data['area']="10 ropani";
		$data['documentRecordNo']="567456";
		$data['remarks']="GOOD"; */    
	//end
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
    
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'jsn='.urlencode(json_encode($data)));
    $response = curl_exec($ch);
    echo $response;
	 
	
	
?>