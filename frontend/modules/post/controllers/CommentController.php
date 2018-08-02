<?php

namespace frontend\modules\post\controllers;

use frontend\models\Comment;
use frontend\modules\post\forms\CommentForm;
use yii\redis\Connection;
use yii\web\Controller;
use Yii;

class CommentController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSave()
    {
        $form = new CommentForm();
        $request = Yii::$app->request;

        if ($request->isPost) {
            $data = $request->post();
            $form->load($data);

            if ($form->validate()) {
                if ($form->save()) {

                    /* @var $redis Connection */
                    $redis = Yii::$app->redis;
                    if ($redis->exists("comments:{$form->post_id}:post")) {
                        $redis->incr("comments:{$form->post_id}:post");
                    } else {
                        $redis->set("comments:{$form->post_id}:post", 1);
                    }

                    Yii::$app->session->setFlash('success', 'Comment have been added.');
                } else {
                    Yii::$app->session->setFlash('danger', 'Something wrong!');
                }
            }
        }

        return $this->redirect(Yii::$app->request->referrer ? : Yii::$app->homeUrl);
    }


    public function actionDelete($id)
    {
        $model = Comment::findOne($id);

        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->decr("comments:{$model->post_id}:post");
        $model->delete();

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionEdit(int $commentId, int $postId = null)
    {
        $model = Comment::findOne($commentId);

        if (! Yii::$app->request->isPost) {
            return $this->render('index', [
                'commentId' => $commentId,
                'postId' => $postId,
                'model' => $model,
            ]);
        }

        $data = Yii::$app->request->post();
        $model->text = $data['Comment']['text'];

        if ($model->save()) {
            return $this->redirect(['/post/' . $data['postId']]);
        }
    }
}