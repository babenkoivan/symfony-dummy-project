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
{{ toYaml .resources | trim | indent 12 }}
          {{- if (.service.env) }}
          env:
          {{- if (.service.env.plain) }}
            {{- range $envName, $envValue := .service.env.plain }}
            - name: {{ $envName | quote }}
              value: {{ $envValue }}
            {{- end }}
          {{- end }}
          {{- if (.service.env.secret) }}
            {{- range $envName, $secret := .service.env.secret }}
            - name: {{ $envName | quote }}
              valueFrom:
                secretKeyRef:
                  name: {{ $secret.name | quote }}
                  key: {{ $secret.key | quote }}
            {{- end }}
          {{- end }}
          {{- end }}
      imagePullSecrets:
        - name: {{ .registry.pullSecret | quote }}
{{- end -}}
