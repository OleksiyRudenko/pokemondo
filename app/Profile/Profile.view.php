<?php
    include_once('app/class.Pokemon.php');
    include_once('app/class.UsermonProfile.php');

    $presets = [
        'userid'        =>  1,
        'gender'        =>  'x',
        'username'      =>  'Александр',
        'birthdate'    =>   '01/31/2000', // MM/DD/YYYY
    ];
    assignRequestPresets($_POST,$presets);
?>
    <FORM METHOD="POST">
    <div class="form-group col-xs-3">
        <label for="userid">User ID:</label>
        <INPUT type="number" name="userid" class="form-control" id="userid" value="<?=@$_POST['userid']?>" />
    </div>
    <div class="form-group col-xs-3">
        <label for="username">User name:</label>
        <INPUT type="text" name="username" class="form-control" id="username" value="<?=@$_POST['username']?>" />
    </div>
    <div class="form-group col-xs-3">
        <label for="gender">Gender:</label>
        <select name="gender" class="form-control" id="gender">
            <?php
            $options = [
                'm' =>  'Male',
                'f' =>  'Female',
                'x' =>  'Either',
                'n' =>  'Neutral',
            ];
            print selectOptions($options,@$_POST['gender']);
            ?>
        </select>
    </div>
    <div class="form-group col-xs-3">
        <label for="birthmonth">Birth date (MM/DD/YYYY):</label>
        <INPUT type="text" name="birthdate" class="form-control" id="birthdate" value="<?=@$_POST['birthdate']?>" />
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

print unlogMessage('UsermonProfile','danger');
print unlogMessage('Profile','danger');

// show profileImage
print '<div class="col-xs-12 text-center">'
    .UsermonProfile::$currentProfile->profileImgTag()
    .'</div>';

// show pokemons from UsermonProfile::$pokemonList
foreach (UsermonProfile::$pokemonList as $poke) {
    print '<div class="col-xs-4 text-center">'
        .htmlElementSingle('img',
            ['src'=>$poke->imageUrl('local','avatar','static','normal')]
        )
        .'<p class="lead text-center">'.$poke->p['pokename_ru'].'</p>'
        .'</div>';
}

