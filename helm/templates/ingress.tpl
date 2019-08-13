{{- define "ingress.template" -}}
apiVersion: extensions/v1beta1
kind: Ingress
metadata:
  name: {{ .service.name | quote }}
  annotations:
    kubernetes.io/ingress.global-static-ip-name: {{ .service.ip | quote }}
spec:
  rules:
    - host: {{ .service.host | quote }}
      http:
        paths:
          - path: /
            backend:
              serviceName: {{ .service.name | quote }}
              servicePort: {{ .service.port }}
{{- end -}}
