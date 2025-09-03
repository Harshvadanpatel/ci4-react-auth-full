import { useEffect, useState } from 'react';
import api from '../api/axios';
import DataTable from '../components/DataTable';

export default function TeachersTable(){
  const [rows, setRows] = useState([]);
  useEffect(() => {
    api.get('/teachers/join').then(({data}) => setRows(data)).catch(()=>setRows([]));
  }, []);

  const columns = [
    {key:'teacher_id', label:'Teacher ID'},
    {key:'user_id', label:'User ID'},
    {key:'email', label:'Email'},
    {key:'first_name', label:'First Name'},
    {key:'last_name', label:'Last Name'},
    {key:'university_name', label:'University'},
    {key:'gender', label:'Gender'},
    {key:'year_joined', label:'Year Joined'},
    {key:'specialization', label:'Specialization'}
  ];

  return <div className="card"><DataTable columns={columns} data={rows} /></div>
}
