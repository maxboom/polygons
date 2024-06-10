## Installation
- **Clone the repository:**
```bash
git clone git@github.com:maxboom/polygons.git .
```
- **Build docker**
```bash
docker-compose up -d
```
- **Install laravel & run migrations**
```bash
make install
```

## Starting background jobs
- **Adding a job worker**
```bash
make queue
```

## Features
- **Refresh the polygons:**
```bash
curl --location --request PUT 'http://localhost:8058/data?delaySeconds=1&action=refresh' \
--header 'Accept:  application/json' \
--header 'Content-Type: application/json'
```
- **Search region by location:**
```bash
curl --location 'http://localhost:8058/data?action=search&lat=50.44899&lon=30.52257' \
--header 'Accept:  application/json' \
--header 'Content-Type: application/json'
```
- **Purges the data:**
```bash
curl --location --request DELETE 'http://localhost:8058/data?action=purge' \
--header 'Accept:  application/json' \
--header 'Content-Type: application/json'
```
- **List all jobs:**
```bash
curl --location 'http://localhost:8058/jobs?limit=2&action=list' \
--header 'Accept:  application/json' \
--header 'Content-Type: application/json'
```
