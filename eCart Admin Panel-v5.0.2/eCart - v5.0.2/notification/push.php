<?php

class Push
{
    //notification title
    private $title;

    //notification message 
    private $message;

    //notification image url 
    private $image;

    //type of notification ex: default / category / product 
    private $type;

    //ID of the type ex: category_id / product_id 
    private $id;

    //return message response  
    private $message_res;

    //initializing values in this constructor
    function __construct($title, $message, $image, $type, $id, $message_res = '')
    {
        $this->title = $title;
        $this->message = $message;
        $this->image = $image;
        $this->type = $type;
        $this->id = $id;
        $this->message_res = $message_res;
    }

    //getting the push notification
    public function getPush()
    {
        $res = array();
        $res['data']['title'] = $this->title;
        $res['data']['message'] = $this->message;
        $res['data']['image'] = $this->image;
        $res['data']['type'] = $this->type;
        $res['data']['id'] = $this->id;
        $res['data']['message_res'] = $this->message_res;

        return $res;
    }
}
