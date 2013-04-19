<? /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="<?= Yii::app()->language; ?>">
    <head>
	<meta charset="utf-8" />
	<meta name="keywords" content="<?= $this->metaKeywords; ?>" />
	<meta name="description" content="<?= $this->metaDescription; ?>" />
	<title><?= CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
	<?
	$this->widget('zii.widgets.CMenu', array(
	    'items' => array(
		array('label' => 'O nas'),
		array('label' => 'Portfolio', 'url' => array('/project')),
		array('label' => 'Praca'),
		array('label' => 'Kontakt'),
	    ),
	));
	?>

<?= $content; ?>
    </body>
</html>
