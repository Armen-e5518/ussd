<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $upc
 * @property int $case_count
 * @property int $cat_id
 * @property int $sub_cat_id
 * @property int $sub_sub_cat_id
 * @property string $name
 * @property string $description
 * @property string $brand
 * @property string $size
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['upc'], 'required'],
            [['case_count'], 'default', 'value' => null],
            [['case_count', 'cat_id', 'sub_cat_id', 'sub_sub_cat_id'], 'integer'],
            [['upc', 'name', 'description', 'brand', 'size'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'upc' => 'Upc',
            'case_count' => 'Case Count',
            'name' => 'Name',
            'description' => 'Description',
            'brand' => 'Brand',
            'size' => 'Size',
            'cat_id' => 'Category',
            'sub_cat_id' => 'Sub Category',
            'sub_sub_cat_id' => 'Sub Sub Category',
        ];
    }

    public static function GetAllProducts()
    {
        return self::find()->asArray()->all();
    }

}
