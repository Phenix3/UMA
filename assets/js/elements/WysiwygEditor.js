import FroalaEditor from 'froala-editor';

import 'froala-editor/js/plugins/colors.min.js';
import 'froala-editor/js/plugins/fullscreen.min.js';
import 'froala-editor/js/plugins/font_family.min.js';
import 'froala-editor/js/plugins/font_size.min.js';
import 'froala-editor/js/plugins/image.min.js';
import 'froala-editor/js/plugins/image_manager.min.js';
import 'froala-editor/js/plugins/link.min.js';
import 'froala-editor/js/plugins/lists.min.js';
import 'froala-editor/js/plugins/markdown.min.js';
import 'froala-editor/js/plugins/paragraph_format.min.js';
import 'froala-editor/js/plugins/paragraph_style.min.js';
import 'froala-editor/js/plugins/quote.min.js';
import 'froala-editor/js/plugins/table.min.js';
import 'froala-editor/js/plugins/url.min.js';
import 'froala-editor/js/plugins/word_paste.min.js';
import 'froala-editor/js/plugins/code_view.min.js';
import 'froala-editor/js/plugins/emoticons.min.js';

import 'froala-editor/js/third_party/spell_checker.min.js';

import 'froala-editor/js/languages/fr.js';

import 'froala-editor/css/froala_editor.css';
import 'froala-editor/css/plugins.pkgd.min.css';
import 'froala-editor/css/themes/royal.min.css';

export default class WysiwygEditor extends HTMLTextAreaElement {
    connectedCallback() {
        new FroalaEditor(this);
    }
}
