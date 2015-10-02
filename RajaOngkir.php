<?php
/**
 * RajaOngkir Library
 * @author      Dony Wahyu Isp
 * @copyright   2015 Dony Wahyu Isp
 * @link        http://github.com/dnaextrim/rajaongkir_php
 * @license     MIT
 * @version     0.1.1
 * @package     RajaOngkir
 */
class RajaOngkir {
    private $url = "http://rajaongkir.com/api/";
    private $api_key="";
    private $curl;
    private $curl_opt = array();

    private $callback;

    /**
     * Constructor for Class Raja Ongkir
     * @param string $api_key API Key from RajaOngkir.com
     */
    public function __construct($api_key) {
        $this->curl = curl_init();
        $this->api_key = $api_key;

        $this->curl_opt = array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: ".$this->api_key
            ),
        );
    }

    /**
     * Execution RajaOngkir API
     * @param  string $type           account type from RajaOngkir [Starter, Basic, Pro]
     * @param  string $command        API Commands
     * @param  string $id             id/parameter for API Commands
     * @param  string $request_method Request Method [GET, POST]
     * @return object                 $res->error, $res->response
     */
    private function exec($type, $command, $id, $request_method="GET") {

        $this->curl_opt[CURLOPT_CUSTOMREQUEST] = "GET";
        unset($this->curl_opt[CURLOPT_POSTFIELDS]);
        $this->curl_opt[CURLOPT_HTTPHEADER] = array(
            "key: ".$this->api_key
        );

        switch ($command) {
            case 'cost':
                $params = $id;
                $id = "";
            break;
        }

        

        if (isset($params)) {
            $this->curl_opt[CURLOPT_CUSTOMREQUEST] = "POST";
            if (is_array($params)) {
                $post_fields = array();
                while(list($id, $value) = each($params)) 
                    array_push($post_fields, "$id=$value");

                $params = implode('&', $post_fields);
            }
            $this->curl_opt[CURLOPT_POSTFIELDS] = $params;
            $this->curl_opt[CURLOPT_HTTPHEADER] = array(
                "content-type: application/x-www-form-urlencoded",
                "key: ".$this->api_key
            );
        }

        if ($type == 'pro') {
            $url = $this->url;
            $this->url = $this->url = "http://pro.rajaongkir.com/api/";
        }
        $this->curl_opt[CURLOPT_URL] = $this->url.$type.'/'.$command.$id;
        // print_r($this->curl_opt);
        curl_setopt_array($this->curl, $this->curl_opt);
        if ($type == 'pro')
            $this->url = $url;

        $res = array();
        $res['response'] = curl_exec($this->curl);
        $res['error'] = curl_error($this->curl);

        curl_close($this->curl);
        
        if (!$res['error']) {
            $res['response'] = json_decode($res['response']);
            $res['response'] = $res['response']->rajaongkir;
        }
        return (object) $res;
    }

    /**
     * Province API
     * @param  int              $id       id of province
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     */
    public function province($id, $callback=null, $error=null) {

        if (is_callable($id)) {
            $callback = $id;
            $id = "";
        } else {
            if (empty($id))
                $id = "";
            else
                $id = "?id=$id";
        }

        $res = $this->exec('starter', 'province', $id, "GET");

        if ($res->error) {
            if (is_callable($error))
                return $error($res->error);
            else
                echo "cURL Error #:" . $res->error;
        } else {
            $callback = \Closure::bind($callback, $this, get_class());
            return $callback($res->response);
        }
    }


    /**
     * City API
     * @param  int              $province province id
     * @param  int              $id       id of city
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     */
    public function city($province, $id, $callback=null, $error=null) {

        if (is_callable($id)) {
            $callback = $id;
            $id = "";
        } else {
            if (empty($id))
                $id = "?id=&province=$province";
            else
                $id = "?id=$id&province=$province";
        }

        $res = $this->exec('starter', 'city', $id, "GET");

        if ($res->error) {
            if (is_callable($error))
                return $error($res->error);
            else
                echo "cURL Error #:" . $res->error;
        } else {
            $callback = \Closure::bind($callback, $this, get_class());
            return $callback($res->response);
        }

    }

    /**
     * Cost API
     * @param  array/string     $params     post data
     * @param  Closure/function $callback   callback after execution API
     * @param  Closure/function $error      error message after execution API
     * @return Object           Data Response from RajaOngkir
     */
    public function cost($params, $callback=null, $error=null) {
        $res = $this->exec('starter', 'cost', $params, "POST");

        if ($res->error) {
            if (is_callable($error))
                return $error($res->error);
            else
                echo "cURL Error #:" . $res->error;
        } else {
            $callback = \Closure::bind($callback, $this, get_class());
            return $callback($res->response);
        }
    }

    /**
     * Internasional Origin API
     * @param  int              $province province id
     * @param  int              $id       id of province
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     */
    public function internasional_origin($province, $id, $callback=null, $error=null) {

        if (is_callable($id)) {
            $callback = $id;
            $id = "";
        } else {
            if (empty($id))
                $id = "?id=&province=$province";
            else
                $id = "?id=$id&province=$province";
        }

        $res = $this->exec('basic', 'internationalOrigin', $id, "GET");

        if ($res->error) {
            if (is_callable($error))
                return $error($res->error);
            else
                echo "cURL Error #:" . $res->error;
        } else {
            $callback = \Closure::bind($callback, $this, get_class());
            return $callback($res->response);
        }

    }

    /**
     * Internasional Destination API
     * @param  int              $id       id of province
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     */
    public function internasional_destination($id, $callback=null, $error=null) {

        if (is_callable($id)) {
            $callback = $id;
            $id = "";
        } else {
            if (empty($id))
                $id = "";
            else
                $id = "?id=$id";
        }

        $res = $this->exec('basic', 'internationalDestination', $id, "GET");

        if ($res->error) {
            if (is_callable($error))
                return $error($res->error);
            else
                echo "cURL Error #:" . $res->error;
        } else {
            $callback = \Closure::bind($callback, $this, get_class());
            return $callback($res->response);
        }
    }

    /**
     * International Cost API
     * @param  array/string     $params   post data
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     */
    public function internasional_cost($params, $callback=null, $error=null) {
        $res = $this->exec('basic', 'internationalCost', $params, "POST");

        if ($res->error) {
            if (is_callable($error))
                return $error($res->error);
            else
                echo "cURL Error #:" . $res->error;
        } else {
            $callback = \Closure::bind($callback, $this, get_class());
            return $callback($res->response);
        }
    }

    /**
     * Currency API
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     */
    public function currency(Closure $callback, $error=null) {
        $res = $this->exec('basic', 'currency', '', "GET");

        if ($res->error) {
            if (is_callable($error))
                return $error($res->error);
            else
                echo "cURL Error #:" . $res->error;
        } else {
            $callback = \Closure::bind($callback, $this, get_class());
            return $callback($res->response);
        }
    }

    /**
     * Waybill API
     * @param  array/string     $params   post data
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     */
    public function waybill($params, $callback=null, $error=null) {
        $res = $this->exec('basic', 'waybill', $params, "POST");

        if ($res->error) {
            if (is_callable($error))
                return $error($res->error);
            else
                echo "cURL Error #:" . $res->error;
        } else {
            $callback = \Closure::bind($callback, $this, get_class());
            return $callback($res->response);
        }
    }

    /**
     * Subdistrict API
     * @param  int              $id       id of city
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     */
    public function subdistrict($id, $callback=null, $error=null) {
        
        if (is_callable($id)) {
            $callback = $id;
            $id = "";
        } else {
            if (empty($id))
                $id = "";
            else
                $id = "?city=$id";
        }

        $res = $this->exec('pro', 'subdistrict', $id, "GET");

        if ($res->error) {
            if (is_callable($error))
                return $error($res->error);
            else
                echo "cURL Error #:" . $res->error;
        } else {
            $callback = \Closure::bind($callback, $this, get_class());
            return $callback($res->response);
        }
    }

}