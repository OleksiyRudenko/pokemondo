<body style="position:relative;" data-spy="scroll" data-target=".navbar" data-offset="50">
<!-- http://www.w3schools.com/bootstrap/bootstrap_scrollspy.asp -->
<div class="maincontentwrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- open/close icon -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">pokemondo</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <?php
                    // build nav menu
                    echo MODULE::navbarNested();
                    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><p class="navbar-text">Hello, <a href="#" class="navbar-link"><?=USER::$u['name']?></a>!</p></li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="section-<?=MODULE::$currMod?>" class="container" style="padding-top: 50px;">
        <div class="col-lg-10 col-lg-offset-1">
            <?=unlogMessage('DBinit')?>
            <?=unlogMessage('DEBUG')?>
            <h1><?=MODULE::currSetting('heading')?></h1>
            <?php
            MODULE::loadView();
            ?>
        </div>
    </div>
</div>