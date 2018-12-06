<?php

require 'mail.php';


$mail2 = new database();

// $mail2->sendMailToPerson("ravishdussaruth@gmail.com", "Ravish Dussaruth", "<br>Hello<br>", "Alt");
$mail = new database();
$mail->initialize();
$mail->saveData('Olalekan Arowoselu ', 'olalekanarowoselu@gmail.com', 'Hello', 'true');

// $k = 123;
// $dateto = date('Y-m-d', strtotime("06-May-1999"));
// echo "Today is " . date('Y-m-d') . "<br>";

// $vr = 'false';

// if ($vr == 'false') {
//     echo 'hello';
// } else {
//     echo 'dalse';
// }

// print('Hello<br>' . ($vr == true));
// echo 'Hello : ' . (strcmp($vr, 'false'));
// $rowTemp = array();
// $campCode = $mail->fetchCustomer('campaignCode', "WHERE campaignName = 'oij'", "CAMPAIGN"); //fetching campaign name code
// echo 'ar : ' .$campCode[0];
// $rows = $mail->fetchNewCustomer('cust_name', 'cust_email', 'WHERE acceptAdvertised = true;', 'customerdata');

// $rowArray = $mail->fetchNewCustomer('CUSTOMERDATA.cust_name', 'CUSTOMERDATA.cust_email', "INNER JOIN oij ON CUSTOMERDATA.cust_id = oij.cust_id 
// WHERE oij.dataSent = false;", 'CUSTOMERDATA'); // getting customer name and emails

// // print_r($rowArray);
// foreach($rowArray as $customer){
//     echo 'Name '. $customer['cust_name'] .'<br>';
// }

// $mail->close();
// echo getcwd(). "/phpfile/newcampaignname.txt";
// $myfile = fopen('C:/wamp64/www/email/phpfile/km4.txt', "r");
// $code =  fread($myfile, filesize('C:/wamp64/www/email/phpfile/km4.txt'));
// echo $code;
// fclose($myfile);

// // echo 'Count : ' . count($rows);
// foreach($rows as $multi){
//     echo "Name : $multi[cust_name]<br> ";
//     echo "Email : $multi[cust_email]<br> ";
// }
 
// foreach ($rows as $str) {
//     echo 'Value  : ' . $str . '<br>';
// }



?>