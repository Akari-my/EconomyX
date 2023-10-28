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

    public function getMoney(Player $player) : int {
        $name = SQLite3::escapeString($player->getName());
        $stmt = $this->db->prepare("SELECT Money FROM Players WHERE Name = :name;");
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $result = $stmt->execute();

        if($result) {
            $data = $result->fetchArray(SQLITE3_ASSOC);
            return $data['Money'] ?? 0;
        }
        return 0;
    }

    public function addMoney(Player $player, int $amount) : void {
        $name = SQLite3::escapeString($player->getName());
        $stmt = $this->db->prepare("INSERT OR IGNORE INTO Players (Name, Money) VALUES (:name, 0);");
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->execute();

        $stmt = $this->db->prepare("UPDATE Players SET Money = Money + :amount WHERE Name = :name;");
        $stmt->bindValue(':amount', $amount, SQLITE3_INTEGER);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->execute();
    }

    public function removeMoney(Player $player, int $amount) : void {
        $name = SQLite3::escapeString($player->getName());
        $stmt = $this->db->prepare("UPDATE Players SET Money = Money - :amount WHERE Name = :name;");
        $stmt->bindValue(':amount', $amount, SQLITE3_INTEGER);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->execute();
    }

    public function setMoney(Player $player, int $amount) : void {
        $name = SQLite3::escapeString($player->getName());
        $stmt = $this->db->prepare("INSERT OR IGNORE INTO Players (Name, Money) VALUES (:name, 0);");
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->execute();

        $stmt = $this->db->prepare("UPDATE Players SET Money = :amount WHERE Name = :name;");
        $stmt->bindValue(':amount', $amount, SQLITE3_INTEGER);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->execute();
    }

    public function payMoney(Player $payer, Player $receiver, int $amount) : bool {
        $payerName = SQLite3::escapeString($payer->getName());
        $receiverName = SQLite3::escapeString($receiver->getName());

        $payerMoney = $this->getMoney($payer);
        if($payerMoney < $amount) {
            return false;
        }

        $this->db->exec("BEGIN TRANSACTION;");
        $stmt = $this->db->prepare("UPDATE Players SET Money = Money - :amount WHERE Name = :payerName;");
        $stmt->bindValue(':amount', $amount, SQLITE3_INTEGER);
        $stmt->bindValue(':payerName', $payerName, SQLITE3_TEXT);
        $stmt->execute();

        $stmt = $this->db->prepare("INSERT OR IGNORE INTO Players (Name, Money) VALUES (:receiverName, 0);");
        $stmt->bindValue(':receiverName', $receiverName, SQLITE3_TEXT);
        $stmt->execute();

        $stmt = $this->db->prepare("UPDATE Players SET Money = Money + :amount WHERE Name = :receiverName;");
        $stmt->bindValue(':amount', $amount, SQLITE3_INTEGER);
        $stmt->bindValue(':receiverName', $receiverName, SQLITE3_TEXT);
        $stmt->execute();

        $this->db->exec("COMMIT;");

        return true;
    }

    public function getTopMoney() : array {
        $stmt = $this->db->prepare("SELECT Name, Money FROM Players ORDER BY Money DESC LIMIT 10;");
        $result = $stmt->execute();

        $topMoney = [];
        if($result) {
            while($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $topMoney[$row['Name']] = $row['Money'];
            }
        }
        return $topMoney;
    }

    public function registerPlayer(Player $player, int $initialMoney = 1000) : void {
        $name = SQLite3::escapeString($player->getName());

        $stmt = $this->db->prepare("SELECT Name FROM Players WHERE Name = :name;");
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $data = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

        if($data === false) {
            $stmt = $this->db->prepare("INSERT INTO Players (Name, Money) VALUES (:name, :initialMoney);");
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $stmt->bindValue(':initialMoney', $initialMoney, SQLITE3_INTEGER);
            $stmt->execute();
        }
    }
}