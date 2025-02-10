<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiMNCSuccess extends Model
{
    use HasFactory;
	
	protected $table = "api_mnc_success";
	
    /**
     * filllable
     *
     * @var array
     */
    protected $fillable = [
      "ReferenceNo",
      "IssuerReferenceNo",
      "PolicyNo",
      "IssueDate"
    ];
	
}
