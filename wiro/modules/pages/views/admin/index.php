<?php
/* @var $model Page */
/* @var $this AdminController */
?>

<fieldset>
    <legend>Strony statyczne</legend>

    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'pages-grid',
	'type' => 'bordered striped condensed',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
	    array(
		'name' => 'pageTitle',
		'type' => 'html',
		'value' => 'CHtml::link(CHtml::encode($data->pageTitle), array("update", "id"=>$data->pageId));',
	    ),
	    array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template' => '{update}',
	    ),
	),
    ));
    ?>
</fieldset>
