<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrademarkRegistration extends Model
{
	protected $fillable = [
        'acceptance_date','publication_date','registration_date'
    ];


	public function claim_convention_filling(){
		return $this->hasOne('App\Models\ClaimConventionDetail')->with('country');
	}

	public function language(){
		return $this->belongsTo('App\Models\Language' , 'language_id');
	}

	public function color(){
		return $this->belongsTo('App\Models\Color' , 'color_id');
	}

	public function applicant_type(){
		return $this->belongsTo('App\Models\ApplicantType' , 'applicant_type_id');
	}

	public function applicant_occupation(){
		return $this->belongsTo('App\Models\ApplicantOccupation' , 'applicant_occupation_id');
	}

	public function nationality(){
		return $this->belongsTo('App\Models\Nationality' , 'applicant_nationality_id');
	}

	public function applicant_company_type(){
		return $this->belongsTo('App\Models\CompanyType' , 'applicant_company_type_id');
	}
	
	
}
