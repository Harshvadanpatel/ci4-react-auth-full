# Full Stack Developer Assignment – Auth & Teachers Management

This project was built as part of the **Full Stack Developer Internship Assignment**.  
It implements **JWT-based authentication** and demonstrates a **1–1 relationship** between `auth_user` and `teachers` tables using **CodeIgniter 4 (Backend)** and **React.js (Frontend)**.

---

## 📂 Project Structure
├── ci4-auth-teachers-api # Backend (CodeIgniter 4)
├── react-auth-teachers-ui # Frontend (React + Vite)
└── sql # Database schema & seeds



---

## ⚙️ Features
- **Register & Login** (Basic Auth with hashed passwords)
- **JWT Token Authentication** for all protected APIs
- **Single POST API** → Inserts into both `auth_user` & `teachers` tables within a transaction
- **Separate Datatables** in React UI for `auth_user` and `teachers`
- **Role-based UI** (restricted access for protected pages)
- **MySQL Schema** (easily switchable to PostgreSQL)

---

## 🗄️ Database Schema

### `auth_user`
| Column      | Type         | Description             |
|-------------|-------------|-------------------------|
| id (PK)     | INT          | Auto Increment ID       |
| email       | VARCHAR(255) | Unique Email            |
| first_name  | VARCHAR(100) | User’s first name       |
| last_name   | VARCHAR(100) | User’s last name        |
| password    | VARCHAR(255) | Hashed password (bcrypt)|
| created_at  | TIMESTAMP    | Auto generated          |

### `teachers`
| Column          | Type         | Description                     |
|-----------------|-------------|---------------------------------|
| id (PK)         | INT          | Auto Increment ID               |
| user_id (FK)    | INT          | References `auth_user.id`       |
| university_name | VARCHAR(255) | University name                 |
| gender          | ENUM         | Male/Female/Other               |
| year_joined     | INT          | Year joined                     |

---

## 🚀 Setup & Installation

### 🔧 Backend (CodeIgniter 4)
1. Go to backend folder:
   ```bash
   cd ci4-auth-teachers-api
   composer install
Copy .env.example → .env and update DB + JWT_SECRET.

Import database schema:

bash
Copy code
mysql -u root -p ci_auth < ../sql/schema.mysql.sql
Start server:


php spark serve
Runs at: http://localhost:8080

💻 Frontend (React + Vite)
Go to frontend folder:


cd react-auth-teachers-ui
npm install
Copy .env.example → .env


VITE_API_BASE=http://localhost:8080/api
Run frontend:


npm run dev
Runs at: http://localhost:5173

🔑 API Endpoints
Auth
POST /api/auth/register → Register a new user

POST /api/auth/login → Login, returns JWT

Teachers
POST /api/teacher → Add user + teacher (transaction) (JWT required)

GET /api/users → Get all users (JWT required)

GET /api/teachers → Get all teachers (JWT required)

GET /api/teachers/join → Get combined user + teacher data (JWT required)

🎨 Frontend Pages
Register Page → Create new account

Login Page → Login & get JWT

Users Page → Table of auth_user data

Teachers Page → Table of teachers data

📸 Screenshots
(Add screenshots of Register, Login, and DataTable pages here)

📌 Notes
Backend: CodeIgniter 4 + JWT

Frontend: React.js + Vite

Database: MySQL (switchable to PostgreSQL)

🧑‍💻 Author
Harshvadan Patel

Email: hvpatel457@gmail.com

GitHub: Harshvadanpatel

LinkedIn: Harshvadan Patel

\

---


