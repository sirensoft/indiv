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

$this->title = 'การคัดกรองผู้สูงอายุ 10 เรื่อง';
$this->params['breadcrumbs'][] = ['label'=>'รายงานกลุ่มงานส่งเสริม','url'=>['/promote/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$sql = " SELECT DISTINCT t.amp_name id,t.amp_name val FROM chospital_amp t ";

$items = MyHelper::dropDownItems($sql, 'id', 'val');
?>
<div class="patient-search" style="margin-bottom: 10px">

    <?php
    $form = ActiveForm::begin([
                'action' => ['/promote/default/aging'],
                'method' => 'get',
    ]);
    ?>

    <div class="input-group">
        
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
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'panel'=>[
        'before'=>'<a href="https://goo.gl/wLlr4M" target="_blank">[ดูผลรวม-คลิก]</a>',
        'heading'=>'รายชื่อ'
    ],
    'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'หน่วยบริการ', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                ['content'=>'กลุ่มเป้าหมาย', 'options'=>['colspan'=>5, 'class'=>'text-center warning']],
                ['content'=>'ADL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                ['content'=>'เบาหวาน', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                ['content'=>'ความดัน', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                ['content'=>'CVD', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                ['content'=>'ช่องปาก', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                ['content'=>'สมองเสื่อม', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                ['content'=>'2Q', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                ['content'=>'เข่าเสื่อม', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                ['content'=>'หกล้ม', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                ['content'=>'BMI', 'options'=>['colspan'=>1, 'class'=>'text-center warning']],
               
                 
            ],
            //'options'=>['class'=>'skip-export'] // remove this row from export
        ]
    ],
    'columns' => [      
        [
            'attribute' =>'hospcode',
            'filter' => MyHelper::dropDownItems($sql_hos, 'id', 'val')
        ],
        'hosname',
        'pid',
        'name:text:ชื่อ', 
        'sex:text:เพศ',
        'age:integer:อายุ',
        'moo:text:หมู่ที่',
        
        'adl_date:date:วันที่',
        [
            'attribute'=>'adl_code',
            'filter'=>['1B1280'=>'ติดสังคม','1B1281'=>'ติดบ้าน','1B1282'=>'ติดเตียง'],
            'label'=>'ผล',
            'value'=>function($model){
                if(!isset($model['adl_code'])){
                    return NULL;
                }
                $code = $model['adl_code'];
                $val =['1B1280'=>'ติดสังคม','1B1281'=>'ติดบ้าน','1B1282'=>'ติดเตียง'];                
                return $val[$code];
                
            }
        ],
                
        'dm_date:date:วันที่',
        [
            'attribute'=>'dm_risk',
            'label'=>'ผล',
            'value'=>function($model){
                if(!isset($model['dm_risk'])){
                    return NULL;
                }
                $code = $model['dm_risk'];
                $val =['0'=>'ปกติ','1'=>'เสี่ยง','2'=>'เสี่ยงสูง'];                
                return $val[$code];
                
            }
        ],
                
        'ht_date:date:วันที่',
        [
            'attribute'=>'ht_risk',
            'label'=>'ผล',
            'value'=>function($model){
                if(!isset($model['ht_risk'])){
                    return NULL;
                }
                $code = $model['ht_risk'];
                $val =['0'=>'ปกติ','1'=>'เสี่ยง','2'=>'เสี่ยงสูง'];
                return $val[$code];
            }
        ],
        
        'cvd_score:text:คะแนน',
        [
            'attribute'=>'cvd_res',
            'label'=>'ผล',
            'value'=>function($model){
                if(!isset($model['cvd_res'])){
                    return NULL;
                }
                $code = $model['cvd_res'];
                $val =['1'=>'ต่ำ','2'=>'ปานกลาง','3'=>'สูง','4'=>'สูงมาก','5'=>'สูงอันตราย'];                
                return $val[$code];
                
            }
        ],
                
        'dent_date:date:วันที่',
        [
            'attribute'=>'dent_code',
            'label'=>'ผล',
            'value'=>function($model){
                if(!isset($model['dent_code'])){
                    return NULL;
                }
                $code = $model['dent_code'];
                $val =['1B1260'=>'ปกติ','1B1261'=>'ผิดปกติ','1B1269'=>'ไม่ระบุ'];
                return $val[$code];
                
            }
        ],
        
        'amt_date:date:วันที่',
        [
            'attribute'=>'amt_code',
            'label'=>'ผล',
            'value'=>function($model){
                if(!isset($model['amt_code'])){
                    return NULL;
                }
                $code = $model['amt_code'];
                $val =['1B1220'=>'ปกติ','1B1221'=>'ผิดปกติ','1B1223'=>'ผิดปกติ','1B1229'=>'ไม่ระบุ'];
                return $val[$code];
                
            }
        ],
                
        '2q_date:date:วันที่',
        [
            'attribute'=>'2q_code',
            'label'=>'ผล',
            'value'=>function($model){
                if(!isset($model['2q_code'])){
                    return NULL;
                }
                $code = $model['2q_code'];
                $val =['1B0280'=>'ปกติ','1B0281'=>'ผิดปกติ'];
                return $val[$code];
                
            }
        ],
                
        'knee_date:date:วันที่',
        [
            'attribute'=>'knee_code',
            'label'=>'ผล',
            'value'=>function($model){
                if(!isset($model['knee_code'])){
                    return NULL;
                }
                $code = $model['knee_code'];
                $val =['1B1270'=>'ปกติ','1B1271'=>'ผิดปกติ','1B1272'=>'ผิดปกติ','1B1279'=>'ไม่ระบุ'];
                return $val[$code];
                
            }
        ],
                
         'fall_date:date:วันที่',
        [
            'attribute'=>'fall_code',
            'label'=>'ผล',
            'value'=>function($model){
                if(!isset($model['fall_code'])){
                    return NULL;
                }
                $code = $model['fall_code'];
                $val =['1B1200'=>'ปกติ','1B1201'=>'ผิดปกติ','1B1202'=>'ผิดปกติ','1B1209'=>'ไม่ระบุ'];
                return $val[$code];
                
            }
        ],
        
        'bmi:text:BMI'
        
       
    ]
]);
