ARG VERSION

FROM mysql:${VERSION}

# Copy sql dump to initialize tables on stratup
COPY init /docker-entrypoint-initdb.d
