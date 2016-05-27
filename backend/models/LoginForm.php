<?php
/**
 * Created by PhpStorm.
 * User: quanhong
 * Date: 2016/5/13
 * Time: 17:24
 */
namespace backend\models;

use yii;
use yii\base\Model;
use yii\web\Cookie;
use common\models\User;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    public $remember;
    private $user;
    const BACKEND_ID = 'backend_id';
    const BACKEND_USERNAME = 'backend_username';
    const BACKEND_COOKIE = 'cookie';

    public function rules()
    {
        return [
            ['username','required','message' => '用户名不能为空'],
            ['password','required','message' => '密码不能为空'],
            ['verifyCode','required','message' => '验证码不能为空'],
            ['username','validateAccount', 'skipOnEmpty' => false],
            ['verifyCode','captcha','captchaAction' => 'login/captcha','message' => '验证码错误'],
            [['password','remember'],'safe']
        ];
    }

    public function validateAccount($attribute, $params)
    {
        if(!preg_match('/^\w{2,30}$/', $this->$attribute)){
            $this->addError($attribute, '用户名或密码错误');
        }else if(strlen($this->password) < 6){
            $this->addError('password', '用户名或密码错误');
        }else{
            $user = User::find()->where(['username' => $this->$attribute, 'status' => 1])->asArray()->one();
            if(!$user || md5($this->password) != $user['password']){
                $this->addError($attribute, '用户名或密码错误');
            }else{
                $this->user = $user;
            }
        }
    }

    public function login(){
        if(empty($this->user) && $this->updateUser()){
            return false;
        }
        $this->createSession();
        if($this->remember == 1){
            $this->createCookie();
        }
        return true;
    }

    /**
     * 创建session
     */
    public function createSession(){
        $session = Yii::$app->session;
        $session->set(SELF::BACKEND_ID, $this->user['id']);
        $session->set(SELF::BACKEND_USERNAME, $this->user['username']);
    }

    /**
     * 创建cookie
     */
    public function createCookie(){
        $cookie = new Cookie();
        $cookie->name = SELF::BACKEND_COOKIE;
        $cookie->value = [
            'id' => $this->user['id'],
            'username' => $this->user['username']
        ];
        //cookie保存7天
        $cookie->expire = time()+ 60 * 60 * 24 *7;
        $cookie->httpOnly =true;

        Yii::$app->response->cookies->add($cookie);
    }

    /**
     * 更新用户的登录时间和ip
     */
    public function updateUser()
    {
        $user = User::findOne($this->user['id']);
        $user->login_date = time();
        $user->login_ip = Yii::$app->request->getUserIp();
        return $user->save();
    }

    /**
     * 通过cookie获取创建session
     */
    public function loginByCookie()
    {
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has(self::BACKEND_COOKIE))
        {
            $userData = $cookies->getValue(self::BACKEND_COOKIE);
            if (isset($userData['id']) && isset($userData['username']))
            {
                $this->user = User::find()->where(['username' => $userData['username'],'id' => $userData['id']])->asArray()->one();
                if ($this->user){
                    $this->createSession();
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 退出
     */
    public function lagout()
    {
        $session = Yii::$app->session;
        $session->remove(self::BACKEND_ID);
        $session->remove(self::BACKEND_USERNAME);
        $session->destroy();

        $cookies = Yii::$app->response->cookies;
        if ($cookies->has(self::BACKEND_COOKIE)){
            $cookies->remove(self::BACKEND_COOKIE);
        }
    }

}