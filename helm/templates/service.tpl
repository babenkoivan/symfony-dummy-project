{{- define "service.template" -}}
{{- $serviceName := .service.name | default .service.image -}}
apiVersion: v1
kind: Service
metadata:
  name: {{ $serviceName | quote }}
spec:
  type: ClusterIP
  ports:
    - port: {{ .service.port }}
  selector:
    service: {{ $serviceName | quote }}
{{- end -}}
