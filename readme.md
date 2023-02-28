# Assignment example

## Prerequisites

- [nodejs](https://nodejs.org/) with [npm](https://www.npmjs.com/)
- [Docker](https://www.docker.com/)
- [MySQL Workbench](https://www.mysql.com/products/workbench/)

## Development

- (optional) edit `./sql/database_source.mwb` and export the new model to `./sql/init-db.sql`
- run `npm install` to install frontend dependencies
- run `docker compose up -d` to start the PHP server
- chmod 777 for `./temp` and `./log`
- run `npm start` or `npm start:admin` to start the ViteJS server
- open http://localhost/ to see the resulting website (any file changes reloads the browser for fast local development)
- open http://localhost:8080/ for database administration
- if you need to run a composer command, run `docker run -it --rm -v $(pwd):/app composer <command>`

## Production

run `npm run build` if you want to create production build of the front module. For the admin module
use `npm run build:admin` command.
