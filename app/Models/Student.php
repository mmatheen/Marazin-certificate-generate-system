<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'students';

    protected $fillable = [
        'register_date',
        'effective_date_of_certificate',
        'registration_no',
        'reference_no',
        'certificate_no',
        'batch_id',
        'full_name_of_student',
        'name_with_initial',
        'nic_no',
        'address',
        'course_name',
        'year',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }


     //this function for auto increament code for reference_no
     protected static function boot()
     {
         parent::boot();
         self::creating(function ($model) {
             $getReferenceNo = self::orderBy('reference_no', 'desc')->first();

             if ($getReferenceNo) {
                 $latestReferenceNo = intval(substr($getReferenceNo->reference_no, 2));
                 $nextReferenceNo = $latestReferenceNo + 1;
             } else {
                 $nextReferenceNo = 1;
             }
             $model->reference_no = 'EX' . sprintf("%04s", $nextReferenceNo);
             while (self::where('reference_no', $model->reference_no)->exists()) {
                 $nextReferenceNo++;
                 $model->reference_no = 'EX' . sprintf("%04s", $nextReferenceNo);
             }
         });
     }


    // it is for set the date for all

     // Setter for effective_date_of_certificate
     public function setEffectiveDateOfCertificateAttribute($date)
     {
         $this->setDateAttribute('effective_date_of_certificate', $date);
     }

     // Setter for register_date
     public function setRegisterDateAttribute($date)
     {
         $this->setDateAttribute('register_date', $date);
     }

    // Method to set a date attribute with multiple formats
    public function setDateAttribute($field, $date)
    {
        // Define the formats you want to check for
        $formats = ['d-m-Y', 'd/m/Y', 'm-d-Y', 'm/d/Y', 'Y-m-d', 'Y/m/d'];

        // Try to create a Carbon instance from various date formats
        foreach ($formats as $format) {
            try {
                $parsedDate = Carbon::createFromFormat($format, $date);
                $this->attributes[$field] = $parsedDate->format('Y-m-d');
                return;
            } catch (\Exception $e) {
                // Continue to the next format
            }
        }
    }

}
