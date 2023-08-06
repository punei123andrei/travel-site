/**
 * General theme js class
 */
class Admin {

    constructor() {
        $(document).ready(this.ready.bind(this));
        $(document).ready(this.load.bind(this));
    }

    /**
     * Method called after document ready.
     */
    ready() {
        this.bind();
    }

    /**
     * Method called after window loaded.
     */
    load() {

    }

    bind() {

        // acf.addFilter('color_picker_args', this.colorPicker);
        // acf.addFilter('wysiwyg_tinymce_settings', this.wysiwygSettings);

        this.addBlockIds();

        $(document).on('click', '.copy-block-id-to-clickboard', this.copyBlockId.bind(this));
    }

    /**
     * Alter editor settings and add css to tinymce
     *
     * @param  {[object]}   mceInit     Tinymce object returned by the init function
     * @param  {[string]}   id          Identifier for the tinymce instance
     * @param  {[object]}   field       Field instance
     * @return {[object]}               Tinymce object
     */
    wysiwygSettings(mceInit, id, field) {

        let fieldName = field.data.name;
        let toolbar =  'formatselect,bold,italic,bullist,numlist,alignleft,aligncenter,alignright,link,pastetext,removeformat,outdent,indent,undo,redo,wp_help';

        // set additional css files for tinymce content_css alogn with default ones
        mceInit.content_css = mceInit.content_css.concat(`,${adminCss}`);

        // customize toolbar 1
        mceInit.toolbar1 = toolbar;

        // customize toolbar 2
        mceInit.toolbar2 = '';

        // remove formatselect from hero_description in page layout
        if ('hero_description' == fieldName || 'page_excerpt' == fieldName) {
            mceInit.toolbar1 = toolbar.replace('formatselect,', '');
        }

        // return mceInit settings
        return mceInit;
    }

    /**
     * Color picker layout change
     * TODO: apply this to specific color picker
     */
    colorPicker(args, field) {

        let fieldName = field.data.name;

        if ('background_color' == fieldName) {

            // background_color args
            args.palettes = [
                '',        // empty for transparent or no color
                '#FFFFFF', // $color__white
                '#F0F4FF', // $color__gray
                '#92297D', // $color__purple
                '#50267A', // $color__purple2
                '#672E6C', // $color__purple3
                '#EC4521', // $color__orange
                '#DE6D1E', // $color__orange2
                '#9F8C28', // $color__green
                '#1E914E', // $color__green2
                '#82BF37', // $color__green3
                '#C79B21', // $color__green4
                '#669933', // $color__green5
                '#08194D', // $color__blue2
                '#142966', // $color__blue3
                '#000D33', // $color__blue4
                '#1C8093', // $color__blue5
                '#1BA1C6', // $color__blue6
                '#182D75', // $color__blue7
                '#23409A', // $color__blue9
                '#CCD9FF', // $color__blue10
                '#901A1E', // $color__brown
                '#D32E34', // $color__red
                '#AC014D', // $color__red3
            ];
        }

        return args;
    }

    /**
     * Add block id to each block with copy option
     */
    addBlockIds() {
        const wpDataEditor = wp.data.select('core/block-editor');

        if (typeof wpDataEditor == 'undefined') {
            return;
        }

        const $blocks = wpDataEditor.getBlocks();

        // subscribe to wp data
        wp.data.subscribe(_.debounce(() => {

            $.each($blocks, (i, el) => {

                let $block = $(`[data-type="${el.name}"]`);
                let blockId = `block_${el.clientId}`;
                let copyForm = `<div class="block-id"><span class="block-id-value" id="clip-${blockId}">${blockId}</span><button class="button button-primary copy-block-id-to-clickboard" data-clipboard-target="#clip-${blockId}">Copy block id</button></div>`;

                // the block is selected to be edited
                // and there is no block-id div added so we add it
                if (($block.hasClass('has-child-selected') || $block.hasClass('is-selected')) && $block.find('.block-id').length === 0) {
                    $block.find('.acf-block-fields:first').prepend(copyForm);
                    $block.addClass('block-id-added');
                }
            });
        }, 10));
    }

    /**
     * Copy to clipboard
     *
     * @param  {[type]} e [description]
     * @return {[type]}   [description]
     */
    copyBlockId(e) {
        this.copyToClipboard($(e.currentTarget).parent().find('.block-id-value'));
    }

    /**
     * Copy to clickboard
     *
     * @param  {[string]} $target   jQuery selector, Target element to copy from
     */
    copyToClipboard($target) {

        $target.addClass('selected');
        $target.before('<span class="copied">copied</span>');

        navigator.clipboard.writeText($target.text()).then(() => {

            // remove selected class after a while
            setTimeout(() => {
                $target.removeClass('selected');
                $target.prev().remove();
            }, 5000);
        });
    }
}

export default new Admin();
