# Лабораторна робота

## Установка

Відкрити головну папку в терміналі і запустити

```bash
docker-compose up -d
```
## PostgreSQL
Для взаємодії з PostgreSQL можна використовувати команду для входу в контейнер:

```bash
docker exec -it postgres_db psql -U admin -d mydb
```
Для імпорту дампу в базу
```bash
docker cp /path/to/your/database_dump.sql postgres_db:/tmp/database_dump.sql
```
