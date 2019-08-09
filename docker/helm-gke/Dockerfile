FROM google/cloud-sdk:alpine

# Install system dependencies
RUN apk add --update --no-cache openssl

# Install kubectl
RUN gcloud components install --quiet kubectl

# Install helm
ARG HELM_VERSION
RUN curl https://raw.githubusercontent.com/helm/helm/master/scripts/get > ~/get_helm.sh && \
    chmod +x ~/get_helm.sh && \
    if [ -z $HELM_VERSION ]; then ~/get_helm.sh; else ~/get_helm.sh -v $HELM_VERSION; fi && \
    rm ~/get_helm.sh
