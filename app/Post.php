<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SahusoftCom\EloquentImageMutator\EloquentImageMutatorTrait;

class Post extends Model
{
    use EloquentImageMutatorTrait;

   	protected $image_fields = ['image'];
    protected $table = 'posts';
    protected $fillable = ['title', 'label', 'content', 'image'];
    protected $hidden = [];

}
