<?php if(!empty($receivedMarks)):?>
<div class="item-title"><?=$lg_marks?></div>
<div class="item-report">
    <div class="section d-flex justify-content-center">
        <select id="monthsList" class="item-report__list">
            <option value = "0"><?=$lg_select_month?></option>
            <?php foreach($lg_name_months as $key=>$month):?>
                <option value = "<?=$key+1?>"><?=$month?></option>
            <?php endforeach;?>
        </select>
        <select name="year" id="yearsList" class="item-report__list">
            <option value = "0"><?=$lg_select_year?></option>
            <?php
            for($i=date("Y")-5; $i<=date("Y")+1; $i++) {
                $select = ($i == date('Y')) ? 'selected' :'';
                echo "<option value=".$i." ".$select.">".date("Y", mktime(0,0,0,0,1,$i+1))."</option>";
            }
            ?>
        </select>
        <img class="" src="/gaintimeoff/img/checked-32.png" onclick="getReportReceivedMarks('<?=$kidName?>');">
    </div>
</div>

<div class="container d-flex flex-column justify-content-center align-items-center">
    <table class="table-marks">
        <?php foreach($receivedMarks as $key => $receivedMark):?>
            <tr>
                <td class="column-subject"><?=$key?></td>
                <td class="column-mark"><?=implode(", ", $receivedMark)?></td>
                <td class="column-average"><?=!isset($receivedMark[0]) ? '' : number_format(array_sum($receivedMark)/count($receivedMark), 2)?></td>
            </tr>
        <?php endforeach;?>
    </table>
</div>
<?php endif;?>