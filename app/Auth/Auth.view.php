<div>
    <FORM class="form-horizontal" METHOD="POST">
    <div class="form-group">
        <label for="login" class="col-sm-2 control-label">Login:</label>
        <div class="col-sm-4">
            <INPUT type="text" name="login" class="form-control" id="login" autofocus />
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

global $DBH, $DBT;
include_once('app/class.dbTable.php');
include_once('app/dbSpec/db.tables.php');
$tbUnative = new dbTable($DBH,'unative',$DBT['unative']);

// create if inexistent
if (!$tbUnative->exists()) {
    print ($tbUnative->create())
        ? alert('Create TABLE unative','info')
        : alert('Creating TABLE unative: '.sqlError());
    $values =
        [
            'uname'       =>  'Root User',
            'ulogin'      =>  'root',
            'usalt'       =>  'aQs5te',
            'upwdhash'    =>  'f44627fdd5755e04f14ca4c949ad4241',
            'upowers'     =>  USER::$AUTH['powers']['root'],
            'pokename'    =>  '',
            'birthdate'   =>  '2000-01-01',
        ];
    print ($tbUnative->insert($values,array_keys($values)))
        ? alert('Default users created. Please, login as root using password from docs and change passwords ASAP.')
        : alert('Creating default users: '.sqlError());
}