<?php

class DataStream {

    private $appkey   = 'YOUR_AUTH_KEY';
    private $guid     = '';
    private $baseURI  = 'http://apisandbox.junar.com';
    private $response = null;

    /**
     * for default junar json leave output blank, its structure is explained here http://wiki.junar.com/index.php/API#JSON_Structure
     * other options are: 
     * - prettyjson, require our help to configure it
     * - json_array, basic javascript array of arrays
     * - csv
     * - tsv
     * - excel
     */

    private $output   = '';

    public function __construct($guid)
    {
        $this->guid = $guid;
    }

    public function getGuid()
    {
        return $this->guid;
    }

    public function invoke($params = array(), $output = '')
    {
        // create the URL
        $i = 0;
        foreach ($params as $param) {
            $query["pArgument$i"] = $param;
            $i++;
        }

        if ($output != '') {
            $this->output = $output;
            $query['output'] = $output;
        }

        $query['auth_key'] = $this->appkey;
        $url = "/datastreams/invoke/{$this->guid}?" . http_build_query($query);
        return $this->callURI($url);
    }

    public function info()
    {
        // create the URL
        $url = "/datastreams/{$this->guid}?auth_key={$this->appkey}";
        return $this->callURI($url);
    }

    public function callURI($url) {
        // get the url
        // you could also use cURL here, it has better performance but i dont
        // know if you have cURL installed
        $response = file_get_contents($this->baseURI . $url);

        // parsing the content
        if (in_array($this->output, array('', 'prettyjson', 'json_array'))) {
            $this->response = @json_decode($response, true);
        }
        return $this->response;
    }
}

$ds = new DataStream('TEPCO-STOCK-QUOTE');
print_r($ds->invoke(array(), 'json_array'));
?>