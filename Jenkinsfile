pipeline {
    agent any

    stages {
        stage('Docker Build and Compile') {
            steps {
                sh 'docker compose up --build --abort-on-container-exit'
            }
        }

        stage('Extract Package to File Server Host') {
            steps {
                echo 'Mengeluarkan file release.zip dari Docker ke folder Host...'
                sh 'mkdir -p /var/www/agro-monitor-app'
                sh 'docker cp agro-builder-container:/tmp/release.zip /var/www/agro-monitor-app/release.zip'
            }
        }
    }

    post {
        always {
            echo 'Pembersihan runner container...'
            sh 'docker compose down -v --remove-orphans'
        }
    }
}