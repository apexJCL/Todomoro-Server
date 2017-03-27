<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 26/03/17
 * Time: 05:50 PM
 */

namespace common\models\rest;


use yii\base\Model;

/**
 * Class User
 *
 * This model describes the data that can be received/sent by the REST API.
 *
 *
 *
 */
class User extends Model
{

    public $username;
    public $first_name;
    public $last_name;
    public $password;
    public $email;

    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name', 'password', 'email'], 'required'],
            [['username', 'first_name', 'last_name', 'password', 'email'], 'string'],
        ];
    }


    public function formName()
    {
        return "user";
    }

    public function authKeys()
    {
        return [
            'status' => 'ok',
            'token' => '123abc:D'
        ];
    }

}