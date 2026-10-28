import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { TextControl, RadioControl, ToggleControl, Button } from '@wordpress/components';
import EditorBlockShell from '../../_shared/EditorBlockShell';

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { kicker, heading, body, ctaText, ctaUrl, ctaTarget, mainImageId, mainImageUrl, mainImageAlt, secondaryImageId, secondaryImageUrl, secondaryImageAlt, imagePosition, dotRing } = attributes;
	const blockProps = useBlockProps( { className: 'container cb-hesis2026-editor-block' } );

	return (
		<EditorBlockShell blockProps={ blockProps } clientId={ clientId } classPrefix="cb-hesis2026" textDomain="cb-hesis2026" title="CB Image Text">
			<TextControl
				label={ __( 'Kicker', 'cb-hesis2026' ) }
				value={ kicker }
				onChange={ ( value ) => setAttributes( { kicker: value } ) }
			/>
			<TextControl
				label={ __( 'Heading', 'cb-hesis2026' ) }
				value={ heading }
				onChange={ ( value ) => setAttributes( { heading: value } ) }
			/>
			<div className="cb-hesis2026-editor-field">
				<label className="cb-hesis2026-editor-field__label">{ __( 'Body', 'cb-hesis2026' ) }</label>
				<RichText
					tagName="div"
					className="cb-hesis2026-editor-field__control"
					aria-label={ __( 'Body', 'cb-hesis2026' ) }
					placeholder={ __( 'Body', 'cb-hesis2026' ) }
					value={ body }
					onChange={ ( value ) => setAttributes( { body: value } ) }
				/>
			</div>
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
			<div style={ { display: 'flex', flexWrap: 'wrap', gap: '12px' } }>
				<div style={ { flex: '50 1 0%' } }>
			<div className="cb-hesis2026-editor-field">
				<label className="cb-hesis2026-editor-field__label">{ __( 'Main Image', 'cb-hesis2026' ) }</label>
				<MediaUploadCheck>
					<MediaUpload
						onSelect={ ( media ) =>
							setAttributes( {
								mainImageId: media.id,
								mainImageUrl: media.url,
								mainImageAlt: media.alt || '',
							} )
						}
						allowedTypes={ [ 'image' ] }
						value={ mainImageId }
						render={ ( { open } ) => (
							<div className="cb-hesis2026-editor-field__control">
								{ mainImageUrl && (
									<img
										src={ mainImageUrl }
										alt={ mainImageAlt }
										style={ { maxWidth: '200px', display: 'block', marginBottom: '8px' } }
									/>
								) }
								<Button variant="secondary" onClick={ open }>
									{ mainImageUrl ? __( 'Replace Main Image', 'cb-hesis2026' ) : __( 'Select Main Image', 'cb-hesis2026' ) }
								</Button>
							</div>
						) }
					/>
				</MediaUploadCheck>
				<p className="cb-hesis2026-editor-field__help">{ __( 'Cropped to a circle.', 'cb-hesis2026' ) }</p>
			</div>
				</div>
				<div style={ { flex: '50 1 0%' } }>
			<div className="cb-hesis2026-editor-field">
				<label className="cb-hesis2026-editor-field__label">{ __( 'Secondary Image', 'cb-hesis2026' ) }</label>
				<MediaUploadCheck>
					<MediaUpload
						onSelect={ ( media ) =>
							setAttributes( {
								secondaryImageId: media.id,
								secondaryImageUrl: media.url,
								secondaryImageAlt: media.alt || '',
							} )
						}
						allowedTypes={ [ 'image' ] }
						value={ secondaryImageId }
						render={ ( { open } ) => (
							<div className="cb-hesis2026-editor-field__control">
								{ secondaryImageUrl && (
									<img
										src={ secondaryImageUrl }
										alt={ secondaryImageAlt }
										style={ { maxWidth: '200px', display: 'block', marginBottom: '8px' } }
									/>
								) }
								<Button variant="secondary" onClick={ open }>
									{ secondaryImageUrl ? __( 'Replace Secondary Image', 'cb-hesis2026' ) : __( 'Select Secondary Image', 'cb-hesis2026' ) }
								</Button>
							</div>
						) }
					/>
				</MediaUploadCheck>
				<p className="cb-hesis2026-editor-field__help">{ __( 'Optional smaller circle overlapping the main image.', 'cb-hesis2026' ) }</p>
			</div>
				</div>
			</div>
			<div style={ { display: 'flex', flexWrap: 'wrap', gap: '12px' } }>
				<div style={ { flex: '50 1 0%' } }>
			<RadioControl
				label={ __( 'Image Position', 'cb-hesis2026' ) }
				selected={ imagePosition }
				options={ [
					{ label: 'Right', value: 'Right' },
					{ label: 'Left', value: 'Left' },
				] }
				onChange={ ( value ) => setAttributes( { imagePosition: value } ) }
			/>
				</div>
				<div style={ { flex: '50 1 0%' } }>
			<ToggleControl
				label={ __( 'Dot Ring', 'cb-hesis2026' ) }
				checked={ dotRing }
				onChange={ ( value ) => setAttributes( { dotRing: value } ) }
				help={ __( 'Rotating ring of orange dots behind the main image.', 'cb-hesis2026' ) }
			/>
				</div>
			</div>
		</EditorBlockShell>
	);
}
