<?php
/**
 * Puvoo
 * http://www.puvoo.com
 *
 * NOTICE OF LICENSE
 *
 * Copyright (c) 2011
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@puvoo.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Puvoo to newer
 * versions in the future. If you wish to customize Puvoo for your
 * needs please refer to http://www.puvoo.com for more information.
 */


/**
 * Class Models_Like
 *
 * Class Models_Like contains methods handle product likes .
 *
 * Date created: 2011-10-13
 *
 * @category	Puvoo
 * @package 	Models
 * @author	    Yogesh 
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */ 
class Models_Like
{
	
	private $db;
	
	/**
	 * Function __construct
	 *
	 * This is a constructor functions.
     * It will set db adapter for the model 
	 *
	 * Date created: 2011-10-13
	 *
	 * @access public
	 * @param ()  - No parameter
	 * @return () - Return void
	 * @author Yogesh
	 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
	 **/
	 
	function __construct()
	{
		$this->db = Zend_Registry::get('Db_Adapter');
	}
	
	function getAllLikes($facebook_userid)
	{
		global $mysession;
		
		$db = $this->db;
		
		$select = "SELECT upl.*,pm.product_id, pm.product_name, pm.product_price, cm.currency_symbol, cm.currency_code, round( ( pm.product_price * ".$mysession->currency_value.") / cm.currency_value, 2 ) as converted_price, pi.image_name, pi.image_path 
				   FROM user_product_likes as upl
				   JOIN product_master as pm ON(pm.product_id = upl.product_id)
				   LEFT JOIN user_master as um ON ( um.user_id = pm.user_id )
				   LEFT JOIN currency_master as cm ON (um.currency_id = cm.currency_id)
				   LEFT JOIN product_images as pi ON ( pm.product_id = pi.product_id AND pi.is_primary_image = 1)
				   WHERE upl.facebook_user_id = '".$facebook_userid."'";
		
		return $db->fetchAll($select);
		
	}
	
	function getAllFriendLikes($friends_list)
	{
		
		global $mysession;
		
		$db = $this->db;
		
		$select = "SELECT upl.*,pm.product_id, pm.product_name, pm.product_price, cm.currency_symbol, cm.currency_code, round( ( pm.product_price * ".$mysession->currency_value.") / cm.currency_value, 2 ) as converted_price, pi.image_name, pi.image_path 
				   FROM user_product_likes as upl
				   JOIN product_master as pm ON(pm.product_id = upl.product_id)
				   LEFT JOIN user_master as um ON ( um.user_id = pm.user_id )
				   LEFT JOIN currency_master as cm ON (um.currency_id = cm.currency_id)
				   LEFT JOIN product_images as pi ON ( pm.product_id = pi.product_id AND pi.is_primary_image = 1)
				   WHERE upl.facebook_user_id in ( ".$friends_list." ) ";
		
		return $db->fetchAll($select);
		
	}
	
	
}
?>