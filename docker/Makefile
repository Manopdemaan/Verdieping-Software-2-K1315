# Simple Makefile to streamline development commands
# Usage examples:
#   make rebuild
#   make up
#   make down
#   make shell

DC        = docker-compose
SERVICE   = webserver

rebuild:
	$(DC) build --no-cache $(SERVICE)

up:
	$(DC) up -d

down:
	$(DC) down

shell:
	$(DC) exec $(SERVICE) /bin/sh
