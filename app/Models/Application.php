<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_no',
        'date',
        'location',
        'name',
        'father_name',
        'address',
        'mobile',
        'gmail',
        'aadhar',
        'pan',
        'bank_account_no',
        'ifsc',
        'education',
        'experience',
        'apply_job',
        'photo_path'
    ];

    protected $hidden = []; // No hidden attributes

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Only set application_no if not already set
            if (empty($model->application_no)) {
                // Use the highest application_no in DB, not just id, for reliability
                $latestAppNo = Application::orderByDesc('application_no')->value('application_no');
                if ($latestAppNo && preg_match('/APP(\d{6})/', $latestAppNo, $matches)) {
                    $nextNum = intval($matches[1]) + 1;
                } else {
                    $nextNum = 1;
                }
                $newAppNo = 'APP' . str_pad($nextNum, 6, '0', STR_PAD_LEFT);

                // Ensure uniqueness
                while (Application::where('application_no', $newAppNo)->exists()) {
                    $nextNum++;
                    $newAppNo = 'APP' . str_pad($nextNum, 6, '0', STR_PAD_LEFT);
                }
                $model->application_no = $newAppNo;
            }
        });
    }
}