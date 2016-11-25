<?php
namespace app\models\globals;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $titleImage;
    

    public function rules()
    {
        return [
            [['titleImage'], 'file', 'skipOnEmpty' => false, 'enableClientValidation'=>true,
                'maxSize'=>512000, 'on' => 'transport_tires'],
        ];
    }

    public function upload($file, $data)
    {
        $this->titleImage = $file;
        if ($this->validate() && $this->titleImage->saveAs($data)) {
            return true;
        } else {
            return false;
        }
    }
}