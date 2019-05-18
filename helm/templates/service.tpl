{{- define "service.template" -}}
apiVersion: v1
kind: Service
metadata:
  name: {{ .service.name | quote }}
spec:
  type: ClusterIP
  ports:
    - port: {{ .service.port }}
  selector:
    service: {{ .service.name | quote }}
{{- end -}}
