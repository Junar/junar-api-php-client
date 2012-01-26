<?php

class Junar {
    /**
     * Base class, contains the configuration
     */

    private $authkey  = '';
    private $baseUri  = 'http://apisandbox.junar.com';

    public function __construct($authkey, $baseUri = 'http://apisandbox.junar.com')
    {
        $this->authkey = $authkey;
        $this->baseUri = $baseUri;
    }

    public function datastream($guid)
    {
        /**
         * Creates a datastream object.
         *
         * @param string $guid the guid of the datastream
         */

        return new DataStream($guid, $this->authkey, $this->baseUri);
    }
}

class DataStream {

    private $guid     = '';
    private $authkey  = '';
    private $baseUri  = 'http://apisandbox.junar.com';
    private $response = null;
    private $output   = '';

    public function __construct($guid, $authkey, $baseUri = 'http://apisandbox.junar.com')
    {
        /**
        * It can be used to invoke a datastream (that means, to get its data), and to get metada about it
        *
        * @param string guid the guid of the datastream
        * @param string auth_key your auth_key to access the API
        * @param string base_uri the base uri of the API
        */

        $this->guid = $guid;
        $this->authkey = $authkey;
        $this->baseUri = $baseUri;
    }

    public function invoke($params = array(), $output = '', $page = null, $limit = null)
    {
        /**
         * Gets the datastream's data.
         *
         * @param array params an array of the parameters, (parameters are positional)
         * @param string output the format in which the document will be returned
         *        for default junar json leave output blank, its structure is explained
         *        here http://wiki.junar.com/index.php/API#JSON_Structure
         *        other options are:
         *         - prettyjson use this, with the collect tool at www.junar.com,
         *                      by enabling the advanced mode, and select "Add aliases", then follow the instructions
         *         - json_array, basic javascript array of arrays, in python a list of lists
         *         - csv
         *         - tsv
         *         - excel
         *         - xml, prettyjson sister, configuration here is not mandatory
         * @param int page the page number of the data, use in combination with limit
         * @param int limit the limit of the data to return, use in combination with page
         */

        if ($this->authkey == '')
        {
            throw new Exception('Please configure your auth_key, get one at http://www.junar.com/developers/');
        }

        $query = array('auth_key' => $this->authkey);

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

        if (!is_null($page) && !is_null($limit) ) {
            $query['page'] = $page;
            $query['limit'] = $limit;
        }

        $url = "/datastreams/invoke/{$this->guid}?" . http_build_query($query);
        return $this->__callURI($url);
    }

    public function info()
    {
        /**
         * Gets the datastream's metadata.
         */

        // create the URL
        $url = "/datastreams/{$this->guid}?auth_key={$this->authkey}";
        return $this->__callURI($url);
    }

    public function __callURI($url) {
        // get the url
        // you could also use cURL here, it has better performance but i dont
        // know if you have cURL installed
        $response = file_get_contents($this->baseUri . $url);

        // parsing the content
        if (in_array($this->output, array('', 'prettyjson', 'json_array'))) {
            $this->response = @json_decode($response, true);
        } else {
            $this->response = $response;
        }

        return $this->response;
    }
}
?>
