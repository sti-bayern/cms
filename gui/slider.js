/**
 * Slider
 */
'use strict';

(function (document, Flickity) {
    document.addEventListener('DOMContentLoaded', function () {
        Array.prototype.forEach.call(document.getElementsByClassName('slider'), function (slider) {
            const items = slider.querySelector('.items');

            if (!items) {
                return;
            }

            const nav = slider.querySelector('.nav');
            const flickity = new Flickity(items, {
                autoPlay: slider.classList.contains('auto'),
                cellAlign: 'left',
                contain: true,
                imagesLoaded: true,
                fullscreen: slider.classList.contains('fullscreen'),
                pageDots: slider.classList.contains('dots'),
                percentPosition: false,
                prevNextButtons: slider.classList.contains('prevnext')
            });

            if (!!nav) {
                const button = nav.getElementsByTagName('button');

                Array.prototype.forEach.call(button, function (b) {
                    b.addEventListener('click', function (ev) {
                        flickity.select(Array.prototype.indexOf.call(button, ev.target));
                    });
                });

                flickity.on('select', function (current) {
                    Array.prototype.forEach.call(button, function (b, index) {
                        if (index === current) {
                            b.classList.add('is-selected');
                        } else {
                            b.classList.remove('is-selected');
                        }
                    });
                });
            }
        });
    });
})(document, Flickity);
