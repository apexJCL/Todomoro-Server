<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 28/03/17
 * Time: 08:44 PM
 */

namespace frontend\controllers\rest\v1;


use frontend\models\Task;
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


    public function actionIndex($token)
    {
        return Task::all($token);
    }


}