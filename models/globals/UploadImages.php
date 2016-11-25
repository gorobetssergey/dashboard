<?php
namespace app\models\globals;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadImages extends Model
{
    /**
     * @var UploadedFile[]
     * @property array $galleryImages
     */
    public $galleryImages;

    public function rules()
    {
        return [
            [['galleryImages'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg', 'maxFiles' => 10],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->galleryImages as $file) {
                $file->saveAs('images/items/transport' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }

    }
}