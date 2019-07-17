<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SahusoftCom\EloquentImageMutator\EloquentImageMutatorTrait;

class Game extends Model
{
 	use EloquentImageMutatorTrait;

   	protected $image_fields = ['image'];
    protected $table = 'games';
    protected $fillable = ['name', 'description', 'image'];
    protected $hidden = [];
}
