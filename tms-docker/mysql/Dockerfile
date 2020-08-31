FROM mysql:5.7

LABEL maintainer=lindynetech@gmail.com

COPY ./tms.sql /docker-entrypoint-initdb.d/

#COPY ./tms_demo.sql /tmp
#RUN mysqldump -u root -p tms_demo < /tmp/tms_demo.sql && rm -f /tmp/tms_demo.sql
