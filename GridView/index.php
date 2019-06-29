<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider; 
use app\models\ProductSearch;

$models = [];
$colomn = 'categoryId';
$colomnSub = 'name';
$atr = 'item';
$filename =  Yii::getAlias('@webroot').'/files/products.xml';
$filenameSub = Yii::getAlias('@webroot').'/files/categories.xml';
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

$searchModel = new ProductSearch();
$dataProvider = $searchModel->search(Yii::$app->request->get(),$models);

echo GridView::widget([
   'dataProvider' => $dataProvider,
   'filterModel' => $searchModel,
   'columns' => [
     ['class' => 'yii\grid\SerialColumn'],
     'id',
     'categoryId',
     'price',
     'hidden',
   ],
]);
