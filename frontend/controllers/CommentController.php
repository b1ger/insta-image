<?php

namespace frontend\controllers;

use frontend\models\Comment;
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
        $comment = new Comment();
        $data = Yii::$app->request->post();

        if (Yii::$app->request->isPost) {
            $comment->load($data);
            $comment->created_at = $time = time();
            $comment->updated_at = $time;

            if ($comment->save()) {
                Yii::$app->session->setFlash('success', 'Comment have been added.');
            } else {
                Yii::$app->session->setFlash('danger', 'Something wrong!');
            }
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }


    public function actionDelete($id)
    {
        $model = Comment::findOne($id);
        $model->delete();

        return $this->redirect($_SERVER['HTTP_REFERER']);
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
