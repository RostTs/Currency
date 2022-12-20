FROM node:alpine
RUN apk add --no-cache \
    bash \
    bash-completion

RUN npm install -g npm@8.19.2
RUN npm install -g @angular/cli@15.0.3

ENV SHELL=/bin/bash

USER node

WORKDIR /application

EXPOSE 4200

CMD [ "bash" ]
