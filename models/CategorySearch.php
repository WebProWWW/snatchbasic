<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;

class CategorySearch extends Category
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['id', 'from_price', 'parent_id', 'order'], 'integer'],
      [['label', 'desc', 'img'], 'safe'],
    ];
  }

  public function scenarios()
  {
    // bypass scenarios() implementation in the parent class
    return Model::scenarios();
  }

  /**
   * @param array $params
   * @return ActiveDataProvider
   */
  public function search($params)
  {
    $query = Category::find();
    // add conditions that should always apply here
    $query->orderBy(['id' => SORT_DESC]);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    // grid filtering conditions
    $query->andFilterWhere([
      'id' => $this->id,
      'from_price' => $this->from_price,
      'parent_id' => $this->parent_id,
      'order' => $this->order,
    ]);

    $query->andFilterWhere(['like', 'label', $this->label])
      ->andFilterWhere(['like', 'desc', $this->desc])
      ->andFilterWhere(['like', 'img', $this->img]);

    return $dataProvider;
  }
}
