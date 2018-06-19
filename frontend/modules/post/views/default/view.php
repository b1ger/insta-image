<?php

/* @var $this \yii\web\View */
/* @var $post \frontend\models\Post */
/* @var $likesCount integer */
/* @var $currentUser \frontend\models\User */
/* @var $commentForm \frontend\modules\post\models\forms\CommentForm */
/* @var $comments \frontend\models\Comment[]*/

use frontend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;

$this->title = 'images.com';

/* @var $author \frontend\models\User*/
$author = $post->user;
?>

    <div class="wrapper">

        <div class="container full">

            <div class="page-posts no-padding">
                <div class="row">
                    <div class="page page-post col-sm-12 col-xs-12 post-82">
                        <div class="blog-posts blog-posts-large">
                            <div class="row">
                                <!-- feed item -->
                                <article class="post col-sm-12 col-xs-12">
                                    <div class="post-meta">
                                        <div class="post-title">
                                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($author->nickname) ? $author->nickname : $author->id]);; ?>"><img src="<?php echo $author->getPicture(); ?>" class="author-image" /></a>
                                            <div class="author-name">
                                                <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($author->nickname) ? $author->nickname : $author->id]); ?>">
                                                    <?php echo $author->first_name . ' ' . $author->last_name ?> <?php if ($author->nickname) {echo '/"' . $author->nickname . '/"';} ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-type-image">
                                            <img src="<?php echo $post->getImage(); ?>" alt="" width="100%" ">
                                    </div>
                                    <div class="post-description">
                                        <p><?php echo $post->description; ?></p>
                                    </div>
                                    <div class="post-bottom">
                                        <div class="post-likes">
                                            <a class="btn btn-secondary"><i class="fa fa-lg fa-heart-o"></i></a>
                                            <span>
                                                <?php if ($post->countLikes()) { echo $post->countLikes(); }?> Likes
                                            </span>
                                            <a href="#"
                                               class="btn btn-default button-unlike <?php echo ($currentUser->likesPost($post->id)) ? "" : "display-none"; ?>"
                                               data-id="<?php echo $post->id; ?>">
                                                Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
                                            </a>
                                            <a href="#"
                                               class="btn btn-default button-like <?php echo ($currentUser->likesPost($post->id)) ? "display-none" : ""; ?>"
                                               data-id="<?php echo $post->id; ?>">
                                                Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
                                            </a>
                                        </div>
                                        <div class="post-comments">
                                            <a href="#foot"><?php echo Yii::$app->redis->get("comments:{$post->id}:post") ?> comments</a>

                                        </div>
                                        <div class="post-date">
                                            <span><?php echo date('M d, Y', $post->created_at); ?></span>
                                        </div>
<!--                                        <div class="post-report">-->
<!--                                            <a href="#">Report post</a>-->
<!--                                        </div>-->
                                    </div>
                                </article>
                                <!-- feed item -->


                                <div class="col-sm-12 col-xs-12">
                                    <h4><?php echo Yii::$app->redis->get("comments:{$post->id}:post") ?> comments</h4>
                                    <div class="comments-post">

                                        <div class="single-item-title"></div>
                                        <div class="row">
                                            <ul class="comment-list">

                                                <?php foreach ($comments as $comment) : ?>
                                                <!-- comment item -->
                                                <li class="comment">
                                                    <div class="comment-user-image">
                                                        <?php $user = User::findOne($comment->user_id); ?>
                                                        <img src="<?php echo $user->getPicture(); ?>" width="75">
                                                    </div>
                                                    <div class="comment-info">
                                                        <h4 class="author"><a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($user->nickname) ? $user->nickname : $user->id]);; ?>"><?php echo $user->first_name . ' ' . $user->last_name; ?></a> <span><?php echo date('(M  d,  Y)', $comment->updated_at); ?></span></h4>
                                                        <p><?php echo $comment->text; ?></p>
                                                    </div>
                                                </li>
                                                <!-- comment item -->
                                                <?php endforeach; ?>

                                            </ul>
                                        </div>

                                    </div>
                                    <!-- comments-post -->
                                </div>
                                <a name="foot"></a

                                <?php if (! Yii::$app->user->isGuest) : ?>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="comment-respond">
                                        <h4>Leave a Reply</h4>
                                        <?php $form = ActiveForm::begin(); ?>
                                        <?php $form->action = Url::to(['/post/comment/save']); ?>
                                            <p class="comment-form-comment">
                                                <?php echo $form->field($commentForm, 'text')->textarea(['rows' => 6, 'class' => 'form-control', 'placeholder' => 'Your comment', 'aria-required' => 'true']); ?>
                                            </p>
                                            <?php echo Html::activeHiddenInput($commentForm, 'user_id', ['value' => Yii::$app->user->identity->getId()]); ?>
                                            <?php echo Html::activeHiddenInput($commentForm, 'post_id', ['value' => $post->id]); ?>
                                            <p class="form-submit">
                                                <?php echo Html::submitButton('Send', ['class' => 'btn btn-secondary']); ?>
                                            </p>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php

$this->registerJsFile('@web/js/like.js', [
        'depends' => JqueryAsset::className(),
]);