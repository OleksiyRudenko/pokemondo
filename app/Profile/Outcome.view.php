<!-- p class="lead">А вот какой!</p -->
<?php
/**
 * Created by PhpStorm.
 * User: Rudenko
 * Date: 10/08/2016
 * Time: 20:31
 */
if (count(ARGV::$a) && ARGV::$a[0]==USER::getUrlId()) {
    /*
       showProfileImage()
       showAlternatives()
    */
    ?>
    <div class="col-xs-12">
        <?=UsermonProfile::$currentProfile->profileImgTag()?>
    </div>
    <?php
    //TODO:  showAlternatives()
} else {
    ?>
    <div class="row">
        <div class="overlayContainer col-xs-12">
            <div class="col-xs-12"><a class="loginFBbttn overlayElement" href="#" onClick="logInWithFacebook()">Войти через Facebook</a></div>
            <img src="img/welcome.jpg" class="img-rounded img-responsive" alt="Welcome" width="623" height="389">
        </div>
    </div>
    <?php
}
