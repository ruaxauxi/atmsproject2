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
        $u->getUserProfile(\Yii::$app->user->identity->id);
        $this->userProfile = $u;
        return $u;
    }
    
    public function getUsername(){
        return \Yii::$app->user->identity->username;
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
