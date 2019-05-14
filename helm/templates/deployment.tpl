{{- define "deployment.template" -}}
{{- $serviceName := .service.name | default .service.image -}}
apiVersion: apps/v1beta2
kind: Deployment
metadata:
  name: {{ $serviceName | quote }}
spec:
  replicas: {{ .service.replicas | default 1 }}
  selector:
    matchLabels:
      service: {{ $serviceName | quote }}
  template:
    metadata:
      labels:
        service: {{ $serviceName | quote }}
    spec:
      containers:
        - name: {{ $serviceName | quote }}
          image: {{ printf "%s/%s:%s" .registry.url .service.image .registry.imageTag | quote }}
          imagePullPolicy: {{ .service.pullPolicy | default "IfNotPresent" | quote }}
          resources:
{{ toYaml .resources | indent 12 }}
      imagePullSecrets:
        - name: {{ .registry.pullSecret | quote }}
{{- end -}}
