<?
	class captcha
	{
		/**
		 * Генерация кода для картинки, сохранение его в сессии
		 */
		public static function generate( $value_length = 4 )
		{
			$captcha_value = mt_rand( pow( 10, $value_length - 1 ), pow( 10, $value_length ) - 1 );
			
			$captcha_id = md5( uniqid() );

			if ( !isset( $_SESSION['CAPTCHA'] ) )
				$_SESSION['CAPTCHA'] = array();

			$_SESSION['CAPTCHA'][$captcha_id] = $captcha_value;
			
			return $captcha_id;
		}
		
		/**
		 * Проверка кода на картинке
		 */
		public static function check( $captcha_id, $captcha_value )
		{
			$check = isset( $_SESSION['CAPTCHA'][$captcha_id] ) && 
				strtolower( $_SESSION['CAPTCHA'][$captcha_id] ) == strtolower( $captcha_value );
			
			unset( $_SESSION['CAPTCHA'][$captcha_id] );
			
			return $check;
		}
		
		/**
		 * Вывод изображения в браузер
		 */
		public static function display( $captcha_value )
		{
			// Размеры изображения
			$image_width = 60;
			$image_height = 18;
			
			// Параметры зашумления
			$koef = 3;
			$lines_count = 50;
			$quality = 75;
			
			// создаем изображение
			$im = imagecreate( $image_width, $image_height );
			
			// Выделяем цвет фона
			imagecolorallocate( $im, rand( 200, 255 ), rand( 200, 255 ), rand( 200, 255 ) );
			
			$code_length = strlen( $captcha_value );
			for ( $i = 0; $i < $code_length; $i++ )
				imagestring( $im, 5, $i * $image_width / $code_length + rand( 0, $image_width / $code_length - 10 ), rand( 0, $image_height - 12 ) - 2, substr( $captcha_value, $i, 1 ), imagecolorallocate( $im, rand( 0, 128 ), rand( 0, 128 ), rand( 0, 128 ) ) );
			
			// Создаем новое изображение, увеличенного размера
			$im1 = imagecreatetruecolor( $image_width * $koef, $image_height * $koef );
			
			// Копируем изображение с изменением размеров в большую сторону
			imagecopyresampled( $im1, $im, 0, 0, 0, 0, $image_width * $koef, $image_height * $koef, $image_width, $image_height );
			
			// Выводим несколько случайных линий поверх символов
			for ( $i = 0; $i < $lines_count; $i++ )
				imageline( $im1, rand( 0, $image_width * $koef - 20 ), rand( 0, $image_height * $koef - 10 ), rand( 0, $image_width * $koef + 20 ), rand( 0, $image_height * $koef + 10 ), imagecolorallocate( $im1, rand( 128, 200 ), rand( 128, 200 ), rand( 128, 200 ) ) );
			
			// Создаем новое изображение, нормального размера
			$im = imagecreatetruecolor( $image_width, $image_height );
			
			// Копируем изображение с изменением размеров в меньшую сторону
			imagecopyresampled( $im, $im1, 0, 0, 0, 0, $image_width, $image_height, $image_width * $koef, $image_height * $koef );
			
			header( 'Content-type: image/jpeg' );
			
			imagejpeg( $im, null, $quality );
		}
	}
?>
