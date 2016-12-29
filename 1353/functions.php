<?php
require 'dbconfig.php';
function checkuser($fuid, $ffname, $femail, $fbfirst_name, $fblast_name, $fbage_range, $fblink, $fbgender, $fblocale, $fbpicture, $fbtimezone, $fbupdated_time, $fbverified){
    $check = mysql_query("select * from users where fb_id='$fuid'");
	$check = mysql_num_rows($check);
	if (empty($check)) { // if new user . Insert a new record		
	$query = "INSERT INTO users (fb_id, name, email, first_name, last_name, age_range, link, gender, locale, timezone, updated_time, verified) VALUES ('$fuid','$ffname','$femail','$fbfirst_name','$fblast_name','teste','$fblink','$fbgender','$fblocale','$fbtimezone','$fbupdated_time','$fbverified')";
	mysql_query($query);	
	} else {   // If Returned user . update the user record		
	$query = "UPDATE users SET name='$ffname', email='$femail', first_name='$fbfirst_name', last_name='$fblast_name', age_range='$fbage_range', link='$fblink', gender='$fbgender', locale='$fblocale', timezone='$fbtimezone', updated_time='$fbupdated_time', verified='$fbverified' where fb_id='$fuid'";
	mysql_query($query);
	}
}?>
