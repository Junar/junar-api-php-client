<?php
    // prettyjson and xml demo
    require_once('JunarApi.php');

    # get an auth_key at www.junar.com/developers/
    $authkey = 'yourauthkey';
    $junarAPIClient = new Junar($authkey);
    $datastream = $junarAPIClient->datastream('CURRE-AGAIN-USD-FULL-LIST');
    $response = $datastream->invoke(array(), $output = 'prettyjson');
    $result = $response['result'];

    // iterating the response and printing it
    foreach ($result as $row)
    {
        print_r($row);
    }

    $response = $datastream->invoke(array(), $output = 'xml');
    echo $response

?>
