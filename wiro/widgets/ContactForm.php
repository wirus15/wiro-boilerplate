<?php

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 * @property-read ContactFormModel $model
 * @property-read boolean $messageSent
 */
class ContactForm extends CWidget
{
    public $emailAddress;
    public $modelClass = 'application.widgets.ContactForm.ContactFormModel';
    public $view = 'view';
    public $captchaOptions = array();
    private $model;
    private $messageSent = false;

    public function init()
    {
	$this->model = Yii::createComponent($this->modelClass);
	$this->emailAddress = Yii::app()->params->contactEmail;
	$this->captchaOptions = CMap::mergeArray(array(
		    'captchaAction' => '/site/captcha',
		    'clickableImage' => true,
		    'showRefreshButton' => false,
		    'imageOptions' => array(
			'style' => 'cursor: pointer',
		    ),
			), $this->captchaOptions);
	$this->model->captchaAction = $this->captchaOptions['captchaAction'];
    }

    public function run()
    {
	$classParts = explode('.', $this->modelClass);
	$modelClass = array_pop($classParts);
	if(isset($_POST[$modelClass])) {
	    $this->model->attributes = $_POST[$modelClass];
	    if($this->model->validate()) {
		$this->send();
		$this->messageSent = true;
	    }
	}

	$this->render($this->view, array(
	    'model' => $this->model,
	));
    }

    private function send()
    {
	$message = new YiiMailMessage;
	$message->setSubject($this->model->subject);
	$message->setBody($this->model->body);
	$message->setFrom(array($this->model->email => $this->model->name));
	$message->setTo($this->emailAddress);
	$message->setReplyTo($this->model->email);
	Yii::app()->mail->send($message);
    }

    public function getModel()
    {
	return $this->model;
    }

    public function getMessageSent()
    {
	return $this->messageSent;
    }

    public function getViewPath($checkTheme = false)
    {
	$className = get_class($this);
	if($checkTheme && ($theme = Yii::app()->getTheme()) !== null) {
	    $path = $theme->getViewPath() . DIRECTORY_SEPARATOR;
	    if(strpos($className, '\\') !== false) // namespaced class
	        $path.=str_replace('\\', '_', ltrim($className, '\\'));
	    else
	        $path.=$className;
	    if(is_dir($path))
	        return $path;
	}
	$class = new ReflectionClass($className);
	return dirname($class->getFileName()).DIRECTORY_SEPARATOR.$className.DIRECTORY_SEPARATOR.'/views';
    }
}
