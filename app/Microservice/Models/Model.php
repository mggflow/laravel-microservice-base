<?php


namespace App\Microservice\Models;


use Illuminate\Database\Eloquent\Model as EloquentModel;
use PDO;

class Model extends EloquentModel
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = false;
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $dateFormat = 'U';

    protected $guarded = [];

    protected $hidden = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->customTimestamps) {
                $model->setCreatedAt($model->freshTimestamp()->format($model->getDateFormat()));
            }
        });
    }

    /**
     * Get AutoIncrement for model table.
     *
     * @return false|mixed
     */
    public function getAutoIncrement()
    {
        $info = $this->getTableInfo();
        if (isset($info['Auto_increment'])) {
            return $info['Auto_increment'];
        }

        return false;
    }

    /**
     * Get model table info.
     *
     * @return false|mixed
     */
    public function getTableInfo()
    {
        $info = $this->getConnection()
            ->getPdo()
            ->query('show table status like "' . $this->getTable() . '"')
            ->fetchAll(PDO::FETCH_ASSOC);

        if (empty($info)) return false;

        return array_shift($info);
    }
}
