// import WysiwygEditor from './WysiwygEditor.js';
// import SelectSelectize from './SelectSelectize.js';
// import SelectSelect2 from './SelectSelect2.js';
// import { DatePicker } from "./DatePicker.js";
import ActionButton from "./ActionButton.js";
import BookmarkButton from './BookmarkButton.js';


// customElements.get('wysiwyg-editor') || customElements.define('wysiwyg-editor', WysiwygEditor, { extends: 'textarea' });
// customElements.get('select-selectize') || customElements.define('select-selectize', SelectSelectize, { extends: 'select' });
// customElements.get('select-select2') || customElements.define('select-select2', SelectSelect2, { extends: 'select' });
// customElements.get('date-time-picker') || customElements.define('date-time-picker', DatePicker, { extends: 'input' });
customElements.get('action-button') || customElements.define('action-button', ActionButton);
customElements.get('bookmark-button') || customElements.define('bookmark-button', BookmarkButton);
