<?php
/**
 * Created by PhpStorm.
 * User: Dibyaranjan
 * Date: 4/15/2018
 * Time: 1:15 PM
 */

namespace App\Modules\Employer\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tasks extends Model
{
    /**
     * @var string
     */
    protected $table = 'tasks';

    /**
     * @var null
     */
    protected static $_instance = null;

    /**
     * @return Tasks|null
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))
            // create an object of same class..
            self::$_instance = new Tasks();
        return self::$_instance;
    }

    /**
     * fetchJobs
     * @param $where
     * @param array $selectCols
     * @return array
     * @throws \Exception
     */
    public function fetchTasks($where, $selectCols = ['*'])
    {
        if (func_num_args() > 0) { // check no. of arguments passed..
            try {
                // DB query.
                $result = DB::table($this->table)
                    ->join('jobs','jobs.job_id','=',$this->table.'.for_job_id')
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->select($selectCols)
//                    ->toSql();
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
     * @param $where
     * @param array $selectedCols
     * @return array
     * @throws \Exception
     */
    public function fetchMyJobs($where, $selectedCols = ['*'])
    {
        if (func_num_args() > 0) {
            try {
                return DB::table($this->table)
                    ->join('jobs', 'jobs.job_id', '=', $this->table . '.for_job_id')
                    ->join('bid', 'bid.bid_for_job', '=', 'jobs.job_id')
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->select($selectedCols)
                    ->get() ?: [];
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } else {
            throw new \Exception('Argument not passed');
        }
    }

    /**
     * @param $where
     * @param $update
     * @return bool
     * @throws \Exception
     */
    public function updateTasks($where, $update)
    {
        if (func_num_args() > 0) {
            try {
                return DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->update($update) ?: false ;
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } else {
            throw new \Exception('Argument not passed');
        }
    }


}
