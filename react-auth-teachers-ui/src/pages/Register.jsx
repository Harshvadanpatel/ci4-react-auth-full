import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

export default function Register() {
  const { register } = useAuth();
  const nav = useNavigate();
  const [form, setForm] = useState({
    email: '', first_name:'', last_name:'', password:'',
    university_name:'', gender:'male', year_joined:new Date().getFullYear(), specialization:''
  });
  const [error, setError] = useState('');

  const set = (k,v)=> setForm(prev=>({...prev,[k]:v}));
  const submit = async (e) => {
    e.preventDefault();
    setError('');
    try {
      await register(form);
      nav('/teachers');
    } catch (err) {
      setError('Registration failed');
    }
  };

  return (
    <form onSubmit={submit} className="card" style={{maxWidth:600,margin:'40px auto',display:'grid',gap:12}}>
      <h2>Register</h2>
      {error && <div style={{color:'crimson'}}>{error}</div>}
      <input placeholder="Email" value={form.email} onChange={e=>set('email', e.target.value)} />
      <div style={{display:'flex',gap:8}}>
        <input placeholder="First Name" value={form.first_name} onChange={e=>set('first_name', e.target.value)} />
        <input placeholder="Last Name" value={form.last_name} onChange={e=>set('last_name', e.target.value)} />
      </div>
      <input type="password" placeholder="Password" value={form.password} onChange={e=>set('password', e.target.value)} />

      <h3>Teacher Profile</h3>
      <input placeholder="University" value={form.university_name} onChange={e=>set('university_name', e.target.value)} />
      <select value={form.gender} onChange={e=>set('gender', e.target.value)}>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
      </select>
      <input type="number" placeholder="Year Joined" value={form.year_joined} onChange={e=>set('year_joined', Number(e.target.value))} />
      <input placeholder="Specialization" value={form.specialization} onChange={e=>set('specialization', e.target.value)} />

      <button type="submit">Create Account</button>
    </form>
  );
}
