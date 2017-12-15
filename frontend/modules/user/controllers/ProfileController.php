<?php

namespace frontend\modules\user\controllers;

use frontend\models\PictureUpload;
use frontend\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Faker\Factory;
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

        return $this->render('view', [
            'user' => $this->findUser($nickname),
            'currentUser' => $currentUser,
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
     * @return null|static
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
     * @return string
     */
    public function actionEdit()
    {
        /* @var $user User */
        $user = Yii::$app->user->identity;

        $pictureUpload = new PictureUpload();
        $file = UploadedFile::getInstance($pictureUpload, 'picture');

        if (Yii::$app->request->isPost) {
            $formData = Yii::$app->request->post();


            if ($user->load($formData) && $user->validate()) {
                if (!$file == null) {
                    $user->picture = $pictureUpload->uploadFile($file, $user->picture);
                }
                $user->save();
                Yii::$app->session->setFlash('success', 'Edited');
                return $this->redirect(["/profile/$user->nickname"]);
            }
        }

        return $this->render('edit', [
            'user' => $user,
            'picture' => $pictureUpload,
        ]);
    }
}