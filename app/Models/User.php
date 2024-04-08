<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\Admin\Role;
use App\Models\Admin\Event;
use App\Models\TwoD\Lottery;
use App\Models\Admin\TwodWiner;
use App\Models\TwoD\TwodWinner;
use App\Models\Admin\BetLottery;
use App\Models\Admin\Permission;
use App\Models\ThreeDigit\Lotto;
use App\Models\Admin\FillBalance;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\LotteryTwoDigit;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'username',
        'email',
        'email_verified_at',
        'password',
        'register_type',
        'third_party_id',
        'token',
        'device_id',
        'fcm_token',
        'status',
        'gem',
        'bonus',
        'limit',
        'limit3',
        'cor',
        'cor3',
        'zero',
        'remark',
        'chk',
        'photo',
        'photo_mime',
        'photo_size',
        'language',
        'active',
        'kpay_no',
        'cbpay_no',
        'wavepay_no',
        'ayapay_no',
        'balance',
        'remember_token',
        'agent_id',
        'created_at',
        'updated_at',
    ];
    protected $dates = ['created_at', 'updated_at'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function getIsMasterAttribute()
    {
        return $this->roles()->where('id', 2)->exists();
    }

    public function getIsAgentAttribute()
    {
        return $this->roles()->where('id', 3)->exists();
    }
    public function getIsUserAttribute()
    {
        return $this->roles()->where('id', 4)->exists();
    }


    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class);

    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function hasRole($role)
    {
        return $this->roles->contains('title', $role);
    }

    public function hasPermission($permission)
    {
        return $this->roles->flatMap->permissions->pluck('title')->contains($permission);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    // Other users that this user (a master) has created (agents)
    public function createdAgents()
    {
        return $this->hasMany(User::class, 'agent_id');
    }

    // The master that created this user (an agent)
    public function createdByMaster()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function lotteries()
{
    return $this->hasMany(Lottery::class);
}

public function twodWiners()
    {
        return $this->belongsToMany(TwodWinner::class);
    }

 public function balancedecrement($column, $amount = 1)
    {
        $this->$column = $this->$column - $amount;
        return $this->save();
    }

    public static function getUserThreeDigits($userId) {
    $displayThreeDigits = Lotto::where('user_id', $userId)
                               ->with('DisplayThreeDigits')
                               ->get()
                               ->pluck('DisplayThreeDigits')
                               ->collapse(); 
    $totalAmount = $displayThreeDigits->sum(function ($threeDigit) {
        return $threeDigit->pivot->sub_amount;
    });

    return [
        'threeDigit' => $displayThreeDigits,
        'total_amount' => $totalAmount
    ];
}

    public static function getAdminthreeDigitsOneMonthHistory()
    {
        $jackpots = Lotto::with('displayThreeDigitsOneMonthHistory')->get();

        $displayJackpotDigits = $jackpots->flatMap(function ($jackpot) {
            return $jackpot->displayThreeDigitsOneMonthHistory;
        });
        $totalAmount = $displayJackpotDigits->sum('pivot.sub_amount');

        return [
            'threeDigit' => $displayJackpotDigits,
            'total_amount' => $totalAmount,
        ];
    }

    public static function getAdminthreeDigitsHistory()
    {
        $jackpots = Lotto::with('displayThreeDigitsOneWeekHistory')->get();

        $displayJackpotDigits = $jackpots->flatMap(function ($jackpot) {
            return $jackpot->displayThreeDigitsOneWeekHistory;
        });
        $totalAmount = $displayJackpotDigits->sum('pivot.sub_amount');

        return [
            'threeDigit' => $displayJackpotDigits,
            'total_amount' => $totalAmount,
        ];
    }

//     public static function getAdminthreeDigitsHistory()
// {
//     $jackpots = Lotto::with('displayThreeDigitsOneWeekHistory')->get();

//     $displayJackpotDigits = $jackpots->map(function ($jackpot) {
//         return $jackpot->displayThreeDigitsOneWeekHistory;
//     })->flatten(); // Use flatten() to collapse the collection into a single dimension

//     $totalAmount = $displayJackpotDigits->sum('pivot.sub_amount');

//     return [
//         'threeDigit' => $displayJackpotDigits,
//         'total_amount' => $totalAmount,
//     ];
// }

}