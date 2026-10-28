import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { useBlockProps, MediaUpload, MediaUploadCheck, InspectorControls } from '@wordpress/block-editor';
import { TextControl, TextareaControl, Button, PanelBody, FocalPointPicker } from '@wordpress/components';
import RepeaterField from '../../_shared/RepeaterField';
import EditorBlockShell from '../../_shared/EditorBlockShell';

const sectorsFields = [
	{ name: 'title', label: __( 'Title', 'cb-hesis2026' ), type: 'text' },
	{ name: 'description', label: __( 'Description', 'cb-hesis2026' ), type: 'textarea' },
	{ name: 'link', label: __( 'Link', 'cb-hesis2026' ), type: 'link' },
];

const sectorsEmptyRow = { title: '', description: '', link: '', linkText: '' };

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { kicker, heading, intro, backgroundImageId, backgroundImageUrl, backgroundImageAlt, backgroundImageFocalPoint, sectors, ctaText, ctaUrl } = attributes;
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
			<EditorBlockShell blockProps={ blockProps } clientId={ clientId } classPrefix="cb-hesis2026" textDomain="cb-hesis2026" title="CB Sectors">
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
				<TextareaControl
					label={ __( 'Intro', 'cb-hesis2026' ) }
					value={ intro }
					onChange={ ( value ) => setAttributes( { intro: value } ) }
				/>
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
				</div>
				<RepeaterField
					label={ __( 'Sectors', 'cb-hesis2026' ) }
					value={ sectors }
					onChange={ ( value ) => setAttributes( { sectors: value } ) }
					fields={ sectorsFields }
					emptyRow={ sectorsEmptyRow }
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
					help={ __( 'Link under the accordion, e.g. View all sectors.', 'cb-hesis2026' ) }
				/>
			</EditorBlockShell>
		</Fragment>
	);
}
