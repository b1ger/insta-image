<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $complaints backend\models\Post[] */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row row-fluid">
        <div class="col col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>User ID</th>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Created at</th>
                    <th>Complaints</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <?php if (count($complaints) > 0) : ?>
                <tbody>
                <?php $i = 0; ?>
                <?php foreach ($complaints as $complaint) : ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $complaint->user_id; ?></td>
                    <td><?php echo $complaint->id; ?></td>
                    <td><?php echo Html::img($complaint->getImage()); ?></td>
                    <td><?php echo $complaint->description; ?></td>
                    <td><?php echo $complaint->created_at; ?></td>
                    <td><?php echo $complaint->complaints; ?></td>
                    <td>
                        <a class="glyphicon glyphicon-search" href="<?php echo Url::toRoute(["/complaints/manage/view", 'id' => $complaint->id]); ?>"></a>&nbsp;
                        <a class="glyphicon glyphicon-ok" href="<?php echo Url::toRoute(["/complaints/manage/approve", 'id' => $complaint->id]); ?>"></a>&nbsp;
                        <a class="glyphicon glyphicon-remove" href="<?php echo Url::toRoute(["/complaints/manage/delete", 'id' => $complaint->id]); ?>"></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <?=count($complaints) ?>
</div>