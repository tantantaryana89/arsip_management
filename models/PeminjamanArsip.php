<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "peminjaman_arsip".
 *
 * @property int $id
 * @property int $arsip_id
 * @property string $nama_peminjam
 * @property string|null $unit
 * @property string|null $judul_dokumen
 * @property string $tanggal_pinjam
 * @property string|null $tanggal_kembali
 * @property string|null $keterangan
 * @property int $status 0 = Dipinjam, 1 = Dikembalikan
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Arsip $arsip
 */
class PeminjamanArsip extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'peminjaman_arsip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
{
    return [
        [['arsip_id','nama_peminjam', 'unit', 'judul_dokumen'], 'required'],
        [['status'], 'integer'],
        [['tanggal_pinjam', 'tanggal_kembali'], 'safe'],
        [['keterangan'], 'string'],
    ];
}





    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'arsip_id' => 'Arsip ID',
            'nama_peminjam' => 'Nama Peminjam',
            'unit' => 'Unit',
            'tanggal_pinjam' => 'Tanggal Pinjam',
            'tanggal_kembali' => 'Tanggal Kembali',
            'keterangan' => 'Keterangan',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Arsip]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArsip()
    {
        return $this->hasOne(Arsip::class, ['id' => 'arsip_id']);
    }

}
