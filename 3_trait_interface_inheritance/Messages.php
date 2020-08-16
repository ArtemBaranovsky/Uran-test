<?php

class Messages extends ListObjects implements FieldInterface
{
    private static $messages;

    public function getList($quantity = 0)
    {
        return parent::getList($quantity);
    }

}