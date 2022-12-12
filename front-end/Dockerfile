FROM node:alpine
WORKDIR /app
# install and cache app dependencies
COPY package.json /app/package.json
RUN npm install

# add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# add app
COPY . /app

EXPOSE 4200
# start app
CMD ng serve --host 0.0.0.0 --disable-host-check