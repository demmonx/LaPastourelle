#!/bin/bash
PGPASSWORD=$DB_PASSWD psql -U $DB_USER -h $DB_HOST -d $DB_NAME < /install/db.sql
