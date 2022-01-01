<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_controller 
{
	//parent constructor will load model inside it
	function Site()
	{
		parent::__construct();
	}
	
	function sendMail()
	{
		sendMail("kakdiya.gautam288@gmail.com", "Test Message", "Check Mail");
	}
	
	function bonusMap()
	{
		$discountMapArr = executeQuery( "SELECT reference_customer_id, COUNT( level ) as total, level FROM customer_discount_map WHERE level <=5 GROUP BY reference_customer_id, level" );//LIMIT ".$start.", ".$end
		
		if( !isEmptyArr( $discountMapArr ) )
		{
			foreach ( $discountMapArr as $k=>$discountMap )
			{
				$insertData['level_1'] = $insertData['level_2'] = $insertData['level_3'] = $insertData['level_4'] = $insertData['level_5'] = 0;
				$insertData['level_'.$discountMap['level']] = $discountMap['level'];
				$insertData['customer_id'] = $discountMap['reference_customer_id'];

				if( $row = checkIfRowExist( "SELECT bonus_map_id FROM bonus_map where customer_id = ".$discountMap['reference_customer_id'] ) )
				{
					$this->db->query( "UPDATE `bonus_map` SET `level_".$discountMap['level']."`=`level_".$discountMap['level']."`+1 WHERE `bonus_map_id`=".$row );
				}
				else
				{
					$this->db->insert( 'bonus_map', $insertData);
				}
				echo $k." : ".$this->db->last_query()."<br><br>";
			}
		}
		else 
		{
			echo "Record Update Successfully";
		}
	}
}