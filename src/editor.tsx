/**
 * Block editor entry point.
 * Registers all custom block edit UIs with Gutenberg.
 * Built to build/editor.tsx.js — only loaded in the block editor.
 */
import { registerBlockType } from '@wordpress/blocks';

import heroMeta           from '../blocks/hero/block.json';
import blurMeta           from '../blocks/blur-headline/block.json';
import bentoMeta          from '../blocks/features-bento/block.json';
import testimonialsMeta   from '../blocks/testimonials/block.json';
import pricingMeta        from '../blocks/pricing/block.json';
import faqMeta            from '../blocks/faq/block.json';
import siteHeaderMeta     from '../blocks/site-header/block.json';
import siteFooterMeta     from '../blocks/site-footer/block.json';
import fhMeta             from '../blocks/features-highlights/block.json';

import { HeroEdit }           from './block-editors/hero-edit';
import { BlurHeadlineEdit }   from './block-editors/blur-headline-edit';
import { FeaturesBentoEdit }  from './block-editors/features-bento-edit';
import { TestimonialsEdit }   from './block-editors/testimonials-edit';
import { PricingEdit }        from './block-editors/pricing-edit';
import { FAQEdit }            from './block-editors/faq-edit';
import { SiteHeaderEdit }     from './block-editors/site-header-edit';
import { SiteFooterEdit }     from './block-editors/site-footer-edit';
import { FeaturesHighlightsEdit } from './block-editors/features-highlights-edit';

registerBlockType( heroMeta.name,           { ...heroMeta,           edit: HeroEdit,          save: () => null } );
registerBlockType( blurMeta.name,           { ...blurMeta,           edit: BlurHeadlineEdit,  save: () => null } );
registerBlockType( bentoMeta.name,          { ...bentoMeta,          edit: FeaturesBentoEdit, save: () => null } );
registerBlockType( testimonialsMeta.name,   { ...testimonialsMeta,   edit: TestimonialsEdit,  save: () => null } );
registerBlockType( pricingMeta.name,        { ...pricingMeta,        edit: PricingEdit,       save: () => null } );
registerBlockType( faqMeta.name,            { ...faqMeta,            edit: FAQEdit,           save: () => null } );
registerBlockType( siteHeaderMeta.name,     { ...siteHeaderMeta,     edit: SiteHeaderEdit,    save: () => null } );
registerBlockType( siteFooterMeta.name,     { ...siteFooterMeta,     edit: SiteFooterEdit,    save: () => null } );
registerBlockType( fhMeta.name,             { ...fhMeta,             edit: FeaturesHighlightsEdit, save: () => null } );
