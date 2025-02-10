<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiMNCError extends Model
{
    use HasFactory;
	
	protected $table = "api_mnc_error";
	
    /**
     * filllable
     *
     * @var array
     */
    protected $fillable = [
		"ReferenceNo",
		"IssuerReferenceNo",
		"IssueDate",
		"ErrorMessage"
    ];
	
}
