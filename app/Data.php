<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Data extends Model
{

	/**
	 * Gather General info about usage
	 * @return array [data object]
	 */
	public static function gather(){

		// GB Used This Month
		$last_record = Static::latest()->take(1)->get()->first();
		$used = $last_record->value;

		// Details 
		$usage = [];

		// Data used
		$usage['data_used'] = $used;
		$usage['last_updated'] = $last_record->created_at->diffForHumans();
		$usage['data_remaining'] = 200 - $used;
		$usage['data_status'] = Static::getStatusFromRatio($usage['data_used'] / 200);

		// Days of Month
		$today = new Carbon;
		$usage['days_in_month'] = $today->daysInMonth;
		$usage['today'] = $today->day;

		$usage['recommended_daily'] = round(200.00 / $usage['days_in_month'] , 2);
		$usage['actual_daily'] = round($usage['data_used'] / $usage['today'] , 2);

		return $usage;
	}    

	public function hourlyUse() // in MB
	{
		$previous_id = Static::where('id', '<', $this->id)->max('id');
		// if it's the very first record, return 0
		if (! $previous_id) {
			return 1;
		}
		$previous_data_point = Static::Find($previous_id);
		$hours_to_previous_data_point = $this->created_at->DiffInHours($previous_data_point->created_at);
		if ($hours_to_previous_data_point < 1) {
			$hours_to_previous_data_point = 1;
		}
		return (int) round((( ($this->value - $previous_data_point->value) / $hours_to_previous_data_point)) * 1000, 2);		
	}

	private static function getStatusFromRatio($ratio)
	{
		$status_options = ['primary','info', 'warning', 'danger'];
		$result = '';
		foreach ($status_options as $key => $option) {
			if ($ratio > ($key * 0.25) ) {
				$result = $option;
			}
		}
		return $result;
	}

	public static function hourlyDataSet(){
		$data  = [];
		$data_this_month = Static::where( DB::raw('MONTH(created_at)'), '=', date('n') )->get();
		$data['values'] = $data_this_month->map(function($data_item){
			return $data_item->hourlyUse();
		});
		$data['labels'] = $data_this_month->map(function($data_item){
			return $data_item->created_at->toW3cString();
		}); 

		return $data;
	}

}
