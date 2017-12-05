<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Fueling]].
 *
 * @see Fueling
 */
class FuelingQuery extends \yii\db\ActiveQuery
{
    public function active($offset)
    {
        return $this->orderBy(['fueling_date'=>SORT_DESC])->limit(10)->offset($offset)->all();
    }

    /**
     * @inheritdoc
     * @return Fueling[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Fueling|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
