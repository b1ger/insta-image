<?php
namespace frontend\tests;

use frontend\tests\fixtures\UserFixture;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return ['users' => UserFixture::className()];
    }
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testGetNickname()
    {
        sleep(10);
    }
}