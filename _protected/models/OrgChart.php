<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "org_chart".
 *
 * @property integer $id
 * @property integer $org_id
 * @property integer $number
 * @property integer $main_acc_id
 * @property integer $level_one_id
 * @property integer $level_two_id
 * @property string $level_three
 * @property string $currency
 * @property string $type
 */
class OrgChart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_chart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_id', 'number', 'main_acc_id', 'level_one_id', 'level_two_id'], 'integer'],
            [['level_three'], 'string', 'max' => 100],
            [['currency'], 'string', 'max' => 5],
            [['type'], 'string', 'max' => 1],
            [['level_three'], 'unique'],
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
            'number' => 'Number',
            'main_acc_id' => 'Main Acc ID',
            'level_one_id' => 'Level One ID',
            'level_two_id' => 'Level Two ID',
            'level_three' => 'Level Three',
            'currency' => 'Currency',
            'type' => 'Type',
        ];
    }

    public function getAccount_base()
    {
        return $this->hasOne(AccountBase::className(), ['id' => 'main_acc_id']);
    }

    public function getLevel_one()
    {
        return $this->hasOne(LevelOne::className(), ['id' => 'level_one_id']);
    }

    public function getLevel_two()
    {
        return $this->hasOne(LevelTwo::className(), ['id' => 'level_two_id']);
    }

    public function search($params,$cat)
    {
        if ($cat==='all')
            $query = OrgChart::find()
                ->with('account_base')
                ->with('level_one')
                ->with('level_two');

        if ($cat=='banks')
            $query = OrgChart::find()
                ->with('account_base')
                ->with('level_one')
                ->with('level_two')
                ->where(['main_acc_id'=>1,'level_one_id'=>1,'level_two_id'=>1]);
        
        if ($cat==='inventory')
            $query = OrgChart::find()
                ->with('account_base')
                ->with('level_one')
                ->with('level_two')
                ->where(['main_acc_id'=>1,'level_one_id'=>2,'level_two_id'=>34]);

        if ($cat==='creditors')
            $query = OrgChart::find()
                ->with('account_base')
                ->with('level_one')
                ->with('level_two')
                ->where(['main_acc_id'=>2,'level_one_id'=>4,'level_two_id'=>27]);
        
        if ($cat==='debtors')
            $query = OrgChart::find()
                ->with('account_base')
                ->with('level_one')
                ->with('level_two')
                ->where(['main_acc_id'=>1,'level_one_id'=>2,'level_two_id'=>26]);

        if ($cat==='expenses')
            $query = OrgChart::find()
                ->with('account_base')
                ->with('level_one')
                ->with('level_two')
                ->where(['main_acc_id'=>3]);
        
        if ($cat==='income')
            $query = OrgChart::find()
                ->with('account_base')
                ->with('level_one')
                ->with('level_two')
                ->where(['main_acc_id'=>4]);

        if ($cat==='approved')
            $query = Expense::find()->with('supplier')->where(array('approved' => 1));

        if ($cat==='void')
            $query = Expense::find()->with('supplier')->where(array('approved' => 3));


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['po_number' => $this->po_number]);
        $query->andFilterWhere(['like', 'supplier', $this->supplier_id]);

        return $dataProvider;
    }
}
