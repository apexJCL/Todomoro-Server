<?php

namespace frontend\controllers;

class JwtController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
