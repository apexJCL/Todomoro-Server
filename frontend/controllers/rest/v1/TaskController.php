<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 28/03/17
 * Time: 08:44 PM
 */

namespace frontend\controllers\rest\v1;

use common\models\rest\Task;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class TaskController
 *
 * Controller for REST API. Route is /rest/v1/task
 *
 * @package frontend\controllers\rest\v1
 */
class TaskController extends Controller
{

    public $enableCsrfValidation = false;


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET']
                ]
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Returns all the tasks
     *
     * @param $token
     * @return \common\models\rest\responses\error\ErrorResponse|static[]
     */
    public function actionIndex($token)
    {
        return Task::all($token);
    }

    /**
     * Creates a new task object and returns the same object, with updated
     * id for referencing on future updates
     * @param $token
     * @return Task
     */
    public function actionCreate($token)
    {
        return Task::create($token);
    }

    /**
     * Returns how many register does exist for the current user
     *
     * @param $token
     * @return \common\models\rest\responses\error\ErrorResponse|int|string
     */
    public function actionCount($token)
    {
        return Task::count($token);
    }

}