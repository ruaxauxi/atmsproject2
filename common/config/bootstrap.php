<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@atms', dirname(dirname(__DIR__)) . '/atms');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@admintheme', dirname(dirname(__DIR__)) . '/atms/themes/default');
Yii::setAlias("@avatar_url",  '/images/avatars');

Yii::setAlias("@sitename", "vere.com");