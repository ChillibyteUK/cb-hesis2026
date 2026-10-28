import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { TextControl, RadioControl } from '@wordpress/components';
import RepeaterField from '../../_shared/RepeaterField';
import EditorBlockShell from '../../_shared/EditorBlockShell';

const postsFields = [
	{ name: 'author', label: __( 'Author', 'cb-hesis2026' ), type: 'text' },
	{ name: 'meta', label: __( 'Meta', 'cb-hesis2026' ), type: 'text' },
	{ name: 'text', label: __( 'Text', 'cb-hesis2026' ), type: 'textarea' },
	{ name: 'postUrl', label: __( 'Post URL', 'cb-hesis2026' ), type: 'text' },
];

const postsEmptyRow = { author: '', meta: '', text: '', postUrl: '' };

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { kicker, source, limit, profileUrl, posts } = attributes;
	const blockProps = useBlockProps( { className: 'container cb-hesis2026-editor-block' } );

	return (
		<EditorBlockShell blockProps={ blockProps } clientId={ clientId } classPrefix="cb-hesis2026" textDomain="cb-hesis2026" title="CB LinkedIn">
			<div style={ { display: 'flex', flexWrap: 'wrap', gap: '12px' } }>
				<div style={ { flex: '50 1 0%' } }>
			<TextControl
				label={ __( 'Kicker', 'cb-hesis2026' ) }
				value={ kicker }
				onChange={ ( value ) => setAttributes( { kicker: value } ) }
			/>
				</div>
				<div style={ { flex: '50 1 0%' } }>
			<RadioControl
				label={ __( 'Source', 'cb-hesis2026' ) }
				selected={ source }
				options={ [
					{ label: 'Live feed', value: 'Live feed' },
					{ label: 'Manual rows', value: 'Manual rows' },
				] }
				onChange={ ( value ) => setAttributes( { source: value } ) }
				help={ __( 'Live feed needs the CBP LinkedIn Feed plugin connected (Settings > LinkedIn Feed); it falls back to the manual rows while nothing is cached.', 'cb-hesis2026' ) }
			/>
				</div>
			</div>
			<div style={ { display: 'flex', flexWrap: 'wrap', gap: '12px' } }>
				<div style={ { flex: '50 1 0%' } }>
			{ source === 'Live feed' && (
			<TextControl
				type="number"
				label={ __( 'Limit', 'cb-hesis2026' ) }
				value={ limit }
				onChange={ ( value ) => setAttributes( { limit: Number( value ) } ) }
				help={ __( 'How many live posts to show. 0 for three.', 'cb-hesis2026' ) }
			/>
			) }
				</div>
				<div style={ { flex: '50 1 0%' } }>
			<TextControl
				label={ __( 'Profile URL', 'cb-hesis2026' ) }
				value={ profileUrl }
				onChange={ ( value ) => setAttributes( { profileUrl: value } ) }
				help={ __( 'The HESIS LinkedIn company page.', 'cb-hesis2026' ) }
			/>
				</div>
			</div>
			{ source === 'Manual rows' && (
			<RepeaterField
				label={ __( 'Posts', 'cb-hesis2026' ) }
				value={ posts }
				onChange={ ( value ) => setAttributes( { posts: value } ) }
				fields={ postsFields }
				emptyRow={ postsEmptyRow }
				layout="column"
			/>
			) }
		</EditorBlockShell>
	);
}
