<!-- p class="lead">А вот какой!</p --><?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 10/08/2016
 * Time: 20:31
 */
// print unlogMessage('OUTCOME');
if (count(ARGV::$a) && ARGV::$a[0]==USER::getUrlId()) {
    /*
       showProfileImage()
       showAlternatives()
    */
    ?>
    <div class="col-xs-12 text-center">
        <?=UsermonProfile::$currentProfile->profileImgTag(true,true)?>
    </div>
    <?php
    foreach (UsermonProfile::$pokemonList as $poke) {
        print '<div class="col-xs-4 text-center">'
            .ahref(
                '/outcome/'.ARGV::$a[0].'/'.$poke->p['pokename'],
                htmlElementSingle('img',
                    ['src'=>$poke->imageUrl('local','avatar','static','normal')]
                    ))
            .'<p class="lead text-center">'.$poke->p['pokename_ru'].'</p>'
            .'</div>';
    }
    ?>
    <div class="col-xs-12 text-center">
        <?=abutton('/outcome/'.ARGV::$a[0],'Ещё...')?>
    </div>
    <?php
} else {
    ?>
    <div class="row">
        <div class="overlayContainer col-xs-12">
            <div class="col-xs-12"><a class="loginFBbttn overlayElement" href="#" onClick="logInWithFacebook()">Войти через Facebook</a></div>
            <img src="/img/welcome.jpg" class="img-rounded img-responsive" alt="Welcome" width="623" height="389">
        </div>
    </div>
    <?php
}
