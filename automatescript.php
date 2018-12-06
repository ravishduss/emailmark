<?php

require 'mail.php';

class Auto
{


    private $connection;
    private $mail;

    function __construct()
    {
             // constructor
        $this->mail = new database();

        $this->mail->initialize();

    }

    private function preloaded()
    {



    }

    public function close()
    {
        $this->mail->close();
    }
    public function createCampaign($campaignName, $campaignCode, $campaignExpiryDate)
    {

        $sqlCreateCampaignTable = 'CREATE TABLE IF NOT EXISTS CAMPAIGN(campaign_id int not null auto_increment, campaignName text, campaignCode text, campaignExpiry date, primary key(campaign_id));';

        $this->mail->createSQL($sqlCreateCampaignTable, 'Table Campaign has successfully been created..', 'Table Campaign cannot be created..');

        $path = getcwd() . "/phpfile/$campaignName.txt"; // path to save code file

        $path = str_replace("\\", "/", $path);
        echo "New path $path";
        $dateto = date('Y-m-d', strtotime($campaignExpiryDate));

        $myfile = fopen($path, "w");
        fwrite($myfile, $campaignCode);
        fclose($myfile); // writing to file ans saving path in database
        $sqlInsertData = "INSERT INTO CAMPAIGN(campaignName, campaignCode, campaignExpiry) VALUES ('$campaignName', '$path', '$dateto');"; // inserting data 

        $this->mail->createSQL($sqlInsertData, "Inserted successfully in table campaign $path", 'Cannot insert data in table campaign');

        $sqlCreateCampaignTable = "CREATE TABLE IF NOT EXISTS  $campaignName (c_id int not null auto_increment, cust_id int, dataSent boolean default false, primary key(c_id), foreign key(cust_id) references customerdata(cust_id));"; // creating table campaigndata

        $inserted = $this->mail->createSQL($sqlCreateCampaignTable, 'Table ' . $campaignName . ' has successfully been created', 'Cannot create table campaignName'); // create


            // need to insert data into table


            // $customers = array();

        if ($inserted == true) { // value is true, then insert all customer into that campaign
            $sqlInsertInto = "INSERT INTO  $campaignName (cust_id) SELECT cust_id FROM customerdata WHERE acceptAdvertised = true;";


            $this->mail->createSQL($sqlInsertInto, 'SUCCESSFULY INSERTED DATA INTO' . $campaignName, 'CANNOT INSERT DATA INTO' . $campaignName); // inserting data

            $this->sendAllCustomersWhoHasAgreed();
        
        }

            // $customer = $this->mail->fetchCustomer('cust_id', 'WHERE acceptAdvertised = true;', 'customerdata'); // searching for customers where customer agreed to receive advertisement from company






    }


    private function sendAllCustomersWhoHasAgreed()
    {

        try {

            $sqlSearch = "";
            $todayDate = date('Y-m-d'); // getting todays date

            $campaignRows = $this->mail->fetchCustomer("campaignName", "WHERE campaignExpiry > '$todayDate';", "CAMPAIGN"); // getting all campaign whoch are not expired

            foreach ($campaignRows as $campName) {
                // selecting all campaigns and sending data

                // $campaignCustomerName = $this->mail->fetchCustomer("")
                $sqlSearch = 
                // "SELECT CUSTOMERDATA.cust_name, CUSTOMERDATA.cust_email FROM CUSTOMERDATA 
                // INNER JOIN $campName ON CUSTOMERDATA.cust_id = $campName.cust_id 
                // WHERE $campName.dataSent = false;"; // customers name who has not yet received the mail

                $rowArray = $this->mail->fetchNewCustomer('CUSTOMERDATA.cust_name', 'CUSTOMERDATA.cust_email', "INNER JOIN $campName ON CUSTOMERDATA.cust_id = $campName.cust_id 
                WHERE $campName.dataSent = false;", 'CUSTOMERDATA'); // getting customer name and emails

                $campCode = $this->mail->fetchCustomer('campaignCode', "WHERE campaignName = '$campName';", "CAMPAIGN"); //fetching campaign name code


                $campCode = $campCode[0]; // getting path of file

                $campaignHtmlCode = $this->readFile($campCode); // getting campaign code

                foreach ($rowArray as $customer) {
                    $customer_name = $customer['cust_name'];
                    $customer_email = $customer['cust_email'];



                    // public function sendMailToPerson($name, $email, $htmlCode, $subject){
                    $this->mail->sendMailToPerson($customer_name, $customer_email, $campaignHtmlCode, "TESTING HOUSEMASTERS"); // sending mail

                }

                //using php mailer to send data
            }


        } catch (Exception $e) {

        }
    }

    private function readFile($path)
    {
        try {

           
            $myfile = fopen($path, "r");
            $code = fread($myfile, filesize($path));
           
            fclose($myfile);
            return $code;
        } catch (Exception $e) {

            return 'null';
        }
    }
}










?>