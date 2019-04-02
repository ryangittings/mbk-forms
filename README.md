# Perch Forms Recaptcha

This Perch app is to use Google Recaptcha v3 with Perch forms.

## How does it work?
It uses Recaptcha to verify that the submission isn't spam. If the submission is spam, it fills out the form honeypot field and will appear in the 'spam' tab within Perch forms.

## Installation
- Download ZIP
- Upload contents of folder to `your_perch_folder/addons/apps/mbk_forms`
- Add `mbk_forms` to `config/apps.php`
- Update the settings in Perch settings with your Recaptcha secret key and [honeypot](https://docs.grabaperch.com/addons/blog/spam/) form field
- Add `<script src="https://www.google.com/recaptcha/api.js?render=YOUR_RECAPTCHA_SITE_KEY" defer></script>` to every page document head
- Add the following to your Perch Form
```
  <perch:input type="hidden" id="g-recaptcha-response" class="g-recaptcha-response">
  <perch:input type="hidden" id="action" value="validate_captcha">
```
- Add `app="mbk_forms"` to your `perch:form` tag. This replaces `app="perch_forms"`!
- Add the following script to pages that include your form (I've included it within a `window.onload` function):
```
  window.onload = function(e) { 
    grecaptcha.ready(() => {
      grecaptcha.execute('YOUR_RECAPTCHA_SITE_KEY', { action: 'validate_captcha' })
        .then((token) => {
          document.querySelector('.g-recaptcha-response').value = token;
        });
    });
  }
```
- Job done!
- To check successful installation front-end, your `g-recaptcha-response` input should populate with a string on document load (this is what the `grecaptcha.ready` code does). This is then passed through when the form is submitted. If the Recaptcha verification is complete, the form should submit. If not, you'll get a submission that's added to the 'Spam' section in forms, and returned to the form with the honeypot field with a value of `Failed captcha`.

## Buy me a beer?
Coding is thirsty work. If you've found this app handy, you can [buy me a beer](https://www.paypal.me/ryangittings/3.50?locale.x=en_GB).