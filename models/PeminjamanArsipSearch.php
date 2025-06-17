<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PeminjamanArsip;

/**
 * PeminjamanArsipSearch represents the model behind the search form of `app\models\PeminjamanArsip`.
 */
class PeminjamanArsipSearch extends PeminjamanArsip
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['arsip_id', 'nama_peminjam', 'tanggal_pinjam', 'status'], 'required'],
            [['arsip_id'], 'integer'],
            [['tanggal_pinjam', 'tanggal_kembali', 'created_at', 'updated_at'], 'safe'],
            [['nama_peminjam', 'unit'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => ['Dipinjam', 'Sudah Dikembalikan']],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = PeminjamanArsip::find();

        // Tambahkan urutan: status 0 (belum kembali) muncul di atas
        $query->orderBy(['status' => SORT_ASC, 'tanggal_pinjam' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10, // Tambahkan pagination (10 baris per halaman)
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'arsip_id' => $this->arsip_id,
            'tanggal_pinjam' => $this->tanggal_pinjam,
            'tanggal_kembali' => $this->tanggal_kembali,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nama_peminjam', $this->nama_peminjam])
              ->andFilterWhere(['like', 'unit', $this->unit])
              ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
