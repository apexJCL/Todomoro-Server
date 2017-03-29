<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 26/03/17
 * Time: 05:50 PM
 */

namespace common\models\rest;


use common\models\rest\responses\error\ErrorResponse;
use common\models\rest\responses\user\Credentials;
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

    /**
     * @var $user \common\models\User | null
     */
    private $user;

    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name', 'password', 'email'], 'required'],
            [['username', 'first_name', 'last_name', 'password', 'email'], 'string'],
        ];
    }

    public function authKeys()
    {
        return [
            'status' => 'ok',
            'token' => '123abc:D'
        ];
    }

    /**
     * Logs in a user
     */
    public function login()
    {
        if (!$this->_loadFromRequest(\Yii::$app->request->bodyParams) && !$this->validate())
            return new ErrorResponse();
        // Login
        $this->user = \common\models\User::findOne(['username' => $this->username]);
        if ($this->validatePassword())
            return new Credentials($this->user);
        return new ErrorResponse('error', 'Username or Password incorrect');
    }

    /**
     * Checks if password is valid
     *
     * @return bool
     */
    private function validatePassword()
    {
        if ($this->hasErrors())
            return false;
        if (!isset($this->user))
            return false;
        return $this->user->validatePassword($this->password);
    }

    /**
     * Loads values from bodyParams
     *
     * @param $bodyParams
     * @return bool If loaded successfully
     */
    private function _loadFromRequest($bodyParams)
    {
        if (!isset($bodyParams['username']))
            return false;
        if (!isset($bodyParams['password']))
            return false;
        $this->username = $bodyParams['username'];
        $this->password = $bodyParams['password'];
        return true;
    }

}