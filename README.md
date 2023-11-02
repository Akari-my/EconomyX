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
`/pay <playerName> <amount>` | Pay a Player | economyx.pay
`/seemoney <playerName>` | Look at another Player's money | economyx.seemoney
`/setmoney <playerName> <amount>` | Set money to a player | economyx.setmonoey
`/topmoney` | Check Top Money | economyx.topmoney

## Config.yml
<details>
  <summary>Click to open</summary>

```yaml
---
#  ______                                     __   __
# |  ____|                                    \ \ / /
# | |__   ___ ___  _ __   ___  _ __ ___  _   _ \ V /
# |  __| / __/ _ \| '_ \ / _ \| '_ ` _ \| | | | > <
# | |___| (_| (_) | | | | (_) | | | | | | |_| |/ . \
# |______\___\___/|_| |_|\___/|_| |_| |_|\__, /_/ \_\
#                                       __/  |
#                                      |_____/
#
# by Akari_my -> support @akari_my on DISCORD

# Please only change things inside the ""

# {player} = Player Name
# {money} = Money

database:
  type: "sqlite"
  sqlite:
    file: "sqlite.sql"

messages:
  is_not_player: "§cThis command can only be used in game"
  player_not_found: "§cPlayer not found"
  not_permission: "§cYou do not have permission to use this command"
  not_enough_money: "§cYou don't have enough money to pay"
  my_money: "§7You have §e{money} §7money"
  set_money: "§7You set §e{money} §7to §e{player}"
  payer_money: "§7You have paid §e{money} §7money to §e{player}"
  payed_money: "§7You have received §e{money} §7money from §e{player}"
  see_money: "§e{player} §7has §e{money} §7money"
  top_money: "§7------ §4TOP MONEY §7------"
...
```
</details>

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

## Bugs??
Write to me on Discord if you have any bugs or problems with EconomyX

## Please leave a ⭐ to help the Project!
