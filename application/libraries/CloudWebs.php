<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Cloud Webs
 * initilize constant and other stuff that we are unable to do in codeigniter initilization.
 */
class CloudWebs
{
	
	function CloudWebs()
	{
		$CI =& get_instance();
				
		/**
		 * CMS client code
		 */
		define('CLIENT', baseClient());
		
		/**
		 * Caching config
		 */
		define( "IS_CACHE", FALSE );		//do caching or not
		
		/**
		 * log config. For DEBUG purpose only
		 * applicable to application's important features which are logged for constatnt examination. <br>
		 * like cmn_db::update_insertProductPrice function
		 *
		 */
		define( "IS_LOG", FALSE );		//do logging or not
		
		/**
		 *
		 * HELD for DEPRECATION, supposed to be deprecated in next version 2.1.2
		 * IS country( so is language ) wise store
		 * Remember that for stores that are managed country wise customely will not support multi language solution natively,
		 * so for such country wise custom store language will be default as per country.
		 */
		define('IS_CS', FALSE);
		
		/**
		 * IS multiCURRENCY?
		 * applicable to multiple currency solution only
		 */
		define('IS_MC', FALSE);
		
		/**
		 * TOLL FREE NO Constant
		 */
		define('TOLL_FREE_NO', '+353123456789');
		
		/**
		 * currency constants
		 */
		$currency_value = $CI->session->userdata('currency_value');
		if( $currency_value === FALSE )
		{
			setCurrencySession( getDefaultCurrency() );
		}
		
		/**
		 |--------------------------------------------------------------------------
		 // CONSTANT: CURRENCY_CODE current currency used in session
		 |--------------------------------------------------------------------------
		 */
		define('CURRENCY_ID', $CI->session->userdata('currency_id'));
		
		/**
		 |--------------------------------------------------------------------------
		 // CONSTANT: CURRENCY_CODE current currency used in session
		 |--------------------------------------------------------------------------
		 */
		define('CURRENCY_CODE', $CI->session->userdata('currency_code'));
		
		/**
		 |--------------------------------------------------------------------------
		 // CONSTANT: CURRENCY_SYMBOL current currency used in session
		 |--------------------------------------------------------------------------
		 */
		define('CURRENCY_SYMBOL', $CI->session->userdata('currency_symbol'));
		
		/**
		 |--------------------------------------------------------------------------
		 // CONSTANT: CURRENCY_SYMBOL current currency used in session
		 |--------------------------------------------------------------------------
		 */
		define('CURRENCY_DECIMAL_SYMBOL', $CI->session->userdata('currency_decimal_symbol'));
		
		/**
		 |--------------------------------------------------------------------------
		 // CONSTANT: CURRENCY_VALUE current currency used in session
		 |--------------------------------------------------------------------------
		 */
		define('CURRENCY_VALUE', $CI->session->userdata('currency_value'));
		
		/**
		 * a constant that specifies if this solution is for any default inventory, <br>
		 * if it will support multiple inventory then it will be 0.
		 */
		define("INVENTORY_TYPE_ID", 0);
		
		/**
		 * CURRENCY ROUNDING
		 */
		define("CURR_RND", 2);
		
		/**
		 * Message 91 Authntication KEY
		 * Cloudwebs: 172713AQbksvGCWb59aa2d35
		 * DicountMaster: 173062AKdjsdNHdK59ad69c7
		 * Parivar Advisor: 272098ADDesgviztoW5cb05247
		 */
		define("MSG91_AUTH_KEY", "272098ADDesgviztoW5cb05247");
		
		
	}
}

/******************************** CONFIG CONSTANT functions **********************************************/
/**
 * let's see if it will benefit or not.
 * TO use constant function instead of CONSTANTs itself to minimize RAM usage.
 */

/**
 * is this installation supports market place?
 */
function IS_MP()
{
	return TRUE;
}

/**
 * returns CONSTANT value by NAME
 */
function cs_CONSTANT( $NAME )
{
	/**
	 * Copyright
	 */
	$__C["CR"] = otherSystemConfig( 'DOMAIN' );
	
	/**
	 * Weather product module supports 'Product Occasion' field and so on it's features.
	 */
	$__C["IS_PO"] = FALSE;
	
	/**
	 * BACK END panels item listing date format
	 */
	$__C["BPDF"] = "d m Y H:i";
	
	return $__C[$NAME];
}

/******************************** CONFIG CONSTANT functions end ******************************************/


/******************************** FRONT END LAYOUT functions **********************************************/

/**
 * per page products to display on front end
 */
if( empty( $_GET["limit"] ) )
{
	if( is_restClient() )
	{
		define('PER_PAGE_FRONT', 16);
	}
	else
	{
		define('PER_PAGE_FRONT', 10);
	}
}
else
{
	define('PER_PAGE_FRONT', (int)$_GET["limit"]);
}

/******************************** FRONT END LAYOUT functions end ******************************************/

/******************************** SOCIAL API config **********************************************/

/**
 * return social api page URL
 */
function socialPageUrl( $api_key )
{
	if( $api_key == "FB" )
	{
		return "put url here";
	}
	else if( $api_key == "TWITTER" )
	{
		return "put url here";
	}
	else if( $api_key == "PINTEREST" )
	{
		return "put url here";
	}
	else if( $api_key == "GOOGLE" )
	{
		return "put url here";
	}
}

