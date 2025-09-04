<?php

namespace App\Models;

use App\Enums\Approval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CashIn extends Model
{
    protected function casts(): array
    {
        return [
            'status' => Approval::class,
            'total_amount' => 'decimal:2',
        ];
    }

    public function settlements(): MorphMany
    {
        return $this->morphMany(SalesSettlementSource::class, 'settleable', null, null, 'code');
    }

    public function cashAccount(): BelongsTo
    {
        return $this->belongsTo(CashAccount::class,'cash_account_id','id')
            ->orderBy('name','asc')
            ->withDefault();
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class,'contact_id','id')
            ->orderBy('name','asc')
            ->withDefault();
    }

    public function details(): HasMany
	{
		return $this->hasMany(CashInDetail::class,'cash_in_id','id');
	}

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by','id')->withDefault();
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by','id')->withDefault();
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
    }

    #[Scope]
    protected function approved(Builder $query): void
    {
        $query->where('status', 'close');
    }
}
