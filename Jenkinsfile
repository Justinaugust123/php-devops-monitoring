pipeline {

    agent any

    environment {
        IMAGE_NAME = "docker.io/justinaugust123/php-devops-monitoring"
        IMAGE_TAG = "${BUILD_NUMBER}"
    }

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build PHP Docker Image') {
            steps {
                sh '''
                    docker build \
                    -t ${IMAGE_NAME}:${IMAGE_TAG} \
                    -t ${IMAGE_NAME}:latest \
                    .
                '''
            }
        }

        stage('Test Container') {
            steps {
                sh '''
                    docker run -d \
                    --name php-m \
                    -p 8082:80 \
                    ${IMAGE_NAME}:${IMAGE_TAG}

                    sleep 5

                    docker rm -f php-m
                '''
            }
        }

        stage('Push Docker Image') {
            steps {
                withCredentials([
                    usernamePassword(
                        credentialsId: 'dockerhub-credentials',
                        usernameVariable: 'DOCKER_USER',
                        passwordVariable: 'DOCKER_PASSWORD'
                    )
                ]) {

                    sh '''
                        echo "$DOCKER_PASSWORD" | docker login \
                        -u "$DOCKER_USER" \
                        --password-stdin

                        docker push ${IMAGE_NAME}:${IMAGE_TAG}
                        docker push ${IMAGE_NAME}:latest
                    '''
                }
            }
        }
    }

    post {
        always {
            sh '''
                docker image prune -f || true
            '''
        }

        success {
            echo 'PHP DevOps pipeline completed successfully.'
        }

        failure {
            echo 'PHP DevOps pipeline failed.'
        }
    }
}
