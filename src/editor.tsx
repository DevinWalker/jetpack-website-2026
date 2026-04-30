/**
 * Block editor entry point.
 * Registers all custom block edit UIs with Gutenberg.
 * Built to build/editor.tsx.js — only loaded in the block editor.
 */
import { registerBlockType } from '@wordpress/blocks';

import heroMeta              from '../blocks/hero/block.json';
import blurMeta              from '../blocks/blur-headline/block.json';
import bentoMeta             from '../blocks/features-bento/block.json';
import testimonialsMeta      from '../blocks/testimonials/block.json';
import pricingMeta           from '../blocks/pricing/block.json';
import pricingHeroMeta       from '../blocks/pricing-hero/block.json';
import pricingTableMeta      from '../blocks/pricing-table/block.json';
import pricingComparisonMeta from '../blocks/pricing-comparison/block.json';
import faqMeta               from '../blocks/faq/block.json';
import siteHeaderMeta        from '../blocks/site-header/block.json';
import footerCtaMeta         from '../blocks/footer-cta/block.json';
import fhMeta                from '../blocks/features-highlights/block.json';
import legacyHeroVisualMeta  from '../blocks/legacy-hero-visual/block.json';

import { HeroEdit }              from './blocks/hero/edit';
import { BlurHeadlineEdit }      from './blocks/blur-headline/edit';
import { FeaturesBentoEdit }     from './blocks/features-bento/edit';
import { TestimonialsEdit }      from './blocks/testimonials/edit';
import { PricingEdit }           from './blocks/pricing/edit';
import { PricingHeroEdit }       from './blocks/pricing-hero/edit';
import { PricingTableEdit }      from './blocks/pricing-table/edit';
import { PricingComparisonEdit } from './blocks/pricing-comparison/edit';
import { FAQEdit }               from './blocks/faq/edit';
import { SiteHeaderEdit }        from './blocks/site-header/edit';
import { FooterCtaEdit }         from './blocks/footer-cta/edit';
import { FeaturesHighlightsEdit }from './blocks/features-highlights/edit';
import { LegacyHeroVisualEdit }  from './blocks/legacy-hero-visual/edit';

registerBlockType( heroMeta.name,              { ...heroMeta,              edit: HeroEdit,              save: () => null } );
registerBlockType( blurMeta.name,              { ...blurMeta,              edit: BlurHeadlineEdit,      save: () => null } );
registerBlockType( bentoMeta.name,             { ...bentoMeta,             edit: FeaturesBentoEdit,     save: () => null } );
registerBlockType( testimonialsMeta.name,      { ...testimonialsMeta,      edit: TestimonialsEdit,      save: () => null } );
registerBlockType( pricingMeta.name,           { ...pricingMeta,           edit: PricingEdit,           save: () => null } );
registerBlockType( pricingHeroMeta.name,       { ...pricingHeroMeta,       edit: PricingHeroEdit,       save: () => null } );
registerBlockType( pricingTableMeta.name,      { ...pricingTableMeta,      edit: PricingTableEdit,      save: () => null } );
registerBlockType( pricingComparisonMeta.name, { ...pricingComparisonMeta, edit: PricingComparisonEdit, save: () => null } );
registerBlockType( faqMeta.name,               { ...faqMeta,               edit: FAQEdit,               save: () => null } );
registerBlockType( siteHeaderMeta.name,        { ...siteHeaderMeta,        edit: SiteHeaderEdit,        save: () => null } );
registerBlockType( footerCtaMeta.name,         { ...footerCtaMeta,         edit: FooterCtaEdit,         save: () => null } );
registerBlockType( fhMeta.name,                { ...fhMeta,                edit: FeaturesHighlightsEdit, save: () => null } );
registerBlockType( legacyHeroVisualMeta.name,  { ...legacyHeroVisualMeta,  edit: LegacyHeroVisualEdit,  save: () => null } );
