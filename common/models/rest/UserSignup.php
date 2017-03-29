<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 27/03/17
 * Time: 08:29 AM
 */

namespace common\models\rest;


class UserSignup extends User
{
    public function rules()
    {
        return [
            ['username', 'string'],
            ['password', 'required'],
            ['password', 'string'],
            ['email', 'string']
        ];
    }


    public function signUp()
    {
        return true;
    }

}