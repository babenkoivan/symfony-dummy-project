{{- define "service.template" -}}
apiVersion: v1
kind: Service
metadata:
  name: {{ .service.name | quote }}
spec:
  type: NodePort
  ports:
    - port: {{ .service.port }}
  selector:
    service: {{ .service.name | quote }}
{{- end -}}
