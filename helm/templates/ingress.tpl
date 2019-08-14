{{- define "ingress.template" -}}
apiVersion: extensions/v1beta1
kind: Ingress
metadata:
  name: {{ .service.name | quote }}
spec:
  backend:
    serviceName: {{ .service.name | quote }}
    servicePort: {{ .service.port }}
{{- end -}}
