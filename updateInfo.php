<!DOCTYPE html>
<!--	Author: Anthony Storti
		Date:	October 1, 2019
		File:	updateInfo.php
		Purpose:test data and add it alphabetically to a userInfo file
-->
<html>
<head>
	<title>Update Info</title>
	<link rel ="stylesheet" type="text/css" href="sample.css">
</head>

<body>

	<?php

        $newFirst = $_POST['first'];
        $newLast = $_POST['last'];
				$email = $_POST['email'];
				$phone = $_POST['phone'];
				// if data is not in correct format this function will be called giving
				// a reason and a link back to the html page
				function call_delay($reason){
					print ("<h>$reason</h>");
					print('<br/>');
					print("<a href = 'userInfo.html'>Back To Data Entry Page</a>");
					exit();
				}
					// This function specifically checks for size format between two
					// numbers
					function check_sizeUpLow($var, $up, $low, $str){
						if(strlen($var)>$up OR strlen($var)<$low){
							call_delay($str);
					}
				}
				//check for email @ sign call invalid without will also detect null entry
				if(!preg_match("/^[@]+$/", $email)){
					$pEmail = explode("@", $email);
				}
				else {
					call_delay("Enter Valid Email Address");
				}
				//check that only 1 "@" delimeter was found  else declare invalid
				// if valid explode on "." delimeter
			if(sizeof($pEmail) <> 2){
					call_delay("Please Enter a Valid Email");
				}
				$email1 = explode(".", $pEmail[1]);
				// check that only 1 "." delimeter was found else declare invalid
			if(sizeof($email1) <> 2){
					call_delay("Please Enter a Valid Email");
				}
				//check domain of email is com or edu
			if(strcmp($email1[1], "com") != 0 AND strcmp($email1[1], "edu") != 0){
					call_delay("Please Enter a Valid Email Address");
				}
				//check handle of email contains only letters and numbers
				if (!preg_match("/^[a-zA-Z0-9]+$/", $pEmail[0])) {
					call_delay("Enter A Valid Email Address");
				}
				//check host of email contains only letters
				if (!preg_match("/^[a-zA-Z]+$/", $email1[0])) {
					call_delay("Enter A Valid Email Address");
				}
				//check email length
				if(strlen($email) > 30){
					call_delay("Enter A Valid Email Address");
				}

				$ePhone = explode("-",$phone);
				// check that phone number was delimeted correctly and contains
				// 3 "-" chars else call invalid
			if(strlen($ePhone[0]) <> 3 OR strlen($ePhone[1]) <> 3 OR strlen
			($ePhone[2]) <> 4){
				call_delay("Please Enter a Valid Phone Number!");
			}
			//check  that phone number only contains numbers **Found preg_match through
			//google
			if (!preg_match("/^[0-9]+$/", $ePhone[0]) OR !preg_match("/^[0-9]+$/",
			$ePhone[1]) OR !preg_match("/^[0-9]+$/", $ePhone[2])) {
				call_delay("Must Enter A Valid Last Name!");
			}
			//check size of first and last name and phone number
			check_sizeUpLow($newFirst, 20, 1, "Must Enter Valid First Name");
			check_sizeUpLow($newLast, 20, 1, "Must Enter Valid Last Name");
			check_sizeUpLow($phone, 12, 1, "Must Enter Valid Phone Number");
			// check first name to ensure it only contains letters
			if (!preg_match("/^[a-zA-Z]+$/", $newFirst)) {
   			call_delay("Must Enter A Valid First Name!");
			}
			// check last name to ensure it only contains letters
			if (!preg_match("/^[a-zA-Z]+$/", $newLast)) {
				call_delay("Must Enter A Valid Last Name!");
			}
						//load file in read data into an array where first string is the key
						$namesFile =fopen("userInfo.txt","r");
						$userData = array();
            while (!feof($namesFile)) {
                $name = fgets($namesFile);

                $name = str_replace(array("\n", "\r"), '', $name);
                $bothNames = explode(":", $name);

                if(!feof($namesFile)) {
                    $key = $bothNames[0];
                    $userData["$key"][1] = $bothNames[1]; //
										$userData["$key"][2] = $bothNames[2];
										$userData["$key"][3] = $bothNames[3];
                }
            }
            fclose($namesFile);

						//add the new data, and sort

            $userData["$newLast"][1] = $newFirst;
						$userData["$newLast"][3] = $email;
						$userData["$newLast"][2] = $phone;
						//sort array
						ksort($userData, SORT_STRING);
						//write array to a file with delimeter using a for each loop
						$outFile = fopen("userInfo.txt","w");
	            foreach($userData as $key=>$value) {
	               fwrite($outFile, $key.":".$value[1].":".$value[2].":".$value[3]);
								 fwrite($outFile,"\n");
							 }
							fclose($outFile);
	// display data in table
	print("Customer Data:");
	print("<table border = \"3\"><tr>");
	print("<th>Last Name</th>");
	print("<th>First Name</th>");
	print("<th>Phone</th>");
	print("<th>Email</th>");
	print("</tr>");

	foreach($userData as $key=>$value) {

		print("<tr>");
		print("<td align = 'center'>".$key."</td>");
		print("<td align = 'center'>".$value[1]."</td>");
		print("<td align = 'center'>".$value[2]."</td>");
		print("<td align = 'center'>".$value[3]."</td>");
		print("</tr>");
	}
	print("</table>");
	print("<a href = 'userInfo.html'>Back To Data Entry Page</a>");

?>
</body>
</html>
