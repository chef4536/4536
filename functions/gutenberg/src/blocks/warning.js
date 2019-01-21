import classNames from 'classnames'

const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;
const { InspectorControls, RichText, BlockControls, AlignmentToolbar, PanelColorSettings, getColorObjectByColorValue } = wp.editor;
const { PanelBody, SelectControl, TextControl, RadioControl } = wp.components;
const { __ } = wp.i18n;
var colors;

registerBlockType( 'gutenberg-extention-4536/aleart', {

    title: __('警告'),

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
      title: {
        type: 'string',
        selector: 'span',
        default: 'WARNING',
      },
      icon: {
        type: 'string',
        default: 'fa-exclamation-triangle',
      },
      fontColor: {
        type: 'string',
      },
    },

    edit( { attributes, className, setAttributes } ) {

      const { content, alignment, title, icon, fontColor } = attributes;

      return (
        <Fragment>
          <BlockControls>
            <AlignmentToolbar
              value={ alignment }
              onChange={ ( value ) => setAttributes({ alignment: value }) }
            />
          </BlockControls>
          <InspectorControls>
            <PanelBody title={ __('警告オプション') }>
              <RadioControl
                label={ __('アイコン') }
                onChange={ ( value ) => setAttributes({ icon: value }) }
                selected={ icon }
                options={[
                  {
                    label: <i class="fas fa-exclamation-triangle"></i>,
                    value: 'fa-exclamation-triangle',
                  },
                  {
                    label: <i class="fas fa-exclamation-circle"></i>,
                    value: 'fa-exclamation-circle',
                  },
                  {
                    label: <i class="fas fa-exclamation"></i>,
                    value: 'fa-exclamation',
                  },
                  {
                    label: <i class="fas fa-skull-crossbones"></i>,
                    value: 'fa-skull-crossbones',
                  },
                ]}
              />
              <TextControl
                label={ __('タイトル') }
                value={ title }
                onChange={ (value) => setAttributes({ title: value }) }
              />
            </PanelBody>
            <PanelColorSettings
              title={ __( '色設定' ) }
              colorSettings={[
                {
                  label: __( '文字色' ),
                  value: fontColor,
                  onChange: (value) => setAttributes({ fontColor: value }),
                },
              ]}
              initialOpen={ false }
              disableCustomColors={ true }
            />
          </InspectorControls>
          <div className={ classNames('frame', 'frame-red') }>
            <div className={ classNames('frame-title', 'caution') }>
              <i className={ classNames('fas', icon) }></i>
              <span>{ title }</span>
            </div>
            <RichText
                key="editable"
                tagName="p"
                // className={ classNames('has-color', getColorClassName( 'color', fontColor ) ) }
                className={ classNames('has-color', getColorObjectByColorValue( colors, fontColor ) ) }
                style={ { color: fontColor } }
                value={ content }
                onChange={ ( value ) => setAttributes({ content: value }) }
            />
          </div>
        </Fragment>
      );
    },

    save( { attributes } ) {

      const { content, alignment, title, icon, fontColor } = attributes;

      return (
        <div className={ classNames('frame', 'frame-red') }>
          <div className={ classNames('frame-title', 'caution') }>
            <i className={ classNames('fas', icon) }></i>
            <span>{ title }</span>
          </div>
          <RichText.Content
            className={ classNames('has-color', getColorObjectByColorValue( colors, fontColor ) ) }
              style={ { color: fontColor } }
              value={ content }
              tagName="p"
          />
        </div>
      );
    },
} );
