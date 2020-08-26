NETWORK = jestor-network
CONTAINER = jestor-web
CONTAINER_MYSQL = jestor-database
MYSQL_USER = root
MYSQL_PASS = jestor
MYSQL_DATABASE = jestor
DUMP_FILE = api/dump/dump.sql

help: ## Show this help
	@echo -e "usage: make [target]\n\ntarget:"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/: ##\s*/\t/' | expand -t 18 | pr -to2

setup: ## Setup inicial. Cria rede do docker, cria os containers, instala as dependencias do composer, builda o app e exibe os logs do php
setup: docker-create-network docker-build composer-install npm-build docker-logs

docker-create-network: ## Cria rede do docker
	docker network ls|grep $(NETWORK) > /dev/null || docker network create --driver bridge $(NETWORK)

docker-build: ## Cria os containers
	docker-compose -f docker/docker-compose.yml up --build -d

docker-up: ## Cria os containers
	docker-compose -f docker/docker-compose.yml up -d

composer-install: ## Instala as dependencias da api
	docker exec $(CONTAINER) composer install --working-dir=api


composer-update: ## Atualiza as dependencias da api
	docker exec $(CONTAINER) composer update --working-dir=api

docker-down: ## Termina os containers
	docker-compose -f docker/docker-compose.yml down

docker-sh: ## Acessa o container via sh
	docker exec -it $(CONTAINER) sh

docker-logs: ## Exibe os logs
	docker logs $(CONTAINER) -f

db-backup: ## Cria um dump do banco
	docker exec -i $(CONTAINER_MYSQL) /usr/bin/mysqldump -u $(MYSQL_USER) --password=$(MYSQL_PASS) $(MYSQL_DATABASE) > $(DUMP_FILE)

db-restore: ## Restaura um dump do banco
	cat $(DUMP_FILE) | docker exec -i $(CONTAINER_MYSQL) /usr/bin/mysql -u $(MYSQL_USER) --password=$(MYSQL_PASS) $(MYSQL_DATABASE)

npm-install: ## Instala as dependencias do app
	docker exec -it $(CONTAINER) npm --prefix ./app install

npm-update: ## Atualiza as dependencias do app
	docker exec -it $(CONTAINER) npm --prefix ./app update

npm-start: ## Instala as dependencias do app
	docker exec -it $(CONTAINER) npm --prefix ./app run start

npm-build: ## Instala as dependencias do app
	docker exec -it $(CONTAINER) npm --prefix ./app run build
