<?php
use yii\helpers\Url;
?>
<?php

$adminRole = Yii::$app->authManager->getRole('admin');

?>
<ul class="nav" id="side-menu">
	<li>
		<a href="<?= Url::to(['/site/dashboard']) ?>" class="<?= \Yii::$app->util->startsWith($view,"/site/dashboard") ? "active" : "" ?>"><i class="fa fa-bullseye fa-fw"></i> Dashboard</a> 
	</li>
	<li>
		<a href="<?= Url::to(['/user/index']) ?>" class="<?= \Yii::$app->util->startsWith($view,"/user/index") ? "active" : "" ?>"><i class="fa fa-users fa-fw"></i> Users</a> 
	</li>
	<li>
		<a href="<?= Url::to(['/vehicle/index']) ?>" class="<?= \Yii::$app->util->startsWith($view,"/vehicle/index") ? "active" : "" ?>"><i class="fa fa-truck fa-fw"></i> Vehicles</a> 
	</li>
	<li>
		<a href="<?= Url::to(['/fueling/index']) ?>" class="<?= \Yii::$app->util->startsWith($view,"/fueling/index") ? "active" : "" ?>"><i class="fa fa-calculator fa-fw"></i> Fuel Service</a> 
	</li>
</ul>