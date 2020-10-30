<?php

class A
{
    public function s()
    {

    }
}

class E extends A
{
    public function s()
    {
        parent::s();
    }
}
