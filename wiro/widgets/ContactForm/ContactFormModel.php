<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactFormModel extends CFormModel
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;
    public $captchaAction;
    
    /**
     * Declares the validation rules.
     */
    public function rules()
    {
	return array(
	    array('name, email, subject, body', 'required'),
	    array('email', 'email'),
	    array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'captchaAction' => $this->captchaAction),
	);
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
	return array(
	    'name' => 'Imię i nazwisko',
	    'email' => 'Adres e-mail',
	    'subject' => 'Temat wiadomości',
	    'body' => 'Treść',
	    'verifyCode' => 'Kod z obrazka',
	);
    }
}