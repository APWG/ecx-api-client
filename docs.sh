#!/usr/bin/env bash
rm -r docs
mkdir docs
php vendor/apigen/apigen/bin/apigen generate --source src --destination docs --template-theme bootstrap