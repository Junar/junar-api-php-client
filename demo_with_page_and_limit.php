<?php

    // display dates related to proposed law at Chilean senado
    require_once('JunarApi.php');

    # get an auth_key at www.junar.com/developers/
    $authkey = 'yourauthkey';
    $junarAPIClient = new Junar($authkey);

    $datastream = $junarAPIClient->datastream('FARM-CROP-PRICE-BY-PARRI');
    $response = $datastream->invoke($params = array('CLARENDON'), $output = '', $page = 0, $limit = 10);
    $result = $response['result'];
    foreach ($result as $row) {
        print_r($row);
    }

?>
