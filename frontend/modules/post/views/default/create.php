<?php
/* @var $this \yii\web\View */
/* @var $model \frontend\modules\post\forms\PostForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="post-default-index">

    <h1>Create post</h1>

    <?php $form = ActiveForm::begin() ?>

    <?php echo $form->field($model, 'picture')->fileInput(); ?>

    <?php echo $form->field($model, 'description'); ?>

    <?php echo Html::submitButton('Post'); ?>

    <?php ActiveForm::end(); ?>

</div>
