<?php
namespace app\models\globals;

use app\models\Items;
use app\models\PhotoTransport;
use app\models\User;
use app\models\Users;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadImages extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg', 'maxFiles' => 10],
        ];
    }
    public function attributeLabels()
    {
        return [
            'imageFiles' => 'Галерея',
        ];
    }
    private function saveImageName($column, $catalog, $name){
        $id = Yii::$app->getSession()->getFlash('id_row_photo');
        switch ($column){
            case 'photo_1' : {
                $x = new PhotoTransport();
                $photo = $x::findOne($id);
                    $photo->photo_1 = $name;
                    $photo->update();
            }break;
            case 'photo_2' : { $photo = PhotoTransport::findOne($id);
                $photo->photo_2 = $name;
                $photo->update();
            }break;
            case 'photo_3' : { $photo = PhotoTransport::findOne($id);
                $photo->photo_3 = $name;
                $photo->update();
            }break;
            case 'photo_4' : { $photo = PhotoTransport::findOne($id);
                $photo->photo_4 = $name;
                $photo->update();
            }break;
            case 'photo_5' : { $photo = PhotoTransport::findOne($id);
                $photo->photo_5 = $name;
                $photo->update();
            }break;
            case 'photo_6' : { $photo = PhotoTransport::findOne($id);
                $photo->photo_6 = $name;
                $photo->update();
            }break;
            case 'photo_7' : { $photo = PhotoTransport::findOne($id);
                $photo->photo_7 = $name;
                $photo->update();
            }break;
            case 'photo_8' : { $photo = PhotoTransport::findOne($id);
                $photo->photo_8 = $name;
                $photo->update();
            }break;
            case 'photo_9' : { $photo = PhotoTransport::findOne($id);
                $photo->photo_9 = $name;
                $photo->update();
            }break;
            case 'photo_10' : { $photo = PhotoTransport::findOne($id);
                $photo->photo_10 = $name;
                $photo->update();
            }break;
        }
    }

    public function upload($catalog)
    {
        $modelItems = new Items();

        if ($this->validate()) {
            foreach ($this->imageFiles as $key => $file) {
                $name = $modelItems::TITLE_IMAGE_PATH[$catalog].Users::id().'_'.$key.'_'.date("Ymd_His") . '.' . $file->extension;
                $file->saveAs($modelItems->setPathPhoto($catalog).$name);
                switch ($key){
                    case 0 : { self::saveImageName('photo_1', $catalog, $name);}break;
                    case 1 : { self::saveImageName('photo_2', $catalog, $name);}break;
                    case 2 : { self::saveImageName('photo_3', $catalog, $name);}break;
                    case 3 : { self::saveImageName('photo_4', $catalog, $name);}break;
                    case 4 : { self::saveImageName('photo_5', $catalog, $name);}break;
                    case 5 : { self::saveImageName('photo_6', $catalog, $name);}break;
                    case 6 : { self::saveImageName('photo_7', $catalog, $name);}break;
                    case 7 : { self::saveImageName('photo_8', $catalog, $name);}break;
                    case 8 : { self::saveImageName('photo_9', $catalog, $name);}break;
                    case 9 : { self::saveImageName('photo_10', $catalog, $name);}break;
                }
            }
            return true;
        } else {
            return false;
        }
    }
}