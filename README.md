# BookStack 도커 컴포즈 배포 가이드 (프라이빗 GitHub 레포 워크플로우)

---

## 1) 개요  
이 가이드는 Linux 서버에 Docker Compose를 사용해 BookStack과 MariaDB를 배포하는 방법을 단계별로 설명합니다.  
- **구성**: BookStack (위키 애플리케이션) + MariaDB (데이터베이스) + Docker Compose (컨테이너 관리)  
- **목표**: 프라이빗 GitHub 저장소에서 코드를 관리하며 서버에서 자동으로 `git pull` 하여 최신 상태 유지  

---

## 2) 사전 준비물  
- **서버 IP/계정**: 배포할 Linux 서버 및 SSH 접속 계정  
- **포트**: BookStack 기본 80/443 포트 또는 원하는 포트  
- **DNS (선택사항)**: 도메인 연결 시 SSL 인증서 발급 용이  

---

---

## (추가) 서버 OS 및 방화벽 사전 확인

### 🔎 서버 OS 확인  
Docker 설치 방법이 OS마다 조금씩 다를 수 있으므로 먼저 OS를 확인합니다.

```bash
cat /etc/os-release
```

- `Ubuntu` / `Debian` → 아래 가이드 그대로 진행 가능  
- `CentOS` / `Rocky` / `RHEL` → Docker 설치 명령이 일부 다를 수 있음  

---

### 🌐 서버 IP 주소 확인  
다른 PC에서 위키에 접속하려면 서버의 IP 주소를 알아야 합니다.

```bash
# 가장 간단한 방법
hostname -I
```

또는

```bash
ip addr show
```

출력 예시:
```
192.168.0.42
```

👉 이 IP를 사용해 브라우저에서 접속:
```
http://서버IP:8080
예) http://192.168.0.42:8080
```

> 내부망에서만 사용할 경우 사설 IP(192.168.x.x, 10.x.x.x 등)를 사용하면 됩니다.

---

### 🔥 방화벽(포트) 확인  
BookStack에 접속하려면 사용하는 포트(예: 8080)가 열려 있어야 합니다.

#### UFW 사용 시
```bash
sudo ufw status
```

포트 열기 예시:
```bash
sudo ufw allow 8080/tcp
```

---

#### firewalld 사용 시 (RHEL 계열)
```bash
sudo firewall-cmd --list-all
sudo firewall-cmd --add-port=8080/tcp --permanent
sudo firewall-cmd --reload
```

---

👉 이 두 가지(OS/방화벽)만 먼저 확인하면 설치 중 막힐 일이 크게 줄어듭니다.

---

## 3) 서버에서 Docker & Docker Compose 설치 (Ubuntu/Debian 기준)  
```bash
# Docker 설치
sudo apt update
sudo apt install -y apt-transport-https ca-certificates curl software-properties-common
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io

# Docker Compose 설치
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# 설치 확인
docker --version
docker-compose --version
```
> **RHEL 계열 (CentOS, Fedora 등)**: `yum install -y docker docker-compose` 또는 공식 문서 참고  

---

## 4) GitHub Private Repo에서 서버가 `git pull` 할 수 있도록 SSH 키 등록  
1. 서버에서 SSH 키 생성 (비밀번호 없이)  
```bash
ssh-keygen -t ed25519 -C "server-bookstack-key" -f ~/.ssh/bookstack_deploy_key -N ""
```
2. 생성된 공개키(`~/.ssh/bookstack_deploy_key.pub`) 내용을 복사 후, GitHub 저장소 → Settings → Deploy keys → New deploy key에 붙여넣기  
3. 서버에서 SSH config 설정 (예시)  
```bash
echo -e "Host github.com\n  IdentityFile ~/.ssh/bookstack_deploy_key\n  IdentitiesOnly yes" >> ~/.ssh/config
chmod 600 ~/.ssh/config
```
4. 저장소 클론 또는 pull 테스트  
```bash
git clone git@github.com:your-org/your-private-repo.git /opt/henplab-wiki
cd /opt/henplab-wiki
git pull
```

---

## 5) 디렉토리 구조 예시  
```
/opt/henplab-wiki/
├── data/          # MariaDB 데이터 볼륨
├── compose/       # docker-compose.yml 및 .env 파일
└── 기타 소스 및 설정 파일
```

