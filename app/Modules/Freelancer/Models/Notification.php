<?php

namespace App\Modules\Freelancer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    /**
     * @var string
     */
    protected $table = 'notifications';

    /**
     * @var null
     */
    protected static $_instance = null;

    /**
     * @return Notification|null
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))
            // create an object of same class..
            self::$_instance = new Notification();
        return self::$_instance;
    }

    /**
     * insertQuery
     * @param $insert
     * @return null
     * @throws \Exception.
     */
    public function insertQuery($insert)
    {
        if (func_num_args() > 0) { // check no. of arguments passed..
            try {
                $result = DB::table($this->table)
                    ->insertGetId($insert);

                return $result ? $result : null;
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } else {
            throw new \Exception("argument not passed.");
        }
    }

    /**
     * fetchNotification
     * @param $where
     * @param array $selectCols
     * @return array
     * @throws \Exception
     */
    public function fetchNotification($where, $selectCols = ['*'])
    {
        if (func_num_args() > 0) { // check no. of arguments passed..
            try {
                $result = DB::table($this->table)
                    ->join('users', 'users.id', '=', $this->table . '.notf_from')
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->orderBy('notf_status', 'desc')
                    ->orderBy('notf_id', 'desc')
                    ->select($selectCols)
                    ->get();

                return $result ? $result : [];
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } else {
            throw new \Exception("argument not passed.");
        }
    }

    /**
     * updateQuery
     * @param $where
     * @param $update
     * @return null
     * @throws \Exception
     */
    public function updateQuery($where, $update)
    {
        if (func_num_args() > 0) { // check no. of arguments passed..
            try {
                // DB query.
                $result = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->update($update);

                return $result ? $result : null;
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } else {
            throw new \Exception("argument not passed.");
        }
    }

}
