import { useRef } from 'react'
import LaserFlow from '../components/LaserFlow'
import jetpackStats from '../assets/jetpack-stats.jpg'
import '../styles/Home.css'

function Home() {
  const revealImgRef = useRef(null)

  const handleMouseMove = (e) => {
    const rect = e.currentTarget.getBoundingClientRect()
    const x = e.clientX - rect.left
    const y = e.clientY - rect.top
    const el = revealImgRef.current
    if (el) {
      el.style.setProperty('--mx', `${x}px`)
      el.style.setProperty('--my', `${y + rect.height * 0.5}px`)
    }
  }

  const handleMouseLeave = () => {
    const el = revealImgRef.current
    if (el) {
      el.style.setProperty('--mx', '-9999px')
      el.style.setProperty('--my', '-9999px')
    }
  }

  return (
    <div className="home">
      {/* Hero Section */}
      <section className="hero-section">
        <div className="hero-content">
          <div className="hero-text">
            <h1 className="hero-title">
              Power up your WordPress site
            </h1>
            <p className="hero-subtitle">
              Jetpack provides security, performance, and growth tools for WordPress sites. 
              Everything you need, all in one place.
            </p>
            <div className="hero-actions">
              <button className="btn btn-primary">Get Started</button>
              <button className="btn btn-secondary">Learn More</button>
            </div>
          </div>
        </div>

        {/* LaserFlow Interactive Box */}
        <div 
          className="laser-flow-box"
          onMouseMove={handleMouseMove}
          onMouseLeave={handleMouseLeave}
        >
          <div className="laser-flow-container">
            <LaserFlow
              horizontalBeamOffset={0.1}
              verticalBeamOffset={0.0}
              color="#2C7BE5"
            />
          </div>

          <img
            ref={revealImgRef}
            src={jetpackStats}
            alt="Jetpack Stats Dashboard"
            className="reveal-image"
          />
        </div>
      </section>

      {/* Additional content sections can go here */}
    </div>
  )
}

export default Home
