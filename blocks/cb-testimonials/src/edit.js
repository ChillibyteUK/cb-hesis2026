import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';
import RepeaterField from '../../_shared/RepeaterField';
import EditorBlockShell from '../../_shared/EditorBlockShell';

const testimonialsFields = [
	{ name: 'quote', label: __( 'Quote', 'cb-hesis2026' ), type: 'textarea' },
	{ name: 'name', label: __( 'Name', 'cb-hesis2026' ), type: 'text' },
	{ name: 'role', label: __( 'Role', 'cb-hesis2026' ), type: 'text' },
];

const testimonialsEmptyRow = { quote: '', name: '', role: '' };

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { kicker, heading, testimonials, ctaText, ctaUrl } = attributes;
	const blockProps = useBlockProps( { className: 'container cb-hesis2026-editor-block' } );

	return (
		<EditorBlockShell blockProps={ blockProps } clientId={ clientId } classPrefix="cb-hesis2026" textDomain="cb-hesis2026" title="CB Testimonials">
			<div style={ { display: 'flex', flexWrap: 'wrap', gap: '12px' } }>
				<div style={ { flex: '50 1 0%' } }>
			<TextControl
				label={ __( 'Kicker', 'cb-hesis2026' ) }
				value={ kicker }
				onChange={ ( value ) => setAttributes( { kicker: value } ) }
			/>
				</div>
				<div style={ { flex: '50 1 0%' } }>
			<TextControl
				label={ __( 'Heading', 'cb-hesis2026' ) }
				value={ heading }
				onChange={ ( value ) => setAttributes( { heading: value } ) }
			/>
				</div>
			</div>
			<RepeaterField
				label={ __( 'Testimonials', 'cb-hesis2026' ) }
				value={ testimonials }
				onChange={ ( value ) => setAttributes( { testimonials: value } ) }
				fields={ testimonialsFields }
				emptyRow={ testimonialsEmptyRow }
				layout="column"
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
			/>
		</EditorBlockShell>
	);
}
