<?php

namespace EconomyX\database;

use pocketmine\player\Player;
use SQLite3;

class EconomyDB {

    private $db;

    public function __construct(string $filename) {
        $this->db = new SQLite3($filename . "ecox.db");
        $this->db->exec("CREATE TABLE IF NOT EXISTS Players (Name TEXT PRIMARY KEY, Money INT DEFAULT 0);");
    }

    public function getMoney(Player $player): int {
        $name = SQLite3::escapeString($player->getName());
        $result = $this->db->query("SELECT Money FROM Players WHERE Name = '$name';");

        if ($result) {
            $data = $result->fetchArray(SQLITE3_ASSOC);
            return $data['Money'] ?? 0;
        }
        return 0;
    }

    public function addMoney(Player $player, int $amount): void {
        $name = SQLite3::escapeString($player->getName());
        $this->db->exec("INSERT OR IGNORE INTO Players (Name, Money) VALUES ('$name', 0);");
        $this->db->exec("UPDATE Players SET Money = Money + $amount WHERE Name = '$name';");
    }

    public function removeMoney(Player $player, int $amount): void {
        $name = SQLite3::escapeString($player->getName());
        $this->db->exec("UPDATE Players SET Money = Money - $amount WHERE Name = '$name';");
    }

    public function setMoney(Player $player, int $amount): void {
        $name = SQLite3::escapeString($player->getName());
        $this->db->exec("INSERT OR IGNORE INTO Players (Name, Money) VALUES ('$name', 0);");
        $this->db->exec("UPDATE Players SET Money = $amount WHERE Name = '$name';");
    }

    public function payMoney(Player $payer, Player $receiver, int $amount): bool {
        $payerName = SQLite3::escapeString($payer->getName());
        $receiverName = SQLite3::escapeString($receiver->getName());

        $payerMoney = $this->getMoney($payer);
        if ($payerMoney < $amount) {
            return false;
        }

        $this->db->exec("BEGIN TRANSACTION;");
        $this->db->exec("UPDATE Players SET Money = Money - $amount WHERE Name = '$payerName';");
        $this->db->exec("INSERT OR IGNORE INTO Players (Name, Money) VALUES ('$receiverName', 0);");
        $this->db->exec("UPDATE Players SET Money = Money + $amount WHERE Name = '$receiverName';");
        $this->db->exec("COMMIT;");

        return true;
    }

    public function getTopMoney(): array {
        $result = $this->db->query("SELECT Name, Money FROM Players ORDER BY Money DESC LIMIT 10;");

        $topMoney = [];
        if ($result) {
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $topMoney[$row['Name']] = $row['Money'];
            }
        }
        return $topMoney;
    }

    public function registerPlayer(Player $player, int $initialMoney = 1000): void {
        $name = SQLite3::escapeString($player->getName());

        $result = $this->db->query("SELECT Name FROM Players WHERE Name = '$name';");
        $data = $result->fetchArray(SQLITE3_ASSOC);

        if($data === false) {
            $this->db->exec("INSERT INTO Players (Name, Money) VALUES ('$name', $initialMoney);");
        }
    }
}