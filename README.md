# :waxing_gibbous_moon: EconomyX Plugin for PocketMine-MP
EconomyX is a feature-rich PocketMine plugin that introduces a robust in-game currency system

## Features :pencil2:
- EconomyX introduces a versatile in-game easy currency system with Database SQLite3
- Users can easily check their coin balance, make transactions, and manage their in-game wealth with simple, intuitive commands.
- EconomyX provides a user-friendly API for effortless integration with other plugins, allowing them to leverage the currency system's capabilities smoothly and efficiently.

## Installation :pencil:
1. Download the latest plugin [Releases](https://github.com/Akari-my/EconomyX/releases)
2. Place the downloaded `EconomyX.phar` file `plugins` folder.
3. Restart your server

## Commands :spades:
Command | Description | Permission
--- | --- | ---
`/mymoney` |Check Your Money | economyx.mymoney
`/pay <playerName> <amount>` | Pay a Player | economyx.mymoney
`/seemoney <playerName>` | Look at another Player's money | economyx.seemoney
`/setmoney <playerName> <amount>` | Set money to a player | economyx.setmonoey
`/topmoney` | Check Top Money | economyx.topmoney

## API 💡
The bees are so simple that it will be fun to make plugins with EconomyX

## Log in to the api with
```php
EconomyAPI::Instance();
```

## Here is an example of how you can use the EconomyX API
```php
public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "api") {
            // It adds 500 of money to you
            EconomyAPI::getInstance()->addMoney($sender, 500);
            return true;
        }
        return false;
    }
}
```

## Get the amount of money for a player
```php
EconomyAPI::Instance()->getMoney($player);
```
## Add money to a player
```php
EconomyAPI::Instance()->addMoney($player, $amount);
```
## Set the amount of money for a player
```php
EconomyAPI::Instance()->setMoney($player, $amount);
```
## Remove money from a player
```php
EconomyAPI::Instance()->removeMoney($player, $amount);
```

## Please leave a ⭐ to help the Project!
