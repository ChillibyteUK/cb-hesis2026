import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { TextControl, TextareaControl } from '@wordpress/components';
import RepeaterField from '../../_shared/RepeaterField';
import EditorBlockShell from '../../_shared/EditorBlockShell';

const cardsFields = [
	{ name: 'title', label: __( 'Title', 'cb-hesis2026' ), type: 'text' },
	{ name: 'text', label: __( 'Text', 'cb-hesis2026' ), type: 'textarea' },
	{ name: 'link', label: __( 'Link', 'cb-hesis2026' ), type: 'link' },
];

const cardsEmptyRow = { title: '', text: '', link: '', linkText: '' };

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { kicker, heading, intro, cards } = attributes;
	const blockProps = useBlockProps( { className: 'container cb-hesis2026-editor-block' } );

	return (
		<EditorBlockShell blockProps={ blockProps } clientId={ clientId } classPrefix="cb-hesis2026" textDomain="cb-hesis2026" title="CB Link Cards">
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
				label={ __( 'Cards', 'cb-hesis2026' ) }
				value={ cards }
				onChange={ ( value ) => setAttributes( { cards: value } ) }
				fields={ cardsFields }
				emptyRow={ cardsEmptyRow }
				layout="column"
			/>
		</EditorBlockShell>
	);
}
