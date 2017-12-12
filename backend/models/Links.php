<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "links".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $page_name
 * @property string $permission
 * @property integer $order
 *
 * @property Links $parent
 * @property Links[] $links
 */
class Links extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'page_name', 'permission'], 'required'],
            [['parent_id','order'], 'integer'],
            [['name', 'permission'], 'string', 'max' => 255],
            [['page_name'], 'string', 'max' => 50],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Links::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'parent_id' => 'Parent ID',
            'page_name' => 'Page Name',
            'permission' => 'Permission',
			'order' => 'Order'
        ];
    }
	
	public function getApiData() {
		$obj = new \stdClass;
		$obj->name = $this->name;
		$obj->order = $this->order;
		$obj->pageName = $this->page_name;
		$obj->childLinks = [];
		return $obj;
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Links::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinks()
    {
        return $this->hasMany(Links::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return LinksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LinksQuery(get_called_class());
    }
}
