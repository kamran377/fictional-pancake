<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(\Yii::$app->name . " | " . $this->params['heading']) ?></title>
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="loader"><h1 class="loadingtext">Trucking<span>Backend</span></h1><p>Awesome things getting ready...</p><br><img src="/backend/web/img/loader2.gif" alt=""> </div>

<div class="wrapper">
    <div class="navbar-default sidebar" >
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" > <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<a class="navbar-brand" href="<?= Url::to(['/']) ?>"><?= \Yii::$app->name ?></a> 
		</div>
		<div class="clearfix"></div>
		<div class="sidebar-nav navbar-collapse">
			
			<?php 
				$view = \Yii::$app->urlManager->parseRequest(Yii::$app->request);
				//print_r( $view);
				$view = trim($view[0]); 
			?>
			<?= $this->render('_menu',['view'=>$view]); ?>
			
		</div>
	</div>
	<div id="page-wrapper">
		<div class="row">
			<nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
				<button class="menubtn pull-left btn "><i class="glyphicon  glyphicon-th"></i></button>
				
				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown"> <a class="dropdown-toggle userdd" data-toggle="dropdown" href="javascript:void(0)">
						<div class="userprofile small "> <span class="userpic"> <img src="/backend/web/img/user.png" alt="" class="userpicimg"> </span>
							<div class="textcontainer">
								<h3 class="username"><?= \Yii::$app->util->fullName; ?></h3>			
								<p><?= \Yii::$app->util->roleName; ?></p>
							</div>
						</div>
						<i class="caret"></i> </a>
						<ul class="dropdown-menu dropdown-user">
						  <li> <a href="socialprofile.html"><i class="fa fa-user fa-fw"></i> User Profile</a> </li>
						  <li> <a href="javascript:void(0)"><i class="fa fa-gear fa-fw"></i> Settings</a> </li>
						  <li> <a href="<?= Url::to(['/site/logout'])?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a> </li>
						</ul>
					<!-- /.dropdown-user --> 
					</li>
				</ul>
			</nav>
		</div>
		<div class="row">
			<div class="col-md-12  header-wrapper" >
				<h1 class="page-header"><?= $this->params['heading'] ?></h1>
				<p class="page-subtitle"><?= $this->params['description'] ?></p>
			</div>
		<!-- /.col-lg-12 --> 
		</div>
		<?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
		<div class="row">
			<div class="col-md-12" >
				<?= \odaialali\yii2toastr\ToastrFlash::widget([
					'options' => [
						'positionClass' => 'toast-top-right'
					]
				]);?>
				<?= $content ?>
			</div>
		</div>
	</div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<?php
$js = <<< JS
	$(document).on('ready',function(){
		
	});
	
JS;

$this->registerJs($js);