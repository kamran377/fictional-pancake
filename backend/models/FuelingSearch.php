<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Fueling;

/**
 * FuelingSearch represents the model behind the search form about `app\models\Fueling`.
 */
class FuelingSearch extends Fueling
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vehicle_id', 'created_by', 'updated_by','account_id'], 'integer'],
            [['fueling_date', 'cost', 'odometer_reading', 'gallons', 'creation_time', 'updated_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Fueling::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> [
				'defaultOrder' => [
					'fueling_date'=>SORT_DESC,
				],
			]
        ]);
		if(isset ($_POST)){
            $params = $_POST;
        }
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date(fueling_date)' => !empty($this->fueling_date) ? date('Y-m-d', strtotime($this->fueling_date)) : '',
            'vehicle_id' => $this->vehicle_id,
            //'created_by' => $this->created_by,
            //'date(creation_time)' => date('Y-m-d', strtotime($this->creation_time)),
            //'updated_by' => $this->updated_by,
            //'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'cost', $this->cost])
            ->andFilterWhere(['like', 'odometer_reading', $this->odometer_reading])
            ->andFilterWhere(['like', 'gallons', $this->gallons]);

		var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        //exit();
			
        return $dataProvider;
    }
}
