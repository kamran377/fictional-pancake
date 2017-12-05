<?php

namespace app\models;

use Yii;
use \yii\helpers\Url;
/**
 * This is the model class for table "user_details".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile

 *
 * @property User $user
 */
class UserDetails extends \yii\db\ActiveRecord {

    public $address;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_details';
    }
	
	
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'first_name', 'last_name',], 'required', 'on' => 'signup'],
            [['first_name', 'last_name', 'mobile'], 'string', 'max' => 255],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

	
	
	public function getApiData() {
		return [
			'first_name'=>$this->first_name,
			'last_name'=>$this->last_name,
			'mobile' => $this->mobile,
		];
	}
	
	public function getName() {
		return $this->first_name . ' ' . $this->last_name;
	}
	
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'mobile' => 'Mobile',      
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

	public static function find()
    {
        return parent::find();
    }

}
