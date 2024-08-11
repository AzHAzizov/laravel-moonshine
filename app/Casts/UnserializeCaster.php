<?php 

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UnserializeCaster implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        return unserialize($value);
    }

    /**
     * Transform the attribute to its underlying model value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        return serialize($value);
    }
}
