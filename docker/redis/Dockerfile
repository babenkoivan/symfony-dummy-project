ARG VERSION

FROM redis:${VERSION}-alpine

# Copy redis config
COPY redis.conf /usr/local/etc/redis/redis.conf

# Run with custom config
CMD ["redis-server", "/usr/local/etc/redis/redis.conf"]
