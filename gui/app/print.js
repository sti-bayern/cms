/**
 * Print Listeners
 *
 * @type {Function}
 */
export default function () {
    window.matchMedia('print').addListener(media => media.matches ? printBefore() : printAfter());
    window.addEventListener('beforeprint', printBefore);
    window.addEventListener('afterprint', printAfter);
}

/**
 * Prepares print version
 */
function printBefore() {
    [].forEach.call(document.getElementsByTagName('details'), details => {
        if (details.hasAttribute('open')) {
            details.setAttribute('data-open', '');
        } else {
            details.setAttribute('open', '');
        }
    });

    document.querySelectorAll('a[href^="/"]').forEach(a => {
        a.setAttribute('data-href', a.getAttribute('href'));
        a.setAttribute('href', a.href);
    });
}

/**
 * Restores screen version
 */
function printAfter() {
    [].forEach.call(document.getElementsByTagName('details'), details => {
        if (details.hasAttribute('data-open')) {
            details.removeAttribute('data-open');
        } else {
            details.removeAttribute('open');
        }
    });

    document.querySelectorAll('a[data-href]').forEach(a => {
        a.setAttribute('href', a.getAttribute('data-href'));
        a.removeAttribute('data-href');
    });
}
