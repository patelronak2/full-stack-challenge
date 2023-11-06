<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasUuids, HasFactory;

    public const JOB_TYPE_REMOTE = 'remote';
    public const JOB_TYPE_IN_PERSON = 'in-person';

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

}
