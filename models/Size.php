<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "size".
 *
 * @property int $id
 * @property string $group Размеры (html)
 * @property string $label Название
 *
 * @property Category[] $categorys
 */
class Size extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'size';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['group', 'label'], 'required'],
      [['group'], 'string'],
      [['label'], 'string'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'group' => 'Размеры (html)',
      'label' => 'Название',
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getCategorys()
  {
    return $this->hasMany(Category::class, ['size_id' => 'id']);
  }
}
