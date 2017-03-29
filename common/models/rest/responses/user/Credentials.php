<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 27/03/17
 * Time: 10:07 AM
 */

namespace common\models\rest\responses\user;


use common\helpers\JWTHelper;
use common\models\User;

class Credentials
{

    public $token;
    public $username;
    public $first_name;
    public $last_name;

    /**
     * Creates a user credentials for REST API usage
     * Credentials constructor.
     * @param User | null $user
     */
    public function __construct($user = null)
    {
        if (!isset($user))
            return;
        // Generate token
        $issuedAt = time();
        $this->token = JWTHelper::generateToken([
            'user_id' => $user->id
        ],
            $issuedAt);
        $this->username = $user->username;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
    }


}