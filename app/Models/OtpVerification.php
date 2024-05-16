<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'society_id',
        'otp',
    ];

    /**
     * Get the user that owns the OTP verification.
     */
    public function society()
    {
        return $this->belongsTo(Society::class);
    }
}