---

## 6) `.env` 파일 생성 예시 (`/opt/henplab-wiki/compose/.env`)  
```env
APP_URL=http://your.domain.or.ip
APP_KEY=base64:랜덤생성된앱키
DB_HOST=db
DB_DATABASE=bookstack
DB_USERNAME=bookstack
DB_PASSWORD=your_db_password
TZ=Asia/Seoul
PUID=1000
PGID=1000
```
- `APP_KEY`는 `php artisan key:generate --show` 로 생성하거나 아래 명령으로 생성 가능:  
```bash
docker run --rm bookstack/bookstack:release php artisan key:generate --show
```

---

## 7) `docker-compose.yml` 예시 (`/opt/henplab-wiki/compose/docker-compose.yml`)  
```yaml
version: "3.8"

services:
  app:
    image: solidnerd/bookstack:release
    container_name: bookstack_app
    env_file:
      - .env
    ports:
      - "8080:80"
    volumes:
      - ../data/uploads:/var/www/bookstack/public/uploads
      - ../data/storage:/var/www/bookstack/storage
    depends_on:
      - db
    restart: unless-stopped
    environment:
      - PUID=${PUID}
      - PGID=${PGID}
      - APP_URL=${APP_URL}
      - DB_HOST=${DB_HOST}
      - DB_DATABASE=${DB_DATABASE}
      - DB_USERNAME=${DB_USERNAME}
      - DB_PASSWORD=${DB_PASSWORD}
      - TZ=${TZ}

  db:
    image: mariadb:10.5
    container_name: bookstack_db
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: ${DB_DATABASE}
      MYSQL_USER: ${DB_USERNAME}
      MYSQL_PASSWORD: ${DB_PASSWORD}
      TZ: ${TZ}
    volumes:
      - ../data/db:/var/lib/mysql
    restart: unless-stopped
```

---

## 8) 실행 / 중지 / 로그 확인 명령  
```bash
cd /opt/henplab-wiki/compose

# 실행 (백그라운드)
docker-compose up -d

# 중지
docker-compose down

# 로그 확인 (실시간)
docker-compose logs -f

# 실행 중 컨테이너 상태 확인
docker-compose ps
```

---

## 9) 내부망 제한 (옵션) - UFW로 특정 사설대역만 허용 예시  
```bash
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow from 192.168.0.0/16 to any port 8080 proto tcp
sudo ufw enable
sudo ufw status
```
- 위 예시는 192.168.x.x 대역에서만 8080 포트 접근 허용  

---

## 10) 업데이트 방법  
```bash
cd /opt/henplab-wiki
git pull origin main

cd compose
docker-compose pull
docker-compose up -d
```
- 코드 변경시 `git pull` 후 `docker-compose up -d`로 컨테이너 재시작  
- 이미지 버전 변경 시 `docker-compose pull` 후 재시작 권장  

---

## 11) 백업 / 복구 기본  
- **DB 덤프**  
```bash
docker exec bookstack_db sh -c 'exec mysqldump -u${DB_USERNAME} -p"${DB_PASSWORD}" ${DB_DATABASE}' > /opt/henplab-wiki/backup/db_backup.sql
```
- **볼륨 백업**: `/opt/henplab-wiki/data/` 전체를 주기적으로 백업  
- **크론 예시 (매일 3시 백업)**  
```bash
0 3 * * * /usr/bin/docker exec bookstack_db sh -c 'exec mysqldump -ubookstack -p"your_db_password" bookstack' > /opt/henplab-wiki/backup/db_backup_$(date +\%F).sql
```

---

## 12) 문제 해결 체크리스트  
- **500 에러 발생 시**  
  - `.env` 파일의 `APP_KEY`가 올바른지 확인  
  - 컨테이너 로그 확인 (`docker-compose logs app`)  
- **DB 연결 오류**  
  - `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD` 환경변수 확인  
  - MariaDB 컨테이너 상태 확인 (`docker-compose ps`)  
- **APP_URL 및 리버스 프록시 설정**  
  - `.env`의 `APP_URL`이 정확한지 확인 (도메인 또는 IP)  
  - Nginx/Apache 리버스 프록시 설정 시 헤더 전달 확인  

---

이 가이드를 참고하여 안전하고 효율적으로 BookStack을 운영하세요!
