# MultiQueueWorker
Can use diffrent queueing engines.  
All configuration is in `config/adapters.php`.  
## Installation
Be sure that you have Docker installed.
```bash
# Initialize containers
docker-compose up
  
# Enter container bash
docker exec -it app bash
  
# Execute job worker
php artisan coolworker
  
# Serve the app
php artisan serve
```
## Usage
To add job in queue you need to make POST request with some data:  
`http://localhost/api/queue/log data`  
  
After that, data will be logged in console.
