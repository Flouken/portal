<?php


class Response
{
    public function __construct()
    {
        $this->payload = new ArrayObject([]);
        $this->payload->setFlags(ArrayObject::ARRAY_AS_PROPS);
    }

    public function send($value=NULL, $http_code=200)
    {
        http_response_code($http_code);
        if($value) {
            if(gettype($value) === 'array' or 'object') {
                print(json_encode($value));
            } else {
                print($value);
            }
        } else {
            print(json_encode($this->payload));
        }
        exit;
    }
}