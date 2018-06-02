<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 22:51
 */

namespace Model;

use Exception\BaseException;

class OrderModel extends BaseModel
{
    const ORDER_TABLE = "db_order";


    public static function addOrder($data)
    {
        $user = database()->insert(self::ORDER_TABLE,$data);

        if(!$user){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function updateOrder($data = [],$where = [])
    {
        $db = database();

        $result = $db->update(self::ORDER_TABLE,$data,
            $where
        );

        return $result;
    }

    public static function getOrderById($order_id)
    {
        $where = [
            "order_id" => $order_id,
        ];

        return database()->get(self::ORDER_TABLE,"*",$where);
    }

    public static function listOrder($where = [])
    {
        $db = database();

        $result = $db->select(
            self::ORDER_TABLE."(o)",
            [
                "[>]db_user(u)" => ["o.user_id" => "id"],
                "[>]db_user_class(uc)" => ["o.order_id" => "order_id"],
                "[>]db_class(c)" => ["uc.class_id" => "id"],
                "[>]db_channel(cc)" =>["o.channel_id"=>"id"]
            ],
            [
                "o.order_id",
                "u.id(user_id)",
                "u.nickname",
                "c.id(class_id)",
                "c.title",
                "cc.channel_name",
                "o.pay_time"
            ],
            $where
        );

        return $result;
    }

    public static function getOrderId()
    {
        return microtime(true)*10000;
    }

    public static function countOrder($where = [])
    {
        return database()->count(self::ORDER_TABLE."(o)",[],$where);
    }

    public static function incomeStaticSum()
    {
        return database()->sum(self::ORDER_TABLE,"settlement_total_fee",["status[>]"=>0]);
    }

    public static function dailyIncome($start_time,$end_time)
    {
        if($start_time>$end_time)
        {
            return [];
        }

        $sql = <<<SQL
SELECT 
  FROM_UNIXTIME(pay_time,'%Y-%m') as pay_date,
  sum(settlement_total_fee) as income
FROM db_order 
WHERE 
  `status`>0 
AND
  pay_time>=$start_time
AND
  pay_time<$end_time
GROUP BY pay_date
SQL;
        return database()->query($sql)->fetchAll();

    }

}