<?php


class Request
{
    public function __construct($body)
    {
        $this->body         = $body;
        $this->parsed_body  = $body ? json_decode($body) : [];
        $this->params       = [];

        $this->args         = NULL;
        $this->payload  = NULL;

        //Data to pass between middleware use it like this: $req->mw_data->user_level = 1
        $this->mw_data      = new ArrayObject([]);
        $this->mw_data->setFlags(ArrayObject::ARRAY_AS_PROPS);
    }

    public function append_url_parameters($parameter_values)
    {
        $this->params = array_merge($this->params, $parameter_values);
        $this->args = new ArrayObject($this->params);
        $this->args->setFlags(ArrayObject::ARRAY_AS_PROPS);
        $this->payload = new ArrayObject($this->parsed_body);
        $this->payload->setFlags(ArrayObject::ARRAY_AS_PROPS);
    }

}