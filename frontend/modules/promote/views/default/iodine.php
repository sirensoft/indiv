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

$this->title = 'ร้อยละของหญิงตั้งครรภ์ได้รับยาเม็ดเสริมไอโอดีน';
$this->params['breadcrumbs'][] = ['label'=>'รายงานกลุ่มงานส่งเสริม','url'=>['/promote/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div> รหัสยา=201120320037726221781506 ,201110100019999920381199
    ,101110000003082121781506,201110100019999920381341,201110100019999921881341
    </div>
<?php


$sql = " SELECT DISTINCT t.amp_name id,t.amp_name val FROM chospital_amp t ";

$items = MyHelper::dropDownItems($sql, 'id', 'val');
?>
<div class="patient-search" style="margin-bottom: 10px">

    <?php
    $form = ActiveForm::begin([
                'action' => ['/promote/default/iodine'],
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
        'before'=>'<a href="https://goo.gl/EYOQOO" target="_blank">[ดูผลรวม-คลิก]</a>',
        'heading'=>'รายชื่อหญิงตั้งครรภ์ได้รับยาเม็ดเสริมไอโอดีน',
     ],
    'columns' => [      
        [
            'attribute' =>'hospcode',
            'filter' => MyHelper::dropDownItems($sql_hos, 'id', 'val')
        ],
        'hosname',
        'pid',
        'name:text:ชื่อ',
        //'lname:text:นามสกุล',  
        //'age:integer:อายุ',
        'date_serv:date:ได้รับ',        
       
        //'b',
        'a:text:A'
    ]
]);
