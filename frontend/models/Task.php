<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 30/03/17
 * Time: 09:38 AM
 */

namespace frontend\models;


use common\helpers\JWTHelper;
use common\models\rest\responses\error\ErrorResponse;

class Task extends \common\models\Task
{

    public static function all($token)
    {
        $payload = JWTHelper::verify($token);
        if (!isset($payload)) {
            \Yii::$app->response->statusCode = 401;
            return new ErrorResponse("tokenError", "Token has expired");
        }
        return self::findAll(['user_id' => $payload->data->user_id]);
    }

}