<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $label Название
 * @property alias $alias Псевдоним
 * @property string $desc Описание
 * @property int $from_price Цена от
 * @property string $img Фото
 * @property int $parent_id Родительская категория
 * @property int $order Сортировка
 * @property int $size_id Размеры
 * @property string $size_table Таблица размеров
 * @property string $part_count Количество в партии
 *
 * @property Category $parent
 * @property Category[] $categories
 */
class Category extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'category';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			['alias', 'required'],
			['alias', 'unique', 'targetClass' => self::class, 'message' => 'Указанный псевдоним уже занят.'],
			['alias', 'string', 'max' => 255],

			['part_count', 'string', 'max' => 255],

			['size_table', 'string', 'max' => 255],

			['label', 'required'],
			['desc', 'string'],
			[['from_price', 'parent_id', 'order'], 'integer'],
			[['label', 'img'], 'string', 'max' => 255],
			[['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['parent_id' => 'id']],

			[['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Size::class, 'targetAttribute' => ['size_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'label' => 'Название',
			'alias' => 'Псевдоним',
			'desc' => 'Описание',
			'from_price' => 'Цена от',
			'img' => 'Фото',
			'parent_id' => 'Родитель',
			'order' => 'Сортировка',
			'size_id' => 'Размеры',
			'size_table' => 'Таблица размеров',
			'part_count' => 'Количество в партии',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getParent()
	{
		return $this->hasOne(Category::class, ['id' => 'parent_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategories()
	{
		return $this->hasMany(Category::class, ['parent_id' => 'id']);
	}


	public function getProducts()
	{
		return $this->hasMany(Product::class, ['category_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSize()
	{
		return $this->hasOne(Size::class, ['id' => 'size_id']);
	}

	public function getListSizes()
	{
		$all = Size::find()
			->select('id, label')
			->all();
		return ArrayHelper::map($all, 'id', 'label');
	}


	public function getListAll()
	{
		$all = static::find()
			->where(['parent_id' => NULL])
			->select('id, label')
			->orderBy('order')
			->all();
		if ($this->id) {
			foreach ($all as $i => $category) {
				if ($category->id === $this->id) {
					ArrayHelper::remove($all, $i);
				}
			}
		}
		return ArrayHelper::map($all, 'id', 'label');
	}

	public static function getParentCategories()
	{
		return static::find()
			->where(['parent_id' => NULL])
			// ->select(['id', 'label', 'alias'])
			->orderBy('order')
			->with('categories')
			->all();
	}

	public function getChilds()
	{
		return static::find()
			->where(['parent_id' => $this->id])
			->with('categories')
			// ->with('parent')
			->orderBy('order')
			->all();
	}

	public static function findByAlias($alias)
	{
		return static::find()
			->where(['alias' => $alias])
			// ->with('categories')
			// ->with('products')
			->with('parent')
			// ->with('size')
			->one();
	}
}
