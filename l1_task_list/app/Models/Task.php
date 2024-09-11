<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','long_description'];

    /* This is opposite of fillable like if there is many column and
    I don't want to write all column then guarded should be use because
    "The rest will be accept as a fillable except those which will be used here".
    But guarded is not a good decision. */
    // protected $guarded = ['column-name'];

    public function toggleComplete(){
        $this->completed = !$this->completed;
        $this->save();
    }
}
