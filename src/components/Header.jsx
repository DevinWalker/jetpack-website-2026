import { Link } from 'react-router-dom'
import jetpackLogo from '../assets/jetpack-logo-white.svg'
import '../styles/Header.css'

function Header() {
  return (
    <header className="header">
      <div className="container">
        <div className="header-content">
          <Link to="/" className="logo-link">
            <img src={jetpackLogo} alt="Jetpack" className="logo" />
          </Link>
        </div>
      </div>
    </header>
  )
}

export default Header

