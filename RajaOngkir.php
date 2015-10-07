<?php
/**
 * RajaOngkir Library
 * @author      Dony Wahyu Isp
 * @copyright   2015 Dony Wahyu Isp
 * @link        http://github.com/dnaextrim/rajaongkir_php
 * @license     MIT
 * @version     0.1.5
 * @package     RajaOngkir
 */
class RajaOngkir {
    private $url = "http://rajaongkir.com/api/";
    private $api_key="";
    private $curl;
    private $curl_opt = array();

    private $response = null;
    private $error = null;



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
        $this->response = null;
        $this->error = null;

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
        
        curl_setopt_array($this->curl, $this->curl_opt);
        if ($type == 'pro')
            $this->url = $url;

        $res = array();
        $res['response'] = curl_exec($this->curl);
        $res['error'] = curl_error($this->curl);

        curl_close($this->curl);
        $this->curl = curl_init();

        if (!$res['error']) {
            $res['response'] = new RajaOngkirResponse($res['response']);
        }

        if ($res['response']->status->code != 200) {
            $res['error'] = $res['response']->status->description;
        }
        return (object) $res;
    }

    /**
     * Success Callback Set
     * @param  Closure $callback 
     * @return $this   for caining          
     */
    public function success(Closure $callback) {
        if (!$this->error) {
            $callback = \Closure::bind($callback, $this, get_class());
            $this->response = $callback($this->response);
        }
        return $this;
    }

    /**
     * Error Callback Set
     * @param  Closure $callback
     * @return $this   for caining
     */
    public function error(Closure $callback) {
        if ($this->error)
            $callback($this->error);
        return $this;
    }

    /**
     * For Non Callback
     * @return array(object)/false
     */
    public function get() {
        if (!$this->error)
            return $this->response;
        else
            return false;
    }

    /**
     * Read data per row
     * @param  string/Closure $field
     * @param  Closure        $callback
     *
     * $RO = new RajaOngkir($api_key);
     * $RO->province($id)->each(function($row) {
     *     print_r($row);
     * });
     *
     * OR using selecting data results
     * $RO->province($id)->each('results', function($row) {
     *         print_r($row);
     *     })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     */
    public function each($field, $callback=null) {
        if (!$this->error) {
            $rows = $this->response;
            
            if (is_callable($field))
                $callback = $field;
            else
                $rows = $rows->$field;
            // print_r($rows);
            foreach ($rows as $key => $value) {
                $this->response = $callback($value);
            }
        }

        return $this;
    }
    /**
     * Province API
     * @param  int              $id       id of province
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     *
     * @example
     * $RO = new RajaOngkir($api_key);
     * $RO->province($id)
     *    ->success(function($data) {
     *        print_r($data);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     *
     * OR
     * $RO->province($id, function($data) {
     *     print_r(data);
     * }, function($msg) {
     *     echo $msg;
     * });
     *
     * OR
     * $res = $RO->province($id)->get();
     * print_r($res);
     *
     * OR
     * $RO->province($id)
     *    ->each(function('results', $row) {
     *        print_r($row);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     */
    public function province($id="", $callback=null, $error=null) {
        if (empty($id)) $id="";

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

        if (is_callable($error))
            $error($res->error);

        if (is_callable($callback)) {
            $callback = \Closure::bind($callback, $this, get_class());
            $callback($res->response);
        }

        $this->response = $res->response;
        $this->error = $res->error;
        return $this;
    }


    /**
     * City API
     * @param  int              $province province id
     * @param  int              $id       id of city
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     *
     * @example
     * $RO = new RajaOngkir($api_key);
     * $RO->city($province, $id)
     *    ->success(function($data) {
     *        print_r($data);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     *
     * OR
     * $RO->city($province, $id, function($data) {
     *     print_r($data);
     * }, function($msg) {
     *     echo $msg;
     * });
     * 
     * OR
     * $res = $RO->city($province, $id)->get();
     * print_r($res);
     *
     * OR
     * $RO->city($province, $id)
     *    ->each(function('results', $row) {
     *        print_r($row);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     */
    public function city($province, $id="", $callback=null, $error=null) {
        if (empty($id)) $id="";

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

        if (is_callable($error))
            $error($res->error);

        if (is_callable($callback)) {
            $callback = \Closure::bind($callback, $this, get_class());
            $callback($res->response);
        }

        $this->response = $res->response;
        $this->error = $res->error;
        return $this;

    }

    /**
     * Cost API
     * @param  array/string     $params     post data
     * @param  Closure/function $callback   callback after execution API
     * @param  Closure/function $error      error message after execution API
     * @return Object           Data Response from RajaOngkir
     *
     * @example
     * $RO = new RajaOngkir($api_key);
     * $params = array(
     *     'origin'         => 501,
     *     'destination'    => 114,
     *     'weight'         => 1700,
     *     'courier'        => 'jne'
     * );
     * $RO->cost($params)
     *    ->success(function($data) {
     *        print_r($data);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     *
     * OR
     * $RO->cost($params, function($data) {
     *     print_r(data);
     * }, function($msg) {
     *     echo $msg;
     * });
     *
     * OR
     * $res = $RO->cost($id)->get();
     * print_r($res);
     *
     * OR
     * $RO->cost($id)
     *    ->each(function('results', $row) {
     *        print_r($row);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     */
    public function cost($params, $callback=null, $error=null) {
        $res = $this->exec('starter', 'cost', $params, "POST");

        if (is_callable($error))
            $error($res->error);

        if (is_callable($callback)) {
            $callback = \Closure::bind($callback, $this, get_class());
            $callback($res->response);
        }

        $this->response = $res->response;
        $this->error = $res->error;
        return $this;
    }

    /**
     * Internasional Origin API
     * @param  int              $province province id
     * @param  int              $id       id of province
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     *
     * @example
     * $RO = new RajaOngkir($api_key);
     * $RO->internationalOrigin($provice, $id)
     *    ->success(function($data) {
     *        print_r($data);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     *
     * OR
     * $RO->internationalOrigin($province, $id, function($data) {
     *     print_r($data);
     * }, function($msg) {
     *     echo $msg;
     * });
     *
     * OR
     * $res = $RO->internationalOrigin($province, $id)->get();
     * print_r($res);
     *
     * OR
     * $RO->internationalOrigin($province, $id)
     *    ->each(function('results', $row) {
     *        print_r($row);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     */
    public function internationalOrigin($province, $id, $callback=null, $error=null) {

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

        if (is_callable($error))
            $error($res->error);

        if (is_callable($callback)) {
            $callback = \Closure::bind($callback, $this, get_class());
            $callback($res->response);
        }

        $this->response = $res->response;
        $this->error = $res->error;
        return $this;
    }

    /**
     * Internasional Destination API
     * @param  int              $id       id of province
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     *
     * @example
     * $RO = new RajaOngkir($api_key);
     * $RO->internationalDestination($id)
     *    ->success(function($data) {
     *        print_r($data);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     *
     * OR
     * $RO->internationalDestination($id, function($data) {
     *     print_r($data);
     * }, function($msg) {
     *     echo $msg;
     * });
     *
     * OR
     * $res = $RO->internationalDestination($id)->get();
     * print_r($res);
     *
     * OR
     * $RO->internationalDestination($id)
     *    ->each(function('results', $row) {
     *        print_r($row);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     */
    public function internationalDestination($id, $callback=null, $error=null) {

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

        if (is_callable($error))
            $error($res->error);

        if (is_callable($callback)) {
            $callback = \Closure::bind($callback, $this, get_class());
            $callback($res->response);
        }

        $this->response = $res->response;
        $this->error = $res->error;
        return $this;
    }

    /**
     * International Cost API
     * @param  array/string     $params   post data
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     *
     * @example
     * $RO = new RajaOngkir($api_key);
     * $params = array(
     * 
     * );
     * $RO->internationalCost($params)
     *    ->success(function($data) {
     *        print_r($data);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     *
     * OR
     * $RO->internationalCost($params, function($data) {
     *     print_r($data);
     * }, function($msg) {
     *     echo $msg;
     * });
     *
     * OR
     * $res = $RO->internationalCost($params)->get();
     * print_r($res);
     *
     * OR
     * $RO->internationalCost($params)
     *    ->each(function('results', $row) {
     *        print_r($row);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     */
    public function internationalCost($params, $callback=null, $error=null) {
        $res = $this->exec('basic', 'internationalCost', $params, "POST");

        if (is_callable($error))
            $error($res->error);

        if (is_callable($callback)) {
            $callback = \Closure::bind($callback, $this, get_class());
            $callback($res->response);
        }

        $this->response = $res->response;
        $this->error = $res->error;
        return $this;
    }

    /**
     * Currency API
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     *
     * @example
     * $RO = new RajaOngkir($api_key);
     * $RO->currency()
     *    ->success(function($data) {
     *        print_r($data);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     *
     * OR
     * $RO->currency(function($data) {
     *     print_r($data);
     * }, function($msg) {
     *     echo $msg;
     * });
     *
     * OR
     * $res = $RO->currency()->get();
     * print_r($res);
     *
     * OR
     * $RO->currency()
     *    ->each(function('results', $row) {
     *        print_r($row);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     */
    public function currency($callback=null, $error=null) {
        $res = $this->exec('basic', 'currency', '', "GET");

        if (is_callable($error))
            $error($res->error);

        if (is_callable($callback)) {
            $callback = \Closure::bind($callback, $this, get_class());
            $callback($res->response);
        }

        $this->response = $res->response;
        $this->error = $res->error;
        return $this;
    }

    /**
     * Waybill API
     * @param  array/string     $params   post data
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     *
     * @example
     * $RO = new RajaOngkir($api_key);
     * $params = array(
     * 
     * );
     * $RO->waybill($params)
     *    ->success(function($data) {
     *        print_r($data);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     *
     * OR
     * $RO->waybill($params, function($data) {
     *     print_r($data);
     * }, function($msg) {
     *     echo $msg;
     * });
     *
     * OR
     * $res = $RO->waybill($params)->get();
     * print_r($res);
     *
     * OR
     * $RO->waybill($params)
     *    ->each(function('results', $row) {
     *        print_r($row);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     */
    public function waybill($params, $callback=null, $error=null) {
        $res = $this->exec('basic', 'waybill', $params, "POST");

        if (is_callable($error))
            $error($res->error);

        if (is_callable($callback)) {
            $callback = \Closure::bind($callback, $this, get_class());
            $callback($res->response);
        }

        $this->response = $res->response;
        $this->error = $res->error;
        return $this;
    }

    /**
     * Subdistrict API
     * @param  int              $id       id of city
     * @param  Closure/function $callback callback after execution API
     * @param  Closure/function $error    error message after execution API
     * @return Object           Data Response from RajaOngkir
     *
     * @example
     * $RO = new RajaOngkir($api_key);
     * $RO->subdistrict($id)
     *    ->success(function($data) {
     *        print_r($data);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
     *
     * OR
     * $RO->subdistrict($id, function($data) {
     *     print_r($data);
     * }, function($msg) {
     *     echo $msg;
     * });
     *
     * OR
     * $res = $RO->subdistrict($id)->get();
     * print_r($res);
     *
     * OR
     * $RO->subdistrict($id)
     *    ->each(function('results', $row) {
     *        print_r($row);
     *    })
     *    ->error(function($msg) {
     *        echo $msg;
     *    });
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

        if (is_callable($error))
            $error($res->error);

        if (is_callable($callback)) {
            $callback = \Closure::bind($callback, $this, get_class());
            $callback($res->response);
        }

        $this->response = $res->response;
        $this->error = $res->error;
        return $this;
    }

}

class RajaOngkirResponse implements Iterator, ArrayAccess, Countable {
    private $data;
    private $raw_data;

    private $position = 0;

    public function __construct($data) {
        $this->position = 0;
        $this->raw_data = $data;
        $this->data = json_decode($data);
        if (isset($this->data->rajaongkir))
            $this->data = $this->data->rajaongkir;
    }

    public function raw() {
        return $this->raw_data;
    }

    public function __toString() {
        if (!is_object($this->data) && !is_array($this->data))
            return $this->data;
        
        return json_encode($this->data);
    }

    public function __set($offset, $value) {
        if (!empty($offset))
            $this->data->$offset = $value;
    }

    public function __get($offset) {
        if (!is_object($this->data->$offset) && !is_array($this->data->$offset))
            return $this->data->$offset;
        
        if (!($this->data->$offset instanceof RajaOngkirResponse ))
            $this->data->$offset = new RajaOngkirResponse(json_encode($this->data->$offset));
        return (isset($this->data->$offset))? $this->data->$offset : null;
    }

    /**
     * Get Original Data
     * @return [object/array] Original Data
     */
    public function get() {
        return $this->data;
    }

    public function offsetSet($offset, $value) {
        if (!empty($offset))
            $this->data->$offset = $value;
    }

    public function offsetExists($offset) {
        return isset($this->data->$offset);
    }

    public function offsetUnset($offset) {
        unset($this->data->$offset);
    }

    public function offsetGet($offset) {
        if (!is_object($this->data->$offset) && !is_array($this->data->$offset))
            return $this->data->$offset;

        if (is_numeric($offset)) {
            if (!($this->data[$offset] instanceof RajaOngkirResponse ))
                $this->data[$offset] = new RajaOngkirResponse(json_encode($this->data[$offset]));
            return isset($this->data[$offset])? $this->data[$offset] : null;
        } else {
            if (!($this->data->$offset instanceof RajaOngkirResponse ))
                $this->data->$offset = new RajaOngkirResponse(json_encode($this->data->$offset));
            return isset($this->data->$offset)? $this->data->$offset : null;
        }

    }

    public function current() {
        return $this->data[$this->position];
    }

    public function next() {
        ++$this->position;
    }

    public function key() {
        return $this->position;
    }

    public function valid() {
        if (is_object($this->data))
            return FALSE;
        return isset($this->data[$this->position]);
    }

    public function rewind() {
        $this->position = 0;
    }

    public function count() {
        return count($this->data);
    }
}