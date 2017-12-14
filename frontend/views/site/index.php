<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $users array frontend\models\User */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <h2>Users</h2>

                <?php foreach ($users as $user) : ?>

                    <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => $user->getNickName()]) ?>"><?php echo "User name: " . $user->username; ?></a>
                    <br>
                    <?php echo "User email: " . $user->email; ?>
                    <br>
                    <hr>

                <?php endforeach; ?>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
