<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'employee_code',
        'name',
        'gender',
        'phone',
        'address',
        'position',
        'join_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'join_date' => 'date',
        ];
    }

    // ==========================================
    // RELASI DEPARTEMEN
    // ==========================================

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    // ==========================================
    // RELASI USER
    // ==========================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ==========================================
    // RELASI EVALUASI
    // ==========================================

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    // ==========================================
    // RELASI OPERASIONAL HARIAN
    // ==========================================

    public function dailyOperations(): HasMany
    {
        return $this->hasMany(DailyOperation::class);
    }
}
