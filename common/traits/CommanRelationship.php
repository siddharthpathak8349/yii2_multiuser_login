<?php

namespace common\traits;

use common\models\GeneralModel;


/**
 * Common Relations
 */
trait CommanRelationship
{
    /**
     * Status Label
     *
     * @return void
     */
    public function getStatuslabel()
    {
        $statuses = GeneralModel::recentstatusoption();

        if (isset($statuses[$this->status])) {
            if ($this->status == 1) {
                return '<img src="' . \Yii::$app->view->params['baseurl'] . '/img/active.png" alt="" style="width: 35px;height: 35px;object-fit: contain;">';
            } else if ($this->status == 2) {
                return '<img src="' . \Yii::$app->view->params['baseurl'] . '/img/suspend.png" alt="" style="width: 35px;height: 35px;object-fit: contain;">';
            } else if ($this->status == -1) {
                return '<img src="' . \Yii::$app->view->params['baseurl'] . '/img/deleted.png" alt="" style="width: 35px;height: 35px;object-fit: contain;">';
            }
        }
        return $this->status;
    }

    public function getTestimoniallabel()
    {
        $return = '';
        if ($this->is_testimonial == 1) {
            $return = "<span class='btn btn-success btn-icon btn-sm'>Yes</span>";
        } else {
            $return = "<span class='btn btn-danger btn-icon btn-sm'>No</span>";
        }
        return $return;
    }


    /**
     * Status Label
     *
     * @return void
     */
    public function getApprovalstatus()
    {
        $statuses = GeneralModel::approvaloption();

        if (isset($statuses[$this->is_approved])) {
            if ($this->is_approved == 1) {
                return '<img src="' . \Yii::$app->view->params['baseurl'] . '/img/active.png" alt="" style="width: 35px;height: 35px;object-fit: contain;">';
            } else if ($this->is_approved == 0) {
                return '<img src="' . \Yii::$app->view->params['baseurl'] . '/img/suspend.png" alt="" style="width: 35px;height: 35px;object-fit: contain;">';
            }
        }
        return $this->status;
    }


    /**
     * Status Label
     *
     * @return void
     */
    public function getApprovallabel()
    {
        $statuses = GeneralModel::approvaloption();

        if (isset($statuses[$this->is_approved])) {
            if ($this->is_approved == 1) {
                return 'Approved';
            } else if ($this->is_approved == 0) {
                return 'Pending';
            }
        }
        return $this->status;
    }
}
