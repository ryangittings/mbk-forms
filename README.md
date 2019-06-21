# Perch Forms Recaptcha

This Perch app is to use Google Recaptcha with Perch forms. It works with both v2 and v3 of Recaptcha.

## How does it work?
It uses Recaptcha to verify that the submission isn't spam. If the submission is spam, it fills out the form honeypot field and will appear in the 'spam' tab within Perch forms.

## Choosing which version
A few users have found when using Recaptcha v3, genuine enquiries have gone to spam. If you're using Recaptcha for small contact forms, v2 is recommended.

## Recaptcha v2 Installation
- Download ZIP
- Upload contents of folder to `your_perch_folder/addons/apps/mbk_forms`
- Add `mbk_forms` to `config/apps.php`
- Update the settings in Perch settings with your Recaptcha secret key and [honeypot](https://docs.grabaperch.com/addons/blog/spam/) form field
- Add `<script src="https://www.google.com/recaptcha/api.js" defer></script>` to every page document head
- Add the following to your Perch Form
```
    <perch:input type="hidden" id="g-recaptcha-response" class="g-recaptcha-response">
    <div class="g-recaptcha" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
```
- Add `app="mbk_forms"` to your `perch:form` tag. This replaces `app="perch_forms"`! This app redispatches submissions from `mbk_forms` to `perch_forms`, so you don't need `perch_forms` in the `app` tag. Don't worry, your submissions will still post to Perch Forms as usual!
- Job done!
- To check successful installation front-end, your `g-recaptcha-response` input should populate with a string on document load (this is what the `grecaptcha.ready` code does). This is then passed through when the form is submitted. If the Recaptcha verification is complete, the form should submit. If not, you'll get a submission that's added to the 'Spam' section in forms, and returned to the form with the honeypot field with a value of `Failed captcha`.

## Recaptcha v3 Installation
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
- Add `app="mbk_forms"` to your `perch:form` tag. This replaces `app="perch_forms"`! This app redispatches submissions from `mbk_forms` to `perch_forms`, so you don't need `perch_forms` in the `app` tag. Don't worry, your submissions will still post to Perch Forms as usual!
- Add the following script to pages that include your form (I've included it within a `window.onload` function, below the `api.js` script above):
```
  <script>
    window.onload = function(e) { 
      grecaptcha.ready(() => {
        grecaptcha.execute('YOUR_RECAPTCHA_SITE_KEY', { action: 'validate_captcha' })
          .then((token) => {
            document.querySelector('.g-recaptcha-response').value = token;
          });
      });
    }
  </script>
```
- Job done!
- To check successful installation front-end, your `g-recaptcha-response` input should populate with a string on document load (this is what the `grecaptcha.ready` code does). This is then passed through when the form is submitted. If the Recaptcha verification is complete, the form should submit. If not, you'll get a submission that's added to the 'Spam' section in forms, and returned to the form with the honeypot field with a value of `Failed captcha`.

## Buy me a beer?
Coding is thirsty work. If you've found this app handy, you can [buy me a beer](https://www.paypal.me/ryangittings/3.50?locale.x=en_GB).