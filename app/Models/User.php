<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'id_num',
        'level',
        'firstname',
        'lastname',
        'password',
        'is_active',
        'activate_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function FullName() {
        return $this->firstname . " " . $this->lastname;
    }

    public function StillBorrowBooks() {
        return BookLog::where("borrower_id", $this->id)->where("is_returned", false)->count() > 0;
    }

    public function GetNumOfBorrowedBooks() {
        return BookLog::where("borrower_id", $this->id)->where("is_returned", false)->count();
    }

    public static function IsIdNumTaken($idNum) {
        return User::where("id_num", $idNum)->count() > 0;
    }
}
