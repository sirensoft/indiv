<?php
$css = <<< CSS
.alignment
{
    margin-top:10px;
}
CSS;
$this->registerCss($css);

use kartik\grid\GridView;
use common\components\MyHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'ผลการดำเนินการการคัดกรองพัฒนาการเด็กตามกลุ่มอายุ special pp';
$this->params['breadcrumbs'][] = ['label'=>'รายงานกลุ่มงานส่งเสริม','url'=>['/promote/default/index']];
$this->params['breadcrumbs'][] = $this->title;


$sql = " SELECT DISTINCT t.amp_name id,t.amp_name val FROM chospital_amp t ";

$items = MyHelper::dropDownItems($sql, 'id', 'val');
?>
<div class="patient-search" style="margin-bottom: 10px">

    <?php
    $form = ActiveForm::begin([
                'action' => ['/promote/default/dspm'],
                'method' => 'get',
    ]);
    ?>

    <div class="input-group" >
        
        <?= $form->field($searchModel, 'cup')->dropDownList($items, ['prompt' => '-- เลือก cup --'])->label(FALSE); ?>
        <span class="input-group-btn">
            <button class="btn btn-default alignment" type="submit">
                <i class="glyphicon glyphicon-search"></i> ตกลง
            </button>
        </span>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php

$sql_hos = " select h.hoscode id,h.hoscode val from chospital_amp h where h.amp_name = '$searchModel->cup' ";
echo GridView::widget([
    'responsiveWrap' => false,
    'responsive' => FALSE,
    'containerOptions' => ['style'=>'overflow: auto'],
    //'floatHeader' => true,
    
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    
    'panel'=>[
        'before'=>'<a href="https://goo.gl/5lxxuK" target="_blank">[ดูผลรวม-คลิก]</a>',
        'heading'=>'รายชื่อเด็กมีวันที่วันแรกที่อายุแตะ 9,18,30,42 เดือน ในปีงบประมาณปัจจุบัน'
    ],
    'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'หน่วยบริการ', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                ['content'=>'กลุ่มเป้าหมาย', 'options'=>['colspan'=>7, 'class'=>'text-center warning']],
                
                ['content'=>'คัดกรองครั้งที่1', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                ['content'=>'คัดกรองครั้งที่2', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning']], 
            ],
            //'options'=>['class'=>'skip-export'] // remove this row from export
        ]
    ],
    'columns' => [
        /* [
          'attribute' => 'cup',
          'label' => 'CUP',
          //'filter' => MyHelper::dropDownItems($sql, 'id', 'val')
          ], */
        [
            'attribute' =>'hospcode',
            'filter' => MyHelper::dropDownItems($sql_hos, 'id', 'val')
        ],
        'hosname',
        'pid',
        [
            'attribute'=>'name',
            'width'=>'80px',
            'noWrap'=>true
        ],
       [
           'attribute'=>'sex',
           'label'=>'เพศ',
           'value'=>function($model){
                if(!isset($model['sex'])){
                    return null;
                }
                $sex = 'ญ';
                if($model['sex']==1)$sex='ช';
                return $sex;
           }
       ],
        //'sex:text:เพศ',
        'birth:date:เกิด',
        [
            'attribute'=>'c_age',
            'label'=>'ปัจจุบัน(ด)',
            'mergeHeader'=>true,
            'vAlign'=>'middle',
            
        ],
          
        [
            'attribute'=>'age_m',
            'format'=>'integer',
            'label'=>'กลุ่ม(ด)',
            'filter'=>['9'=>'9ด','18'=>'18ด','30'=>'30ด','42'=>'42ด']
        ],
        'date_start:date:วันอายุแตะ',     
        
        //'age_m:integer:อายุ(ด)',
        'date_serv_first:date:วันที่',
        'sp_first:text:รหัส',
        'date_serv_last:date:วันที่',
        'sp_last:text:รหัส',
        [
            'attribute'=>'color',
            'label'=>'lose',
            'filter'=>['yes'=>'yes']
        ]
    ],
    'rowOptions' => function ($model, $index, $widget, $grid){
      if(empty($model['color'])){
            return [];
      }
      if($model['color'] == 'yes' and $model['c_age']==$model['age_m']){
       return ['style'=>'background-color:yellow'];
      }
      if($model['color'] == 'yes'){
       return ['style'=>'color:white;background-color:#fd3434'];
      }
      return [];
    },
     'hover'=>true
]);
