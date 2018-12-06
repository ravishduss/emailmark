
<?php

require 'automatescript.php';
    $campaignName = $_POST['camp_name'];
    $exp_date = $_POST['exp_date'];

    // echo 'Got';
    $code = $_POST['html_code'];
    // echo 'Code : ' .$code;
    $auto = new Auto();

    // need to save html code in file
    $auto->createCampaign($campaignName, $code, $exp_date);

?>