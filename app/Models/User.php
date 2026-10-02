<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
        'role',
        'major',
        'avatar',
        'bio',
        'supervisor_id',
        'internship_place_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'supervisor_id' => 'integer',
            'internship_place_id' => 'integer',
        ];
    }

    /**
     * Relationship: Guru Pembimbing of this student.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(self::class, 'supervisor_id');
    }

    /**
     * Relationship: Students supervised by this teacher.
     */
    public function students(): HasMany
    {
        return $this->hasMany(self::class, 'supervisor_id');
    }

    /**
     * Relationship: DUDI / Internship Place where the student is placed.
     */
    public function internshipPlace(): BelongsTo
    {
        return $this->belongsTo(InternshipPlace::class, 'internship_place_id');
    }

    /**
     * Relationship: Attendances of this student.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Relationship: Internship daily logs / journal of this student.
     */
    public function internshipLogs(): HasMany
    {
        return $this->hasMany(InternshipLog::class);
    }

    /**
     * Check if user is an Administrator (Hubin).
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a Supervisor (Guru Pembimbing).
     */
    public function isSupervisor(): bool
    {
        return $this->role === 'supervisor';
    }

    /**
     * Check if user is a Student (Siswa PKL).
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
}
