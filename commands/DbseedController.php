<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use Yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DbseedController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */

    public $sql;
    public function actionIndex()
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            Yii::$app->db->createCommand()->batchInsert('topmenu', ['title'], [
                ['transport'],
                ['real_estate'],
                ['child_world'],
                ['job'],
                ['animals'],
                ['house_garden'],
                ['electronics'],
                ['business_and_services'],
                ['fashion_style'],
                ['sport'],
                ['helping'],
                ['giveAwey'],
                ['exchange'],
            ])->execute();

            Yii::$app->db->createCommand()->batchInsert('submenu', ['title'], [
                ['tires_and_wheels'],               //1
                ['spare_parts_for_speciale'],       //2
                ['cars'],                           //3
                ['motozapchastey_and_accessories'], //4
                ['motorcycles'],                    //5
                ['agriculture'],                    //6
                ['trucks'],                         //7
                ['buses'],                          //8
                ['spesial_tehnik'],                 //9
                ['air_transport'],                  //10
                ['woter_transpotr'],                //11
                ['other_transport'] ,               //12
                ['trailers'],                       //13
                ['spec_acessories'],                //14
                ['spare_parts'],                    //15
                //real_estate
                ['apartments_rent'],                //16
                ['land_lease'],                     //17
                ['apartments'],                     //18
                ['land_sale'],                      //19
                ['sale_space'],                     //20
                ['garage'],                         //21
                ['rooms_rent'],                     //132
                ['rental_garage_parking'],          //22
                ['sale_rooms'],                     //23
                ['sale_garages_parking'],           //24
                ['real_estate_exchange'],           //25
                ['lease_houses'],                   //26
                ['looking_companion'],              //27
                ['sale_houses'],                    //28
                ['rental_premises'],                //29
                ['other_real_estate'],              //30
                //child_world
                ['clothes'],                        //31
                ['child_car_seats'],                //32
                ['children_transport'],             //33
                ['other_children_products'],        //34
                ['children_shoes'],                 //35
                ['children_furniture'],             //36
                ['nursing_products'],               //37
                ['baby_carriage'],                  //38
                ['toys'],                           //39
                ['goods_schoolboys'],               //40
                //(job) old version, do not use them
                ['retail_sale_purchase'],           //41
                ['legal_accounting'],               //42
                ['human_resources_HR'],             //43
                ['transport_logistics'],            //44
                ['building'],                       //45
                ['bars_restaurants'],               //46
                ['security_safety'],                //47
                ['domestic_staff'],                 //48
                ['beauty_fitness_sport'],           //49
                ['tourism_recreation_activities'],  //50
                ['education'],                      //51
                ['culture_arts'],                   //52
                ['medical_pharmacy'],               //53
                ['IT_telecom_computer'],            //54
                ['banking_finance_insurance'],      //55
                ['realty'],                         //56
                ['marketing_advertising_design'],   //57
                ['manufacturing_energy'],           //58
                ['telecommunications_communications'],  //59
                ['agriculture_agribusiness_forestry'],  //60
                ['secretariat_operations'],         //61
                ['part_time_employment'],           //62
                ['early_career_students'],          //63
                ['service_life'],                   //64
                ['other_areas_employment'],         //65
                ['work_abroad'],                    //66
                //animals
                ['free'],                           //67
                ['cats'],                           //68
                ['dogs'],                           //69
                ['aquaria'],                        //70
                ['birds'],                          //71
                ['rodents'],                        //72
                ['reptiles'],                       //73
                ['agricultural_animals'],           //74
                ['other_animals'],                  //75
                ['pet_supplies'],                   //76
                ['knitting'],                       //77
                ['lost_found'],                     //78
                //house_garden
                ['office_supplies_consumables'],    //79
                ['furniture'],                      //80
                ['food_drinks'],                    //81
                ['interior_decorations'],           //82
                ['garden'],                         //83
                ['instruments'],                    //84
                ['building_repair'],                //86
                ['houseplants'],                    //87
                ['crockery_cooking_utensils'],      //88
                ['garden_tools'],                   //89
                ['household_equipment_household_chemicals'],    //90
                ['other_household_goods'],          //91
                //electronics
                ['phones_accessories'],             //92
                ['computers_accessories'],          //93
                ['photo_video'],                    //94
                ['tv_video'],                       //95
                ['games_consoles'],                 //96
                ['tablets_books_accessories'],      //97
                ['home_appliances'],                //98
                ['kitchen_appliances'],             //99
                ['climatic_equipment'],             //100
                ['individualized_care'],            //101
                ['accessories_components'],         //102
                ['other_electronics'],              //103
                ['repair_maintenance_machinery'],   //104
                ['business_services'],              //105
                ['audio'],                          //106
                ['laptops_accessories'],            //107
                //business_and_services
                ['building_repair_cleaning'],       //108
                ['financial_services_partnership'], //109
                ['transportation_transportation_rent'], //110
                ['advertisement_printing_marketing_internet'],  //111
                ['raw_materials'],                  //112
                ['equipment'],                      //113
                ['education_sports'],               //114
                ['animal_services'],                //115
                ['business_sales'],                 //116
                ['entertainment_arts_photography_video'],   //117
                ['tourism_immigration'],            //118
                ['interpreter_typing'],             //119
                ['auto_moto_services'],             //120
                ['repair_maintenance_machinery'],   //104   //104
                ['network_marketing'],              //122
                ['legal_services'],                 //123
                ['beauty_health'],                  //124
                ['nannies_nurse'],                  //125
                ['rolled_goods'],                   //126
                ['other_services'],                 //127
                //fashion_style
                ['clothes_shoes'],                  //128
                ['accessories'],                    //129
                ['presents'],                       //130
                ['for_wedding'],                    //131
                ['wrist_watch'],                    //132
                ['beauty_health'],                  //124   //124
                ['fashion_different'],              //134
                //sport
                ['antiques_collections'],           //135
                ['books_magazines'],                //136
                ['musical_instruments'],            //137
                ['sport_relax'],                    //138
                ['CD_DVD_record_cassette'],         //139
                ['tickets'],                        //140
                ['search_travel'],                  //141
                ['search_bands_musicians'],         //142
                ['other'],                          //143
                //helping
                ['need_help'],                      //144
                //giveAwey
                ['child_world'],                    //145
                ['house_garden'],                   //146
                ['animals'],                        //147
                ['electronics'],                    //148
                ['business_services'],              //149
                ['fashion_style'],                  //150
                //exchange
                ['child_world'],                    //151
                ['animals'],                        //152
                ['transport'],                      //153
                ['house_garden'],                   //146   //146
                ['business_services'],              //149   //149
                ['electronics'],                    //148   //148
                ['fashion_style'],                  //150   //150
                ['hobbies_sports'],                 //154
                //+job
                ['jobs_category'],                  //159
                ['jobs_cities'],                    //160
                ['work_students'],                  //161
            ])->execute();

