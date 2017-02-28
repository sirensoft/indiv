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

$this->title = 'ความชุกของภาวะอ้วน(BMI ≥ 25 กก/ม2) และหรือภาวะอ้วนลงพุง (รอบเอวเกิน ชาย 90 ซม. หญิง 80 ซม.)';
$this->params['breadcrumbs'][] = ['label'=>'รายงานกลุ่มงานส่งเสริม','url'=>['/promote/default/index']];
$this->params['breadcrumbs'][] = $this->title;


$sql = " SELECT DISTINCT t.amp_name id,t.amp_name val FROM chospital_amp t ";

$items = MyHelper::dropDownItems($sql, 'id', 'val');
?>
<div class="patient-search" style="margin-bottom: 10px">

    <?php
    $form = ActiveForm::begin([
                'action' => ['/promote/default/fat'],
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
        'before'=>'<a href="https://goo.gl/ju64gR" target="_blank">[ดูผลรวม-คลิก]</a>',
        'heading'=>'รายชื่อ'
    ],
    'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'หน่วยบริการ', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                ['content'=>'กลุ่มเป้าหมาย', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                ['content'=>'การตรวจคัดกรอง', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                
               
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
        
        'date_screen:date:ตรวจ',
        'waist:text:รอบเอว',
        'bmi',
        //'b',
        [
            'attribute'=>'a',
            'label'=>'อ้วน',
            'filter'=>['Y'=>'Y-อ้วน']
        ]
    ]
]);
