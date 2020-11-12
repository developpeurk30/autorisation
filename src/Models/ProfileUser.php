<?php
namespace  Chimak\Autorisation\Models;
use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Model{
    public $timestamps = true;
    protected $table = 'profile_user';
    protected $fillable = ['created_at', 'updated_at','profile_opened_at','profile_closed_at','profile_id','user_id'];
    protected $dates = ['created_at', 'updated_at','profile_opened_at','profile_closed_at'];
}
