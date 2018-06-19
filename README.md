
# Lara Wallet

Larawallet is a wallet system package that allow you fast develop wallet system in your project.

## Installation

Install the package with composer:

```bash
composer require nattaponra/larawallet
```

## Run Migrations

Publish the migrations and config file with this artisan command:

```bash
php artisan vendor:publish --provider="nattaponra\LaraWallet\LaraWalletServiceProvider"
```
Run migration file to create database tables:

```bash
php artisan migrate
```
 
