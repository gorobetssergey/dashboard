<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "properties".
 *
 * @property integer $id
 * @property string $name
 *
 * @property PropertiesGroup[] $propertiesGroups
 * @property TransportProp[] $transportProps
 */
class Properties extends \yii\db\ActiveRecord
{
    const BREND_TIRES =  [
        "1" => 'ACCELERA',
        "2" => 'ACHILLES',
        "3" => 'AEOLUS',
        "4" => 'ALTENZO',
        "5" => 'AMTEL',
        "6" => 'ANTARES',
        "7" => 'APLUS',
        "8" => 'APOLLO',
        "9" => 'ARTUM',
        "10" => 'АШК (БАРНАУЛ)',
        "11" => 'ATLAS',
        "12" => 'ATTURO',
        "13" => 'AUFINE',
        "14" => 'AURORA',
        "15" => 'AUSTONE',
        "16" => 'AUTOGRIP',
        "17" => 'AVATYRE',
        "18" => 'AVON',
        "19" => 'BARUM',
        "20" => 'BCT',
        "21" => 'БЕЛШИНА',
        "22" => 'BFGOODRICH',
        "23" => 'BONTYRE',
        "24" => 'BRIDGESTONE',
        "25" => 'COMFORSER',
        "26" => 'COMPASS',
        "27" => 'CONTINENTAL',
        "28" => 'CONTYRE',
        "29" => 'COOPER',
        "30" => 'CORDIANT',
        "31" => 'CORDOVAN',
        "32" => 'COURIER',
        "33" => 'DAEWOO',
        "34" => 'DAYTON',
        "35" => 'DEAN TIRES',
        "36" => 'DEBICA',
        "37" => 'DELTA',
        "38" => 'DIPLOMAT',
        "39" => 'DMACK',
        "40" => 'DOUBLESTAR',
        "41" => 'DUNLOP',
        "42" => 'DURUN',
        "43" => 'ELDORADO',
        "44" => 'EVERGREEN',
        "45" => 'FALKEN',
        "46" => 'FATE',
        "47" => 'FEDERAL',
        "48" => 'FIRESTONE',
        "49" => 'FIRSTSTOP',
        "50" => 'FORMULA',
        "51" => 'FORTUNA',
        "52" => 'FULDA',
        "53" => 'FULLRUN',
        "54" => 'FULLWAY',
        "55" => 'GENERAL TIRE',
        "56" => 'GISLAVED',
        "57" => 'GOFORM',
        "58" => 'GOODRIDE',
        "59" => 'GOODYEAR',
        "60" => 'GRIPMAX',
        "61" => 'GT RADIAL',
        "62" => 'HABILEAD',
        "63" => 'HAIDA',
        "64" => 'HANKOOK',
        "65" => 'HEADWAY',
        "66" => 'HERCULES',
        "67" => 'HIFLY',
        "68" => 'HORIZON',
        "69" => 'INFINITY',
        "70" => 'INTERSTATE',
        "71" => 'IRONMAN',
        "72" => 'JINYU',
        "73" => 'JOYROAD',
        "74" => 'КАМА (НКШЗ)',
        "75" => 'KAPSEN',
        "76" => 'KELLY',
        "77" => 'KENDA',
        "78" => 'KETER',
        "79" => 'KINFOREST',
        "80" => 'KINGRUN',
        "81" => 'KINGSTAR',
        "82" => 'KLEBER',
        "83" => 'KORMORAN',
        "84" => 'KUMHO',
        "85" => 'LAKESEA',
        "86" => 'LANDSAIL',
        "87" => 'LANVIGATOR',
        "88" => 'LASSA',
        "89" => 'LAUFENN',
        "90" => 'LINGLONG',
        "91" => 'MABOR',
        "92" => 'MANSORY',
        "93" => 'MARANGONI',
        "94" => 'MARSHAL',
        "95" => 'MASTERCRAFT',
        "96" => 'MATADOR',
        "97" => 'MAXTREK',
        "98" => 'MAXXIS',
        "99" => 'MEMBAT',
        "100" => 'MENTOR',
        "101" => 'MICHELIN',
        "102" => 'MINERVA',
        "103" => 'MIRAGE',
        "104" => 'MOTOMASTER',
        "105" => 'MOTRIO',
        "106" => 'NAMA',
        "107" => 'NANKANG',
        "108" => 'NEXEN',
        "109" => 'NITTO',
        "110" => 'NOKIAN',
        "111" => 'ORIUM',
        "112" => 'OVATION',
        "113" => 'PAXARO',
        "114" => 'PETLAS',
        "115" => 'PIRELLI',
        "116" => 'POINTS',
        "117" => 'PREMIORRI',
        "118" => 'PRESA',
        "119" => 'PRO COMP',
        "120" => 'PROFIL',
        "121" => 'RADAR',
        "122" => 'RIKEN',
        "123" => 'ROADSTONE',
        "124" => 'ROCKSTONE',
        "125" => 'ROSAVA',
        "126" => 'ROTALLA',
        "127" => 'ROTEX',
        "128" => 'SAETTA',
        "129" => 'SAILUN',
        "130" => 'SANNY',
        "131" => 'SATOYA',
        "132" => 'SAVA',
        "133" => 'SAXON',
        "134" => 'SEIBERLING',
        "135" => 'SEMPERIT',
        "136" => 'SIGMA',
        "137" => 'SILVERSTONE',
        "138" => 'SPORTIVA',
        "139" => 'STARFIRE',
        "140" => 'STARMAXX',
        "141" => 'STRIAL',
        "142" => 'SUMITOMO',
        "143" => 'SUMO TIRE',
        "144" => 'SUNFULL',
        "145" => 'SUNITRAC',
        "146" => 'SUNNY',
        "147" => 'SYRON',
        "148" => 'TAURUS',
        "149" => 'TIGAR',
        "150" => 'TOYO',
        "151" => 'TRACMAX',
        "152" => 'TRIANGLE',
        "153" => 'TRISTAR',
        "154" => 'TUNGA',
        "155" => 'UNIROYAL',
        "156" => 'VIATTI',
        "157" => 'VIKING',
        "158" => 'VOLTYRE',
        "159" => 'VOYAGER',
        "160" => 'VREDESTEIN',
        "161" => 'VSP',
        "162" => 'WANLI',
        "163" => 'WESTLAKE',
        "164" => 'WINDA',
        "165" => 'WOLFSBURG',
        "166" => 'YOKOHAMA',
        "167" => 'ZEETEX',
        "168" => 'ZETA',
        "169" => 'ZETUM',
    ];

