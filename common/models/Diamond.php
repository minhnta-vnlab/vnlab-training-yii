<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "diamond".
 *
 * @property int $id
 * @property float|null $carat
 * @property string|null $cut
 * @property string|null $color
 * @property string|null $clarity
 * @property float|null $depth
 * @property float|null $table
 * @property float|null $price
 * @property float|null $x
 * @property float|null $y
 * @property float|null $z
 */
class Diamond extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diamond';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['carat', 'depth', 'table', 'price', 'x', 'y', 'z'], 'number'],
            [['cut'], 'string', 'max' => 128],
            [['color'], 'string', 'max' => 1],
            [['clarity'], 'string', 'max' => 5],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'carat' => 'Carat',
            'cut' => 'Cut',
            'color' => 'Color',
            'clarity' => 'Clarity',
            'depth' => 'Depth',
            'table' => 'Table',
            'price' => 'Price',
            'x' => 'X',
            'y' => 'Y',
            'z' => 'Z',
        ];
    }
}
