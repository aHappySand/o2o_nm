<?php
namespace app\business\controller;

class Index extends AuthBase
{
    public function index()
    {
        return $this->fetch();
    }
}
