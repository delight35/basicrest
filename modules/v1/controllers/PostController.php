<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;
use app\controllers\BaseApiController;
use app\modules\v1\resources\PostResource;
use app\models\Post;

class PostController extends BaseApiController
{   
    public $modelClass = PostResource::class;
    
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'dataIndex'];
        return $actions;
    }    
    
    public function dataIndex() 
    {
        $limitParam = Yii::$app->request->get('limit');
        // TODO : cityid and offset..
        $offsetParam = Yii::$app->request->get('offset');
        //$cityParam = Yii::$app->request->get('cityid');
        
        $validatorNumber = new NumberValidator();
        
        if (!$validatorNumber->validate($limitParam) || $limitParam == null) {
            $limitParam = Post::DEFAULT_LIMIT;
        } 
        
        if (!$validatorNumber->validate($offsetParam) || $offsetParam == null) {
            $offsetParam = Post::DEFAULT_OFFSET;
        }
        
        //$validatorString = new StringValidator();
        
        //if (!$validatorString->validate($cityParam) || $cityParam == null) {
        //    $cityParam = '';
        //}       

        $query = Post::find()
                ->offset($offsetParam)
                ->limit($limitParam);
        
        return Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $query,
            'pagination' => false
        ]);
    }
}

