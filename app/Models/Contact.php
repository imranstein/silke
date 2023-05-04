<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use RalphJSmit\Laravel\SEO\Support\HasSEO;


class Contact extends Model
{
    use HasSEO;
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id', //added by me
        'name',
        'email',
        'phone',
        'alt_phone',
        'address',
        'dob',
        'image',
    ];

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orWhere('email', 'like', $term)
                ->orWhere('phone', 'like', $term)
                ->orWhere('alt_phone', 'like', $term)
                ->orWhere('address', 'like', $term);
        });
    }

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        //$user = Auth::user()->name;
        //return "{$user} has {$eventName} user {$this->name}";

        return "user has {$eventName} user {$this->name}";
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->useLogName("Contact");
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
