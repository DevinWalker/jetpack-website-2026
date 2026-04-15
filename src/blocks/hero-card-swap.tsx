import React from 'react';
import { createRoot } from 'react-dom/client';
import CardSwap, { Card } from '@/components/react-bits/CardSwap';

const mount = document.getElementById( 'jetpack-card-swap-mount' );
const THEME_URI = ( mount as HTMLElement | null )?.dataset.themeUri ?? '';

function HeroCards() {
	return (
		<CardSwap
			width={ 500 }
			height={ 400 }
			cardDistance={ 60 }
			verticalDistance={ 65 }
			delay={ 5000 }
			pauseOnHover={ false }
			skewAmount={ 0 }
			easing="elastic"
			containerClassName="absolute bottom-[-4rem] left-1/2 -translate-x-1/2 perspective-[900px] overflow-visible origin-bottom max-[768px]:scale-[0.75] max-[480px]:scale-[0.55]"
		>
			<Card className="bg-neutral-900 border-neutral-700 overflow-hidden p-0">
				<img
					src={ `${ THEME_URI }/assets/jetpack-paid-traffic.png` }
					alt="Jetpack paid traffic dashboard"
					className="w-full h-full object-cover object-top"
					loading="eager"
					decoding="async"
				/>
			</Card>

			<Card className="bg-neutral-900 border-neutral-700 overflow-hidden flex flex-col justify-between p-7">
				<div>
					<div className="inline-flex items-center gap-2 bg-emerald-500/15 text-emerald-400 text-xs font-semibold px-2.5 py-1 rounded-full mb-5">
						<svg className="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
						Security & Backups
					</div>
					<h3 className="text-white text-2xl font-bold leading-snug mb-3">
						Protected around<br/>the clock.
					</h3>
					<p className="text-neutral-400 text-sm leading-relaxed">
						Real-time malware scanning, automated backups, and one-click restores keep your site safe — without lifting a finger.
					</p>
				</div>
				<div className="flex items-center gap-4 mt-6">
					<div className="flex-1 bg-neutral-800 rounded-xl p-3.5">
						<p className="text-neutral-500 text-xs mb-1">Threats blocked</p>
						<p className="text-white text-2xl font-bold">4,219</p>
					</div>
					<div className="flex-1 bg-neutral-800 rounded-xl p-3.5">
						<p className="text-neutral-500 text-xs mb-1">Uptime</p>
						<p className="text-emerald-400 text-2xl font-bold">99.9%</p>
					</div>
				</div>
			</Card>

			<Card className="bg-neutral-900 border-neutral-700 overflow-hidden flex flex-col justify-between p-7">
				<div>
					<div className="inline-flex items-center gap-2 bg-violet-500/15 text-violet-400 text-xs font-semibold px-2.5 py-1 rounded-full mb-5">
						<svg className="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" aria-hidden="true"><path d="M4 12v8a2 2 0 002 2h12a2 2 0 002-2v-8M16 6l-4-4-4 4M12 2v13"/></svg>
						Social & SEO
					</div>
					<h3 className="text-white text-2xl font-bold leading-snug mb-3">
						Reach more<br/>readers, fast.
					</h3>
					<p className="text-neutral-400 text-sm leading-relaxed">
						Auto-share to every social network, boost posts to millions of WordPress.com readers, and climb search rankings with built-in SEO tools.
					</p>
				</div>
				<div className="flex items-center gap-4 mt-6">
					<div className="flex-1 bg-neutral-800 rounded-xl p-3.5">
						<p className="text-neutral-500 text-xs mb-1">Shares this month</p>
						<p className="text-white text-2xl font-bold">1,840</p>
					</div>
					<div className="flex-1 bg-neutral-800 rounded-xl p-3.5">
						<p className="text-neutral-500 text-xs mb-1">SEO score</p>
						<p className="text-violet-400 text-2xl font-bold">A+</p>
					</div>
				</div>
			</Card>
		</CardSwap>
	);
}

if ( mount ) {
	createRoot( mount ).render( <HeroCards /> );
}
