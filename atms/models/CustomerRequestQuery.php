<?php

namespace atms\models;

/**
 * This is the ActiveQuery class for [[CustomerRequest]].
 *
 * @see CustomerRequest
 */
class CustomerRequestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CustomerRequest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CustomerRequest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
