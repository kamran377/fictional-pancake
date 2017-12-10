<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Account]].
 *
 * @see Account
 */
class AccountQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

	public function selectList($userId)
    {
        $this->join('JOIN',
			'user_accounts',
			'accounts.id = user_accounts.account_id'
		);
		$this->where(['user_accounts.user_id'=>$userId, 'accounts.status' => 1]);
		return $this->all();
    }
	
	public function active()
    {
        return $this->where(['status' => 1])->all();
    }
	
    /**
     * @inheritdoc
     * @return Account[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Account|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
