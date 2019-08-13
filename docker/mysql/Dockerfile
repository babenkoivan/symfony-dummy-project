ARG VERSION

FROM mysql:${VERSION} as prod

# Copy sql dump to initialize tables on stratup
COPY init /docker-entrypoint-initdb.d
