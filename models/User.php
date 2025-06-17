<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string|null $auth_key
 * @property string $role
 * @property string|null $created_at
 * @property string|null $updated_at
 */

class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    public $password;


    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['auth_key'], 'default', 'value' => null],
            [['role'], 'default', 'value' => self::ROLE_USER],
            [['username', 'email', 'password'], 'required', 'on' => 'create'],
            [['password'], 'string', 'min' => 6],
            [['role'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 64],
            [['email'], 'string', 'max' => 128],
            [['password_hash'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            ['role', 'in', 'range' => array_keys(self::optsRole())],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function optsRole()
    {
        return [
            self::ROLE_ADMIN => 'admin',
            self::ROLE_USER => 'user',
        ];
    }

    public function displayRole()
    {
        return self::optsRole()[$this->role];
    }

    public function isRoleAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function setRoleToAdmin()
    {
        $this->role = self::ROLE_ADMIN;
    }

    public function isRoleUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function setRoleToUser()
    {
        $this->role = self::ROLE_USER;
    }

    // ========== LOGIN & AUTHENTICATION ==========

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; // belum digunakan
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            } elseif (!empty($this->password)) {
                // Update password jika diisi
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            }

            return true;
        }
        return false;
    }

}
