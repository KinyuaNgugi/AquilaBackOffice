<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country_tax_rates".
 *
 * @property integer $id
 * @property string $tax_rate_name
 * @property integer $tax_id
 * @property double $rate
 * @property integer $supermarket_applicable
 */
class CountryTaxRates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country_tax_rates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tax_id', 'supermarket_applicable'], 'integer'],
            [['rate'], 'number'],
            [['tax_rate_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tax_rate_name' => 'Tax Rate Name',
            'tax_id' => 'Tax ID',
            'rate' => 'Rate',
            'supermarket_applicable' => 'Supermarket Applicable',
        ];
    }
}
