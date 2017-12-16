<?php
/* @var $this yii\web\View */
/* @var $user \frontend\models\User */
/* @var $picture \frontend\models\PictureUpload */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="row">
    <div class="col col-md-5">
        <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->field($user, 'username'); ?>

        <?php echo $form->field($user, 'nickname'); ?>

        <?php echo $form->field($user, 'type'); ?>

        <?php echo $form->field($user, 'about')->textarea(['row' => 100]); ?>

        <?php echo $form->field($picture, 'picture')->fileInput(['maxlength' => true]); ?>
        <br>
        <br>
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-info']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>

