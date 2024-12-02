<?php
namespace common\models\cms\contentmanagement\form;
use common\models\cms\contentmanagement\ContentManagement;
use common\models\faq\Faq;
use common\models\GeneralModel;
use Yii;
use yii\base\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $type P=>Page,B=>Block
 * @property string $content
 * @property string|null $remark
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $updated_by
 * @property int $created_by
 */
class ContentManagementForm extends Model
{
    public $id;
    public $name;
    public $type;
    public $content;
    public $remark;
    public $status;
    public $created_by;
    public $created_at;
    public $updated_by;
    public $updated_at;
    public $status_option = [];

    public $formModel;

    public function __construct(ContentManagement $formModel = null, $config = [])
    {
        parent::__construct($config);

        if ($formModel === null) {
            $this->formModel = new ContentManagement();
        } else {
            $this->formModel = $formModel;
            $this->name = $this->formModel->name;
            $this->type = $this->formModel->type;
            $this->content = $this->formModel->content;
            $this->remark = $this->formModel->remark;
            $this->status = $this->formModel->status;
            $this->created_at = $this->formModel->created_at;
            $this->updated_at = $this->formModel->updated_at;
            $this->created_by = $this->formModel->created_by;
            $this->updated_by = $this->formModel->updated_by;
        }
        $this->status_option = GeneralModel::statusOption();
    }

    public function rules()
    {
        return [
            [['name', 'type', 'content'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['name', 'remark'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'content' => 'Content',
            'remark' => 'Remark',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function save($runValidation = true, $attributequestions = null)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }

        $this->initializeForm();
        return $this->formModel->save();
    }

    public function initializeForm()
    {
        $this->formModel->name = $this->name;
        $this->formModel->type = $this->type;
        $this->formModel->content = $this->content;
        $this->formModel->remark = $this->remark;
        $this->formModel->status = $this->status;
    }
}
