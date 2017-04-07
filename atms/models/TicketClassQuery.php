<?php

namespace atms\models;

/**
 * This is the ActiveQuery class for [[TicketClass]].
 *
 * @see TicketClass
 */
class TicketClassQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TicketClass[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TicketClass|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
