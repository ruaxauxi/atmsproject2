<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace atms\components;

/**
 * Description of User
 *
 * @author dang vo <vhdang2302@gmail.com>
 */

use atms\models\UserProfile;

class User extends \yii\web\User {
    //put your code here
    
    public $userProfile;
    
    public function getUserProfile()
    {


        $u = new UserProfile();
        $userid = isset(\Yii::$app->user->identity->id)?\Yii::$app->user->identity->id:null;
        $u->getUserProfile($userid);
        $this->userProfile = $u;
        return $u;
    }
    
    public function getUsername(){
        return isset(\Yii::$app->user->identity->username)?\Yii::$app->user->identity->username:null;
    }
    
    public function getFullname()
    {
        if ($this->userProfile !=null)
        {

            return $this->userProfile->getFullname();
        }
        else
        {
             $this->getUserProfile();
            return $this->userProfile->getFullname();
        }
    }

    public function getUserRole()
    {
        return \Yii::$app->user->identity->getUserRole();
    }

    public function getGender()
    {
        if ($this->userProfile !=null)
        {
            return $this->userProfile->getGender();

        }else{
            $this->getUserProfile();
            return $this->userProfile->getGender();
        }
    }
    
     public function getAvatar()
    {
        if ($this->userProfile !=null)
        {

            return $this->userProfile->getAvatar();
        }
        else
        {
             $this->getUserProfile();
            return $this->userProfile->getAvatar();
        }
    }
           
}
