<?php

namespace frontend\controllers;

use common\helpers\JWTHelper;

class JwtController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGenerate()
    {
        return $this->render('generate', [
            'jwt' => JWTHelper::generateToken(
                [
                    'user_id' => \Yii::$app->user->id
                ],
                time()
            )
        ]);
    }

    public function actionCheck($token)
    {
        $result = JWTHelper::verify($token);
        return $this->render('check', [
            'result' => $result,
            'token' => $token
        ]);
    }

}
