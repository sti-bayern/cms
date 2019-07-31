import Observer from './Observer.js';

/**
 * Fix space key for editable summary elements
 */
export default class SummaryObserver extends Observer {
    /**
     * @inheritDoc
     */
    observe(ev) {
        ev.forEach(item => item.addedNodes.forEach(node => {
            if (node instanceof HTMLElement && node.tagName.toLowerCase() === 'summary'
                || node instanceof HTMLDetailsElement && (node = node.querySelector('summary'))
            ) {
                node.addEventListener('blur', () => {
                    if (!node.innerText.trim()) {
                        node.innerText = 'Details';
                    }
                });
                node.addEventListener('keydown', ev => {
                    if (ev.key === ' ') {
                        ev.preventDefault();
                    }
                });
                node.addEventListener('keyup', ev => {
                    if (ev.key === ' ') {
                        ev.preventDefault();
                        this.editor.insertText(' ');
                    }
                });
            }
        }));
    }
}