//            $submenu = (new \yii\db\Query())
//                ->select('id')
//                ->from('submenu')
//                ->all();
//
//            $top_cab = [];
//            foreach ($submenu as $item) {
//                $top_cab[] = [1,(int)$item['id']];
//            }
            Yii::$app->db->createCommand()->batchInsert('top_sub', ['id_top','id_sub'],[
                [1, 1],
                [1, 2],
                [1, 3],
                [1, 4],
                [1, 5],
                [1, 6],
                [1, 7],
                [1, 8],
                [1, 9],
                [1, 10],
                [1, 11],
                [1, 12],
                [1, 13],
                [1, 14],
                [1, 15],

                [2, 16],
                [2, 17],
                [2, 18],
                [2, 19],
                [2, 20],
                [2, 21],
                [2, 132],
                [2, 22],
                [2, 23],
                [2, 24],
                [2, 25],
                [2, 26],
                [2, 27],
                [2, 28],
                [2, 29],
                [2, 30],

                [3, 31],
                [3, 32],
                [3, 33],
                [3, 34],
                [3, 35],
                [3, 36],
                [3, 37],
                [3, 38],
                [3, 39],
                [3, 40],

                [4, 159],
                [4, 160],
                [4, 161],

                [5, 67],
                [5, 68],
                [5, 69],
                [5, 70],
                [5, 71],
                [5, 72],
                [5, 73],
                [5, 74],
                [5, 75],
                [5, 76],
                [5, 77],
                [5, 78],
                [5, 78],

                [6, 79],
                [6, 80],
                [6, 83],
                [6, 84],
                [6, 86],
                [6, 87],
                [6, 88],
                [6, 89],
                [6, 90],
                [6, 91],

                [7, 92],
                [7, 93],
                [7, 94],
                [7, 95],
                [7, 96],
                [7, 97],
                [7, 98],
                [7, 99],
                [7, 100],
                [7, 101],
                [7, 102],
                [7, 103],
                [7, 107],

                [8, 108],
                [8, 109],
                [8, 110],
                [8, 111],
                [8, 111],
                [8, 112],
                [8, 113],
                [8, 114],
                [8, 115],
                [8, 116],
                [8, 117],
                [8, 118],
                [8, 119],
                [8, 120],
                [8, 104],
                [8, 122],
                [8, 123],
                [8, 124],
                [8, 125],
                [8, 126],
                [8, 127],

                [9, 128],
                [9, 129],
                [9, 130],
                [9, 131],
                [9, 132],
                [9, 124],
                [9, 134],

                [10, 135],
                [10, 136],
                [10, 137],
                [10, 138],
                [10, 139],
                [10, 140],
                [10, 141],
                [10, 142],
                [10, 143],

                [11, 144],

                [12, 145],
                [12, 146],
                [12, 147],
                [12, 148],
                [12, 149],
                [12, 150],

                [13, 151],
                [13, 152],
                [13, 153],
                [13, 146],
                [13, 149],
                [13, 148],
                [13, 150],
                [13, 158]
                ])->execute();;

            Yii::$app->db->createCommand()->batchInsert('catalog', ['title'], [
                ['Tires'],              //1
                ['Discs'],              //2
                ['Complete_wheels'],    //3
                ['Covers'],             //4
                ['motorcycle_tires']    //5
            ])->execute();
