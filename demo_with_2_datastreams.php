<?php

    // display dates related to proposed law at Chilean senado
    require_once('JunarApi.php');

    # get an auth_key at www.junar.com/developers/
    $authkey = 'yourauthkey';
    $junarAPIClient = new Junar($authkey);

    $datastream = $junarAPIClient->datastream('SEGUR-EN-TASA-DE-DENUN');
    $response = $datastream->invoke($params = array(), $output = 'json_array');

    // creating new data =)
    $myNewData = array();
    $myNewData[0] = $response['result'][3];
    $myNewData[1] = $response['result'][4];

    sleep(5);

    $datastream = $junarAPIClient->datastream('SEGUR-EN-TASA-DE-DETEN');
    $response = $datastream->invoke($params = array(), $output = 'json_array');

    $myNewData[2] = $response['result'][4];

    // "printing" our csv
    foreach ($myNewData as $row)
    {
        $newCSVRow = array();
        foreach ($row as $cell) {
            $newCSVRow[] = '"' . $cell . '"';
        }

        echo join(',', $newCSVRow) . "\n";
    }

?>
