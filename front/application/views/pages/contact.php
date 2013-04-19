<?php 
/* @var $this PagesController */
/* @var $model Page */
?>

<h1><?= CHtml::encode($model->pageTitle); ?></h1>

<?= $model->pageContent; ?>

<? $this->widget('application.widgets.ContactForm'); ?>