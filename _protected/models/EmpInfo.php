<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "emp_info".
 *
 * @property integer $id
 * @property integer $accountid
 * @property string $firstname
 * @property string $middlename
 * @property string $surname
 * @property string $cellphone
 * @property string $gender
 * @property string $dob
 * @property string $id_no
 * @property integer $orgid
 * @property string $state
 * @property string $photo
 * @property string $payroll_number
 * @property integer $psId
 * @property string $type
 * @property string $joinDate
 * @property string $marital
 * @property integer $status
 */
class EmpInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emp_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accountid', 'firstname', 'middlename', 'surname', 'cellphone', 'gender', 'dob', 'id_no', 'orgid', 'psId', 'joinDate', 'marital'], 'required'],
            [['accountid', 'orgid', 'psId', 'status'], 'integer'],
            [['dob', 'joinDate'], 'safe'],
            [['firstname', 'middlename', 'surname', 'cellphone', 'gender', 'id_no', 'photo', 'payroll_number'], 'string', 'max' => 255],
            [['state'], 'string', 'max' => 40],
            [['type'], 'string', 'max' => 20],
            [['marital'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'accountid' => 'Accountid',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            'cellphone' => 'Cellphone',
            'gender' => 'Gender',
            'dob' => 'Dob',
            'id_no' => 'Id No',
            'orgid' => 'Orgid',
            'state' => 'State',
            'photo' => 'Photo',
            'payroll_number' => 'Payroll Number',
            'psId' => 'Ps ID',
            'type' => 'Type',
            'joinDate' => 'Join Date',
            'marital' => 'Marital',
            'status' => 'Status',
        ];
    }
    public function search($params,$cat)
    {
        if ($cat=='active')
            $query = EmpInfo::find()
                ->where(['status' => 1]);

        if ($cat=='terminated')
            $query = EmpInfo::find()
                ->where(['status' => 0]);
        


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
