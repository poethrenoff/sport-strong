<?
	class upload
	{
		public static function upload_file( $file_descr, $upload_path, $only_image = false )
		{
			umask( 0 );
			
			$name = $file_descr['name']; $tmp_name = $file_descr['tmp_name'];
			$real_upload_path = $_SERVER['DOCUMENT_ROOT'] . $upload_path;
			
			if ( $file_descr['error'] != UPLOAD_ERR_OK )
				throw new Exception( 'Ошибка. Невозможно закачать файл "' . $name . '".' );
			
			if ( $only_image && ( getImageSize( $tmp_name ) === false ) )
				throw new Exception( 'Ошибка. Файл "' . $name . '" не является изображением.' );
			
			if( !file_exists( $real_upload_path ) )
				if ( !( @mkdir( $real_upload_path , 0777, true ) ) )
					throw new Exception( 'Ошибка. Невозможно создать каталог "' . $real_upload_path . '".' );
			
			$name = self::get_unique_file_name( $real_upload_path, self::get_translit_file_name( $name ) );
			
			if ( !( @move_uploaded_file( $tmp_name, $real_upload_path . $name ) &&
					@chmod( $real_upload_path . $name, 0777 ) ) )
				throw new Exception( 'Ошибка. Невозможно закачать файл "' . $real_upload_path . $name . '".' );
			
			return $upload_path . $name;
		}
		
		public static function get_unique_file_name( $path, $name )
		{
			$point_index = strrpos( $name, '.' );
			$base = ( $point_index !== false ) ? substr( $name, 0, $point_index ) : $name;
			$ext = ( $point_index !== false ) ? substr( $name, $point_index, strlen( $name ) ) : '';
			
			$new_name = $name; $n = 0;
			while ( file_exists( $path . '/' . $new_name ) )
				$new_name = $base . '_' . ( ++$n ) . $ext;
			return $new_name;
		}
		
		public static function get_translit_file_name( $name )
		{
			return preg_replace( '/[^\w\.\[\]-]/', '', strtr( strtolower( $name ), self::$translit ) );
		}
		
		public static $translit = array(
			' ' => '_', 'ё' => 'yo', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ж' => 'zh',
			'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p',
			'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh',
			'щ' => 'shch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'u', 'я' => 'ya', '№' => 'N' );
		
		public static function resize_image( $original_image, $upload_path, $maxwidth = 120, $maxheight = 150 )
		{
			$real_original_image = $_SERVER['DOCUMENT_ROOT'] . $original_image;
			
			if ( $upload_path )
			{
				$real_upload_path = $_SERVER['DOCUMENT_ROOT'] . $upload_path;
				
				if( !file_exists( $real_upload_path ) )
					if ( !( @mkdir( $real_upload_path , 0777, true ) ) )
						throw new Exception( 'Ошибка. Невозможно создать каталог "' . $real_upload_path . '".' );
				
				$image_name = self::get_unique_file_name( $real_upload_path,
					self::get_translit_file_name( basename( $real_original_image ) ) );
				
				$real_preview_image = $real_upload_path . $image_name;
				
				$preview_image = $upload_path . $image_name;
			}
			else
			{
				$real_preview_image = $real_original_image;
				
				$preview_image = $original_image;
			}
			
			if ( ( $original_image_info = getImageSize( $real_original_image ) ) === false )
				throw new Exception( 'Ошибка. Файл "' . $real_original_image . '" не является изображением.' );
			
			list( $width, $height, $type, $attr ) = $original_image_info;
			
			switch ( $type )
			{
				case 1: $si = @imageCreateFromGif( $real_original_image ); break;
				case 2: $si = @imageCreateFromJpeg( $real_original_image ); break;
				case 3: $si = @imageCreateFromPng( $real_original_image ); break;
				default:
					throw new Exception( 'Ошибка. Тип изображения "' . $real_original_image . '" не поддерживается.' );
			}
			
			$nwidth = $width; $nheight = $height;
			
			if ( $height / $maxheight > $width / $maxwidth )
			{
				if ( $height > $maxheight )
				{
					$nheight = $maxheight; $nwidth = round( $width * $maxheight / $height );
				}
			}
			else
			{
				if ( $width > $maxwidth )
				{
					$nwidth = $maxwidth; $nheight = round( $height * $maxwidth / $width );
				}
			}
			
			$di = imageCreateTrueColor( $nwidth, $nheight );
			
			if ( $type == 1 )
			{
				imagecolortransparent($di, imagecolorat($di, 0, 0));
			}
			
			if ( $type == 3 )
			{
				imagesavealpha($di, true);
				imagealphablending($di, false);
			}
			
			imageCopyResampled( $di, $si, 0, 0, 0, 0, $nwidth, $nheight, $width, $height );
			
			switch ( $type )
			{
				case 1: @imageGif( $di, $real_preview_image ); break;
				case 2: @imageJpeg( $di, $real_preview_image ); break;
				case 3: @imagePng( $di, $real_preview_image ); break;
			}
			
			imageDestroy( $si ); imageDestroy( $di );
			
			if ( !( file_exists( $real_preview_image ) && @chmod( $real_preview_image, 0777 ) ) )
				throw new Exception( 'Ошибка. Невозможно создать файл "' . $real_preview_image . '".' );
			
			return $preview_image;
		}
	}
?>
