/**
 * Editor Config
 */
export default class Config {
    /**
     * Creates a new instance of editor config with given defaults
     *
     * @param {Object} [opts = {}]
     */
    constructor(opts = {}) {
        /**
         * Block
         *
         * @type {Object}
         * @readonly
         */
        this.block = opts.block || {};

        /**
         * Language
         *
         * @type {String}
         * @readonly
         */
        this.lang = opts.lang;

        /**
         * Translations
         *
         * @type {Object}
         * @readonly
         */
        this.i18n = opts.i18n || {};

        /**
         * Media
         *
         * @type {Object}
         * @readonly
         */
        this.media = opts.media || {};

        /**
         * Section
         *
         * @type {Object}
         * @readonly
         */
        this.section = opts.section || {};
    }
}
