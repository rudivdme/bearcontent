<?php

namespace Rudivdme\BearContent\Models;

use Rudivdme\BearContent\Models\Model;

class Settings extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function get($key)
    {
        $record = $this->where('key', '=', $key)->first();

        if ($record)
        {
            return $record->value;
        }

        return;
    }

    public function set($key, $value)
    {
        $record = $this->where('key', '=', $key)->first();

        if (!empty($record))
        {
            $record->fill(['value' => $value])->save();
        }
        else
        {
            $this->create([
                'key'   => $key,
                'value' => $value,
            ]);
        }
    }
}
