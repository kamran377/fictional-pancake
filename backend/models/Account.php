<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "accounts".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $created_by
 * @property string $creation_time
 * @property integer $updated_by
 * @property string $updated_time
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts';
    }
	
	public function getApiData() {
		return [
			'id' => \Yii::$app->util->encrypt($this->id),
			'name'=>$this->name,
		];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_by', 'creation_time'], 'required'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['creation_time', 'updated_time'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_by' => 'Created By',
            'creation_time' => 'Creation Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
			
        ];
    }
	
	
	

    /**
     * @inheritdoc
     * @return AccountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccountQuery(get_called_class());
    }
}
