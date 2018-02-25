<?php

/* @var $this yii\web\View */
/* @var $commentId integer */
/* @var $postId integer */
/* @var $model \frontend\models\Comment */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="post-default-index">
    <div class="rows">
        <div class="col col-lg-6">

            <h2>Edit your comment</h2>

            <?php $form = ActiveForm::begin() ?>

            <?php echo $form->field($model, 'text')->textarea(['rows' => 10]); ?>

            <?php echo Html::submitButton('Edit', ['class' => 'btn btn-info']); ?>

            <?php echo Html::hiddenInput('postId', $postId); ?>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
