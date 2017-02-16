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

$this->title = 'อัตราการคัดกรองมะเร็งเต้านมในสตรีอายุ 30-70 ปี';
$this->params['breadcrumbs'][] = ['label'=>'รายงานกลุ่มงานส่งเสริม','url'=>['/promote/default/index']];
$this->params['breadcrumbs'][] = $this->title;


$sql = " SELECT DISTINCT t.amp_name id,t.amp_name val FROM chospital_amp t ";

$items = MyHelper::dropDownItems($sql, 'id', 'val');
?>
<div class="patient-search" style="margin-bottom: 10px">

    <?php
    $form = ActiveForm::begin([
                'action' => ['/promote/default/breast'],
                'method' => 'get',
    ]);
    ?>

    <div class="input-group">
        
        <?= $form->field($searchModel, 'cup')->dropDownList($items, ['prompt' => '-- เลือก cup --'])->label(FALSE); ?>
        <span class="input-group-btn">
            <button class="btn btn-default alignment" type="submit">
                <i class="glyphicon glyphicon-search"></i> ค้นหา
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
        'before'=>'<a href="https://goo.gl/uU7eKB" target="_blank">[ดูผลรวม-คลิก]</a>',
        'heading'=>'รายชื่อการคัดกรองมะเร็งเต้านมในสตรีอายุ 30-70 ปี'
    ],
    'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'', 'options'=>['colspan'=>6, 'class'=>'text-center warning']], 
                ['content'=>'ตรวจโดย', 'options'=>['colspan'=>2, 'class'=>'text-center warning']], 
                ['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center warning']], 
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
        'age:integer:อายุ',
        'screen_date:date:ตรวจ',
        'doctor:text:เจ้าหน้าที่',
        'self:text:ตนเอง',
       
        //'b',
        'a:text:A'
    ]
]);
