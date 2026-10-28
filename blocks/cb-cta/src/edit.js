import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { TextControl, ToggleControl } from '@wordpress/components';
import EditorBlockShell from '../../_shared/EditorBlockShell';

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { heading, subline, ctaText, ctaUrl, ctaTarget, showPhone } = attributes;
	const blockProps = useBlockProps( { className: 'container cb-hesis2026-editor-block' } );

	return (
		<EditorBlockShell blockProps={ blockProps } clientId={ clientId } classPrefix="cb-hesis2026" textDomain="cb-hesis2026" title="CB CTA">
			<TextControl
				label={ __( 'Heading', 'cb-hesis2026' ) }
				value={ heading }
				onChange={ ( value ) => setAttributes( { heading: value } ) }
			/>
			<TextControl
				label={ __( 'Subline', 'cb-hesis2026' ) }
				value={ subline }
				onChange={ ( value ) => setAttributes( { subline: value } ) }
				help={ __( 'e.g. Liverpool HQ & Crawley office. The phone number from Site-Wide Settings is appended.', 'cb-hesis2026' ) }
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
			<ToggleControl
				label={ __( 'Open CTA in a new tab', 'cb-hesis2026' ) }
				checked={ ctaTarget }
				onChange={ ( value ) => setAttributes( { ctaTarget: value } ) }
			/>
			<ToggleControl
				label={ __( 'Show Phone', 'cb-hesis2026' ) }
				checked={ showPhone }
				onChange={ ( value ) => setAttributes( { showPhone: value } ) }
			/>
		</EditorBlockShell>
	);
}
