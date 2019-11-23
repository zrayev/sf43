bin/console do:da:cr

bin/console do:sc:up --force

bin/console do:fi:lo

lesson 8
API (after bin/console do:fi:lo)
curl -H "X-AUTH-TOKEN: {user/admin}" http://{host}/api/ - login
curl -H "X-AUTH-TOKEN: user" http://{host}/api/students - get all students;
curl -H "X-AUTH-TOKEN: admin" http://{host}.loc/api/courses - get all courses;
