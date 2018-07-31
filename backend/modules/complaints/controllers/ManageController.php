<?php

namespace backend\modules\complaints\controllers;

use frontend\models\Feed;
use Yii;
use backend\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ManageController implements the CRUD actions for Post model.
 */
class ManageController extends Controller
{
    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::findComplaints(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
//    public function actionDelete($id)
//    {
//        $feeds = $this->findFeed($id);
//        echo '<pre>';
//        print_r($feeds);
//        echo '</pre>';
//        die;
//        if ($feeds) {
//            foreach ($feeds as $feed) {
//                $feed->delete();
//            }
//        }
//
//        $this->findModel($id)->delete();
//
//        Yii::$app->redis->getClient()->del("post:{$id}:complaints");
//        Yii::$app->redis->getClient()->del("post:{$id}:likes");
//        Yii::$app->redis->getClient()->del("comments:{$id}:post");
//
//        return $this->redirect(['index']);
//    }

    /**
     * Approve post action if it looks ok
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
//    public function actionApprove($id)
//    {
//        $post = $this->findModel($id);
//        if ($post->approve()) {
//            Yii::$app->session->setFlash('success', 'Post marked as appropriate');
//            return $this->redirect(['index']);
//        }
//
//        return false;
//    }


    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
//    protected function findModel($id)
//    {
//        if (($model = Post::findOne($id)) !== null) {
//            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }


    /**
     * @param $postId
     * @return Feed[]|null
     */
//    public function findFeed($postId)
//    {
//        if ($models = Feed::findAll(['post_id' => $postId])) {
//            return $models;
//        }
//
//        return null;
//    }
}
