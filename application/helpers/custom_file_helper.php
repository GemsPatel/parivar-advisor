<?php  if ( ! defined('BASE_DIR')) exit('No direct script access allowed');

/* 
  filename without extension 
  ex: file_core_name('toto.jpg') -> 'toto'
*/
if ( ! function_exists('file_core_name'))
{
	function file_core_name($file_name)
	{
		$exploded = explode('.', $file_name);
 
		// if no extension
		if (count($exploded) == 1)
		{
			return $file_name;
		}
 
		// remove extension
		array_pop($exploded);
 
		return implode('.', $exploded);
	}
}
 
/* 
  file extension 
  ex: file_extension('toto.jpg') -> 'jpg'
*/
 
if ( ! function_exists('file_extension'))
{
	function file_extension($path)
	{
		$extension = substr(strrchr($path, '.'), 1);
		return $extension;
	}
}
 
/* 
  file size 
  ex: file_size('toto.jpg') -> '3.3 MB'
*/
if ( ! function_exists('file_size'))
{
	function file_size($path)
	{
		$num = filesize($path);
 
		// code from byte_format()
		$CI =& get_instance();
		$CI->lang->load('number');
 
		$decimals = 1;
 
		if ($num >= 1000000000000) 
		{
			$num = round($num / 1099511627776, 1);
			$unit = $CI->lang->line('terabyte_abbr');
		}
		elseif ($num >= 1000000000) 
		{
			$num = round($num / 1073741824, 1);
			$unit = $CI->lang->line('gigabyte_abbr');
		}
		elseif ($num >= 1000000) 
		{
			$num = round($num / 1048576, 1);
			$unit = $CI->lang->line('megabyte_abbr');
		}
		elseif ($num >= 1000) 
		{
			$decimals = 0; // decimals are not meaningful enough at this point
 
			$num = round($num / 1024, 1);
			$unit = $CI->lang->line('kilobyte_abbr');
		}
		else
		{
			$unit = $CI->lang->line('bytes');
			return number_format($num).' '.$unit;
		}
 
		$str = number_format($num, $decimals).' '.$unit;
 
		$str = str_replace(' ', '&nbsp;', $str);
		return $str;
	}
}
 
/**
 * tells weather given path is file
 */
function csfile_isFile( $path )
{
	return is_file( BASE_DIR.$path );
}

/**
 * tells weather given path is directory
 */
function csfile_isDir( $path )
{
	return is_dir( BASE_DIR.$path );
}

/**
 * check file exists: abstraction function
 */
function csfile_isFileExists( $path )
{
	return file_exists( BASE_DIR.$path );
}

/**
 * check directory exists: abstraction function
 */
function csfile_isDirExists( $path )
{
	return file_exists( BASE_DIR.$path );
}

/**
 * make dir: abstraction function
 */
function csfile_mkDirectory( $path )
{
	return mkdir( BASE_DIR.$path );
}

/**
 * copy file: abstraction function
 */
function csfile_copyFile( $source, $dest )
{
	return copy( BASE_DIR.$source, BASE_DIR.$dest );
}

/**
 * copy dir: abstraction function
 */
function csfile_copyDir( $source, $dest )
{
	$dir = opendir( $source );
	while( false !== ( $file = readdir( $dir ) ) )
	{
		if ( ( $file != '.' ) && ( $file != '..' ) )
		{
			if( is_dir( $source . '/' . $file ) )
			{
				copyDir($source . '/' . $file,$dest . '/' . $file);
			}
			else
			{
				copy( $source . '/' . $file, $dest . '/' . $file );
			}
		}
	}
	closedir($dir);
}

/**
 *
 */
function csfile_fileWrite( $filename, $content )
{
	$fp = fopen( BASE_DIR . $filename, "w") or die("Unable to open file!");
	fwrite( $fp, $content);
	fclose( $fp );
}

/**
 *
 */
function csfile_fileRead( $filename )
{
	return file_get_contents( BASE_DIR.$filename );
}

/**
 *
 */
function csfile_fileLines( $filename )
{
	return file( BASE_DIR.$filename );
}


/**
 * @abstract
 */
function csfile_convertPdfToText( $file_pdf, $file_text )
{
	$command = "pdftotext -layout ".$file_pdf." ".$file_text;
	exec( $command );
}

