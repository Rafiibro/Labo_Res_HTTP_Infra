FROM node:12.4

RUN apt-get update && apt-get install nano

COPY src /opt/app

CMD ["node", "/opt/app/index.js"]