    const SEASON_TIRES = [
        '170' => 'Зима',
        '171' => 'Лето',
        '172' => 'Всесезонка'
    ];

    const WIDTH_TIRES = [
        "173" => 3.5,
        "174" => 3.25,
        "175" => 6.5,
        "176" => 7.00,
        "177" => 7.5,
        "178" => 30,
        "179" => 31,
        "180" => 33,
        "181" => 37,
        "182" => 135,
        "183" => 145,
        "184" => 155,
        "185" => 165,
        "186" => 175,
        "187" => 185,
        "188" => 195,
        "189" => 205,
        "190" => 215,
        "191" => 225,
        "192" => 235,
        "193" => 245,
        "194" => 255,
        "195" => 265,
        "196" => 275,
        "197" => 285,
        "198" => 295,
        "199" => 305,
        "200" => 315,
        "201" => 365,
    ];

    const SIDE_VIEW_TIRES = [
        "202" => 9.5,
        "203" => 10.5,
        "204" => 11.5,
        "205" => 12.5,
        "206" => 35,
        "207" => 40,
        "208" => 45,
        "209" => 50,
        "210" => 55,
        "211" => 60,
        "212" => 65,
        "213" => 70,
        "214" => 75,
        "215" => 80,
        "216" => 85,
        "217" => 90,
        "218" => 100,
    ];

    const DIAMETER_TIRES = [
        "219" => 'R12',
        "220" => 'R12C',
        "221" => 'R13',
        "222" => 'R13C',
        "223" => 'R14',
        "224" => 'R14C',
        "225" => 'R15',
        "226" => 'R15C',
        "227" => 'R16',
        "228" => 'R16C',
        "229" => 'R17',
        "230" => 'R17.5',
        "231" => 'R17C',
        "232" => 'R18',
        "233" => 'R19',
        "234" => 'R20',
        "235" => 'R21',
        "236" => 'R22',
    ];

    const CAR_TYPE_TIRES = [
        "237" => 'Легковые',
        "238" => 'Грузовые',
        "239" => 'Грузопассажирские'
    ];

    const THORNS_TIRES = [
        '240' => 'Ошипованная',
        '241' => 'Без шипов'
    ];

    const CAN_THORNS_TIRES = [
        '242' => 'Возможность ошиповки',
        '243' => 'Без возможности ошиповки'
    ];
    const TYPE_SALES = [
        '244' => 'без доставки',
        '245' => 'Нова пошта',
        '246' => 'Экспресс мейл',
        '247' => 'Meest Express',
        '248' => 'КМ ЭКСПРЕСС'
    ];
    const OLD_PRODUCT = [
        '249' => 'новий',
        '250' => 'б/у'
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'properties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertiesGroups()
    {
        return $this->hasMany(PropertiesGroup::className(), ['prop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransportProps()
    {
        return $this->hasMany(TransportProp::className(), ['prop_id' => 'id']);
    }
}
