<?php

namespace App\Models;

use App\Models\OtpVerification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;

class Society extends Model implements Authenticatable
{
    use HasFactory;

    protected $guarded = [];

    public function otpVerifications()
    {
        return $this->hasMany(OtpVerification::class);
    }

     // Implementing the required methods of the Authenticatable interface
     public function getAuthIdentifierName()
     {
         return 'id'; // Change 'id' to the name of the identifier column in your societies table
     }
 
     public function getAuthIdentifier()
     {
         return $this->getKey();
     }
 
     public function getAuthPassword()
     {
         // In most cases, you don't need this for OTP-based authentication.
         // You can return null or an empty string.
         return '';
     }
 
     public function getRememberToken()
     {
         // If you're using remember tokens, implement this method
         return null;
     }
 
     public function setRememberToken($value)
     {
         // If you're using remember tokens, implement this method
     }
 
     public function getRememberTokenName()
     {
         // If you're using remember tokens, implement this method
         return '';
     }
}
