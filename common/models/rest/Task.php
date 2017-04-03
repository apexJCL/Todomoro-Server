<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 1/04/17
 * Time: 08:57 PM
 */

namespace common\models\rest;


use common\helpers\JWTHelper;
use common\models\rest\responses\error\ErrorResponse;
use common\models\Task as TaskModel;
use yii\base\Model;

class Task extends Model
{

    public $title;
    public $description;
    public $due_date;
    public $pomodoro_cycles;
    public $done;

    public static function create($token)
    {
        $payload = JWTHelper::verify($token);
        if (!isset($payload)) {
            {
                \Yii::$app->response->statusCode = 401;
                return new ErrorResponse("tokenError", "Token has expired");
            }
        }
        $t = new self();
        if (!$t->_loadFromRequest(\Yii::$app->request->bodyParams) || !$t->validate()) {
            \Yii::$app->response->statusCode = 401;
            return new ErrorResponse("error", "There was an error saving");
        }
        return TaskModel::createFor($payload->data->user_id, $t);
    }

    private function _loadFromRequest($params)
    {
        if (!isset($params['title']))
            return false;
        if (!isset($params['due_date']))
            return false;
        $this->title = $params['title'];
        $this->description = $params['description'];
        $this->due_date = $params['due_date'];
        $this->done = $params['done'];
        $this->pomodoro_cycles = $params['pomodoro_cycles'];
        return true;
    }

    public static function count($token)
    {
        $payload = JWTHelper::verify($token);
        if (!isset($payload)) {
            \Yii::$app->response->statusCode = 401;
            return new ErrorResponse("tokenError", "Token has expired");
        }
        return TaskModel::find()->where(['user_id' => $payload->data->user_id])->count();
    }

    public function rules()
    {
        return [
            [['title', 'due_date'], 'required'],
            [['title', 'description'], 'string'],
            [['done'], 'boolean'],
            [['pomodoro_cycles'], 'integer', 'min' => 0]
        ];
    }

    public static function all($token)
    {
        $payload = JWTHelper::verify($token);
        if (!isset($payload)) {
            \Yii::$app->response->statusCode = 401;
            return new ErrorResponse("tokenError", "Token has expired");
        }
        return TaskModel::findAll(['user_id' => $payload->data->user_id]);
    }

}