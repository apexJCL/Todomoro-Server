<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 27/03/17
 * Time: 10:03 AM
 */

namespace common\models\rest\responses\error;


class ErrorResponse
{

    public $status;
    public $message;
    public $digest;

    public function __construct($status = 'Error', $message = "There's been an error")
    {
        $this->status = $status;
        $this->message = $message;
    }

}