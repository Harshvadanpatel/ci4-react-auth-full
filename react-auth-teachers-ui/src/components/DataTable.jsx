export default function DataTable({ columns, data }) {
  return (
    <div className="card">
      <table cellPadding={8} style={{borderCollapse:'collapse'}}>
        <thead>
          <tr>
            {columns.map((c) => (
              <th key={c.key} style={{textAlign:'left',borderBottom:'1px solid #ddd'}}>{c.label}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {data.map((row, i) => (
            <tr key={i} style={{borderBottom:'1px solid #f0f0f0'}}>
              {columns.map((c) => (
                <td key={c.key}>{String(row[c.key] ?? '')}</td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
