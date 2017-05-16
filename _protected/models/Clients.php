<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property integer $id
 * @property integer $org_id
 * @property string $client_name
 * @property string $email
 * @property string $phone
 * @property string $town
 * @property string $country
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_id'], 'integer'],
            [['client_name'], 'string', 'max' => 70],
            [['email', 'phone', 'town', 'country'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'org_id' => 'Org ID',
            'client_name' => 'Client Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'town' => 'Town',
            'country' => 'Country',
        ];
    }
}
