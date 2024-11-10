<?php
    class Request {
        public $body = null;
        public $params = null;
        public $query = null;
		
        public function __construct() {
            try {
                $this->body = json_decode(file_get_contents('php://input'));
            }
            catch (Exception $e) {
                $this->body = null;
            }
            $this->query = (object) $_GET;
        }
    }