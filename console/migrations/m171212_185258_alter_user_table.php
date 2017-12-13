<?php

use yii\db\Migration;

/**
 * Class m171212_185258_alter_user_table
 */
class m171212_185258_alter_user_table extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%user}}', 'about', $this->text());
        $this->addColumn('{{%user}}', 'type', $this->integer(3));
        $this->addColumn('{{%user}}', 'nickname', $this->text(70));
        $this->addColumn('{{%user}}', 'picture', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'picture');
        $this->dropColumn('{{%user}}', 'nickname');
        $this->dropColumn('{{%user}}', 'type');
        $this->dropColumn('{{%user}}', 'about');
    }
}
