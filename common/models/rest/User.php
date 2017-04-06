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
use common\models\UserApp;
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
    public $fbtoken;

    /**
     * @var $user \common\models\User | null
     */
    private $user;

    /**
     * @internal param \common\models\User $user
     */
    private function loginUpdate()
    {
        $user_app = UserApp::findOne(['user_id' => $this->user->id]);
        if (!isset($user_app)) {
            $user_app = new UserApp();
            $user_app->user_id = $this->user->id;
        }
        $user_app->firebase_token = $this->fbtoken;
        $user_app->save();
    }

    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name', 'password', 'email', 'fbtoken'], 'required'],
            [['username', 'first_name', 'last_name', 'password', 'email', 'fbtoken'], 'string'],
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
        if ($this->validatePassword()) {
            $this->loginUpdate();
            return new Credentials($this->user);
        }
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
        $this->fbtoken = isset($bodyParams['fbtoken']) ? $bodyParams['fbtoken'] : null;
        return true;
    }

    public function loadFromPost($params)
    {
        $attribs = get_class_vars(User::className());
        foreach ($attribs as $nombre => $valor) {
            $this->$nombre = isset($params[$nombre]) ? $params[$nombre] : null;
        }
        return $this->validate();
    }

    public function signUp()
    {
        $user = new \common\models\User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if ($user->validate() && $user->save()) {
            $userdata = new UserApp();
            $userdata->user_id = $user->primaryKey;
            $userdata->firebase_token = $this->fbtoken;
            $userdata->save();
            return new Credentials($user);
        }
        return new ErrorResponse('error', var_dump($user->errors));
    }

}