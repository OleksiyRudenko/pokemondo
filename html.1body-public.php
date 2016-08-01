<?php
global $APPID;
?><body>
<script>
    // ================== FACEBOOK ==============================
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '<?=$APPID['fb']?>',
            xfbml      : true,
            version    : 'v2.7'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script>
<div id="section-public" class="container">
    <div class="col-lg-10 col-lg-offset-1">
        <h1><?=MODULE::currSetting('heading')?></h1>
        <?php
        MODULE::loadView();
        ?>
    </div>
</div>