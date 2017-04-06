<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 26/03/17
 * Time: 05:39 PM
 */

namespace frontend\controllers\rest\v1;


use common\models\rest\responses\error\ErrorResponse;
use common\models\rest\User;
use common\models\rest\UserLogin;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{

    public $enableCsrfValidation = false;


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'signup' => ['POST'],
                    'login' => ['POST']
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


    public function actionIndex()
    {
        return $this->render('index', [
            'model' => new User()
        ]);
    }


    public function actionSignup()
    {
        $model = new User();
        if ($model->loadFromPost(\Yii::$app->request->bodyParams)){
            return $model->signUp();
        }
        return new ErrorResponse('eror loading model', var_dump($model->errors));
    }

    public function actionLogin()
    {
        $model = new UserLogin();
        return $model->login();
    }

}