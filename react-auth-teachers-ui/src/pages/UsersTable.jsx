import { useEffect, useState } from 'react';
import api from '../api/axios';
import DataTable from '../components/DataTable';

export default function UsersTable(){
  const [rows, setRows] = useState([]);
  useEffect(() => {
    api.get('/users').then(({data}) => setRows(data)).catch(()=>setRows([]));
  }, []);

  const columns = [
    {key:'id', label:'ID'},
    {key:'email', label:'Email'},
    {key:'first_name', label:'First Name'},
    {key:'last_name', label:'Last Name'},
    {key:'is_active', label:'Active'},
    {key:'created_at', label:'Created'}
  ];

  return <div className="card"><DataTable columns={columns} data={rows} /></div>
}
