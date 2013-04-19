<? /* @var $this Controller */ ?>
<? $this->widget('common.extensions.bootstrap-select.BootstrapSelect'); ?>
<!DOCTYPE html>
<html lang="<?= Yii::app()->language; ?>">
    <head>
	<meta charset="utf-8" />
	<title><?= CHtml::encode($this->pageTitle); ?></title>
	<link type="text/css" rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/css/style.css" media="screen" />
    </head>

    <body>
	<div id="wrap">
	    <div class="container-fluid">
		<nav id="main-menu">
		    <?
		    $this->widget('bootstrap.widgets.TbNavbar', array(
			'brand' => Yii::app()->name,
			'fixed' => false,
			'items' => array(
			    array(
				'class' => 'bootstrap.widgets.TbMenu',
				'htmlOptions' => array('class' => 'pull-right'),
				'items' => array(
				    array(
					'label' => 'Zaloguj', 
					'url' => array('/login'), 
					'visible' => Yii::app()->user->isGuest,
					'icon' => 'user',
				    ),
				    array(
					'label' => 'Wyloguj', 
					'url' => array('/login/logout'), 
					'visible' => !Yii::app()->user->isGuest,
					'icon' => 'off',
				    ),
				),
			    ),
			),
		    ));
		    ?>
		</nav>
		<?= $content; ?>
	    </div>
	    <div id="push"></div>
	</div>

	<footer id="footer">
	    <div class="container">
		<div class="credit">Copyright &copy;
		    <?= date('Y'); ?>
		    by <?= Yii::app()->params->companyName; ?>. All Rights Reserved.
		</div>
	    </div>
	</footer>

    </body>
</html>
