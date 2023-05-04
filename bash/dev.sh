#!/bin/bash

DOCKERHOST=$(ifconfig | grep -A 1 docker0 | awk 'NR > 1 {print $2}')
export DOCKERHOST
cd container &&
  docker compose up --build --remove-orphans --detach &&
  docker compose exec --user=app php bash
