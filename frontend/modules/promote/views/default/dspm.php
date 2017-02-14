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
    'panel'=>['before'=>'ผลงานจากแฟ้ม special_pp'],
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
        'name:text:ชื่อ',
        'sex:text:เพศ',
        'birth:date:เกิด',
        [
            'attribute'=>'age_m',
            'format'=>'integer',
            'label'=>'อายุ(ด)',
            'filter'=>['9'=>'9','18'=>'18','30'=>'30','42'=>'42']
        ],
        //'age_m:integer:อายุ(ด)',
        'date_serv_first:date:ครั้งแรก',
        'sp_first:text:รหัส',
        'date_serv_last:date:ครั้งสอง',
        'sp_last:text:รหัส'
    ]
]);
