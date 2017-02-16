<?php

namespace frontend\modules\promote\controllers;

use yii\web\Controller;
use frontend\modules\promote\models\RptDspm;
use frontend\modules\promote\models\RptHct;
use frontend\modules\promote\models\RptPap;
use frontend\modules\promote\models\RptBreast;
use frontend\modules\promote\models\RptLborn1519;

/**
 * Default controller for the `promote` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionDspm() {
        $searchModel = new RptDspm();
       
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        

        return $this->render('dspm', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
    public function actionHct() {
        $searchModel = new RptHct();
       
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        

        return $this->render('hct', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
    public function actionPap() {
        $searchModel = new RptPap();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('pap', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    
    public function actionBreast() {
        $searchModel = new RptBreast();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('breast', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    public function actionLborn1519() {
        $searchModel = new RptLborn1519();      
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('lborn1519', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }

}
