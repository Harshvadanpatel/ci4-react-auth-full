import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

export default function Login() {
  const { login } = useAuth();
  const nav = useNavigate();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');

  const submit = async (e) => {
    e.preventDefault();
    setError('');
    try {
      await login(email, password);
      nav('/teachers');
    } catch (err) {
      setError('Invalid credentials');
    }
  };

  return (
    <form onSubmit={submit} className="card" style={{maxWidth:420,margin:'40px auto',display:'grid',gap:12}}>
      <h2>Login</h2>
      {error && <div style={{color:'crimson'}}>{error}</div>}
      <input placeholder="Email" value={email} onChange={e=>setEmail(e.target.value)} />
      <input type="password" placeholder="Password" value={password} onChange={e=>setPassword(e.target.value)} />
      <button type="submit">Login</button>
    </form>
  );
}
