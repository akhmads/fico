<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected function casts(): array
    {
        return [
            'debit_total' => 'decimal:2',
            'credit_total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Model $model) {
            $model->created_by = auth()->user()->id;
            $model->updated_by = auth()->user()->id;
        });

        static::updating(function (Model $model) {
            $model->updated_by = auth()->user()->id;
        });

        static::updated(function (Model $model) {

            if ($model->isDirty('status')) {
                $model->details()->update([
                    'status' => $model->status
                ]);
            }
        });
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class,'contact_id','id')->withDefault();
    }

    public function details(): HasMany
    {
        return $this->hasMany(JournalDetail::class,'journal_id','id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by','id')->withDefault();
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by','id')->withDefault();
    }
}
