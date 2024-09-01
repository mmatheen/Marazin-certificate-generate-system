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
        'course_duration',
        'year',
        'pass_rate',
        'study_mode',
        'picture',
        'session_id',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    // Boot method for auto-increment code

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            // Auto increment code for reference_no
            $getReferenceNo = self::orderBy('reference_no', 'desc')->first();
            $nextReferenceNo = $getReferenceNo ? intval(substr($getReferenceNo->reference_no, 2)) + 1 : 1;
            $model->reference_no = 'EX' . sprintf("%04s", $nextReferenceNo);

            // Ensure uniqueness of reference_no
            while (self::where('reference_no', $model->reference_no)->exists()) {
                $nextReferenceNo++;
                $model->reference_no = 'EX' . sprintf("%04s", $nextReferenceNo);
            }

            // Auto increment code for certificate_no
            $year = $model->year;
            $latestCertificate = self::whereRaw("SUBSTRING(certificate_no, 1, 4) = ?", [$year])
                ->orderBy('certificate_no', 'desc')
                ->first();
            $nextSequenceNo = $latestCertificate ? intval(substr($latestCertificate->certificate_no, 4)) + 1 : 1;
            $model->certificate_no = $year . sprintf("%06d", $nextSequenceNo);

            // Auto increment code for registration_no
            $courseId = $model->course_name;
            $course = Course::find($courseId);

            if ($course) { // Ensure course is valid
                $year = $model->year;
                $prefix = 'IATSL/' . $course->short_name . '/' . $year;
                $latestRegistration = self::whereRaw("SUBSTRING(registration_no, 1, LENGTH(?)) = ?", [$prefix, $prefix])
                    ->orderBy('registration_no', 'desc')
                    ->first();
                $nextSequenceNo = $latestRegistration ? intval(substr($latestRegistration->registration_no, strlen($prefix))) + 1 : 1;
                $model->registration_no = $prefix . sprintf("%06d", $nextSequenceNo);
            }
        });
    }

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
        $formats = ['d-m-Y', 'd/m/Y', 'm-d-Y', 'm/d/Y', 'Y-m-d', 'Y/m/d'];

        foreach ($formats as $format) {
            try {
                $parsedDate = Carbon::createFromFormat($format, $date);
                $this->attributes[$field] = $parsedDate->format('Y-m-d');
                return;
            } catch (\Exception $e) {
                // Continue to the next format
            }
        }

        // If no format matched, you may want to throw an exception or log it
    }
}
