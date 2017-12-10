<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $whoseme_token

 
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public $password_repeat;
    public $old_password;
    public $new_password;
    public $original_password;
    public $verifyCode;
    public $reCaptcha;
    public $authKey;
    public $profile;
    public $user_id;
    public $profileImage;
    public $name;
	public $role;
	
    public function getUserDetails() {
        return $this->hasOne(\app\models\UserDetails::className(), ['user_id' => 'id']);
    }
	
	
	public function getRole() {
        $role1 =  \Yii::$app->util->getRole($this->id);
        return $role1->name;
    }
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_INACTIVE]],
            [['password_hash', 'password_repeat', 'email', 'username'], 'required', 'on' => 'signup'],
            [['password_repeat', 'new_password'], 'required', 'on' => 'reset_password'],
            ['username', 'unique'],
            ['email', 'unique'],
            ['email', 'email'],
            ['accountIds','safe'],
			['password_repeat', 'compare', 'compareAttribute' => 'password_hash', 'message' => \Yii::t('app', "Passwords don't match"), 'on' => 'signup'],
            ['password_repeat', 'compare', 'compareAttribute' => 'new_password', 'message' => \Yii::t('app', "Passwords don't match"), 'on' => 'change_password'],
            //[['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className() ,'on' => 'signup' ],
            [['whoseme_token','role'], 'string', 'max' => 255],
            [['password_repeat', 'new_password'], 'string', 'min' => 6],
        ];
    }
	
	public function getUserAccounts() {
        return $this->hasMany(Account::className(), ['id' => 'account_id'])->viaTable('{{%user_accounts}}', ['user_id' => 'id']);
    }
	
	private $_accountIds;
   
    public function getAccountIds() {
        if ($this->_accountIds === null) {
            $this->_accountIds = ArrayHelper::getColumn($this->userAccounts, 'id');
        }
        return $this->_accountIds;
    }
	
	public function setAccountIds($value) {
       $this->_accountIds = $value;
    }

	public function getApiData() {
		return [
			'id' => \Yii::$app->util->encrypt($this->id),
			'whoseme_token' => $this->whoseme_token,
		];
	}
    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        if (Yii::$app->getSession()->has('user-' . $id)) {
            return new self(Yii::$app->getSession()->get('user-' . $id));
        } else {
            return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        }
    }

    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['whoseme_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        if (strpos($username, '@') !== false) {
            $user = static::findOne(['email' => $username, 'status' => self::STATUS_ACTIVE]);
        } else {
            //Otherwise we search using the username
            $user = static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
        }
        return $user;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findByPasswordResetTokenSimple($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = 3600;
        return $timestamp + $expire >= time();
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    public function attributeLabels() {
        return [
            'password_hash' => Yii::t('app', 'Password'),
            'password_repeat' => Yii::t('app', 'Repeat Password'),
            'old_password' => Yii::t('app', 'Old Password'),
            'new_password' => Yii::t('app', 'New Password'),
            'original_password' => Yii::t('app', 'Current Password'),
            'verifyCode' => Yii::t('app', 'Captcha'),
            'name' => Yii::t('app', 'Name'),
            'mobile' => Yii::t('app', 'Mobile'),
            'profile_image' => Yii::t('app', 'Profile image'),
			'accountIds'=> 'Assigned Accounts'
        ];
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateWhosemeToken() {
        $this->whoseme_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }
	
	public static function find()
    {
        return new UserQuery(get_called_class());
    }


}
