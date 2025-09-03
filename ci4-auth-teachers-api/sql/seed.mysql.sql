USE ci4_auth_teachers;

INSERT INTO auth_user (email, first_name, last_name, password)
VALUES ('demo@demo.com','Demo','User','$2y$10$e0NRs3jvGQ2h2Jq9s8bGyOaX4u6cWlI9kZ6sEoYxQ1aP0Yb3JcF2W'); -- Demo@123

INSERT INTO teachers (user_id, university_name, gender, year_joined, specialization)
VALUES (1, 'Open University', 'other', 2019, 'Computer Science');
