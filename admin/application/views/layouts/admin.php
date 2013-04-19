<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row-fluid">
    <div class="span3 well" style="padding: 8px 0px">
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type' => 'list',
	    'items' => array(
		array('label'=>'Menu główne', 'itemOptions'=>array('class'=>'nav-header')),
		'',
		array('label'=>'Projekty', 'url'=>array('/project/index'), 'icon'=>'briefcase'),
		array('label'=>'Kategorie', 'url'=>array('/category/index'), 'icon'=>'folder-open'),
		array('label'=>'Marki', 'url'=>array('/company/index'), 'icon'=>'tags'),
		'',
		array('label'=>'Strony statyczne', 'url'=>array('/pages/admin/index'), 'icon'=>'file'),
		array('label'=>'Wyloguj', 'url'=>array('/login/logout'), 'icon'=>'off'),
	    ),
	)); ?>
    </div>
    <div class="span9">
	<div id="content">
	    <?php echo $content; ?>
	</div>
    </div>
</div>
<?php $this->endContent(); ?>