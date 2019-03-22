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

  $form->redispatch('perch_forms'); // send along
}