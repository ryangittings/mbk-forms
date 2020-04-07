<?php

require_once 'vendor/autoload.php';

function mbk_forms_form_handler($form) {
  $API = new PerchAPI(1.0, 'mbk_forms');
  $Settings = $API->get('Settings');
  $data = $form->data;
  $responseKey = null;
  
  // This is what the widget returns when submitting the form
  if(isset($data['g-recaptcha-response'])) {
    $responseKey = $data['g-recaptcha-response'];
  }
  
  $recaptcha = new \ReCaptcha\ReCaptcha($Settings->get('mbk_forms_recaptcha_secret_key')->val());
  $response = $recaptcha->verify($responseKey, $_SERVER['REMOTE_ADDR']);

  if (!$response->isSuccess()) {
    $form->data[$Settings->get('mbk_forms_honeypot_name')->val()] = 'Failed captcha';
  }


  // no need to pass recaptcha response to other apps
  unset($form->data['g-recaptcha-response']);


  // get form attributes
  $attrs = [];
  $Tag = $form->get_form_attributes();
  if(is_object($Tag) && isset($Tag->attributes)) $attrs = $Tag->attributes;


  // redispatch to other apps
  // default to perch_forms unless redispatch attribute is set
  $apps = ['perch_forms'];
  if(isset($attrs['redispatch']) && $attrs['redispatch'] != '') {
    $apps = explode(' ', trim($attrs['redispatch'])); 
  }

  foreach($apps as $app) {
    if( !$response->isSuccess() && $app !== 'perch_forms' ) continue;
    if( function_exists($app.'_form_handler') ) $form->redispatch($app);
  }
}