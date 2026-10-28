import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';
import EditorBlockShell from '../../_shared/EditorBlockShell';

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { kicker, heading, limit, ctaText, ctaUrl } = attributes;
	const blockProps = useBlockProps( { className: 'container cb-hesis2026-editor-block' } );

	return (
		<EditorBlockShell blockProps={ blockProps } clientId={ clientId } classPrefix="cb-hesis2026" textDomain="cb-hesis2026" title="CB Case Studies">
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
			<TextControl
				type="number"
				label={ __( 'Limit', 'cb-hesis2026' ) }
				value={ limit }
				onChange={ ( value ) => setAttributes( { limit: Number( value ) } ) }
				help={ __( 'How many of the latest case studies to show. 0 for six.', 'cb-hesis2026' ) }
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
				help={ __( 'Link under the carousel, e.g. Discover all case studies.', 'cb-hesis2026' ) }
			/>
		</EditorBlockShell>
	);
}