//            $catalog = (new \yii\db\Query())
//                ->select('id')
//                ->from('catalog')
//                ->all();
            $cat_cab = [];
//            foreach ($catalog as $item) {
//                $cat_cab[] = [1,(int)$item['id']];
//            }


            Yii::$app->db->createCommand()->batchInsert('sub_cat', ['id_sub','id_cat'], [
                [1, 1],
                [1, 2],
                [1, 3],
                [1, 4],
                [1, 5]
            ])->execute();

            Yii::$app->db->createCommand()->batchInsert('properties', ['name'], [
                ['price_tires'],
                ['brand_name_tires'],
                ['season_tires'],
                ['width_tires'],
                ['side_view_tires'],
                ['diameter_tires'],
                ['car_type_tires'],
                ['thorns_tires'],
                ['can_thorns_tires'],
                ['delivery_tires'],
                ['old_tires'],
                ['descriptions_tires'],
                ['name_tires']
            ])->execute();

            $properties = (new \yii\db\Query())
                ->select('id')
                ->from('properties')
                ->all();
            $prop_group = [];
            foreach ($properties as $item) {
                $prop_group[] = [1,(int)$item['id']];
            }
            Yii::$app->db->createCommand()->batchInsert('properties_group', ['groups','prop_id'], $prop_group)->execute();


            Yii::$app->db->createCommand()->batchInsert('role', ['value'], [
                ['user'],
                ['admin'],
                ['moderator']
            ])->execute();

            /**
             * status items
             */

            Yii::$app->db->createCommand()->batchInsert('status_items', ['status'], [
                ['vip'],
                ['top'],
                ['standart']
            ])->execute();

            /**
             * ounership user
             */

            Yii::$app->db->createCommand()->batchInsert('ownership', ['value'], [
                ['incognito'],
                ['user'],
                ['entity'],
                ['individual']
            ])->execute();

            /*
             * test data to table user
             */


//            Yii::$app->db->createCommand()->batchInsert('users', ['email','role','active','password','repassword','token','created','auth'], [
//                ['user@user.net',1,1,'qqqqqqqq','wwwwwwww','eeeeeeee','2016-10-12 23:00:00',1]
//            ])->execute();

            Yii::$app->db->createCommand()->batchInsert('level', ['value'], [
                ['bonus'],
                ['user'],
                ['junior'],
                ['middle'],
                ['senior'],
                ['top'],
                ['vip'],
                ['menedger'],
                ['boss'],
                ['prezident'],
            ])->execute();

            $transaction->commit();

        } catch(\Exception $e) {

            $transaction->rollBack();

            throw $e;
        }
    }
}
