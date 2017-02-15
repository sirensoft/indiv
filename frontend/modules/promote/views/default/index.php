<?php

use yii\helpers\Html;

$this->title = 'รายงานกลุ่มงานส่งเสริม';
?>
<div class="promote-default-index">
    <h3>รายงานกลุ่มงานส่งเสริม</h3>
    <ol>
        <li>
<?= Html::a('ผลการดำเนินการการคัดกรองพัฒนาการเด็กตามกลุ่มอายุ special pp', ['/promote/default/dspm']) ?>
        </li>
        <li>
            <?= Html::a('ภาวะโลหิตจางในหญิงตั้งครรภ์', ['/promote/default/hct']) ?>
            
        </li>
        <li>
            <?=Html::a('อัตราการคัดกรองมะเร็งปากมดลูกในสตรีอายุ 30-60 ปี',['/promote/default/pap'])?>
        </li>
        <li>
             <?=Html::a('อัตราการคัดกรองมะเร็งเต้านมในสตรีอายุ 30-70 ปี',['/promote/default/breast'])?>
            
        </li>
    </ol>

</div>
