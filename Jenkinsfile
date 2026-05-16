pipeline {
    agent any

    stages {
        stage('Install Automation Tools') {
            steps {
                echo "=== Menyiapkan NodeJS dan Playwright di Server Jenkins ==="
                // Menginstal package yang dibutuhkan robot untuk berjalan di Jenkins
                sh '''
                    npm init -y
                    npm install playwright
                    npx playwright install-deps chromium
                '''
            }
        }

        stage('Execute Web Automation Deploy') {
            steps {
                echo "=== Menjalankan Robot untuk Menembus terminal.scholair.my.id ==="
                // Menjalankan script bot yang melewati alert pop-up secara otomatis
                sh 'node deploy.js'
            }
        }
    }

    post {
        always {
            echo "=== Pembersihan Workspace ==="
            cleanWs()
        }
    }
}