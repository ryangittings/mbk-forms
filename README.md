# Perch Forms Recaptcha

This Perch app is to use Google Recaptcha v3 with Perch forms.

## How does it work?
It uses Recaptcha to verify that the submission isn't spam. If the submission is spam, it fills out the form honeypot field and will appear in the 'spam' tab within Perch forms.

## Installation
- Download ZIP
- Upload contents of folder to `your_perch_folder/addons/apps/mbk_forms`
- Add `mbk_forms` to `config/apps.php`
- Update the settings in Perch settings with your Recaptcha secret key and honeypot form field
- Add `<script src="https://www.google.com/recaptcha/api.js?render={YOUR_RECAPTCHA_SITE_KEY}" defer></script>` to every page document head
- Add the following to your Perch Form
```
  <perch:input type="hidden" id="g-recaptcha-response" class="g-recaptcha-response">
  <perch:input type="hidden" id="action" value="validate_captcha">
```
- Add `app="mbk_forms"` to your `perch:form` tag
- On document load, add this script:
```
  grecaptcha.ready(() => {
    grecaptcha.execute('{YOUR_RECAPTCHA_SITE_KEY}', { action: 'validate_captcha' })
      .then((token) => {
        document.querySelector('.g-recaptcha-response').value = token;
      });
  });
```
- Job done!