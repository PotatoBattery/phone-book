<?php

namespace App\Models\PhoneBook;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'second_name',
        'last_name',
        'favorite',
        'user_id',
    ];

    /**
     * @description Аксессор и Мутатор для поля first_name модели Контакта
     *
     * @return Attribute
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn($value) => $value
        );
    }
    /**
     * @description Аксессор и Мутатор для поля second_name модели Контакта
     *
     * @return Attribute
     */
    protected function secondName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn($value) => $value
        );
    }
    /**
     * @description Аксессор и Мутатор для поля last_name модели Контакта
     *
     * @return Attribute
     */
    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn($value) => $value
        );
    }
    /**
     * @description Аксессор и Мутатор для поля favorite модели Контакта
     *
     * @return Attribute
     */
    protected function favorite(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (bool)$value,
            set: fn($value) => (bool)$value
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function numbers(): HasMany
    {
        return $this->hasMany(Number::class, 'contact_id');
    }

}
