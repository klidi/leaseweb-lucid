<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 1.11.20
 * Time: 12:44 AM
 */

namespace Framework\Data;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;
}
