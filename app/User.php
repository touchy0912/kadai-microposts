<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    public function microposts(){
        return $this->hasMany(Micropost::class);
    }
    
    public function followings(){
        return $this->belongsToMany(User::class,'user_follow','user_id','follow_id')->withTimestamps();
        
    }
    public function followers(){
        return $this->belongsToMany(User::class,'user_follow','follow_id','user_id')->withTimestamps();
    }
    
    public function favorite(){
        return $this->belongsToMany(Micropost::class,'user_favorite','user_id','post_id')->withTimestamps();
    }
    
    public function follow($userId){
        $exist=$this->is_following($userId);
        $its_me=$this->id==$userId;
        
        if($exist||$its_me){
            return false;
        }else{
            $this->followings()->attach($userId);
            return true;
        }
    }
    public function unfollow($userId){
        $exist=$this->is_following($userId);
        $its_me=$this->id==$userId;
        
        if($exist && !$its_me){
            $this->followings()->detach();
            return true;
        }else{
            return false;
        }
    }
    public function is_following($userId){
        return $this->followings()->where('follow_id',$userId)->exists();
    }
    
    public function feed_microposts(){
        $follow_user_ids=$this->followings()->pluck('user_id')->toArray();
        $follow_user_ids[]=$this->id;
        return Micropost::whereIn('user_id',$follow_user_ids);
    }
    
    public function favo($postId){
    $exist=$this->is_favorite($postId);
    
    if($exist){
        return false;
    }else{
        $this->favorite()->attach($postId);
        return true;
    }
    
    }
    
    public function unfavo($postId){
        $exist=$this->is_favorite($postId);
        
        if($exist){
            $this->favorite()->detach($postId);
            return true;
        }else{
            return false;
        }
    }
    
    public function is_favorite($postId){
        return $this->favorite()->where('post_id',$postId)->exists();
    }
    
    
    
}
