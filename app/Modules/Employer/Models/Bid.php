<?php

namespace App\Modules\Employer\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bid extends Model
{
    /**
     * @var string
     */
    protected $table = 'bid';

    /**
     * @var null
     */
    protected static $_instance = null;

    /**
     * @return Bid|null
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))
            // create an object of same class..
            self::$_instance = new Bid();
        return self::$_instance;
    }

    /**
     * fetchBid
     * @param $where
     * @param array $selectCols
     * @return array
     * @throws \Exception
     */
    public function fetchBid($where, $selectCols = ['*'])
    {
        if (func_num_args() > 0) { // check no. of arguments passed..
            try {
                // DB query.
                $result = DB::table($this->table)
                    ->join('jobs', 'jobs.job_id', '=', $this->table . '.bid_for_job')
                    ->join('users', 'users.id', '=', $this->table . '.bid_by')
//                    ->whereIn($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
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

    public function updateQuery($where, $update)
    {
        if (func_num_args() > 0) { // check no. of arguments passed
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
