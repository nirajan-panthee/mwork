<?php

include 'connection.php';

if(isset($_GET['project_id']))
{

	$image_id=$_GET['project_id'];
	$image=mysql_fetch_array(mysql_query("SELECT Image from project WHERE project_id='$image_id'"));
	$image_content=$image['Image'];
	echo '<img src="data:image/jpeg;base64,' . base64_encode( $image_content ) . '" />';

}

?>
