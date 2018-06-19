
# Lara Wallet

Lara wallet is a wallet system package that allow you fast develop wallet system in laravel framework.
## Features
 - Balance checking
 - Deposition
 - Withdrawal
 - Transfer
 - fee 
 - SanBox Mode

## 1. Installation

Install the package with composer:

```bash
composer require nattaponra/larawallet
```

## 2. Run Migrations

Publish the migrations and config file with this artisan command:

```bash
php artisan vendor:publish --provider="nattaponra\LaraWallet\LaraWalletServiceProvider"
```
Run migration file to create database tables:

```bash
php artisan migrate
```
## 3. Wallet using with user model.

 Add 'HasWallet' trait in User model (app/User.php):

```bash
class User extends Authenticatable
{

    use HasWallet;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
```
 
## 4. Using

Create example user 
```bash
$user = Auth::user();
```
Balance checking

```bash
echo $user->wallet->balance()
```
Deposition

```bash
$user->wallet->deposit(100);
```
Withdrawal
```bash
$user->wallet->withdraw(5000);
```
Transfer
```bash

 $user1 = User::find(1);
 $user2 = User::find(2);
 
 $user1->wallet->deposit(15000);
 $user1->wallet->transfer(1000,$user2);

 echo $user1->wallet->balance(); #14000
 echo $user2->wallet->balance(); #1000

```
SanBox Mode 
```bash
  $user->sanBoxWallet->balance();
```
