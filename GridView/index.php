<?php

use yii\grid\GridView;
use app\models\ProductSearch;

$searchModel = new ProductSearch();

$dataProvider = $searchModel->search(Yii::$app->request->get(),$filename,$filenameSub);

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