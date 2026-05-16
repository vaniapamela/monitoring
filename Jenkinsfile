pipeline {
    agent any

    environment {
        // Informasi Bastion / Jump Server
        BASTION_USER = 'sija'
        BASTION_HOST = 'terminal.scholair.my.id'

        // Informasi Server Target (Di dalam Proxmox)
        TARGET_USER  = 'root'
        TARGET_IP    = '192.168.200.23'
        
        // Konfigurasi Aplikasi
        IMAGE_NAME   = 'agro-monitor-app-image:latest'
        TARGET_DIR   = '/var/www/agro-monitor-app'
    }

    stages {
        stage('Build Docker Image') {
            steps {
                echo "=== Memulai Build Docker Image di Jenkins ==="
                // Memaksimalkan fungsi Dockerfile Anda di sisi Jenkins
                sh "docker build -t ${IMAGE_NAME} ."
                
                echo "=== Menyimpan Image ke format .tar ==="
                sh "docker save ${IMAGE_NAME} -o agro-app.tar"
            }
        }

        stage('Prepare Target & Install Docker') {
            steps {
                // Memanggil kedua kredensial sekaligus menggunakan sshagent resmi Jenkins
                sshagent(credentials: ['bastion-credentials', 'server-target-credentials']) {
                    echo "=== Memeriksa & Menginstal Docker di Server Target via Bastion ==="
                    
                    // Kita gunakan trik ProxyJump (-J) lewat perintah ssh biasa (sh)
                    sh """
                        ssh -o StrictHostKeyChecking=no -J ${BASTION_USER}@${BASTION_HOST} ${TARGET_USER}@${TARGET_IP} '
                            mkdir -p ${TARGET_DIR}
                            
                            if ! command -v docker &> /dev/null; then
                                echo "Docker belum ada di server Proxmox target. Menginstal otomatis..."
                                apt-get update -y
                                apt-get install -y apt-transport-https ca-certificates curl software-properties-common
                                curl -fsSL https://download.docker.com/linux/ubuntu/gpg | apt-key add -
                                add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu \$(lsb_release -cs) stable"
                                apt-get update -y
                                apt-get install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin
                                systemctl start docker
                                systemctl enable docker
                                echo "Docker & Docker Compose berhasil diinstal!"
                            fi
                        '
                    """
                }
            }
        }

        stage('Transfer Deployment Files') {
            steps {
                sshagent(credentials: ['bastion-credentials', 'server-target-credentials']) {
                    echo "=== Mengirim Berkas (.tar, compose, .env) Menembus Bastion ==="
                    // Menggunakan scp dengan flag -J untuk melompati jump server
                    sh """
                        scp -o StrictHostKeyChecking=no -J ${BASTION_USER}@${BASTION_HOST} \
                        agro-app.tar docker-compose.yml .env.production \
                        ${TARGET_USER}@${TARGET_IP}:${TARGET_DIR}/
                    """
                }
            }
        }

        stage('Deploy to Target Server') {
            steps {
                sshagent(credentials: ['bastion-credentials', 'server-target-credentials']) {
                    echo "=== Mengeksekusi Container di Server Target ==="
                    sh """
                        ssh -o StrictHostKeyChecking=no -J ${BASTION_USER}@${BASTION_HOST} ${TARGET_USER}@${TARGET_IP} '
                            cd ${TARGET_DIR}
                            
                            echo "Loading Docker Image dari file tar..."
                            docker load -i agro-app.tar
                            rm -f agro-app.tar
                            
                            echo "Menjalankan aplikasi dengan Docker Compose..."
                            docker compose down --remove-orphans || true
                            docker compose up -d
                        '
                    """
                }
            }
        }
    }

    post {
        always {
            echo "=== Pembersihan Workspace Lokal Jenkins ==="
            // Menghapus file tar dan file env rahasia agar tidak tertinggal di mesin Jenkins
            sh "rm -f agro-app.tar .env.production"
            cleanWs()
        }
    }
}