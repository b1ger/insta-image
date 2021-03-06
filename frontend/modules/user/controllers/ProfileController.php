<?php

namespace frontend\modules\user\controllers;

use frontend\models\Post;
use frontend\models\User;
use frontend\modules\user\forms\PictureForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class ProfileController
 * @package frontend\modules\user\controllers
 */
class ProfileController extends Controller
{
    /**
     * @param $nickname
     * @return string
     */
    public function actionView($nickname)
    {
        $currentUser = Yii::$app->user->identity;

        $modelPicture = new PictureForm();
        $user = $this->findUser($nickname);
        $posts = Post::find()->where(['user_id' => $user->id])->all();

        return $this->render('view', [
            'user' => $user,
            'currentUser' => $currentUser,
            'modelPicture' => $modelPicture,
            'posts' => $posts,
        ]);
    }

    /**
     * @param $nickname string
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public function findUser($nickname)
    {
        if ($user = User::find()->where(['nickname' => $nickname])->orWhere(['id' => $nickname])->one()) {
            return $user;
        }

        throw new NotFoundHttpException();
    }

    public function actionSubscribe($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        $user = $this->findUserById($id);

        $currentUser->followUser($user);

        return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);
    }


    public function actionUnsubscribe($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        /* @var $user User */
        $user = $this->findUser($id);

        $currentUser->unfollowUser($user);

        return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);
    }

    /**
     * @param $id
     * @return User
     * @throws NotFoundHttpException
     */
    private function findUserById($id)
    {
        if ($user = User::findOne($id)) {
            return $user;
        }
        throw new NotFoundHttpException();
    }

    /**
     * @return array
     */
    public function actionUploadPicture()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');


        if ($model->validate()) {
            /* @var $user User */
            $user = Yii::$app->user->identity;

            if($user->picture) {
                unlink(Yii::getAlias('@app/web') . $user->getPicture());
            }

            $user->picture = Yii::$app->storage->saveUploadedFile($model->picture);

            if ($user->save(false, ['picture'])) {
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->picture),
                ];
            }
        }

        return [
            'success' => false,
            'errors' => $model->getErrors(),
        ];
    }

    public function actionDeletePicture()
    {
        /* @var $user User */
        $user = Yii::$app->user->identity;

        if($user->deleteCurrentPicture()) {
            Yii::$app->session->setFlash('success', 'Picture deleted');
        } else {
            Yii::$app->session->setFlash('danger', 'Error occurred');
        }

        return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);
    }
}