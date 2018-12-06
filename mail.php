<?php

require 'sendingMail.php';
class database
{


    private $sendMail;
    private $servername;
    private $userName;
    private $pass;
    private $conn;

    private $newConn;



    function __construct()
    {


            // connecting to the database

        $this->servername = "localhost";
        $this->userName = "root";
        $this->pass = "";

        $this->sendMail = new sendingMail();



        try {
            $conn = new mysqli($this->servername, $this->userName, $this->pass);
            
            // Check connection


            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            echo "Connected successfully";


            $sql = "CREATE DATABASE IF NOT EXISTS testHouse";
           
            // $this->createSQL($sql, 'Database has been created successfully', 'Error cannot create database..');

            if ($conn->query($sql) === true) {
                echo "Database created successfully";
            } else {
                echo "Error creating database: " . $conn->error;
            }

            $conn->close();




        } catch (Exception $e) {
            echo 'Error : ' . $e;
        }




    }

    public function close(){
        $this->newConn->close();
    }

    public function initialize()
    {
        $this->newConn = $this->getConnection(); // getting connection

    }
    public function getString()
    {
        return $this->servername;
    }


    public function getConnection()
    {
        try {


            $connection = new mysqli($this->servername, $this->userName, $this->pass, "testHouse");

            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
                return null;
            }

            return $connection;
        } catch (Exception $e) {

            return null;
        }
    }

    private $cust_id;

    public function createSQL($sql, $successMessage, $errorMessage)
    { // creating table


        if ($this->newConn->query($sql) === true) {
            echo $successMessage;
            $this->cust_id = $this->newConn->insert_id; // getting user last id

            return true;
        } else {
            echo $errorMessage . $this->newConn->error;
            return false;
        }


    }



    public function saveData($name, $email, $message, $acceptBeingAdvertised)
    {


        try {

            // creating table for saving the data

            

            // creating table
            $sqlCreateTable = 'CREATE TABLE IF NOT EXISTS CUSTOMERDATA(cust_id int not null auto_increment, cust_name varchar(255), cust_email text, cust_message text, acceptAdvertised boolean, primary key(cust_id));';
        
            // echo '<br>SqlINset : ' .$sqlCreateTable;
            $gotSuccess = $this->createSQL($sqlCreateTable, 'Table CUSTOMERDATA HAS SUCCESSFULLY BEEN CREATED..', 'CANNOT CREATE TABLE');

            // $sqlInsert = 'INSERT INTO CUSTOMERDATA(cust_name, cust_email, cust_message, acceptAdvertised) VALUES(\'' . $name . '\', \'' . $email . '\', \'' . $message . '\', ' . $acceptBeingAdvertised . ');';

            $sqlInsert = "INSERT INTO CUSTOMERDATA(cust_name, cust_email, cust_message, acceptAdvertised) VALUES('$name' , '$email','$message', $acceptBeingAdvertised );";


           // echo '<br>Boolean : ' . ($acceptBeingAdvertised) . '<br>';
            // echo '<br>$sqlInsert : ' . $sqlInsert . '<br> Accept : ' . (bool)$acceptBeingAdvertised;
            $this->createSQL($sqlInsert, 'Data inserted successfully', 'Data cannot be insert');


            $customer_id = $this->cust_id;
            // // need to enter id into campaign table

            $rowsCampaign = array();

            $todayDate = date('Y-m-d');
            if ($acceptBeingAdvertised == 'true') { // customer has agreed to get advertised
                $rowsCampaign = $this->fetchCustomer("campaignName", "WHERE campaignExpiry > '$todayDate';", "CAMPAIGN"); // fetching campaigns

                if (count($rowsCampaign) > 0) {
                // means that there is campaign and can insert customer

                    foreach ($rowsCampaign as $campaign) {
                    // inserting id in campaign

                        $sqlInsert = "INSERT INTO $campaign(cust_id, dataSent) VALUES($customer_id, false);"; // inserting id into customer name
                        // inserting customer id into campagins
                        $this->createSQL($sqlInsert, 'Success : ' . $name . ' into table ' . $campaign, 'Cannot insert name : ' . $name . ' into table : ' . $campaign);


                    }
                }
            }

        } catch (Exception $e) {

            echo 'Error in saveData : ' . $e;
        }
    }


    public function fetchCustomer($columnName, $condition, $tableName)
    {

        $sqlSearch = 'SELECT ' . $columnName . ' FROM ' . $tableName . ' ' . $condition;
        echo '<br>SQL : ' .$sqlSearch;
        $result = $this->newConn->query($sqlSearch);


        $rows = array();

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row[$columnName];
        }


        return $rows;
    }

    public function fetchNewCustomer($col1, $col2, $condition, $table){

        $sqlSearch = "SELECT  $col1, $col2  FROM   $table   $condition";
        print ('SQL : ' .$sqlSearch);
        $result = $this->newConn->query($sqlSearch);


        $rows = array();

        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;

    }


    public function sendMailToPerson($name, $email, $htmlCode, $subject){

        // recipientEmail, $recipientName, $subject, $body, $altbo
        echo 'INside';
        $this->sendMail->sendMail($email, $name, $subject, $htmlCode, "HTML CODE CANNOT BE RENDERED"); // sending mail

    }



}






?>