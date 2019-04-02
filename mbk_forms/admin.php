<?php

if ($CurrentUser->logged_in()) {
    $this->register_app('mbk_forms', 'Perch Forms Recaptcha', 99, 'Google Recaptcha x Perch Forms', '1.0', true); 
    $this->require_version('mbk_forms', '2.0');

    $this->add_setting('mbk_forms_recaptcha_secret_key', 'Recaptcha secret key', 'text', '');
    $this->add_setting('mbk_forms_honeypot_name', 'Honeypot field ID', 'text', '');
}