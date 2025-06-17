<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "arsip".
 *
 * @property int $id
 * @property int $folder_id
 * @property string $judul
 * @property string $file_path
 * @property string|null $uploaded_at
 *
 * @property Folder $folder
 */
class Arsip extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'arsip';
    }

    /**
     * {@inheritdoc}
     */
    public $upload_file;

    public function rules()
    {
            return [
            [['folder_id', 'judul'], 'required'],
            [['folder_id'], 'integer'],
            [['judul', 'file_path'], 'string', 'max' => 255],
            [['upload_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf,jpg,png'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'folder_id' => 'Folder ID',
            'judul' => 'Judul',
            'file_path' => 'File Path',
            'uploaded_at' => 'Uploaded At',
        ];
    }

    /**
     * Gets query for [[Folder]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFolder()
    {
        return $this->hasOne(Folder::class, ['id' => 'folder_id']);
    }
    public function getFolderPath()
    {
        $path = [];
        $folder = $this->folder;
        while ($folder) {
            array_unshift($path, $folder->name);
            $folder = $folder->parent;
        }
        return implode(' / ', $path);
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->upload_file instanceof \yii\web\UploadedFile) {
                $filename = uniqid() . '.' . $this->upload_file->extension;
                $path = Yii::getAlias('@webroot/uploads/arsip/' . $filename);
                if ($this->upload_file->saveAs($path)) {
                    $this->file_path = 'uploads/arsip/' . $filename;
                } else {
                    $this->addError('upload_file', 'Gagal menyimpan file.');
                    return false;
                }
            }
            return true;
         }
        return false;
}



}
