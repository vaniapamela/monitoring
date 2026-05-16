pipeline {
    agent any

    stages {
        stage('Checkout Code') {
            steps {
                checkout scm
            }
        }

        stage('Build & Deploy via Docker Container') {
            steps {
                echo "=== Memulai Build & Run di dalam Docker Container ==="
                # Menjalankan docker compose. Container akan otomatis build PHP, Node, 
                # lalu mengeksekusi 'node deploy.js' di akhir prosesnya.
                sh "docker compose up --build --abort-on-container-exit"
            }
        }
    }

    post {
        always {
            echo "=== Pembersihan Environment Jenkins ==="
            sh "docker compose down --v --remove-orphans"
            cleanWs()
        }
    }
}