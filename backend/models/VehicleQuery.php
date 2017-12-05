<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Vehicle]].
 *
 * @see Vehicle
 */
class VehicleQuery extends \yii\db\ActiveQuery
{
    public function active($offset)
    {
        return $this->where(['status' => 1])->limit(10)->offset($offset)->all();
    }

	public function selectList()
    {
        return $this->where(['status' => 1])->all();
    }
    /**
     * @inheritdoc
     * @return Vehicle[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Vehicle|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
