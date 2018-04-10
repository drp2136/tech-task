<?php

namespace App\Modules\Freelancer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var null
     */
    protected static $_instance = null;

    /**
     * @return Users|null
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))
            // create an object of same class..
            self::$_instance = new Users();
        return self::$_instance;
    }

    /**
     * @param $userdata
     * @return null
     * @throws \Exception
     * @author Dibyaranjan Pradhan<dibyachintu6@gmail.com>
     * @since 06-Apr-2018
     */
    public function insertQuery($userdata)
    {
        if (func_num_args() > 0) { // check no. of arguments passed..
            try {
                // DB query.
                $result = DB::table($this->table)
                    ->insertGetId($userdata);

                return $result ? $result : null;
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } else {
            throw new \Exception("argument not passed.");
        }
    }

}
