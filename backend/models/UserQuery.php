<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

	public function profileUser($userId) {
		$this->join('LEFT JOIN',
			'feedback',
			'feedback.to = user.id'
		);
		$this->select(['user.*', 'reviews'=>'COUNT(distinct feedback.id)', 'feedbackScore'=>'ROUND(IFNULL(AVG(feedback.score),0),2)']);
		$this->where(['user.id'=>$userId]);
		$this->groupBy('user.id');
		return $this->one();
	}
	
	public function searchTalents($params, $offset)
	{
		$skills = $params->skills;
		$addresses = $params->addresses;
		$identityVerified = $params->identityVerified;
		
		$this->joinWith(['verificationRequests','userSkills','userDetails']);
		$this->join('LEFT JOIN',
			'feedback',
			'feedback.to = user.id'
		);
		$this->select(['user.*', 'reviews'=>'COUNT(distinct feedback.id)', 'feedbackScore'=>'ROUND(IFNULL(AVG(feedback.score),0),2)']);
		$this->where(['user_details.user_type_id'=>2]);
		if(!empty($skills) && count($skills) > 0)
		{
			$this->andWhere(['skills.name'=>$skills]);
		}
		
		if(!empty($addresses) && count($addresses) > 0)
		{
			$this->join('INNER JOIN',
                'city',
                'city.id = user_details.city_id'
            );

			$this->andWhere(['or',
			   ['city.name'=>$addresses],
			   ['user_details.suburb'=>$addresses]
		    ]);
		}
		if($identityVerified == 2) {
			$this->joinWith('verificationRequests');
			$this->andWhere(['user_verfication_request.type_id'=>3,'user_verfication_request.status_id'=>2]);
			
		}
		$this->offset($offset);
		$this->groupBy('user.id');
		$this->limit(5);
		$this->orderBy(['reviews'=>SORT_DESC]);
		//var_dump($this->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql);
		//exit();
		return $this->all();
	}
    /**
     * @inheritdoc
     * @return User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
