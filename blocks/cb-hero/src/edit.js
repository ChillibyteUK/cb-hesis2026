import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { useBlockProps, MediaUpload, MediaUploadCheck, InspectorControls } from '@wordpress/block-editor';
import { TextControl, TextareaControl, ToggleControl, Button, PanelBody, FocalPointPicker } from '@wordpress/components';
import EditorBlockShell from '../../_shared/EditorBlockShell';

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { kicker, heading, intro, primaryCtaText, primaryCtaUrl, primaryCtaTarget, secondaryCtaText, secondaryCtaUrl, secondaryCtaTarget, backgroundImageId, backgroundImageUrl, backgroundImageAlt, backgroundImageFocalPoint, bottomCurve } = attributes;
	const blockProps = useBlockProps( { className: 'container cb-hesis2026-editor-block' } );

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody title={ __( 'Background Image settings', 'cb-hesis2026' ) }>
					<FocalPointPicker
						label={ __( 'Focal point', 'cb-hesis2026' ) }
						url={ backgroundImageUrl }
						value={ backgroundImageFocalPoint }
						onChange={ ( value ) => setAttributes( { backgroundImageFocalPoint: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<EditorBlockShell blockProps={ blockProps } clientId={ clientId } classPrefix="cb-hesis2026" textDomain="cb-hesis2026" title="CB Hero">
				<TextControl
					label={ __( 'Kicker', 'cb-hesis2026' ) }
					value={ kicker }
					onChange={ ( value ) => setAttributes( { kicker: value } ) }
					help={ __( 'Small orange line above the heading.', 'cb-hesis2026' ) }
				/>
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
				<div style={ { display: 'flex', flexWrap: 'wrap', gap: '12px' } }>
					<div style={ { flex: '50 1 0%' } }>
				<TextControl
					label={ __( 'Primary CTA Text', 'cb-hesis2026' ) }
					value={ primaryCtaText }
					onChange={ ( value ) => setAttributes( { primaryCtaText: value } ) }
				/>
				<TextControl
					type="url"
					label={ __( 'Primary CTA URL', 'cb-hesis2026' ) }
					value={ primaryCtaUrl }
					onChange={ ( value ) => setAttributes( { primaryCtaUrl: value } ) }
				/>
				<ToggleControl
					label={ __( 'Open Primary CTA in a new tab', 'cb-hesis2026' ) }
					checked={ primaryCtaTarget }
					onChange={ ( value ) => setAttributes( { primaryCtaTarget: value } ) }
				/>
					</div>
					<div style={ { flex: '50 1 0%' } }>
				<TextControl
					label={ __( 'Secondary CTA Text', 'cb-hesis2026' ) }
					value={ secondaryCtaText }
					onChange={ ( value ) => setAttributes( { secondaryCtaText: value } ) }
				/>
				<TextControl
					type="url"
					label={ __( 'Secondary CTA URL', 'cb-hesis2026' ) }
					value={ secondaryCtaUrl }
					onChange={ ( value ) => setAttributes( { secondaryCtaUrl: value } ) }
				/>
				<ToggleControl
					label={ __( 'Open Secondary CTA in a new tab', 'cb-hesis2026' ) }
					checked={ secondaryCtaTarget }
					onChange={ ( value ) => setAttributes( { secondaryCtaTarget: value } ) }
				/>
					</div>
				</div>
				<div className="cb-hesis2026-editor-field">
					<label className="cb-hesis2026-editor-field__label">{ __( 'Background Image', 'cb-hesis2026' ) }</label>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ ( media ) =>
								setAttributes( {
									backgroundImageId: media.id,
									backgroundImageUrl: media.url,
									backgroundImageAlt: media.alt || '',
								} )
							}
							allowedTypes={ [ 'image' ] }
							value={ backgroundImageId }
							render={ ( { open } ) => (
								<div className="cb-hesis2026-editor-field__control">
									{ backgroundImageUrl && (
										<img
											src={ backgroundImageUrl }
											alt={ backgroundImageAlt }
											style={ { maxWidth: '200px', display: 'block', marginBottom: '8px' } }
										/>
									) }
									<Button variant="secondary" onClick={ open }>
										{ backgroundImageUrl ? __( 'Replace Background Image', 'cb-hesis2026' ) : __( 'Select Background Image', 'cb-hesis2026' ) }
									</Button>
								</div>
							) }
						/>
					</MediaUploadCheck>
					<p className="cb-hesis2026-editor-field__help">{ __( 'Landscape photo. A dark scrim keeps white text legible.', 'cb-hesis2026' ) }</p>
				</div>
				<ToggleControl
					label={ __( 'Bottom Curve', 'cb-hesis2026' ) }
					checked={ bottomCurve }
					onChange={ ( value ) => setAttributes( { bottomCurve: value } ) }
					help={ __( 'Curved white edge under the hero. Leave off when the Accreditations band follows.', 'cb-hesis2026' ) }
				/>
			</EditorBlockShell>
		</Fragment>
	);
}
