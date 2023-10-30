-- #!sqlite
-- #{ init
CREATE TABLE IF NOT EXISTS Players(
                                      Name TEXT PRIMARY KEY COLLATE NOCASE,
                                      Money INTEGER
);
-- #}
-- #{ insertPlayer
-- #  :name string
-- #  :initialMoney int
INSERT OR IGNORE INTO Players (Name, Money) VALUES (:name, :initialMoney);
-- #}
-- #{ getMoney
-- #  :name string
SELECT Money FROM Players WHERE Name = :name;
-- #}
-- #{ addMoney
-- #  :name string
-- #  :amount int
UPDATE Players SET Money = Money + :amount WHERE Name = :name;
-- #}
-- #{ removeMoney
-- #  :name string
-- #  :amount int
UPDATE Players SET Money = Money - :amount WHERE Name = :name;
-- #}
-- #{ setMoney
-- #  :name string
-- #  :amount int
UPDATE Players SET Money = :amount WHERE Name = :name;
-- #}
-- #{ getTopMoney
-- #  :limit int
SELECT Name, Money FROM Players ORDER BY Money DESC LIMIT :limit;
-- #}