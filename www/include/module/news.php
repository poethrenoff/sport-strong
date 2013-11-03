<?
	class news extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array( 'mode' => 'news', 'items_per_page' => 10 );
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			$news_id = init_string( 'news_id' );
			
			if ( $news_id && ( $this -> params['mode'] == 'news' ) )
				$this -> get_item( $news_id );
			else
				$this -> get_list();
		}
		
		// Вывод списка новостей
		protected function get_list()
		{
			$items_per_page = max( intval( $this -> params['items_per_page'] ), 1 );
			
			$news_query = 'select count(*) as _news_count from news where news_active = 1';
			$news_count = db::select( $news_query );
			
			if ( $news_count = $news_count['_news_count'] )
			{
				$first_page = 0; $last_page = max( floor( ( $news_count - 1 ) / $items_per_page ), 0 );
				$page = min( max( intval( init_string( 'page' ) ), $first_page ), $last_page );
				
				if ( $this -> params['mode'] == 'main' ) $page = 0;
				
				$limit = $items_per_page; $offset = $items_per_page * $page;
				
				$news_query = 'select * from news where news_active = 1
					order by news_date desc limit ' . $limit . ' offset ' . $offset;
				$news_list = db::select_all( $news_query );
				
				foreach ( $news_list as $news_index => $news_item )
				{
					$news_list[$news_index]['news_date'] = get_date( $news_item['news_date'], 'short' );
					$news_list[$news_index]['news_url'] =
						get_url( array( 'news_id' => $news_item['news_id'] ), array(), '/news.php' );
				}
				
				$this -> tpl -> assign( 'news_list', $news_list );
				
				if ( $news_count > $items_per_page )
					$this -> tpl -> assign( 'pages', pages( $last_page + 1, $page ) );
			}
			
			if($this -> params['mode'] == 'main')
            $news_template =  'news_list_short.tpl';
            elseif($this -> params['mode'] == 'map')
            $news_template =  'news_list_map.tpl';
            else 
            $news_template =  'news_list.tpl';
			$this -> content = $this -> tpl -> fetch( 'module/news/' . $news_template );
			
			
			$news_path = array();
			$news_path[] = array( 'title' => 'Новости' );
			
			$this -> path = array_merge( $this -> path, $news_path );
			$this -> meta = $this -> read_meta( 'news' );
		}
		
		// Вывод карточки новости
		protected function get_item( $news_id )
		{
			$news_query = 'select * from news where news_id = :news_id and news_active = 1';
			$news_item = db::select( $news_query, array( 'news_id' => $news_id ) );
			
			if ( !$news_item ) return false;
			
			$news_path = array();
			$news_path[] = array( 'title' => 'Новости', 'url' => get_url( array(), array(), '/news.php' ) );
			$news_path[] = array( 'title' => $news_item['news_title'] );
			
			$news_item['news_content'] = $news_item['news_content'];
			$news_item['news_date'] = get_date( $news_item['news_date'], 'short' );
			
			$this -> tpl -> assign( $news_item );
			
			$this -> content = $this -> tpl -> fetch( 'module/news/news_item.tpl' );
			
			$this -> path = array_merge( $this -> path, $news_path );
			$this -> meta = $this -> read_meta( 'news' );
		}
	}
?>
