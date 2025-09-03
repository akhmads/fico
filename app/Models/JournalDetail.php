<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class JournalDetail extends Model
{
    protected function casts(): array
    {
        return [
            'debit' => 'decimal:2',
            'credit' => 'decimal:2',
            'amount' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Model $model) {
            // $model->year = Carbon::parse($model->date)->format('Y');
            // $model->month = Carbon::parse($model->date)->format('Ym');
            $model->date = $model->date ?? $model->journal->date;
            $model->amount = $model->dc->value == 'D' ? $model->debit : ($model->credit * -1);
            $model->status = $model->status ?? $model->journal->status;
            $model->type = $model->type ?? $model->journal->type;
        });

        static::updating(function (Model $model) {
            // $model->year = Carbon::parse($model->date)->format('Y');
            // $model->month = Carbon::parse($model->date)->format('Ym');
            $model->date = $model->date ?? $model->journal->date;
            $model->amount = $model->dc->value == 'D' ? $model->debit : ($model->credit * -1);
            $model->status = $model->status ?? $model->journal->status;
            $model->type = $model->type ?? $model->journal->type;
        });
    }

    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class,'journal_id','id')->withDefault();
    }

    public function coa(): BelongsTo
    {
        return $this->belongsTo(Coa::class,'coa_code','code')->withDefault();
    }

    #[Scope]
    protected function approved(Builder $query): void
    {
        $query->where('status', 'approved');
    }
}
