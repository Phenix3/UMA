import { startStimulusApp } from '@symfony/stimulus-bridge';
// import $ from 'jquery';
// import TomSelect from 'tom-select'
import '@@/js/elements/index.js';
import '@@/components/index.js';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);

 // Choices
/*  $('select[multiple]:not([is])').forEach(
    s =>
      new TomSelect(s, {
        plugins: {
          remove_button: {
            title: 'Supprimer cet élément'
          }
        },
        maxItems: s.dataset.limit || null
      })
  ) */

  /**
 * Evite le chargement ajax lors de l'utilisation d'une ancre
 *
 * cf : https://github.com/turbolinks/turbolinks/issues/75
 */
/* document.addEventListener('turbolinks:click', e => {
    const anchorElement = e.target
    const isSamePageAnchor =
      anchorElement?.hash &&
      anchorElement.origin === window.location.origin &&
      anchorElement.pathname === window.location.pathname
  
    if (isSamePageAnchor) {
      Turbolinks.controller.pushHistoryWithLocationAndRestorationIdentifier(e.data.url, Turbolinks.uuid())
      e.preventDefault()
      window.dispatchEvent(new Event('hashchange'))
    }
  }) */