/**
 * deletes the file
 */
function csfile_imfile_remove( $filename )
{
	return unlink( BASE_DIR.$filename );
}

/**
 * remove particular directory from path, like "u/" directory since FTP conn made to asset directory directly
 * e.g. @param $dirToRemove= "u/" remove that and replace with @param $replace optional default to ""(empty)
 */
function csfile_removeDirFromPath( $path, $dirToRemove, $replace="" )
{
	return str_replace($dirToRemove, $replace, $path);
}

/**
 * Sync language files when user switches to other language
 *
 * @access	public
 * @param	string	$src_file the source language file to sync from
 * @param	string	$target_file the target language file to sync to
 * @return	void
 */
function csfile_lang_fileAllLbels( $src_file, $LANGsession )
{
	$labelA = array(); 
	$src_contentArr = csfile_fileLines( $src_file );
	$temp_type = "";
	$temp_val = ""; 
	
	$keyArr = array_keys( $src_contentArr );
	$size = sizeof( $keyArr );
	
	$cnt = 0;
	
	for ( $i=0; $i<$size; $i++ )
	{
		if( strpos( $src_contentArr[ $keyArr[$i] ], "==") !== FALSE )
		{
			if( strpos( $src_contentArr[ $keyArr[$i] ], "== '") !== FALSE )
			{
				if( strpos( $src_contentArr[ $keyArr[$i + 2] ], "return '") !== FALSE )
				{ 
					$labelA[ $LANGsession . "_" . fetchSubStr( $src_contentArr[ $keyArr[$i] ], "== '", "'") ] = fetchSubStr( $src_contentArr[ $keyArr[$i + 2] ], "return '", "'");
				}
				else 
				{
					$labelA[ $LANGsession . "_" . fetchSubStr( $src_contentArr[ $keyArr[$i] ], "== '", "'") ] = fetchSubStr( $src_contentArr[ $keyArr[$i + 2] ], "return \"", "\"");
				}
			}
			else if( strpos( $src_contentArr[ $keyArr[$i] ], "== \"") !== FALSE )
			{
				if( strpos( $src_contentArr[ $keyArr[$i + 2] ], "return '") !== FALSE )
				{
					$labelA[ $LANGsession . "_" . fetchSubStr( $src_contentArr[ $keyArr[$i] ], "== \"", "\"") ] = fetchSubStr( $src_contentArr[ $keyArr[$i + 2] ], "return '", "'");
				}
				else 
				{
					$labelA[ $LANGsession . "_" . fetchSubStr( $src_contentArr[ $keyArr[$i] ], "== \"", "\"") ] = fetchSubStr( $src_contentArr[ $keyArr[$i + 2] ], "return \"", "\"");
				}
			}
			
			$i = $i + 3;
		}		
		
	}
	
	return $labelA; 
}

/**
 * return file name with extension from path provided
 */
function csfile_fileName( $path )
{
	return basename( $path );
}

/**
 * check file exists: wrapper function
 */
function csfile_isFileExistsByExtType( $path, $filetype )
{
	$allowed_types = array();
	if($filetype == 'image')
	{	$allowed_types = array( "gif", "jpg", "png", "jpeg", "JPEG" ); 	}
	
	foreach ($allowed_types as $k=>$ar)
	{
		if( file_exists( BASE_DIR.$path.".".$ar ) )
		{
			return $ar;
		}
	}
	
	return FALSE;
}

/**
 * uploads product image folder
 * Changed on 24-03-2015 to suppport both single image file upload and zip file upload
 */
function uploadFolder( $uploadFile, $filetype, $folder )
{
	$image = uploadFile( $uploadFile, $filetype, $folder ); //input file, type, folder
	if(@$image['error'])
	{
		setFlashMessage('error',$image['error']);
		$path = $image['path'];
		@unlink('./'.$path);
	}
	
	$path = $image['path'];
	
	if( $filetype == "zip" )
	{
		@unlink('./'.$path); //delete zip file
		return substr($path,0,strrpos($path,".")) ;
	}
	else
	{
		return $path;
	}
}
/* End of file MY_file_helper.php */
/* Location: ./system/application/helpers/MY_file_helper.php */