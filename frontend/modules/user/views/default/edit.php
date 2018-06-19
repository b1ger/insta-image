<?php
/* @var $this yii\web\View */
/* @var $updateForm \frontend\modules\user\forms\UserUpdateForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update user';

?>

<div class="row margin-bottom-xl">
  <div class="col col-md-5">
    <?php $form = ActiveForm::begin(); ?>

      <?php echo $form->field($updateForm, 'first_name')->input('text')->label('First name'); ?>

      <?php echo $form->field($updateForm, 'last_name')->input('text')->label('Last name'); ?>

      <?php echo $form->field($updateForm, 'nickname')->input('text')->label('Nickname'); ?>

      <?php echo $form->field($updateForm, 'email')->input('email')->label('Email'); ?>

      <?php echo $form->field($updateForm, 'about')->textarea(['row' => 100]); ?>

      <?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>

      <?php ActiveForm::end(); ?>
  </div>
</div>
