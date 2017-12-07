<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fuelings".
 *
 * @property integer $id
 * @property string $fueling_date
 * @property string $cost
 * @property string $odometer_reading
 * @property string $gallons
 * @property integer $vehicle_id
 * @property integer $account_id
 * @property integer $created_by
 * @property string $creation_time
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $receipt_photo
 */
class Fueling extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fuelings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fueling_date', 'cost', 'odometer_reading', 'gallons', 'created_by', 'creation_time','receipt_photo'], 'required'],
            [['fueling_date', 'creation_time', 'updated_time'], 'safe'],
            [['vehicle_id', 'created_by', 'updated_by'], 'integer'],
            [['cost', 'odometer_reading','gallons'], 'string', 'max' => 20],
			[['receipt_photo'], 'string', 'max' => 200],
        ];
    }

	public function getApiData() {
		return [
			'id' => \Yii::$app->util->encrypt($this->id),
			'fueling_date'=>\Yii::$app->util->dateTimeFormat($this->fueling_date, false),
			'cost' =>$this->cost,
			'odometer_reading' =>$this->odometer_reading,
			'cost' =>$this->cost,
			'vehicle' => $this->vehicle->name,
			'gallons' => $this->gallons,
			'receipt_photo' => $this->receipt_photo,
			
		];
	}
	
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::className(), ['id' => 'vehicle_id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fueling_date' => 'Fuel Service Date',
            'cost' => 'Cost',
            'odometer_reading' => 'Odometer Reading',
            'gallons' => 'Gallons',
            'vehicle_id' => 'Vehicle',
            'account_id' => 'Account',
            'created_by' => 'Created By',
            'creation_time' => 'Creation Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
			'receipt_photo' => 'Receipt Photo'
        ];
    }

    /**
     * @inheritdoc
     * @return FuelingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FuelingQuery(get_called_class());
    }
}
