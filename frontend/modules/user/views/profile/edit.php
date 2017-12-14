<?php
/* @var $this yii\web\View */
/* @var $user frontend\models\User */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($user, 'username'); ?>

    <?php echo Html::submitButton('Save', ['class' => 'btn btn-info']) ?>

<?php ActiveForm::end(); ?>
