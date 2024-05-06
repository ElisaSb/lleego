#!/bin/bash
# Docker containers
DOCKER_BE = lleego_php

# Env files
ENV_LOCAL = .env.local
DEFAULT_ENV = dev
DOCKER_ENV = docker/.env

# Alias
UID = 1000:1000
EXEC_PHP = php
DOCKER_EXEC = U_ID=${UID} docker exec -it -u ${UID}
DOCKER_SSH = ${DOCKER_EXEC} ${DOCKER_BE}
DOCKER_COMPOSE_SSH = docker-compose --env-file ${DOCKER_ENV} exec -T -u ${UID} lleego_php env TERM=xterm
DOCKER_ROOT_SSH = U_ID=${UID} docker exec -it -u root ${DOCKER_BE}

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

net-create:
	docker network inspect lleego-network >/dev/null || docker network create lleego-network
	@echo -e 'lleego-network active!'

install: ## Install project in Unix
	make env-install-unix
	make net-create
	make start
	make composer-install
	make compose-ssh
	@echo 'Installed successfully, now go to http://127.0.7.14 on your navigator!'

composer-install: ## Install composer dependencies
	$(DOCKER_ROOT_SSH) composer install --no-scripts --no-interaction --optimize-autoloader
	$(DOCKER_ROOT_SSH) composer config --global disable-tls true
	$(DOCKER_ROOT_SSH) composer config --global secure-http false

uninstall: ## Uninstall project
	make stop
	docker-compose --env-file ${DOCKER_ENV} rm
	@echo 'Uninstalled successfully!'

env-install-%:
	touch $(DOCKER_ENV)
	cat "docker/.$*.conf" > $(DOCKER_ENV)

start: ## Starts docker containers
	docker-compose --env-file ${DOCKER_ENV} up -d --remove-orphans

stop: ## Stops docker containers
	docker-compose --env-file ${DOCKER_ENV} down --remove-orphans

build:
	docker-compose --env-file ${DOCKER_ENV} build

ssh-be:
	$(DOCKER_SSH) bash

compose-ssh:
	$(DOCKER_COMPOSE_SSH)

mac-setup-ip-aliases: ## Setup local ip loopback aliases for MacOSX
	sudo ifconfig lo0 alias 127.0.7.14 up
	sudo ifconfig lo0 down && sudo ifconfig lo0 up
	@echo 'IP Aliases created!'