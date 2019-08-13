ARG VERSION

FROM mysql:${VERSION} as dev

# Copy sql dump to initialize tables on stratup
COPY init /docker-entrypoint-initdb.d
