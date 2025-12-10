import LaserFlowHero from '../components/LaserFlowHero'
import '../styles/Home.css'

function Home() {
  return (
    <div className="home bg-white">
      {/* Hero Section with LaserFlow */}
      <section className="hero-section">
        <div className="laser-flow-container">
          <LaserFlowHero />
        </div>
        
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
      </section>

      {/* Additional content sections can go here */}
    </div>
  )
}

export default Home
