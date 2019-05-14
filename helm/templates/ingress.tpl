{{- define "ingress.template" -}}
{{- $serviceName := .service.name | default .service.image -}}
apiVersion: extensions/v1beta1
kind: Ingress
metadata:
  name: {{ $serviceName | quote }}
spec:
  rules:
    - host: {{ .service.host | quote }}
      http:
        paths:
          - path: /
            backend:
              serviceName: {{ $serviceName | quote }}
              servicePort: {{ .service.port }}
{{- end -}}
