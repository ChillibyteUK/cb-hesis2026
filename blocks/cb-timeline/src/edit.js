import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { TextControl, TextareaControl } from '@wordpress/components';
import RepeaterField from '../../_shared/RepeaterField';
import EditorBlockShell from '../../_shared/EditorBlockShell';

const milestonesFields = [
	{ name: 'year', label: __( 'Year', 'cb-hesis2026' ), type: 'text' },
	{ name: 'title', label: __( 'Title', 'cb-hesis2026' ), type: 'text' },
	{ name: 'description', label: __( 'Description', 'cb-hesis2026' ), type: 'textarea' },
];

const milestonesEmptyRow = { year: '', title: '', description: '' };

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { kicker, heading, intro, milestones } = attributes;
	const blockProps = useBlockProps( { className: 'container cb-hesis2026-editor-block' } );

	return (
		<EditorBlockShell blockProps={ blockProps } clientId={ clientId } classPrefix="cb-hesis2026" textDomain="cb-hesis2026" title="CB Timeline">
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
			<TextareaControl
				label={ __( 'Intro', 'cb-hesis2026' ) }
				value={ intro }
				onChange={ ( value ) => setAttributes( { intro: value } ) }
			/>
			<RepeaterField
				label={ __( 'Milestones', 'cb-hesis2026' ) }
				value={ milestones }
				onChange={ ( value ) => setAttributes( { milestones: value } ) }
				fields={ milestonesFields }
				emptyRow={ milestonesEmptyRow }
				layout="column"
			/>
		</EditorBlockShell>
	);
}
