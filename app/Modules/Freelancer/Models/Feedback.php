<?php

namespace App\Modules\Freelancer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Feedback extends Model
{
    /**
     * @var string
     */
    protected $table = 'feedback';

    /**
     * @var null
     */
    protected static $_instance = null;

    /**
     * @return Feedback|null
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))
            // create an object of same class..
            self::$_instance = new Feedback();
        return self::$_instance;
    }

    /**
     * fetchBid
     * @param $where
     * @param array $selectCols
     * @return array
     * @throws \Exception
     */
    public function fetchFeedback($where, $selectCols = ['*'])
    {
        if (func_num_args() > 0) { // check no. of arguments passed..
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

}