<?php

/* @var $this \yii\web\View */
/* @var $post \frontend\models\Post */
/* @var $likesCount integer */
/* @var $currentUser \frontend\models\User */

use frontend\models\Comment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;

$this->title = 'images.com'

?>

<div class="post-default-index">

    <div class="row">

        <div class="col-md-12">
            <?php if ($post->user) : ?>
                <p><?php echo Html::encode($post->user->username); ?></p>
            <?php endif; ?>
        </div>

        <div class="col-md-12">
            <img src="<?php echo $post->getImage(); ?>" width="640"/>
        </div>

        <div class="col-md-12">
            <?php echo Html::encode($post->description); ?>
        </div>

    </div>

    <hr>

    <div class="col-md-12">
        Likes: <span class="likes-count"><?php echo $post->countLikes(); ?></span>

        <a href="#" class="btn btn-primary button-unlike <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "" : "display-none"; ?>" data-id="<?php echo $post->id; ?>">
            Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
        </a>
        <a href="#" class="btn btn-primary button-like <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "display-none" : ""; ?>" data-id="<?php echo $post->id; ?>">
            Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
        </a>

    </div>

    <br><br><br>

    <div class="row">

        <div class="col col-lg-6">

            <?php if ($post->hasComments($post->id)) : ?>

                <h2>Comments</h2>

                <hr>

                <?php foreach ($post->comments as $comment) : ?>

                    <p><?php echo $comment->text; ?></p>

                    <p><?php echo "by " . $comment->username . ", " . $comment->getDate(); ?></p>

                    <?php if (!Yii::$app->user->isGuest && ($comment->username == $currentUser->username)) : ?>

                        <a href="<?php echo Url::to(['../comment/edit', 'commentId' => $comment->id, 'postId' => $post->id]); ?>" class="btn btn-primary">Edit</a>

                        <a href="<?php echo Url::to(['../comment/delete', 'id' => $comment->id]); ?>" class="btn btn-danger">Delete</a>

                    <?php endif; ?>

                    <hr>

                <?php endforeach; ?>

            <?php endif; ?>

            <?php if (!Yii::$app->user->isGuest) : ?>

                <?php $form = ActiveForm::begin(); ?>

                    <?php $comment = new Comment(); ?>

                    <?php $form->action = "../comment/save"; ?>

                    <?php echo $form->field($comment, 'text')->textarea(['rows' => 4]); ?>

                    <?php echo $form->field($comment, 'username')->hiddenInput(['value' => Yii::$app->user->identity->username]); ?>

                    <?php echo $form->field($comment, 'post_id')->hiddenInput(['value' => $post->id]); ?>

                    <?php echo Html::submitButton('Comment', ['class' => 'btn btn-info']); ?>

                <?php ActiveForm::end(); ?>

            <?php endif; ?>

        </div>

    </div>

</div>


<?php $this->registerJsFile('@web/js/like.js', [
        'depends' => JqueryAsset::className(),
]);