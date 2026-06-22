<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['key', 'value'])]
class Setting extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    public static function get(string $key, mixed $default = null): mixed
    {
        return static::find($key)?->value ?? $default;
    }

    public static function put(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * @return array<string, string|null>
     */
    public static function allValues(): array
    {
        return static::pluck('value', 'key')->all();
    }
}
