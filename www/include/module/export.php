<?
	class export extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array ();
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			$catalogue_query = '
				select catalogue_id, catalogue_parent, catalogue_title
				from catalogue where catalogue_export = 1 and catalogue_active = 1
				order by catalogue_id';
			$catalogue_list = db::select_all( $catalogue_query );
			
			$product_query = '
				select product.*, brand.brand_title
                from product
					inner join brand on brand.brand_id = product.product_brand
					inner join catalogue on catalogue.catalogue_id = product.product_catalogue
				where product_active = 1 and product_available = 1 and
					catalogue_export = 1 and catalogue_active = 1
				order by product_id';
			$product_list = db::select_all( $product_query );
			
			$this -> tpl -> assign( 'catalogue_list', $catalogue_list );
			$this -> tpl -> assign( 'product_list', $product_list );
			
			$this -> content = $this -> tpl -> fetch( 'module/export/export_yandex.tpl' );
		}
	}
?>
