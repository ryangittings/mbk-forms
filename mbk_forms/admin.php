<?php

if ($CurrentUser->logged_in()) {
    $this->register_app('mbk_forms', 'Forms Recaptcha', 1, 'Recaptcha protection', '1.0');
    $this->require_version('mbk_forms', '2.0');

    $this->add_setting('mbk_forms_recaptcha_secret_key', 'Recaptcha secret key', 'text', '');
    $this->add_setting('mbk_forms_honeypot_name', 'Honepot field name', 'text', '');
}