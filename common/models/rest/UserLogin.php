<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 27/03/17
 * Time: 09:55 AM
 */

namespace common\models\rest;


class UserLogin extends User
{
    public function rules()
    {
        return [
            [['username', 'password'], 'string'],
            [['username', 'password'], 'required']
        ];
    }

}