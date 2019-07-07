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
   
   public function search($param)
   {
      $models = [];
      $colomn = 'categoryId';
      $colomnSub = 'name';
      $atr = 'item';
      $filename =  \Yii::getAlias('@webroot').'/files/products.xml';
      $filenameSub = \Yii::getAlias('@webroot').'/files/categories.xml';
      $fileObject = simplexml_load_file($filename);
      $fileObjectSub = simplexml_load_file($filenameSub);
      $jsonString = json_encode($fileObject);
      $resultArray = json_decode($jsonString, TRUE); 
      $jsonStringSub = json_encode($fileObjectSub);
      $resultArraySub = json_decode($jsonStringSub, TRUE);
      $limit = $fileObject->count();
      for ($count = 0; $count < $limit; ++$count) {
         $models[] = $resultArray[$atr][$count];
         $num = $resultArray[$atr][$count][$colomn]-1;
         $models[$count][$colomn] = $resultArraySub[$atr][$num][$colomnSub];
      }
      
      $jsonStr = json_encode($param);
      $resultArray = json_decode($jsonStr, TRUE);
      
      $newArr = [];
      if (isset($resultArray["ProductSearch"])) {
        
         $filter = array_filter($resultArray["ProductSearch"], function($v){
             return ($v != "");
            });
         
         $key = array_keys($filter)[0];
         $value = $filter[$key];
         
         $limit = count($models);
         for ($count = 0; $count < $limit; ++$count) {
            $values = array_filter($models[$count], function($v, $k) use ($key,$value) {
               return ($k == $key and $v == $value);
            }, ARRAY_FILTER_USE_BOTH);
            if (count($values) != 0)
               $newArr[] = $models[$count];
         }
        $models =  $newArr;
      }
      
      $dataProvider = new ArrayDataProvider([
          'allModels' => $models,
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