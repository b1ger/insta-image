<?php

namespace frontend\modules\user\forms;

use frontend\models\User;
use yii\base\Model;

class UserUpdateForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $nickname;
    public $about;

    private $user;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email'], 'required'],
            ['email', 'email'],
            [['about', 'nickname', 'user'], 'safe'],
        ];
    }

    public function setUserParams(User $user)
    {
        $this->user = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->nickname = $user->nickname;
        $this->about = $user->about;
    }

    public function update()
    {
        $this->user->first_name =  $this->first_name;
        $this->user->last_name = $this->last_name;
        $this->user->email = $this->email;
        $this->user->nickname = $this->nickname;
        $this->user->about = $this->about;

        if (! $this->user->save()) {
            return false;
        }

        return true;
    }
}
