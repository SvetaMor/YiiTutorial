<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Sort;

class ProductController extends Controller {
  
   public function actionIndex(){
      $sort = new Sort([
         'attributes' => [
            'categoryId',
            'price',
         ],
      ]);
      
      return $this->render('index', [
         'sort' => $sort,
      ]);
   }
}