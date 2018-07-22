<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $label Название
 * @property string $desc Описание
 * @property int $price Прайс
 * @property string $img Изображение
 * @property int $category_id Категория
 * @property int $order Сортировка
 *
 * @property Category $category
 */
class Product extends ActiveRecord
{

  public static function tableName()
  {
    return 'product';
  }

  public function rules()
  {
    return [
      [['desc', 'price', 'label', 'img'], 'required'],
      [['desc'], 'string'],
      [['price', 'category_id', 'order'], 'integer'],
      [['label', 'img'], 'string', 'max' => 255],
      [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
    ];
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'label' => 'Название',
      'desc' => 'Описание',
      'price' => 'Прайс',
      'img' => 'Изображение',
      'category_id' => 'Категория',
      'order' => 'Сортировка',
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getCategory()
  {
    return $this->hasOne(Category::class, ['id' => 'category_id']);
  }

  public function getListCategories()
  {
    $all = Category::find()
      ->where(['not', ['parent_id' => NULL]])
      ->select('id, label')
      ->orderBy('order')
      ->all();
    return ArrayHelper::map($all, 'id', 'label');
  }

}
