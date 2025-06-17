<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Arsip;

/**
 * ArsipSearch represents the model behind the search form of `app\models\Arsip`.
 */
class ArsipSearch extends Arsip
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'folder_id'], 'integer'],
            [['judul', 'file_path', 'uploaded_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Arsip::find();

        // add conditions that should always apply here
         $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10, // Atur jumlah item per halaman
                ],
                'sort' => [
                    'defaultOrder' => [
                        'uploaded_at' => SORT_DESC, // Urutkan dari yang terbaru
                    ],
                ],
            ]);


        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'folder_id' => $this->folder_id,
            'uploaded_at' => $this->uploaded_at,
        ]);

        $query->andFilterWhere(['like', 'judul', $this->judul])
            ->andFilterWhere(['like', 'file_path', $this->file_path]);

        return $dataProvider;
    }
    
}
