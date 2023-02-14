CREATE VIEW emp_dep AS
SELECT employees.name AS emp_name, departments.name AS dep_name, COUNT(employees.department_id) AS dep_count
FROM employees
INNER JOIN departments ON emp.dep_id = departments.id
GROUP BY employees.department_id;