<?php

    // display dates related to proposed law at Chilean senado
    require_once('JunarApi.php');

    # get an auth_key at www.junar.com/developers/
    $authkey = 'yourauthkey';
    $junarAPIClient = new Junar($authkey);

    $guid = 'CONGR-DE-LA-PROYE-PUBLI';

    // the guid (identificator)
    $datastream = $junarAPIClient->datastream($guid);

    // the parameters are the date in chilean format
    $response = $datastream->invoke($params = array('01/01/2011', '01/12/2011'), $output = 'json_array');
    $result = $response['result'];

    // iterating the response and printing it
    foreach ($result as $row)
    {
        echo "$row[4] -> $row[1]\n";
    }
?>