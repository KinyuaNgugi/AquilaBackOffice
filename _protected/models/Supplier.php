<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "supplier".
 *
 * @property string $supplierName
 * @property integer $supplierId
 * @property string $vatNumber
 * @property string $kraPin
 * @property string $phoneNumber
 * @property integer $methodOfPayment
 * @property integer $status
 * @property string $email
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
            [['methodOfPayment', 'status'], 'integer'],
            [['supplierName', 'vatNumber', 'kraPin', 'phoneNumber'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
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
            'status' => 'Status',
            'email' => 'Email',
        ];
    }
    public function getPayment_methods()
    {
        return $this->hasOne(PaymentMethods::className(), ['id' => 'methodOfPayment']);
    }
    public function search($params,$cat)
    {
        if ($cat == 1)
            $query = Supplier::find()->with('payment_methods');

        if ($cat == 0)
            $query = Supplier::find()->where(array('status' => 0))->with('payment_methods');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'supplierName', $this->supplierName]);

        return $dataProvider;
    }
}
