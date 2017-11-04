<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{

	/**
	 * Gather General info about usage
	 * @return array [data object]
	 */
	public static function gather($dataused){
		// $usage = Static::latest()->take(1)->get()->first()->value;

		// Fake Values:
		$usage = [];
		$usage['data_used'] = $dataused;
		$usage['data_remaining'] = 200 - $usage['data_used'];

		$status_options = ['primary','info', 'warning', 'danger'];
		$ratio = $usage['data_used'] / 200;


		foreach ($status_options as $key => $option) {
			if ($ratio > ($key * 0.25) ) {
				$usage['status'] = $option;
			}
		}

		return $usage;
	}    

}
