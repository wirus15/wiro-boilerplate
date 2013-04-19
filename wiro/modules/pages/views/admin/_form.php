<?php 
/* @var $this AdminController */
/* @var $model Page */
?>

<div class="form">
    
    <?php
    $form = $this->beginWidget('awecrud.components.AweActiveForm', array(
	'id' => 'page-form',
	'enableAjaxValidation' => false,
	'enableClientValidation'=> false,
    )); ?>

    <p class="note">Pola oznaczone <span class="required">*</span> są wymagane.</p>

    <div class="well" style="overflow: auto">
	<?php echo $form->textFieldRow($model, 'pageTitle', array('class' => 'input-block-level', 'maxlength' => 255)) ?>
	<?php echo $form->redactorRow($model,'pageContent',array('rows'=>6, 'cols'=>50, 'class'=>'span8')) ?>
    </div>
    
    
    
    
    <div class="well" id="meta-data-container">
	<?php $this->beginWidget('bootstrap.widgets.TbCollapse', array('toggle' => false));?>
	    <a data-toggle="collapse" href="#meta-data">Meta dane</a>
	    
	    <div id="meta-data" class="collapse">
		<div style="margin-top: 20px">
		    <?php echo $form->textFieldRow($model, 'metaKeywords', array('class' => 'span5', 'maxlength' => 255)) ?>
		    <?php echo $form->textAreaRow($model,'metaDescription',array('rows'=>6, 'cols'=>50, 'class'=>'span8')) ?>
		</div>
	    </div>
	<?php $this->endWidget();?>
    </div>             
    
    <div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Zapisz',
	)); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=> 'Anuluj',
		'url' => array('index'),
	)); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>