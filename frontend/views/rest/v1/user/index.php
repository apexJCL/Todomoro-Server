<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 26/03/17
 * Time: 06:00 PM
 * @var $this \yii\web\View
 * @var $model \common\models\rest\User
 */
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'email') ?>

<?php ActiveForm::end() ?>
