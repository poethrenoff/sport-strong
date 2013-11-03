<?
	class metadata
	{
		public static $tables = array(
			'text' => array(
				'title' => 'Тексты',
				'class' => 'content',
				'fields' => array(
					'text_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'text_tag' => array( 'title' => 'Метка', 'type' => 'string', 'show' => 1, 'errors' => 'require' ),
					'text_title' => array( 'title' => 'Заголовок', 'type' => 'string', 'show' => 1, 'main' => 1, 'sort' => 'asc', 'errors' => 'require' ),
					'text_content' => array( 'title' => 'Содержимое', 'type' => 'text', 'textarea' => 'editor', 'errors' => 'require' ),
					'text_active' => array( 'title' => 'Видимость', 'type' => 'active' )
				)
			),
			
			'article' => array(
				'title' => 'Статьи',
				'class' => 'content',
				'fields' => array(
					'article_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'article_title' => array( 'title' => 'Заголовок', 'type' => 'string', 'show' => 1, 'main' => 1, 'sort' => 'asc', 'errors' => 'require' ),
					'article_announce' => array( 'title' => 'Анонс', 'type' => 'text', 'textarea' => 'editor', 'errors' => 'require' ),
					'article_content' => array( 'title' => 'Содержимое', 'type' => 'text', 'textarea' => 'editor', 'errors' => 'require' ),
					'article_catalogue' => array( 'title' => 'Категория', 'type' => 'table', 'table' => 'catalogue' ),
					'article_active' => array( 'title' => 'Видимость', 'type' => 'active' )
				)
			),
			
			'news' => array(
				'title' => 'Новости',
				'class' => 'content',
				'fields' => array(
					'news_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'news_title' => array( 'title' => 'Заголовок', 'type' => 'string', 'show' => 1, 'main' => 1, 'sort' => 'asc', 'errors' => 'require' ),
					'news_content' => array( 'title' => 'Текст', 'type' => 'text', 'textarea' => 'editor', 'errors' => 'require' ),
					'news_date' => array( 'title' => 'Дата', 'type' => 'date', 'show' => 1, 'sort' => 'desc', 'errors' => 'require' ),
					'news_active' => array( 'title' => 'Видимость', 'type' => 'active' )
				)
			),
			
			'meta' => array(
				'title' => 'Метатеги',
				'fields' => array(
					'meta_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'meta_module' => array( 'title' => 'Модуль', 'type' => 'select', 'show' => 1, 'filter' => 1, 'values' => array(
							array( 'value' => 'cart', 'title' => 'Корзина' ),
							array( 'value' => 'catalogue', 'title' => 'Каталог' ),
							array( 'value' => 'order', 'title' => 'Заказ' ),
							array( 'value' => 'price', 'title' => 'Прайс-лист' ),
							array( 'value' => 'product', 'title' => 'Товары' ),
							array( 'value' => 'search', 'title' => 'Поиск' ),
							array( 'value' => 'text', 'title' => 'Тексты' ) ), 'errors' => 'alpha' ),
					'meta_content' => array( 'title' => 'Идентификатор', 'type' => 'string', 'show' => 1, 'errors' => 'int', 'group' => array( 'meta_module' ) ),
					'meta_title' => array( 'title' => 'Заголовок', 'type' => 'text', 'main' => 1 ),
					'meta_keywords' => array( 'title' => 'Ключевые слова', 'type' => 'text' ),
					'meta_description' => array( 'title' => 'Описание', 'type' => 'text' ),
					'page_bottom' => array( 'title' => 'SEO-текст', 'type' => 'text' ),
				)
			),
			
			'catalogue' => array(
				'title' => 'Каталог',
				'class' => 'catalogue',
				'fields' => array(
					'catalogue_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'catalogue_parent' => array( 'title' => 'Родительский раздел', 'type' => 'parent' ),
					'catalogue_title' => array( 'title' => 'Название', 'type' => 'string', 'show' => 1, 'main' => 1, 'errors' => 'require' ),
					'catalogue_short_title' => array( 'title' => 'Краткое название', 'type' => 'string', 'errors' => 'require' ),
					'catalogue_url' => array( 'title' => 'ЧПУ', 'type' => 'string', 'errors' => 'require', 'group' => array(), 'no_add' => 1 ),
					'catalogue_description' => array( 'title' => 'Описание', 'type' => 'text', 'textarea' => 'editor' ),
					'catalogue_description_top' => array( 'title' => 'Описание (сверху)', 'type' => 'text', 'textarea' => 'editor' ),
                    'catalogue_description_bottom' => array( 'title' => 'Описание (снизу)', 'type' => 'text', 'textarea' => 'editor' ),
					'catalogue_picture' => array( 'title' => 'Изображение', 'type' => 'image', 'upload_dir' => '/image/catalogue/' ),
					'catalogue_export' => array( 'title' => 'Экспортировать в Яндекс', 'type' => 'boolean' ),
					'catalogue_use_url' => array( 'title' => 'ЧПУ для товаров', 'type' => 'boolean' ),
					'catalogue_order' => array( 'title' => 'Порядок', 'type' => 'order', 'group' => array( 'catalogue_parent' ) ),
					'catalogue_active' => array( 'title' => 'Видимость', 'type' => 'active' )
				),
				'links' => array(
					'product' => array( 'table' => 'product', 'field' => 'product_catalogue' ),
				)
			),
			
			'brand' => array(
				'title' => 'Бренды',
				'class' => 'brand',
				'fields' => array(
					'brand_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'brand_title' => array( 'title' => 'Название', 'type' => 'string', 'show' => 1, 'main' => 1, 'sort' => 'asc', 'errors' => 'require' ),
					'brand_url' => array( 'title' => 'ЧПУ', 'type' => 'string', 'errors' => 'require', 'group' => array(), 'no_add' => 1 ),
					'brand_country' => array( 'title' => 'Страна', 'type' => 'string', 'show' => 1 ),
					'brand_description' => array( 'title' => 'Описание', 'type' => 'text', 'textarea' => 'editor' ),
					'brand_picture' => array( 'title' => 'Изображение', 'type' => 'image', 'upload_dir' => '/image/brand/' ),
				),
				'links' => array(
					'product' => array( 'table' => 'product', 'field' => 'product_brand' )
				)
			),
			
			'product' => array(
				'title' => 'Товары',
				'class' => 'product',
				'fields' => array(
					'product_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'product_catalogue' => array( 'title' => 'Категория', 'type' => 'table', 'table' => 'catalogue', 'errors' => 'require' ),
					'product_brand' => array( 'title' => 'Производитель', 'type' => 'table', 'table' => 'brand', 'errors' => 'require' ),
					'product_type' => array( 'title' => 'Тип товара', 'type' => 'table', 'table' => 'product_type', 'errors' => 'require' ),
					'product_title' => array( 'title' => 'Название', 'type' => 'string', 'main' => 1, 'errors' => 'require' ),
					'product_url' => array( 'title' => 'ЧПУ', 'type' => 'string', 'errors' => 'require', 'group' => array(), 'no_add' => 1 ),
					'product_description_short' => array( 'title' => 'Краткое описание', 'type' => 'text', 'textarea' => 'editor' ),
					'product_description' => array( 'title' => 'Описание', 'type' => 'text', 'textarea' => 'editor' ),
					'product_description_list' => array( 'title' => 'Описание для списка', 'type' => 'text', 'textarea' => 'editor' ),
					'product_preview' => array( 'title' => 'Описание для экспорта', 'type' => 'text' ),
					'product_price' => array( 'title' => 'Цена', 'type' => 'float', 'show' => 1, 'errors' => 'require' ),
					'product_price_old' => array( 'title' => 'Цена (старая)', 'type' => 'float' ),
					'product_picture_big' => array( 'title' => 'Большое изображение', 'type' => 'image', 'upload_dir' => '/image/product/original/' ),
					'product_picture_middle' => array( 'title' => 'Среднее изображение', 'type' => 'image', 'upload_dir' => '/image/product/' ),
					'product_picture_small' => array( 'title' => 'Маленькое изображение', 'type' => 'image', 'upload_dir' => '/image/product/preview/' ),
					'product_available' => array( 'title' => 'Экспортировать в Яндекс', 'type' => 'boolean' ),
					'product_order' => array( 'title' => 'Порядок', 'type' => 'order', 'group' => array( 'product_catalogue' ) ),
					'product_active' => array( 'title' => 'Видимость', 'type' => 'active' )
				),
				'links' => array(
					'picture' => array( 'title' => 'Картинки', 'table' => 'picture', 'field' => 'picture_product', 'ondelete' => 'cascade' ),
					'file' => array( 'title' => 'Файлы',  'table' => 'file', 'field' => 'file_product', 'ondelete' => 'cascade' ),
				),
				'relations' => array(
					'marker' => array( 'secondary_table' => 'marker', 'relation_table' => 'product_marker',
						'primary_field' => 'product_id', 'secondary_field' => 'marker_id', 'title' => 'Маркеры' ),
					'like' => array( 'secondary_table' => 'product', 'relation_table' => 'product_like',
						'primary_field' => 'product_id', 'secondary_field' => 'like_product_id', 'title' => 'Похожие' ),
				),
			),
			
			/*
			 *	Таблица "Похожие товары"
			 */
			'product_like' => array(
				'title' => 'Похожие товары',
				'internal' => true,
				'fields' => array(
					'product_id' => array( 'title' => 'Товар', 'type' => 'table', 'table' => 'product', 'errors' => 'require' ),
					'like_product_id' => array( 'title' => 'Товар', 'type' => 'table', 'table' => 'product', 'errors' => 'require' ),
				),
			),
			
			'picture' => array(
				'title' => 'Дополнительные изображения',
				'class' => 'picture',
				'fields' => array(
					'picture_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'picture_product' => array( 'title' => 'Товар', 'type' => 'table', 'table' => 'product', 'errors' => 'require' ),
					'picture_title' => array( 'title' => 'Название', 'type' => 'string', 'show' => 1, 'main' => 1, 'sort' => 'asc', 'errors' => 'require' ),
					'picture_name_big' => array( 'title' => 'Большое изображение', 'type' => 'image', 'upload_dir' => '/image/product/extra/' ),
					'picture_name_small' => array( 'title' => 'Маленькое изображение', 'type' => 'image', 'upload_dir' => '/image/product/extra/preview/' ),
					'picture_active' => array( 'title' => 'Видимость', 'type' => 'active' )
				)
			),
			
			'file' => array(
				'title' => 'Дополнительные файлы',
				'fields' => array(
					'file_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'file_product' => array( 'title' => 'Товар', 'type' => 'table', 'table' => 'product', 'errors' => 'require' ),
					'file_title' => array( 'title' => 'Название', 'type' => 'string', 'show' => 1, 'main' => 1, 'sort' => 'asc', 'errors' => 'require' ),
					'file_name' => array( 'title' => 'Файл', 'type' => 'file', 'show' => 1, 'upload_dir' => '/file/product/', 'errors' => 'require' ),
					'file_active' => array( 'title' => 'Видимость', 'type' => 'active' )
				)
			),
			
			'product_type' => array(
				'title' => 'Типы товаров',
				'fields' => array(
					'product_type_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'product_type_title' => array( 'title' => 'Название', 'type' => 'string', 'show' => 1, 'main' => 1, 'sort' => 'asc', 'errors' => 'require' )
				),
				'links' => array(
					'product' => array( 'table' => 'product', 'field' => 'product_type' ),
					'property' => array( 'table' => 'property', 'field' => 'property_type' ),
				)
			),
			
			/*
			 *	Таблица "Маркеры"
			 */
			'marker' => array(
				'title' => 'Маркеры',
				'fields' => array(
					'marker_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'marker_title' => array( 'title' => 'Название', 'type' => 'string', 'show' => 1, 'main' => 1, 'sort' => 'asc', 'errors' => 'require' ),
					'marker_type' => array( 'title' => 'Системное имя', 'type' => 'string', 'show' => 1, 'errors' => 'require' ),
					'marker_picture' => array( 'title' => 'Картинка', 'type' => 'image', 'upload_dir' => '/image/marker/' ),
				),
				'relations' => array(
					'product' => array( 'secondary_table' => 'product', 'relation_table' => 'product_marker',
						'primary_field' => 'marker_id', 'secondary_field' => 'product_id', 'title' => 'Товары' ),
				),
			),
			
			/*
			 *	Таблица "Связь маркеров с товарами"
			 */
			'product_marker' => array(
				'title' => 'Связь маркеров с товарами',
				'internal' => true,
				'fields' => array(
					'product_id' => array( 'title' => 'Товар', 'type' => 'table', 'table' => 'product', 'errors' => 'require' ),
					'marker_id' => array( 'title' => 'Маркер', 'type' => 'table', 'table' => 'marker', 'errors' => 'require' ),
				),
			),
			
			'property' => array(
				'title' => 'Свойства',
				'class' => 'property',
				'fields' => array(
					'property_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'property_type' => array( 'title' => 'Тип товара', 'type' => 'table', 'table' => 'product_type', 'errors' => 'require' ),
					'property_title' => array( 'title' => 'Название', 'type' => 'string', 'show' => 1, 'main' => 1, 'errors' => 'require' ),
					'property_kind' => array( 'title' => 'Тип свойства', 'type' => 'select', 'show' => 1, 'filter' => 1, 'values' => array(
						array( 'value' => 'string', 'title' => 'Строка' ), 
						array( 'value' => 'number', 'title'  => 'Число' ),
						array( 'value' => 'boolean', 'title'  => 'Флаг' ),
						array( 'value' => 'select', 'title'  => 'Список' ) ), 'errors' => 'require' ),
					'property_unit' => array( 'title' => 'Единица измерения', 'type' => 'string' ),
					'property_order' => array( 'title' => 'Порядок', 'type' => 'order', 'group' => array( 'property_type' ) ),
					'property_active' => array( 'title' => 'Видимость', 'type' => 'active' )
				),
				'links' => array(
					'property_value' => array( 'table' => 'value', 'field' => 'value_property', 'show' => array( 'property_kind' => array( 'select' ) ), 'ondelete' => 'cascade' )
				)
			),
			
			'value' => array(
				'title' => 'Значения свойств',
				'class' => 'value',
				'fields' => array(
					'value_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'value_property' => array( 'title' => 'Свойство', 'type' => 'table', 'table' => 'property', 'errors' => 'require' ),
					'value_title' => array( 'title' => 'Название', 'type' => 'string', 'show' => 1, 'main' => 1, 'sort' => 'asc', 'errors' => 'require' )
				)
			),
			
			'product_property' => array(
				'title' => 'Свойства товара',
				'internal' => 1,
				'fields' => array(
					'product' => array( 'title' => 'Товар', 'type' => 'table', 'table' => 'product', 'errors' => 'require' ),
					'property' => array( 'title' => 'Свойство', 'type' => 'table', 'table' => 'property', 'errors' => 'require' ),
					'value' => array( 'title' => 'Значение', 'type' => 'string', 'errors' => 'require' )
				)
			),
			
			'orders' => array(
				'title' => 'Заказы',
				'fields' => array(
					'order_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'order_client_name' => array( 'title' => 'Клиент', 'type' => 'string', 'main' => 1, 'errors' => 'require' ),
					'order_client_email' => array( 'title' => 'Email', 'type' => 'string', 'errors' => 'email' ),
					'order_client_phone' => array( 'title' => 'Телефон', 'type' => 'string' ),
					'order_client_address' => array( 'title' => 'Адрес', 'type' => 'text' ),
					'order_client_comment' => array( 'title' => 'Комментарий', 'type' => 'text' ),
					'order_date' => array( 'title' => 'Дата', 'type' => 'datetime', 'show' => 1, 'sort' => 'desc', 'errors' => 'require' ),
					'order_sum' => array( 'title' => 'Сумма', 'type' => 'float', 'show' => 1, 'errors' => 'require' ),
					'order_status' => array( 'title' => 'Статус заказа', 'type' => 'select', 'show' => 1, 'filter' => 1, 'values' => array(
						array( 'value' => 'new', 'title' => 'Новый' ), 
						array( 'value' => 'fast', 'title'  => 'Быстрый' ),
						array( 'value' => 'accept', 'title'  => 'В работе' ),
						array( 'value' => 'cancel', 'title'  => 'Отклонен' ),
						array( 'value' => 'close', 'title'  => 'Доставлен' ) ), 'errors' => 'require' ),
				),
				'links' => array(
					'item' => array( 'table' => 'item', 'field' => 'item_order', 'ondelete' => 'cascade' ),
				)
			),
			
			'item' => array(
				'title' => 'Позиции заказов',
				'fields' => array(
					'item_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'item_order' => array( 'title' => 'Заказ', 'type' => 'table', 'table' => 'orders', 'errors' => 'require' ),
					'order_product' => array( 'title' => 'Товар', 'type' => 'string', 'main' => 1, 'errors' => 'require' ),
					'order_price' => array( 'title' => 'Цена', 'type' => 'float', 'show' => 1, 'errors' => 'require' ),
					'order_count' => array( 'title' => 'Количество', 'type' => 'int', 'show' => 1, 'errors' => 'require' )
				)
			),
			
			'preference' => array(
				'title' => 'Настройки',
				'fields' => array(
					'preference_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'preference_title' => array( 'title' => 'Название', 'type' => 'string', 'show' => 1, 'main' => 1, 'errors' => 'require' ),
					'preference_name' => array( 'title' => 'Имя', 'type' => 'string', 'show' => 1, 'errors' => 'require|alpha', 'group' => array() ),
					'preference_value' => array( 'title' => 'Значение', 'type' => 'string', 'show' => 1 ),
				)
			),
			
			'system_map' => array(
				'title' => 'Системные разделы',
				'fields' => array(
					'system_map_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'system_map_parent' => array( 'title' => 'Родительский раздел', 'type' => 'parent' ),
					'system_map_title' => array( 'title' => 'Название', 'type' => 'string', 'show' => 1, 'main' => 1, 'errors' => 'require' ),
					'system_map_object' => array( 'title' => 'Объект', 'type' => 'string', 'show' => 1 ),
					'system_map_order' => array( 'title' => 'Порядок', 'type' => 'order', 'group' => array( 'system_map_parent' ) ),
					'system_map_active' => array( 'title' => 'Видимость', 'type' => 'active' )
				)
			),
			
			'question' => array(
				'title' => 'Вопросы',
				'fields' => array(
					'question_id' => array( 'title' => 'Идентификатор', 'type' => 'pk' ),
					'question_author' => array( 'title' => 'Автор', 'type' => 'string', 'errors' => 'require' ),
					'question_email' => array( 'title' => 'Email', 'type' => 'string', 'errors' => 'email' ),
					'question_content' => array( 'title' => 'Вопрос', 'type' => 'text', 'show' => 1, 'main' => 1, 'errors' => 'require' ),
					'question_answer' => array( 'title' => 'Ответ', 'type' => 'text', 'textarea' => 'editor' ),
					'question_date' => array( 'title' => 'Дата', 'type' => 'datetime', 'show' => 1, 'sort' => 'desc', 'errors' => 'require' ),
					'question_active' => array( 'title' => 'Активность', 'type' => 'active' )
				)
			)
		);
		
		public static $tools = array(
			'import' => array(
				'title' => 'Импорт цен',
				'class' => 'import'
			),
			
			'export' => array(
				'title' => 'Экспорт цен',
				'class' => 'export'
			),
			
			'fm' => array(
				'title' => 'Файл-менеджер',
				'class' => 'fm'
			),
			
			'meta_import' => array(
				'title' => 'Импорт метатегов',
				'class' => 'meta_import'
			),
			
			'meta_export' => array(
				'title' => 'Экспорт метатегов',
				'class' => 'meta_export'
			),
			
		);
	}
?>
