import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

export default function Navbar() {
  const { user, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

  return (
    <nav style={{display:'flex',alignItems:'center',gap:16,padding:12,borderBottom:'1px solid #eee'}}>
      <div className="container" style={{display:'flex',alignItems:'center',gap:16}}>
        <Link to="/">Home</Link>
        <Link to="/users">Users</Link>
        <Link to="/teachers">Teachers</Link>
        <div style={{marginLeft:'auto'}}>
          {user ? (
            <>
              <span style={{marginRight:8}}>Hi, {user.first_name}</span>
              <button onClick={handleLogout}>Logout</button>
            </>
          ) : (
            <>
              <Link to="/login" style={{marginRight:8}}>Login</Link>
              <Link to="/register">Register</Link>
            </>
          )}
        </div>
      </div>
    </nav>
  );
}
