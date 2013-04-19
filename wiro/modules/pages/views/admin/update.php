<?php 
/* @var $this AdminController */
/* @var $model Page */
?>

<fieldset>
    <legend>Edytuj stronę: <?php echo CHtml::encode($model) ?></legend>
    <?php echo $this->renderPartial('_form',array('model' => $model)); ?>
</fieldset>