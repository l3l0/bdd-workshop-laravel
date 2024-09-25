FROM bdd-workshop-base AS bdd-workshop

ENV PATH=/usr/local/lib/node_modules/npm/bin:/usr/local/bin:$PATH

COPY --from=node:22.5.0-slim /usr/local /usr/local
COPY --from=node:22.5.0-slim /usr/local/lib/node_modules /usr/local/bin/node_modules

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
