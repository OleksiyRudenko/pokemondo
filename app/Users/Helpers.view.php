    <FORM class="form-horizontal" METHOD="POST">
        <div class="form-group">
            <label for="usalt" class="col-sm-2 control-label">Salt(6):</label>
            <div class="col-sm-4">
                <INPUT type="text" name="usalt" class="form-control" id="usalt" value="<?=@$_POST['usalt']?>" autofocus />
            </div>
        </div>
        <div class="form-group">
            <label for="pwd" class="col-sm-2 control-label">Password:</label>
            <div class="col-sm-4">
                <INPUT type="text" name="pwd" class="form-control" id="pwd" value="<?=@$_POST['pwd']?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?=buttonSubmit('md5','md5')?>
            </div>
        </div>
    </FORM>
<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 10/08/2016
 * Time: 17:55
 */

print unlogMessage('HELPERS');