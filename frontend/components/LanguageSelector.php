<?php

namespace frontend\components;

use Yii;
use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface
{

    private $availableLanguages = ['en-US', 'ru-RU'];

    public function bootstrap($app)
    {
        $cookieLang = Yii::$app->request->cookies['language'];
        if (isset($cookieLang) && in_array($cookieLang, $this->availableLanguages)) {
            $app->language = $cookieLang;
        }
    }
}