<?php


class Users extends ListObjects
{
    private static $users;

    public function getList($quantity = 0)
    {
        return parent::getList($quantity);
    }
}