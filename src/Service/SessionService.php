<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/28
 * Time: 23:26
 */
namespace Service;

class SessionService
{
    public function __construct()
    {
        ini_set('session.gc_maxlifetime',   config()->get("session_expire"));
        ini_set('session.cookie_lifetime',  config()->get("session_expire"));
    }

    public function stop()
    {
        session_unset();
        session_destroy();
    }

    public function start()
    {
        session_start();
    }

    public function setId($id)
    {
        session_id($id);
    }
}