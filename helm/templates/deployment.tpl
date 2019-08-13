{{- define "deployment.template" -}}
apiVersion: apps/v1beta2
kind: Deployment
metadata:
  name: {{ .service.name | quote }}
spec:
  replicas: {{ .service.replicas | default 1 }}
  selector:
    matchLabels:
      service: {{ .service.name | quote }}
  template:
    metadata:
      labels:
        service: {{ .service.name | quote }}
    spec:
      containers:
        - name: {{ .service.name | quote }}
          image: {{ printf "%s:%s" .service.image .imageTag | quote }}
          imagePullPolicy: {{ .service.pullPolicy | default "IfNotPresent" | quote }}
          resources:
{{ toYaml .resources | trim | indent 12 }}
          {{- if (.service.probes) }}
{{ toYaml .service.probes | trim | indent 10 }}
          {{- end }}
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
{{- end -}}
