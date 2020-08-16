<?php

class ListObjects
{
    private static $db;
    private static $table;
    private static $otherTable;
    private static $alias;
    private static $otherAlias;
    private static $mainField;
    private static $OtherMainField;
    private static $quantity;

    public function __construct()
    {
        self::$db = new SQLite3('forum.sqlite');
        self::$table = strtolower(get_class($this));
        self::$alias = self::$table[0];
        self::$otherTable = (self::$table !== 'users') ? 'users' : 'messages';
        self::$otherAlias = self::$otherTable[0];
        self::$mainField = (self::$table === 'users') ? 'name' : 'body';
        self::$OtherMainField = (self::$table !== 'users') ? 'name' : 'body';
    }

    function getList($quantity = 0){
        $query = "SELECT ".self::$alias.".id, ".self::$OtherMainField.", ".self::$mainField."  FROM ".self::$table." ".self::$alias." JOIN ".self::$otherTable." ".self::$otherAlias." on m.author_id = u.id ORDER BY ".self::$alias.".id ASC";

        if (!$quantity) {
            $stm = self::$db->prepare($query);
        } else {
            $query.= " LIMIT  ?";
            $stm = self::$db->prepare($query);
            $stm->bindValue(1, $quantity, SQLITE3_INTEGER);
        }

        $res = $stm->execute();
        $array = [];
        $index = 0;
        while ($row = $res->fetchArray(SQLITE3_NUM)) {
            foreach ($row as $column) {
                $array[$index][] = $column;
            }
            $index++;
        }
//        var_dump($array);
        return $array;
    }
}