<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['review','rating'];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    // model event broadcasting
    // This is for cache memory where store the query
    // When any changes happened in this model then this function will triggered
    // Event handler
    // But all time it will not triggered like if database directly modified which is outside the laravel, if the model will not loaded
    // $review = \App\Models\Review::findOrFail($id);$review->rating=4;$review->save(); = this way below function will triggered then cache memory will also cleared
    // $review = \App\Models\Review::findOrFail($id);$review->update(['rating'=>1]); = this way below function will triggered then cache memory will also cleared
    // \App\Models\Review::where('id',$id)->update(['rating'=>2]); = this way below function will not triggered then cache memory will not also cleared
    protected static function booted()
    {
        // If the database updated or deleted through model then cache memory will be cleared
        // $key = 'book:'.$review->book_id;
        static::updated(fn(Review $review) => cache()->forget('book:'.$review->book_id));
        static::deleted(fn(Review $review) => cache()->forget('book:'.$review->book_id));
        static::created(fn(Review $review) => cache()->forget('book:'.$review->book_id));
    }
}
