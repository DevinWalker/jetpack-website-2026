import LaserFlow from './LaserFlow';
import { useRef } from 'react';

function LaserFlowHero() {
    const revealImgRef = useRef(null);

    return (
        <div
            className="w-full h-[800px] relative overflow-hidden bg-white"
            onMouseMove={(e) => {
                const rect = e.currentTarget.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const el = revealImgRef.current;
                if (el) {
                    el.style.setProperty('--mx', `${x}px`);
                    el.style.setProperty('--my', `${y + rect.height * 0.5}px`);
                }
            }}
            onMouseLeave={() => {
                const el = revealImgRef.current;
                if (el) {
                    el.style.setProperty('--mx', '-9999px');
                    el.style.setProperty('--my', '-9999px');
                }
            }}
        >
            <div className="absolute inset-0 w-full h-full z-10">
                <LaserFlow
                    horizontalBeamOffset={0.1}
                    verticalBeamOffset={0.0}
                    color="#FF79C6"
                />
            </div>

            <div 
                className="absolute top-1/2 left-1/2 -translate-x-1/2 w-[86%] h-[60%] bg-[#060010] rounded-[20px] border-2 border-[#FF79C6] flex items-center justify-center text-white text-[2rem] z-[6]"
            >
                Hello World
            </div>

            <img
                ref={revealImgRef}
                src="/src/assets/jetpack-stats.jpg"
                alt="Reveal effect"
                className="absolute w-full -top-1/2 z-[5] mix-blend-multiply opacity-60 pointer-events-none"
                style={{
                    '--mx': '-9999px',
                    '--my': '-9999px',
                    WebkitMaskImage: 'radial-gradient(circle at var(--mx) var(--my), rgba(255,255,255,1) 0px, rgba(255,255,255,0.95) 60px, rgba(255,255,255,0.6) 120px, rgba(255,255,255,0.25) 180px, rgba(255,255,255,0) 240px)',
                    maskImage: 'radial-gradient(circle at var(--mx) var(--my), rgba(255,255,255,1) 0px, rgba(255,255,255,0.95) 60px, rgba(255,255,255,0.6) 120px, rgba(255,255,255,0.25) 180px, rgba(255,255,255,0) 240px)',
                    WebkitMaskRepeat: 'no-repeat',
                    maskRepeat: 'no-repeat'
                }}
            />
        </div>
    );
}

export default LaserFlowHero;