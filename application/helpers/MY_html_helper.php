<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| CodeIgniter URL Helpers
|--------------------------------------------------------------------------
|
| This file extends the default CodeIgniter URL Helper base.
|
|   See: http://www.codeigniter.com/userguide3/helpers/html_helper.html
|   See: http://www.codeigniter.com/userguide3/general/helpers.html#extending-helpers
|
*/

// ------------------------------------------------------------------------

/**
 * Script (NEW)
 *
 * Generates a <script /> element
 *
 * @param	string	$src	javascript source data
 * @param	bool	$index_page	whether to treat $src as a routed URI string
 * @param	bool	$async	load the script asyncronously
 * @return	string
 */
function script_tag($src = '', $index_page = FALSE, $async = FALSE)
{
	$script = '<script type="text/javascript"';

	if ($index_page === TRUE)
	{
		$script .= ' src="'.get_instance()->config->site_url($src).'"';
	}
	else
	{
		if ( ! preg_match('/^assets\/javascripts/', $src))
		{
			$src = 'assets/javascripts/'.$src;
		}
		$script .= ' src="'.get_instance()->config->slash_item('base_url').$src.'"';
	}
	
	if ($async === TRUE)
	{
		$script .= ' async="true"';
	}
	
	return $script.'></script>';
}

// ------------------------------------------------------------------------

/**
 * Image (REPLACES ORIGINAL)
 *
 * Generates an <img /> element
 *
 * @param	mixed
 * @param	bool
 * @param	mixed
 * @return	string
 */
function img($src = '', $index_page = FALSE, $attributes = '')
{
   if ( ! is_array($src) )
   {
	   $src = array('src' => $src);
   }

   // If there is no alt attribute defined, set it to an empty string
   if ( ! isset($src['alt']))
   {
	   $src['alt'] = '';
   }

   $img = '<img';

   foreach ($src as $k => $v)
   {
	   if ($k === 'src' && ! preg_match('#^([a-z]+:)?//#i', $v))
	   {
		   if ($index_page === TRUE)
		   {
			   $img .= ' src="'.get_instance()->config->site_url($v).'"';
		   }
		   else
		   {
			   // prefix with assets/images/
			   if ( ! preg_match('/^assets\/images/', $v))
			   {
					$v = 'assets/images/'.$v;
			   }
			   $img .= ' src="'.get_instance()->config->slash_item('base_url').$v.'"';
		   }
	   }
	   else
	   {
		   $img .= ' '.$k.'="'.$v.'"';
	   }
   }

   return $img._stringify_attributes($attributes).' />';
}

// ------------------------------------------------------------------------

/**
 * Link (REPLACES ORIGINAL)
 *
 * Generates link to a CSS file
 *
 * @param	mixed	stylesheet hrefs or an array
 * @param	string	rel
 * @param	string	type
 * @param	string	title
 * @param	string	media
 * @param	bool	should index_page be added to the css path
 * @return	string
 */
function link_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '', $index_page = FALSE)
{
	$CI =& get_instance();
	$link = '<link ';

	if (is_array($href))
	{
		foreach ($href as $k => $v)
		{
			if ($k === 'href' && ! preg_match('#^([a-z]+:)?//#i', $v))
			{
				if ($index_page === TRUE)
				{
					$link .= 'href="'.$CI->config->site_url($v).'" ';
				}
				else
				{
					// prefix with assets/stylesheets/
					if ($rel == 'stylesheet' &&  ! preg_match('/^assets\/stylesheets/', $v))
					{
						$v = 'assets/stylesheets/'.$v;
					}
					$link .= 'href="'.$CI->config->slash_item('base_url').$v.'" ';
				}
			}
			else
			{
				$link .= $k.'="'.$v.'" ';
			}
		}
	}
	else
	{
		if (preg_match('#^([a-z]+:)?//#i', $href))
		{
			$link .= 'href="'.$href.'" ';
		}
		elseif ($index_page === TRUE)
		{
			$link .= 'href="'.$CI->config->site_url($href).'" ';
		}
		else
		{
			// prefix with assets/stylesheets/
			if ($rel == 'stylesheet' &&  ! preg_match('/^assets\/stylesheets/', $href))
			{
				$href = 'assets/stylesheets/'.$href;
			}
			$link .= 'href="'.$CI->config->slash_item('base_url').$href.'" ';
		}

		$link .= 'rel="'.$rel.'" type="'.$type.'" ';

		if ($media !== '')
		{
			$link .= 'media="'.$media.'" ';
		}

		if ($title !== '')
		{
			$link .= 'title="'.$title.'" ';
		}
	}

	return $link."/>\n";
}