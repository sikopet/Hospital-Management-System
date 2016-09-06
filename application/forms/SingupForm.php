<?php

class Application_Form_SingupForm extends Zend_Form
{

    /**
     * Form's set values and multy options
     * @var array
     */
    private $_options;

    /**
     * Initailise options arrays
     * @param $options
     */
    public function __construct($options = null)
    {
        if (isset($options)) {
            $this->_options = $options;
        }
        parent::__construct();
        $this->setMethod('post');
    }
    
    
    public function init()
    {
        $options = $this->_options;
    
       	$this->setMethod('post');
       	
       	$textDecorator =  array(
        	'ViewHelper',                
            'Label',
            'Errors',
            array('HtmlTag',
            	array('tag' => 'div', 'class' => 'formfield')
            )
        );

       	$email = new Zend_Form_Element_Text('email');
       	$email->setLabel('User name (ex: pat@example.com)');
       	$email->setRequired(true);
       	$email->addFilter('StringTrim');
       	$email->addValidator('EmailAddress');      
        $email->setDecorators($textDecorator);	
       
       	$password = new Zend_Form_Element_Password('password');
       	$password->setLabel('Password');
       	$password->setRequired(true);
       	$password->addFilter('StringTrim');
       	$password->addValidator(
            'StringLength', 
            false, 
            array('min' => 6, 'max' => 30)
        );               
        $password->setDecorators($textDecorator);	
       
       	$repassword = new Zend_Form_Element_Password('repassword');
       	$repassword->setLabel('Re-enter Password');
       	$repassword->setRequired(true);
       	$repassword->addFilter('StringTrim');
       	$repassword->addValidator(
            'StringLength', 
            false, 
            array('min' => 6, 'max' => 30)
        );       
        $repassword->setDecorators($textDecorator);	
       	
       	$title = new Zend_Form_Element_Select('title');
       	$title->setLabel('Title');
       	$title->setRequired(true);
       	$title->addMultiOptions(array('Mr.' => 'Mr.','Mrs.' => 'Mrs.', 'Ms.' => 'Ms.'));
        $title->class = 'w50';
        $title->setDecorators($textDecorator);	
       
       	$initials = new Zend_Form_Element_Text('initials');
       	$initials->setLabel('Initials');
       	$initials->setRequired(true);
       	$initials->addFilter('StringTrim');
        $initials->setDecorators($textDecorator);	
       
       	$fname = new Zend_Form_Element_Text('fname');
       	$fname->setLabel('First Name');
       	$fname->setRequired(true);
       	$fname->addFilter('StringTrim');
        $fname->setDecorators($textDecorator);	
       
       	$lname = new Zend_Form_Element_Text('lname');
       	$lname->setLabel('Last Name');
       	$lname->setRequired(true);
       	$lname->addFilter('StringTrim');
        $lname->setDecorators($textDecorator);	
 
       	$bday = new ZendX_JQuery_Form_Element_DatePicker('bday');
       	$bday->setLabel('Birth Day');      	
       	$bday->addValidator('date');
       	$bday->setJQueryParam('dateFormat', 'yy-mm-dd');
        $bday->setJQueryParam('changeMonth', true);
        $bday->setJQueryParam('changeYear', true);   
        $bday->setJQueryParam('yearRange', '1900:2012');          
		$bday->addValidator('date');
		$bday->class = 'w150';
        $bday->setDecorators(
            array(
                'UiWidgetElement',                
                'Label',               
                array('HtmlTag',
                    array('tag' => 'div', 'class' => 'formfield')
                )
            )
        );	
       	
       	$telno = new Zend_Form_Element_Text('telno');
       	$telno->setLabel('Tel No');       
       	$telno->addFilter('StringTrim');
       	$telno->addValidator('digits');
        $telno->setDecorators($textDecorator);	
       	       	
       	$address1 = new Zend_Form_Element_Text('address1');
       	$address1->setLabel('Address 1');       
       	$address1->addFilter('StringTrim');       
        $address1->setDecorators($textDecorator);	
       	
       	$address2 = new Zend_Form_Element_Text('address2');
       	$address2->setLabel('Address 2');       
       	$address2->addFilter('StringTrim');
        $address2->setDecorators($textDecorator);	
       	
       	$city = new Zend_Form_Element_Text('city');
       	$city->setLabel('City');       
       	$city->addFilter('StringTrim');
        $city->setDecorators($textDecorator);	
      	
       	$country = new Zend_Form_Element_Select('country');       
        $country->setLabel('Country');	       
        $country->addMultiOptions($options['countrylist']);
        $country->addMultiOption(0,'Select Country');
        $country->setDecorators($textDecorator);		
      
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Profile Image');             
       	$image->addValidator('IsImage'); 
        $image->setDestination('images/tmp');
        $image->setDecorators(
            array(
                'File',                
                'Label',
                'Errors',
                array('HtmlTag',
                    array('tag' => 'div', 'class' => 'formfield')
                )
            )
        );
         
       	$baseURL = Zend_Controller_Front::getInstance()->getBaseUrl();
        
       	$captcha = new Zend_Form_Element_Captcha('captcha', array(           
            'captcha' => array(
                'captcha' => 'image',                
                'wordLen' => 6,
                'timeout' => 300 ,
                'height' => 75,
                'fontSize' => 30,
                'font' => PUBLIC_PATH .'/fonts/Arial.ttf',                
                'imgDir' => PUBLIC_PATH .'/captcha',
                'imgUrl' => $baseURL .'/captcha/'                
            )
        ));
        $captcha->setLabel('Please enter the 6 letters displayed below');
        $captcha->setRequired(true);
        $captcha->setDecorators(
            array( 
                'Captcha',                             
                'Label', 
                'Errors',
                array('HtmlTag',
                    array(
                        'tag' => 'div', 
                        'class' => 'formfield w450 mart10'
                    )
                )
            )
        );
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Sign Up');
        $submit->class = 'button blue';
       
        $this->addDisplayGroup(
            array($email, $password, $repassword), 
            'ldetails',
            array(
                'legend' => 'Login Details',
                'decorators' => array(        
                    'FormElements',
                    'Fieldset'
                )                
            )
            
        );
        
        $this->addDisplayGroup(
            array(  
                $title,
                $initials,
                $fname,
                $lname,				
                $bday,
                $telno,
                $address1,
                $address2,
                $city,
                $country,
                $image
            ), 
            'udetails',
            array(
                'legend' => 'User Details',
                'decorators' => array(        
                    'FormElements',
                    'Fieldset'
                )  
            )
        );
        
        $this->addElements(array($captcha, $submit));       
       
        $this->setDecorators(array('FormElements', 'Form'));
    }


}

