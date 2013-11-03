			<li id="menu-brands">Бренды
				<div class="brands_menu">
					<ul>
						{foreach from=$brand_list_1 item=item name=mas_1}
							<li><a href="/brand/{$item.brand_url}/">{$item.brand_title}</a></li>
						{/foreach}
					</ul>
					
					<ul>
						{foreach from=$brand_list_2 item=item2 name=mas_2}
							<li><a href="/brand/{$item2.brand_url}/">{$item2.brand_title}</a></li>
						{/foreach}
					</ul>
					
					<ul>
						{foreach from=$brand_list_3 item=item3 name=mas_3}
							<li><a href="/brand/{$item3.brand_url}/">{$item3.brand_title}</a></li>
						{/foreach}
					</ul>
					<ul>
						{foreach from=$brand_list_4 item=item4 name=mas_4}
							<li><a href="/brand/{$item4.brand_url}/">{$item4.brand_title}</a></li>
						{/foreach}
					</ul>
					<div class="clear"></div>
				</div>
			</li>
