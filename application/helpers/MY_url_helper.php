<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| CodeIgniter HTML Helpers
|--------------------------------------------------------------------------
|
| This file extends the default CodeIgniter HTML Helper base.
|
|   See: http://www.codeigniter.com/userguide3/helpers/url_helper.html
|   See: http://www.codeigniter.com/userguide3/general/helpers.html#extending-helpers
|
*/

// ------------------------------------------------------------------------

/**
 * Asset URL (NEW)
 *
 * Create a local asset URL based on your basepath.
 *
 * @param	string	$uri
 * @param	string	$protocol
 * @return	string
 */
function asset_url($uri = '', $protocol = NULL)
{
	$uri = 'assets/'.$uri;
	return get_instance()->config->base_url($uri, $protocol);
}