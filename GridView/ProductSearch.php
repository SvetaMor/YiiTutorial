<?php

namespace app\models;

use yii\base\Model;
use yii\data\ArrayDataProvider;

class ProductSearch extends Model
{
   public $id;
   public $price;
   public $categoryId;
   public $hidden;
    
   public function rules()
   {
      return [
         [['id', 'price', 'hidden'], 'integer'],
         [['categoryId'], 'string'],
         ];
   }
   
   public function search($param,$arr)
   {
      $jsonStr = json_encode($param);
      $resultArray = json_decode($jsonStr, TRUE);
      
      $newArr = [];
      if (isset($resultArray["ProductSearch"])) {
        
         $filter = array_filter($resultArray["ProductSearch"], function($v){
            return ($v != "");
         });
        
         
         $key = array_keys($filter)[0];
         $value = $filter[$key];
         
         $limit = count($arr);
         for ($count = 0; $count < $limit; ++$count) {
            $values = array_filter($arr[$count], function($v, $k) use ($key,$value) {
               return ($k == $key and $v == $value);
            }, ARRAY_FILTER_USE_BOTH);
            
            if (count($values) != 0)
               $newArr[] = $arr[$count];
         }
         
         $arr = $newArr;
         
      }
      
      $dataProvider = new ArrayDataProvider([
          'allModels' => $arr,
          'pagination' => [
              'pageSize' => 5,
          ],
          'sort' => [
              'attributes' => ['categoryId', 'price'],
          ],
      ]);

        return $dataProvider;
    }
}
