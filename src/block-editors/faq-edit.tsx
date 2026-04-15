import { InspectorControls, RichText, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button, Tooltip } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

interface FAQItem { question: string; answer: string }
interface Attrs {
	sectionTitle: string; sectionDescription: string;
	ctaPrimaryText: string; ctaPrimaryUrl: string;
	ctaSecondaryText: string; ctaSecondaryUrl: string;
	items: FAQItem[];
}
interface Props { attributes: Attrs; setAttributes: ( a: Partial< Attrs > ) => void }

export function FAQEdit( { attributes, setAttributes }: Props ) {
	const { items, sectionTitle, sectionDescription } = attributes;

	const updateItem = ( i: number, patch: Partial< FAQItem > ) => {
		setAttributes( { items: items.map( ( item, idx ) => idx === i ? { ...item, ...patch } : item ) } );
	};

	const removeItem = ( i: number ) => {
		setAttributes( { items: items.filter( ( _, idx ) => idx !== i ) } );
	};

	const addItem = () => {
		setAttributes( { items: [ ...items, { question: '', answer: '' } ] } );
	};

	const moveItem = ( from: number, to: number ) => {
		if ( to < 0 || to >= items.length ) return;
		const next = [ ...items ];
		const [ moved ] = next.splice( from, 1 );
		next.splice( to, 0, moved );
		setAttributes( { items: next } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'CTA Buttons', 'jetpack-theme' ) } initialOpen>
					<TextControl label={ __( 'Primary text', 'jetpack-theme' ) } value={ attributes.ctaPrimaryText }   onChange={ ( v ) => setAttributes( { ctaPrimaryText: v } ) } />
				<TextControl label={ __( 'Primary URL', 'jetpack-theme' ) }  value={ attributes.ctaPrimaryUrl ?? '' }    help={ `Default: ${ window.jetpackThemeData?.homeUrl ?? '' }/pricing/` } onChange={ ( v ) => setAttributes( { ctaPrimaryUrl: v } ) } __nextHasNoMarginBottom />
				<TextControl label={ __( 'Secondary text', 'jetpack-theme' ) } value={ attributes.ctaSecondaryText } onChange={ ( v ) => setAttributes( { ctaSecondaryText: v } ) } />
				<TextControl label={ __( 'Secondary URL', 'jetpack-theme' ) }  value={ attributes.ctaSecondaryUrl ?? '' }  help={ `Default: ${ window.jetpackThemeData?.homeUrl ?? '' }/support/` } onChange={ ( v ) => setAttributes( { ctaSecondaryUrl: v } ) } __nextHasNoMarginBottom />
				</PanelBody>
			</InspectorControls>

			<div { ...useBlockProps( { className: 'jetpack-faq-editor' } ) }>
				<div className="jetpack-faq-editor__header">
					<span className="jetpack-faq-editor__eyebrow">
						{ __( 'Frequently Asked Questions', 'jetpack-theme' ) }
					</span>
					<RichText
						tagName="h2"
						className="jetpack-faq-editor__title"
						value={ sectionTitle }
						onChange={ ( v: string ) => setAttributes( { sectionTitle: v } ) }
						placeholder={ __( 'Section title…', 'jetpack-theme' ) }
						allowedFormats={ [ 'core/bold', 'core/italic' ] }
					/>
					<RichText
						tagName="p"
						className="jetpack-faq-editor__description"
						value={ sectionDescription }
						onChange={ ( v: string ) => setAttributes( { sectionDescription: v } ) }
						placeholder={ __( 'Section description…', 'jetpack-theme' ) }
						allowedFormats={ [ 'core/bold', 'core/italic', 'core/link' ] }
					/>
					<div className="jetpack-faq-editor__ctas">
						<span className="jetpack-faq-editor__cta-primary">
							{ attributes.ctaPrimaryText }
						</span>
						<span className="jetpack-faq-editor__cta-secondary">
							{ attributes.ctaSecondaryText }
						</span>
					</div>
				</div>

				<div className="jetpack-faq-editor__items">
					{ items.map( ( item, i ) => (
						<div key={ i } className="jetpack-faq-editor__item">
							<div className="jetpack-faq-editor__item-header">
								<RichText
									tagName="span"
									className="jetpack-faq-editor__question"
									value={ item.question }
									onChange={ ( v: string ) => updateItem( i, { question: v } ) }
									placeholder={ __( 'Question…', 'jetpack-theme' ) }
									allowedFormats={ [ 'core/bold', 'core/italic' ] }
								/>
								<div className="jetpack-faq-editor__item-actions">
									<Tooltip text={ __( 'Move up', 'jetpack-theme' ) }>
										<Button
											icon="arrow-up-alt2"
											size="small"
											disabled={ i === 0 }
											onClick={ () => moveItem( i, i - 1 ) }
											label={ __( 'Move up', 'jetpack-theme' ) }
										/>
									</Tooltip>
									<Tooltip text={ __( 'Move down', 'jetpack-theme' ) }>
										<Button
											icon="arrow-down-alt2"
											size="small"
											disabled={ i === items.length - 1 }
											onClick={ () => moveItem( i, i + 1 ) }
											label={ __( 'Move down', 'jetpack-theme' ) }
										/>
									</Tooltip>
									<Tooltip text={ __( 'Remove', 'jetpack-theme' ) }>
										<Button
											icon="no-alt"
											size="small"
											isDestructive
											onClick={ () => removeItem( i ) }
											label={ __( 'Remove question', 'jetpack-theme' ) }
										/>
									</Tooltip>
								</div>
							</div>
							<RichText
								tagName="p"
								className="jetpack-faq-editor__answer"
								value={ item.answer }
								onChange={ ( v: string ) => updateItem( i, { answer: v } ) }
								placeholder={ __( 'Answer…', 'jetpack-theme' ) }
								allowedFormats={ [ 'core/bold', 'core/italic', 'core/link' ] }
							/>
						</div>
					) ) }
				</div>

				<Button
					variant="secondary"
					className="jetpack-faq-editor__add-btn"
					onClick={ addItem }
					icon="plus-alt2"
				>
					{ __( 'Add Question', 'jetpack-theme' ) }
				</Button>
			</div>
		</>
	);
}
