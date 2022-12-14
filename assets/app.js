/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any SCSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

const copy = document.querySelectorAll('[data-copy-link]');

if (copy) {
    copy.forEach((element => {
        element.addEventListener('click', () => {
            let value = element.innerHTML;
            navigator.clipboard.writeText(value);
            element.innerHTML = 'lien copié ✅';
        });
    }))
}

