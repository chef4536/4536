const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;
const {
    RichText,
    BlockControls,
    AlignmentToolbar,
} = wp.editor;
const { __ } = wp.i18n;

registerBlockType( 'gutenberg-extention-4536/aleart', {

    title: __('アラート'),

    icon: 'warning',

    category: 'custom-block-4536',

    attributes: {
        content: {
            type: 'string',
            source: 'html',
            selector: 'p',
        },
        alignment: {
            type: 'string',
        },
    },

    edit( { attributes, className, setAttributes } ) {
        const { content, alignment } = attributes;

        function onChangeContent( newContent ) {
            setAttributes( { content: newContent } );
        }

        function onChangeAlignment( newAlignment ) {
            setAttributes( { alignment: newAlignment } );
        }

        return (
            <Fragment>
                <BlockControls>
                    <AlignmentToolbar
                        value={ alignment }
                        onChange={ onChangeAlignment }
                    />
                </BlockControls>
                <RichText
                    key="editable"
                    tagName="p"
                    className={ className }
                    style={ { textAlign: alignment } }
                    onChange={ onChangeContent }
                    value={ content }
                />
            </Fragment>
        );
    },

    save( { attributes } ) {
        const { content, alignment } = attributes;

        return (
            <RichText.Content
                style={ { textAlign: alignment } }
                value={ content }
                tagName="p"
            />
        );
    },
} );
