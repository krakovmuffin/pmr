docker exec -it --user postgres pmr-db psql -c 'DROP DATABASE project;'
docker exec -it --user postgres pmr-db psql -f /docker-entrypoint-initdb.d/init.sql

