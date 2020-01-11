## Run locally 
run "docker-compose up"

###Restore backup

```
cat backup.sql | docker exec -i CONTAINER /usr/bin/mysql -u test --password=test BiblioMania
```
