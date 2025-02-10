<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiTest extends Model
{
    use HasFactory;
	
	protected $table = "api_test";
	
    /**
     * filllable
     *
     * @var array
     */
    protected $fillable = [
		"id",
		"json_request",
		"json_response",
		"created_at",
		"updated_at",
		"created_by",
    ];
	
}
