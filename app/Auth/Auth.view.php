<div>
    <FORM class="form-horizontal" METHOD="POST">
    <div class="form-group">
        <label for="login" class="col-sm-2 control-label">Login:</label>
        <div class="col-sm-4">
            <INPUT type="text" name="login" class="form-control" id="login" />
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Password:</label>
        <div class="col-sm-4">
            <INPUT type="password" name="password" class="form-control" id="password" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?=buttonSubmit('Login','Login')?>
        </div>
    </div>
</FORM>
</div><?php
print unlogMessage('AUTH');
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 09/08/2016
 * Time: 11:32
 */