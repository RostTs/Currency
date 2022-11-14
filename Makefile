## Start environment
start: 
	docker-compose up -d
	symfony server:start

## Stop environment
stop: 
	docker-compose stop
	symfony server:stop

## Restart environment
restart: 
	make stop
	make start