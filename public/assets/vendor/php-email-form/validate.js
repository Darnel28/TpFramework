/**
* PHP Email Form Validation - v3.11 (Version corrigée)
* URL: https://bootstrapmade.com/php-email-form/
* Author: BootstrapMade.com
* Modifié pour éviter les erreurs d'éléments manquants
*/
(function () {
  "use strict";

  let forms = document.querySelectorAll('.php-email-form');

  // Si aucun formulaire n'est trouvé, ne rien faire
  if (forms.length === 0) {
    console.log('Aucun formulaire .php-email-form trouvé');
    return;
  }

  forms.forEach( function(e) {
    e.addEventListener('submit', function(event) {
      event.preventDefault();

      let thisForm = this;

      let action = thisForm.getAttribute('action');
      
      if( ! action ) {
        console.error('The form action property is not set!');
        thisForm.submit(); // Soumettre normalement
        return;
      }
      
      // Vérifier si les éléments existent avant d'y accéder
      let loading = thisForm.querySelector('.loading');
      let errorMessage = thisForm.querySelector('.error-message');
      let sentMessage = thisForm.querySelector('.sent-message');
      
      if (loading) {
        loading.classList.add('d-block');
        loading.style.display = 'block';
      }
      
      if (errorMessage) {
        errorMessage.classList.remove('d-block');
        errorMessage.style.display = 'none';
      }
      
      if (sentMessage) {
        sentMessage.classList.remove('d-block');
        sentMessage.style.display = 'none';
      }

      let formData = new FormData( thisForm );
      let recaptcha = thisForm.getAttribute('data-recaptcha-site-key');

      if ( recaptcha ) {
        if(typeof grecaptcha !== "undefined" ) {
          grecaptcha.ready(function() {
            try {
              grecaptcha.execute(recaptcha, {action: 'php_email_form_submit'})
              .then(token => {
                formData.set('recaptcha-response', token);
                php_email_form_submit(thisForm, action, formData);
              })
            } catch(error) {
              displayError(thisForm, error);
            }
          });
        } else {
          displayError(thisForm, 'The reCaptcha javascript API url is not loaded!')
        }
      } else {
        php_email_form_submit(thisForm, action, formData);
      }
    });
  });

  function php_email_form_submit(thisForm, action, formData) {
    fetch(action, {
      method: 'POST',
      body: formData,
      headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(response => {
      if( response.ok ) {
        return response.text();
      } else {
        throw new Error(`${response.status} ${response.statusText} ${response.url}`); 
      }
    })
    .then(data => {
      // Vérifier à nouveau que les éléments existent
      let loading = thisForm.querySelector('.loading');
      let sentMessage = thisForm.querySelector('.sent-message');
      
      if (loading) {
        loading.classList.remove('d-block');
        loading.style.display = 'none';
      }
      
      if (data.trim() == 'OK') {
        if (sentMessage) {
          sentMessage.classList.add('d-block');
          sentMessage.style.display = 'block';
        }
        thisForm.reset(); 
      } else {
        throw new Error(data ? data : 'Form submission failed and no error message returned from: ' + action); 
      }
    })
    .catch((error) => {
      displayError(thisForm, error);
    });
  }

  function displayError(thisForm, error) {
    let loading = thisForm.querySelector('.loading');
    let errorMessage = thisForm.querySelector('.error-message');
    
    if (loading) {
      loading.classList.remove('d-block');
      loading.style.display = 'none';
    }
    
    if (errorMessage) {
      errorMessage.innerHTML = error;
      errorMessage.classList.add('d-block');
      errorMessage.style.display = 'block';
    } else {
      console.error('Form error:', error);
      // Si pas de div d'erreur, afficher une alerte
      alert('Erreur: ' + error);
    }
  }

})();