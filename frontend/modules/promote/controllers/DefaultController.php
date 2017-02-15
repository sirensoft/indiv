<?php

namespace frontend\modules\promote\controllers;

use yii\web\Controller;
use frontend\modules\promote\models\RptDspm;
use frontend\modules\promote\models\RptHct;

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

}
