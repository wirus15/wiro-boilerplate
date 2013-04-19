<?php 
/* @var $this ContactForm */
/* @var $model ContactFormModel */
?>

<? $form = $this->beginWidget('CActiveForm', array('id' => 'contact-form')); ?>
<div class="form">
<?php if ($this->messageSent): ?>
    <div class="flash-success">
	Twoja wiadomość została wysłana. Dziękujemy za kontakt.
    </div>
<?php else: ?>
    <p class="note">Pola oznaczone <span class="required">*</span> są wymagane.</p>

    <div class="row">
	<?php echo $form->labelEx($model, 'name'); ?>
	<?php echo $form->textField($model, 'name'); ?>
	<?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
	<?php echo $form->labelEx($model, 'email'); ?>
	<?php echo $form->emailField($model, 'email'); ?>
	<?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
	<?php echo $form->labelEx($model, 'subject'); ?>
	<?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 128)); ?>
	<?php echo $form->error($model, 'subject'); ?>
    </div>

    <div class="row">
	<?php echo $form->labelEx($model, 'body'); ?>
	<?php echo $form->textArea($model, 'body', array('rows' => 6, 'cols' => 50)); ?>
	<?php echo $form->error($model, 'body'); ?>
    </div>

    <?php if (CCaptcha::checkRequirements()): ?>
	<div class="row">
	    <?php echo $form->labelEx($model, 'verifyCode'); ?>
	    <div>
	    <?php $this->widget('CCaptcha', $this->captchaOptions); ?>
	    <?php echo $form->textField($model, 'verifyCode'); ?>
	    </div>
	    <?php echo $form->error($model, 'verifyCode'); ?>
	</div>
    <?php endif; ?>

    <div class="row buttons">
	<?php echo CHtml::submitButton('Wyślij'); ?>
    </div> 
<?php endif; ?>
</div>
 <?php $this->endWidget(); ?>