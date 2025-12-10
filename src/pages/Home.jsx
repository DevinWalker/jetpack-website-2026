import LaserFlowHero from '../components/LaserFlowHero'
import '../styles/Home.css'

function Home() {
  return (
    <div className="home bg-white">
      {/* Hero Section with LaserFlow */}
      <section className="w-full">
        <LaserFlowHero />
      </section>

      {/* Additional content sections can go here */}
    </div>
  )
}

export default Home
