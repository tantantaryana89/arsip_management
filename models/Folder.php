<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "folder".
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property string|null $created_at
 *
 * @property Folder[] $folders
 * @property Folder $parent
 */
class Folder extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'folder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['parent_id'], 'integer'],
            [['created_at'], 'safe'],
            [['parent_id'], 'default', 'value' => null],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Folder::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['name'], 'validateUniqueName'], // validasi unik dalam parent
        ];
    }

    /**
     * Validasi nama folder unik dalam parent
     */
    public function validateUniqueName($attribute, $params)
    {
        $query = self::find()
            ->where(['name' => $this->name, 'parent_id' => $this->parent_id]);

        if (!$this->isNewRecord) {
            $query->andWhere(['<>', 'id', $this->id]);
        }

        if ($query->exists()) {
            $this->addError($attribute, 'Nama folder sudah digunakan dalam folder ini.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nama Folder',
            'parent_id' => 'Parent Folder',
            'created_at' => 'Dibuat Pada',
        ];
    }

    /**
     * Relasi ke subfolder
     */
    public function getFolders()
    {
        return $this->hasMany(Folder::class, ['parent_id' => 'id']);
    }

    /**
     * Relasi ke folder induk
     */
    public function getParent()
    {
        return $this->hasOne(Folder::class, ['id' => 'parent_id']);
    }

    /**
     * Isi otomatis created_at
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => function () {
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }

    public function getBreadcrumbs()
{
    $breadcrumbs = [];
    $current = $this;

    while ($current !== null) {
        $breadcrumbs[] = [
            'label' => $current->name,
            'url' => ['folder/index', 'parent' => $current->id]
        ];
        $current = $current->parent;
    }

    return array_reverse($breadcrumbs);
}

}
