import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { TextControl, TextareaControl } from '@wordpress/components';
import RepeaterField from '../../_shared/RepeaterField';
import EditorBlockShell from '../../_shared/EditorBlockShell';

const tilesFields = [
	{ name: 'iconName', label: __( 'Icon Name', 'cb-hesis2026' ), type: 'text' },
	{ name: 'iconImage', label: __( 'Icon Image', 'cb-hesis2026' ), type: 'image' },
	{ name: 'title', label: __( 'Title', 'cb-hesis2026' ), type: 'text' },
	{ name: 'link', label: __( 'Link', 'cb-hesis2026' ), type: 'link' },
];

const tilesEmptyRow = { iconName: '', iconImage: 0, title: '', link: '', linkText: '' };

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { heading, intro, tiles, ctaText, ctaUrl } = attributes;
	const blockProps = useBlockProps( { className: 'container cb-hesis2026-editor-block' } );

	return (
		<EditorBlockShell blockProps={ blockProps } clientId={ clientId } classPrefix="cb-hesis2026" textDomain="cb-hesis2026" title="CB Service Tiles">
			<TextControl
				label={ __( 'Heading', 'cb-hesis2026' ) }
				value={ heading }
				onChange={ ( value ) => setAttributes( { heading: value } ) }
			/>
			<TextareaControl
				label={ __( 'Intro', 'cb-hesis2026' ) }
				value={ intro }
				onChange={ ( value ) => setAttributes( { intro: value } ) }
			/>
			<RepeaterField
				label={ __( 'Tiles', 'cb-hesis2026' ) }
				value={ tiles }
				onChange={ ( value ) => setAttributes( { tiles: value } ) }
				fields={ tilesFields }
				emptyRow={ tilesEmptyRow }
			/>
			<TextControl
				label={ __( 'CTA Text', 'cb-hesis2026' ) }
				value={ ctaText }
				onChange={ ( value ) => setAttributes( { ctaText: value } ) }
			/>
			<TextControl
				type="url"
				label={ __( 'CTA URL', 'cb-hesis2026' ) }
				value={ ctaUrl }
				onChange={ ( value ) => setAttributes( { ctaUrl: value } ) }
				help={ __( 'Text link under the grid, e.g. View all services.', 'cb-hesis2026' ) }
			/>
		</EditorBlockShell>
	);
}
