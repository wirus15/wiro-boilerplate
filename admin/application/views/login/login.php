<?php
/**
 * @var $this Controller
 * @var $model LoginForm
 */
?>

<div class="form-signin well">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'login-form',
	'type' => 'vertical',
    ));
    ?>

    <fieldset>
	<?php echo $form->textField($model, 'username', array(
	    'class' => 'input-block-level',
	    'placeholder' => $model->getAttributeLabel('username')));
	?>
	<?php echo $form->error($model, 'username'); ?>
	<?php echo $form->passwordField($model, 'password', array(
	    'class' => 'input-block-level',
	    'placeholder' => $model->getAttributeLabel('password')));
	?>
	<?php echo $form->error($model, 'password'); ?>
	<?php
	if (Yii::app()->user->allowAutoLogin)
	    echo $form->checkBoxRow($model, 'rememberMe');
	?>
    </fieldset>

    <br/>

    <p>
	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
	    'buttonType' => 'submit',
	    'block' => true,
	    'type' => 'primary',
	    'label' => 'Zaloguj',
	));
	?>
    </p>
<?php $this->endWidget(); ?>
</div>