/******************************** SOCIAL API config end **********************************************/


/***************************************** Warehouse config functions **********************************************/

/**
 * checks weather for current inventory type inventory type is warehouse managed
 */
function hewr_isWarehouseManaged()
{
	/**
	 * From 02-07-2015 it's decided to treat all inventory as warehouse managed,
	 * let's see how it fit with non-warehouse managed inventory.
	 *
	 *
	 */
	return true;
	
	$CI =& get_instance();
	if( $CI->session->userdata("IT_KEY") == "GC" )
		return true;
		else
			return false;
}


/**
 * decimal rounding applied to product prices
 */
function productPriceRounding()
{
	return 2;
}

/***************************************** Warehouse config functions end ******************************************/

/***************************************** Checkout/Order/Sales/Affiliate/  config functions ******************************************/

/**
 * is client want to add/use to checkout payable amount additional import duty for abroad shippments
 */
function isImportDuty()
{
	return FALSE;
}

/**
 * added on 30-06-2015
 */
function orderSupportedStatuses()
{
	return ' "ORD_PLC", "ORDER_FAILED", "ORDER_DENIED", "ORDER_PENDING", "ORDER_CANCELED", "PAYMENT_APPROVED", "PACKAGING", "YET_TO_SHIP", "YET_TO_REACH_AT_HUB", "YET_TO_BE_DELIVERED", "ORDER_DELIVERED", "ORDER_EXPIRED", "ORDER_REFUND_BUCKS", "ORDER_PEFUNDED", "ORD_ACPS" ';
}

/**
 * added on 30-06-2015
 */
function orderSupportedUpdateStatuses()
{
	return ' "ORDER_DENIED", "PACKAGING", "YET_TO_SHIP", "YET_TO_REACH_AT_HUB", "YET_TO_BE_DELIVERED", "ORDER_DELIVERED", "ORD_ACPS" ';
}

/***************************************** Checkout/Order/Sales/Affiliate/  config functions end ******************************************/

/******************************** Other config **********************************************/

/**
 * about to deprecated
 */
function baseClient()
{
	return "Ocean";
}

/**
 * base domain
 */
function baseDomain()
{
	return "bansi_stationary/"; //otherSystemConfig( 'DOMAIN' );
}

/**
 * email from name
 */
function emailFrom()
{
	return "Bansi Stationary";
}


/**
 * weather to send SMS after order placed, on order dispatch and so on for entire checkout and post order processing.
 */
function isSignupSMSOn()
{
	return FALSE;
}


/**
 * weather to send SMS after order placed, on order dispatch and so on for entire checkout and post order processing.
 */
function isOrderSMSOn()
{
	return FALSE;
}

$host = $_SERVER['HTTP_HOST'];

if( $host == LOCALHOST_IP )
{
	/**
	 * Default country ID for installation
	 */
	function getDefaultCountryID()
	{
		return 105;//308;
	}
	
	/**
	 * With State code FIX by Gautam
	 */
	function getDefaultStateID()
	{
		return 3835;
	}
}
else
{
	/**
	 * Default country ID for installation
	 */
	function getDefaultCountryID()
	{
		return 105;//239;
	}
	
	/**
	 * With State code FIX by Gautam
	 */
	function getDefaultStateID()
	{
		return 3835;//3650;
	}
}


/**
 * is for state always show state drop down only
 */
function isStateDropDownOnly()
{
	return 0;
}

/**
 * is for Province always show Province drop down only
 */
function isProvinceDropDownOnly()
{
	return 0;
}

/**
 * Cloud Webs
 */
function getDefaultCity()
{
	return "Surat";
}

/**
 * Facebook page url
 */
function getFbPageUrl()
{
	return "https://www.facebook.com/CeramicWorlds-1618887225022715/";
}

/**
 * Twitter page url
 */
function getTwitterPageUrl()
{
	return "https://twitter.com/CeramicWorlds";
}

/**
 * getPintrestPageUrl page url
 */
function getPintrestPageUrl()
{
	return "http://www.pinterest.com/ceramic/";
}

/**
 * Google plus page url
 */
function getGooglePageUrl()
{
	return "https://plus.google.com/111913402653315889154/posts";
}

function facebookAppID()
{
	return "738573352925856";
	
}
/**
 * Android app url
 */
function getAndroidAppUrl()
{
	return "https://play.google.com/store/apps/details?id=com.ceramicworlds.cm_android_3_10";
}
/**
 * Apple app url
 */
function getAppleAppUrl()
{
	return "https://itunes.apple.com/in/app/ceramicworlds/id1052048481?mt=8";
}
/**
 * Get company address
 */
function getCompanyAddress()
{
	return "";
}


/******************************** Other config end **********************************************/

/******************************** Server config *************************************************/
/**
 * not recommended to use, use only this configurations if client owns shared servers only
 */

/**
 * function will tell if explicit created date storing is required
 */
function isExplicitCreatedDate()
{
	return FALSE;
}

/**
 * sets default DBs mysql timezone
 */
function setMySqlTimezone()
{
	$CI =& get_instance();
	$CI->db->query( " SET SESSION time_zone='+8:00' " );
}
/******************************** Server config end **********************************************/