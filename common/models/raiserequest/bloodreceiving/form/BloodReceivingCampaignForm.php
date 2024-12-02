<?php

namespace common\models\raiserequest\bloodreceiving\form;

use common\models\Campaign;
use Yii;
use yii\base\Model;

class BloodReceivingCampaignForm extends Campaign
{
    public $category = Campaign::CATEGORY_BLOOD_RECEIVING;
    public $title;
    public $model_id;
    public $slug;
    public $status;
    public $valid_till_datetime;
    public $formModel;
    public $isNewRecord;


    public function __construct($model = null)
    {
        $this->formModel = \Yii::createObject([
            'class' => Campaign::className()
        ]);


        $this->isNewRecord = true;
        if ($model != null) {
            $this->isNewRecord = false;
            $this->formModel = $model;
            $this->model_id = $this->formModel->model_id;
            $this->slug = $this->formModel->slug;
            $this->category = Campaign::CATEGORY_BLOOD_RECEIVING;
            $this->valid_till_datetime = $this->formModel->valid_till_datetime;
            $this->title = $this->formModel->title;
            $this->status = $this->formModel->status;
        }
    }

    public function rules()
    {
        return [
            [['slug', 'valid_till_datetime'], 'required'],
            [['category', 'title','model_id','status'], 'safe'],
            [['slug'], 'unique', 'targetClass' => '\common\models\Campaign',  'filter' => ['!=', 'id', $this->formModel->id]],
            [['valid_till_datetime'], 'date', 'format' => 'php:Y-m-d'],



        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'category' => 'Category',
            'slug' => 'Slug',
            'valid_till_datetime' => 'Valid Till',

        ];
    }


    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }
        $this->initializeForm();
        if ($this->formModel->save()) {
            return true;
        }
        return false;
    }

    public function initializeForm()
    {
        $this->formModel->slug = $this->slug;
        $this->formModel->title = $this->title;
        $this->formModel->model_id = $this->model_id;
        $this->formModel->category = $this->category;
        $this->formModel->valid_till_datetime = $this->valid_till_datetime;
        $this->formModel->status = $this->status ?? 1;
    }
}
