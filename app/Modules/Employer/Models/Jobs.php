<?php

namespace App\Modules\Employer\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Jobs extends Model
{
    /**
     * @var string
     */
    protected $table = 'jobs';

    /**
     * @var null
     */
    protected static $_instance = null;

    /**
     * @return Jobs|null
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))
            // create an object of same class..
            self::$_instance = new Jobs();
        return self::$_instance;
    }

    /**
     * fetchJobs
     * @param $where
     * @param array $selectCols
     * @return array
     * @throws \Exception
     */
    public function fetchJobs($where, $selectCols = ['*'])
    {
        if (func_num_args() > 0) { // check no. of arguments passed
            try {
                // DB query.
                $result = DB::table($this->table)
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

    public function insertQuery($addJob)
    {
        if (func_num_args() > 0) { // check no. of arguments passed
            try {
                // DB query.
                $result = DB::table($this->table)
                    ->insertGetId($addJob);

                return $result ? $result : null;
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