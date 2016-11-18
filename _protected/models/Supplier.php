<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property string $supplierName
 * @property integer $supplierId
 * @property string $vatNumber
 * @property string $kraPin
 * @property string $phoneNumber
 * @property string $methodOfPayment
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplierName', 'methodOfPayment'], 'required'],
            [['supplierName', 'vatNumber', 'kraPin', 'phoneNumber', 'methodOfPayment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'supplierName' => 'Supplier Name',
            'supplierId' => 'Supplier ID',
            'vatNumber' => 'Vat Number',
            'kraPin' => 'Kra Pin',
            'phoneNumber' => 'Phone Number',
            'methodOfPayment' => 'Method Of Payment',
        ];
    }
}
