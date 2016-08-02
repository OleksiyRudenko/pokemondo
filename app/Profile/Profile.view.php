<FORM METHOD="GET">
    <div class="form-group col-xs-6">
        <label for="gender">Gender:</label>
        <select name="gender" class="form-control" id="gender">
            <?php
            $options = [
                'm' =>  'Male',
                'f' =>  'Female',
                'x' =>  'Either',
                'n' =>  'Neutral',
            ];
            print selectOptions($options,@$_GET['gender']);
            ?>
        </select>
    </div>
    <div class="form-group col-xs-6">
        <label for="birthmonth">Birth month:</label>
        <select name="birthmonth" class="form-control" id="birthmonth">
            <?php
            $options = [];
            for ($i=1;$i<=12;$i++) $options[$i]=$i;
            print selectOptions($options,@$_GET['birthmonth']);
            ?>
        </select>
    </div>
    <div class="form-group">
        <?=buttonSubmit('Process','Process')?>
    </div>
</FORM>
<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 02/08/2016
 * Time: 12:40
 */


