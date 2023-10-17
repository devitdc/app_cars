#---VARIABLES--------------------------------------------------------------------#
#---DOCTRINE---#
DOCTRINE = bin/console doctrine:
DOCTRINE_CREATE_DATABASE = $(DOCTRINE)database:create
DOCTRINE_DROP_DATABASE = $(DOCTRINE)database:drop --force --if-exists
DOCTRINE_DELETE_MIGRATION = /bin/rm -f ./migrations/*
DOCTRINE_CREATE_MIGRATION = $(DOCTRINE)migrations:diff --no-interaction
DOCTRINE_MIGRATE = $(DOCTRINE)migrations:migrate --no-interaction
DOCTRINE_LOAD_FIXTURES  =$(DOCTRINE)fixtures:load --no-interaction
#---DOCTRINE---#
#--------------------------------------------------------------------------------#

database-drop:
	$(DOCTRINE_DROP_DATABASE)
.PHONY: database-drop

database-create:
	$(DOCTRINE_CREATE_DATABASE)
.PHONY: database-create

doctrine-create-migration:
	$(DOCTRINE_DELETE_MIGRATION)
	$(DOCTRINE_CREATE_MIGRATION)
.PHONY: doctrine-create-migration

doctrine-migrate:
	$(DOCTRINE_MIGRATE)
.PHONY:doctrine-migrate

doctrine-fixtures:
	$(DOCTRINE_LOAD_FIXTURES)
.PHONY:doctrine-fixtures

start-dev:
	$(MAKE) database-drop
	$(MAKE) database-create
	$(MAKE) doctrine-create-migration
	$(MAKE) doctrine-migrate
	$(MAKE) doctrine-fixtures
.PHONY: start-dev

start-prod:
	$(MAKE) database-create
	$(MAKE) doctrine-create-migration
	$(MAKE) doctrine-migrate
.PHONY: start-prod
