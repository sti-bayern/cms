'use strict';

(function (CKEDITOR) {
    const types = {
        flac: 'audio',
        gif: 'img',
        jpg: 'img',
        mov: 'video',
        mp3: 'audio',
        mp4: 'video',
        oga: 'audio',
        ogg: 'audio',
        ogv: 'video',
        png: 'img',
        svg: 'img',
        wav: 'audio',
        weba: 'audio',
        webm: 'video',
        webp: 'img',
    };

    CKEDITOR.plugins.add('media', {
        requires: 'dialog,widget',
        icons: 'media',
        lang: 'de,en',
        init: function(editor) {
            editor.widgets.add('media', {
                button: editor.lang.media.title,
                dialog: 'media',
                template: '<figure class="media"><figcaption></figcaption></figure>',
                editables: {
                    caption: {
                        selector: 'figcaption',
                        allowedContent: 'strong em'
                    }
                },
                allowedContent: 'figure(!media, left, center, right); img audio video[!src, alt, controls]; figcaption',
                requiredContent: 'figure(media); img audio video[src]',
                defaults: {
                    align: '',
                    alt: '',
                    caption: false,
                    src: ''
                },
                upcast: function(element) {
                    return element.name == 'figure' && element.hasClass('media');
                },
                init: function () {
                    if (this.element.hasClass('left')) {
                        this.setData('align', 'left');
                    } else if (this.element.hasClass('center')) {
                        this.setData('align', 'center');
                    } else if (this.element.hasClass('right')) {
                        this.setData('align', 'right');
                    }
                },
                data: function () {
                    let ext;

                    if (!this.data.src || !(ext = this.data.src.split('.').pop()) || !types.hasOwnProperty(ext)) {
                        return;
                    }

                    let media = this.element.findOne('img,audio,video');
                    let caption = this.element.findOne('figcaption');

                    if (!media || media.getName() !== types[ext]) {
                        if (media) {
                            media.remove();
                        }

                        media = new CKEDITOR.dom.element(types[ext]);

                        if (caption) {
                            media.insertBefore(caption);
                        } else {
                            this.element.append(media);
                        }
                    }

                    media.setAttribute('src', this.data.src);

                    if (types[ext] === 'img') {
                        media.setAttribute('alt', this.data.alt);
                    } else {
                        media.setAttribute('controls', true);
                    }

                    if (this.data.caption && !caption) {
                        this.element.append(new CKEDITOR.dom.element('figcaption'));
                    } else if (!this.data.caption && caption) {
                        caption.remove();
                    }

                    this.element.removeClass('left');
                    this.element.removeClass('center');
                    this.element.removeClass('right');

                    if (this.data.align) {
                        this.element.addClass(this.data.align);
                    }
                }
            });

            CKEDITOR.dialog.add('media', this.path + 'dialogs/media.js');
        }
    });
})(CKEDITOR);
