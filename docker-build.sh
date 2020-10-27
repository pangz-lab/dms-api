echo 'Run as $ ./build-docker.sh 0.0.1'
docker build -f AppDockerFile -t dms-pool/api:$1 .
