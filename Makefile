## Start environment
start: 
	docker-compose up -d

## Stop environment
stop: 
	docker-compose stop

## Restart environment
restart: 
	make stop
	make start