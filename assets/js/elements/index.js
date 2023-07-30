import WysiwygEditor from '@@/js/elements/WysiwygEditor.js';
// import SelectSelectize from './SelectSelectize.js';
import SelectSelect2 from '@@/js/elements/SelectSelect2.js';
import { DatePicker } from "./DatePicker.js";
import ActionButton from "@@/js/elements/ActionButton.js";
import BookmarkButton from '@@/js/elements/BookmarkButton.js';
import {Alert, FloatingAlert} from '@@/js/elements/Alert.js';
import InputAttachment from '@admin/js/elements/InputAttachment.js';
import { CommentsElement } from '../../react/controllers/Comments.jsx';

customElements.get('input-attachment') || customElements.define('input-attachment', InputAttachment, { extends: 'input' });


customElements.get('wysiwyg-editor') || customElements.define('wysiwyg-editor', WysiwygEditor, { extends: 'textarea' });
// customElements.get('select-selectize') || customElements.define('select-selectize', SelectSelectize, { extends: 'select' });
customElements.get('select-select2') || customElements.define('select-select2', SelectSelect2, { extends: 'select' });
customElements.get('date-time-picker') || customElements.define('date-time-picker', DatePicker, { extends: 'input' });
customElements.get('action-button') || customElements.define('action-button', ActionButton);
customElements.get('bookmark-button') || customElements.define('bookmark-button', BookmarkButton);
customElements.get('alert-message') || customElements.define('alert-message', Alert);
customElements.get('alert-floating') || customElements.define('alert-floating', FloatingAlert);
customElements.define('comments-area', CommentsElement);
