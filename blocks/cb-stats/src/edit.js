import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import RepeaterField from '../../_shared/RepeaterField';
import EditorBlockShell from '../../_shared/EditorBlockShell';

const statsFields = [
	{ name: 'value', label: __( 'Value', 'cb-hesis2026' ), type: 'text' },
	{ name: 'label', label: __( 'Label', 'cb-hesis2026' ), type: 'text' },
];

const statsEmptyRow = { value: '', label: '' };

export default function Edit( { attributes, setAttributes, clientId } ) {
	const { stats } = attributes;
	const blockProps = useBlockProps( { className: 'container cb-hesis2026-editor-block' } );

	return (
		<EditorBlockShell blockProps={ blockProps } clientId={ clientId } classPrefix="cb-hesis2026" textDomain="cb-hesis2026" title="CB Stats">
			<RepeaterField
				label={ __( 'Stats', 'cb-hesis2026' ) }
				value={ stats }
				onChange={ ( value ) => setAttributes( { stats: value } ) }
				fields={ statsFields }
				emptyRow={ statsEmptyRow }
			/>
		</EditorBlockShell>
	);
}
