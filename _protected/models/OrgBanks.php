<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "org_banks".
 *
 * @property integer $id
 * @property integer $bank_id
 * @property integer $branch_id
 * @property string $account
 * @property string $currency
 */
class OrgBanks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_banks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank_id', 'branch_id', 'account'], 'required'],
            [['bank_id', 'branch_id'], 'integer'],
            [['account'], 'string', 'max' => 50],
            [['currency'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_id' => 'Bank ID',
            'branch_id' => 'Branch ID',
            'account' => 'Account',
            'currency' => 'Currency',
        ];
    }
    public function getBanks()
    {
        return $this->hasOne(Banks::className(), ['id' => 'bank_id']);
    }

    public function getBankbranch()
    {
        return $this->hasOne(Bankbranch::className(), ['id' => 'branch_id']);
    }
    public function search($params=NULL)
    {

        $query = OrgBanks::find()
            ->with('banks')
            ->with('bankbranch');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'account', $this->account]);

        return $dataProvider;
    }
}
