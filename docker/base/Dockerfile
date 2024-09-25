FROM l3l0/php:8.2.4-apache-buster AS bdd-workshop-base

ENV PATH=/usr/local/lib/node_modules/npm/bin:/usr/local/bin:$PATH

COPY --from=node:22.5.0-slim /usr/local /usr/local
COPY --from=node:22.5.0-slim /usr/local/lib/node_modules /usr/local/bin/node_modules

WORKDIR /home/www
