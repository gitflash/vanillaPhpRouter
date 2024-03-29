<?php 
namespace Routing\Router;
class Router
{
    /**
     * TODO:
     * Add getters / setters
     * Improve _dispatchRequest
     * Add post request body management
     * Complete list of headers in the _result function 
     */
    
    /**
     * $allowed_http_requests 
     *
     * @var array
     */
    protected $allowed_http_requests = ['GET', 'POST', 'PATCH' , 'DELETE'];

    /**
     * $request_method_mapping
     *
     * @var array
     */
    protected $request_method_mapping = [
        'GET' => 'get',
        'POST' => 'create',
        'PATCH' => 'update',
        'DELETE' => 'delete'
    ];

    /**
     * $request_method
     *
     * @var string
     */
    protected $request_method;

    /**
     * $instance
     *
     * @var object
     */
    protected $instance;

    /**
     * $class
     *
     * @var string
     */
    protected $class;

    /**
     * $method_arguments
     *
     * @var array
     */
    protected $method_arguments;

    /**
     * $uri_segments
     *
     * @var array
     */
    protected $uri_segments;


    public function __construct() {
        $this->request_method = $_SERVER['REQUEST_METHOD'];
        $this->start();
    }

    public static function resource($class) {
        
        $class = implode('', array_map( function ($item) {
            return ucfirst($item);
        },explode('.',$class))) . 'Controller';
    
        // Experiencing challenge to load the controller folder from the composer package   
        if (file_exists( __DIR__ . '/../../../../../controller/' . $class . '.php')) {
            require_once __DIR__ . '/../../../../../controller/' . $class . '.php';
        } elseif (file_exists( __DIR__ . '/../../../testproject/controller/'. $class . '.php' )) {
            require_once  __DIR__ . '/../../../testproject/controller/'. $class . '.php';
        } else {
            echo "Controller not found";
            die;
        }   
    }

    public function start() {
        Self::_checkRequest();
        Self::_parseUrlSegments();
        Self::_instance();
        Self::_dispatchRequest();
        Self::result();
    }

    private function _checkRequest() {
        if (!in_array($this->request_method, $this->allowed_http_requests)) die('Http Request not allowed');
    } 

    private function _instance() {
        $this->instance = new $this->class;
    }

    private function _parseUrlSegments() {
        $this->uri_segments = explode('/',trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
        Self::_prepArguments();
        Self::_prepClass();
    }

    private function _prepArguments() {
        $this->method_arguments = array_filter($this->uri_segments, function($index) {return $index & 1;} ,ARRAY_FILTER_USE_KEY);
    }

    private function _prepClass() {
        $this->class = implode('', array_map(function($item) { return ucfirst($item); },array_filter($this->uri_segments, function($index) {return !($index & 1);} ,ARRAY_FILTER_USE_KEY))). 'Controller';
    }

    private function _dispatchRequest() {
        // Definitely a refactoring need here
        if ($this->request_method === "GET" && (count($this->method_arguments) === 0 OR count($this->uri_segments) === 3)) {
            // index 
            $this->result = call_user_func_array(array($this->instance, 'index'), $this->method_arguments); 
        } else {
            // non index
            $this->result = call_user_func_array(array($this->instance, $this->request_method_mapping[$this->request_method]), $this->method_arguments); 
        }
    }

    private function result() {
        header('Content-Type: application/json');
        echo json_encode($this->result);
    }
}