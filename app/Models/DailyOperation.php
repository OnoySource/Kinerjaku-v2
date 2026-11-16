<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyOperation extends Model
{
    protected $fillable = [
        'employee_id',
        'operation_date',
        'activity',
        'quantity',
        'unit',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'operation_date' => 'date',
            'quantity' => 'decimal:2',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
