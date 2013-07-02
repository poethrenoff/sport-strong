/*
	Календарь
	
	Пример добавления календаря на страницу
	
	<link rel="stylesheet" type="text/css" href="calendar.css"/>
	<script type="text/javascript" src="calendar.js"></script>
	...
	<form action="..." method="..." id="form_name">
		<input type="input" value="01.01.1970 00:00:00" name="field_name"/>
		<a href="" onclick="Calendar.show( document.forms['form_name']['field_name'], this, 'full' ); return false">...</a>
	</form>
*/
 
var Calendar =
{
	// Массив с названиями месяцев
	monthNames: [ 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь' ],
	
	// Массив с названиями дней недели
	weekNames: [ 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс' ],
	
	//
	// Показ календаря
	//
	show: function( control, source, mode )
	{
		this.mode = mode;
		this.control = control;
		
		// Получаем внутренный объект для работы с датами
		this.internalDate = Calendar.getInternalDate( this.mode );
		
		// Забираем дату из поля ввода и парсим ее
		try {
			this.currentDate = this.internalDate.toDate( this.control.value );
		} catch ( e ) {
			alert( e ); this.currentDate = new Date();
		}
		
		// В первый раз создаем div календаря, задаем ему стиль
		if ( !this.divCalendar )
		{
			this.divCalendar = document.createElement('div');
			this.divCalendar.className = 'calendar';
			document.body.appendChild( this.divCalendar );
		}
		
		// Заполняем календарь таблицей чисел текущего месяца
		this.display( this.currentDate );
		
		// Определяем абсоблютные координаты опорных элементов
		var rControl = this.getPosition( control );
		var rSource = this.getPosition( source );
		
		// Позиционируем календарь в зависимости от его положения на странице
		var expand_right = rControl.x + this.divCalendar.offsetWidth <
			this.getClientWidth() + this.getBodyScrollLeft();
		var expand_bottom = rControl.y + control.offsetHeight + this.divCalendar.offsetHeight <
			this.getClientHeight() + this.getBodyScrollTop();
		
		if ( expand_right )
			this.divCalendar.style.left = rControl.x + 'px';
		else
			this.divCalendar.style.left = ( rSource.x + source.offsetWidth - this.divCalendar.offsetWidth ) + 'px';
		
		if ( expand_bottom )
			this.divCalendar.style.top = ( rControl.y + control.offsetHeight + 4 ) + 'px';
		else
			this.divCalendar.style.top = ( rControl.y - this.divCalendar.offsetHeight - 4 ) + 'px';
		
		// Показываем календарь
		this.divCalendar.style.visibility = 'visible';
	},
	
	//
	// Установка текущей даты
	//
	now: function( control, mode )
	{
		var internalDate = Calendar.getInternalDate( mode );
		
		control.value = internalDate.toString( new Date() );
	},
	
	// Метод возвращает внутренный объект для работы с датами
	getInternalDate: function( mode )
	{
		if ( mode == 'long' )
			return new DateLong();
		else if ( mode == 'full' )
			return new DateFull();
		else
			return new DateShort();
	},
	
	// Метод возвращает абсолютные координаты объекта
	getPosition: function( oObj )
	{
		var x = oObj.offsetLeft, y = oObj.offsetTop;
		while ( oObj = oObj.offsetParent )
			if ( oObj.tagName != 'HTML' )
				x += oObj.offsetLeft, y += oObj.offsetTop;
		
		return { 'x': x, 'y': y };
	},
	
	//
	// Метод возвращает проскролленность страницы по горизонтали
	//
	getBodyScrollLeft: function()
	{
		return ( document.documentElement && document.documentElement.scrollLeft ) ||
			( document.body && document.body.scrollLeft );
	},
	
	//
	// Метод возвращает проскролленность страницы по вертикали
	//
	getBodyScrollTop: function()
	{
		return ( document.documentElement && document.documentElement.scrollTop ) ||
			( document.body && document.body.scrollTop );
	},
	
	//
	// Метод возвращает ширину клиентской части окна
	//
	getClientWidth: function()
	{
		return ( !window.opera && document.documentElement && document.documentElement.clientWidth ) ||
			( document.body && document.body.clientWidth );
	},
	
	//
	// Метод возвращает высоту клиентской части окна
	//
	getClientHeight: function()
	{
		return ( !window.opera && document.documentElement && document.documentElement.clientHeight ) ||
			( document.body && document.body.clientHeight );
	},
	
	//
	// Скрытие календаря
	//
	hide: function()
	{
		this.divCalendar.style.visibility = 'hidden';
	},
	
	//
	// Заполнение поля ввода выбранной датой. Скрытие календаря
	//
	writeDate: function( date )
	{
		this.displayDate.setDate( date );
		
		this.control.value = this.internalDate.toString( this.displayDate );
		
		this.hide();
	},
	
	//
	// Смена месяца
	//
	setMonth: function(select)
	{
		var tDate =
			new Date(
				this.displayDate.getFullYear(), select.selectedIndex, 1,
				this.displayDate.getHours(), this.displayDate.getMinutes(), this.displayDate.getSeconds() );
		this.display( tDate );
	},
	
	//
	// Смена года
	//
	setYear: function( year )
	{
		if ( parseInt( year, 10 ) != year )
			return;
		
		var tDate =
			new Date(
				year, this.displayDate.getMonth(), 1,
				this.displayDate.getHours(), this.displayDate.getMinutes(), this.displayDate.getSeconds() );
		this.display( tDate );
	},
	
	// Смена года стрелками
	changeYear: function( shift )
	{
		var tDate =
			new Date(
				this.displayDate.getFullYear() + shift, this.displayDate.getMonth(), 1,
				this.displayDate.getHours(), this.displayDate.getMinutes(), this.displayDate.getSeconds() );
		this.display( tDate );
	},
	
	//
	// Смена часа
	//
	setHours: function( hours )
	{
		this.displayDate.setHours( hours );
	},
	
	//
	// Смена минут
	//
	setMinutes: function( minutes )
	{
		this.displayDate.setMinutes( minutes );
	},
	
	//
	// Смена секунд
	//
	setSeconds: function( seconds )
	{
		this.displayDate.setSeconds( seconds );
	},
	
	//
	// Сравнение дат
	//
	isEqualDate: function( dDate1, dDate2 )
	{
		return	( dDate1.getFullYear() == dDate2.getFullYear() ) &&
				( dDate1.getMonth() == dDate2.getMonth() ) &&
				( dDate1.getDate() == dDate2.getDate() );
	},
	
	//
	// Заполнение таблицы календаря числами текущего месяца
	//
	display: function( oDate )
	{
		// Отображаемая в данный момент дата
		this.displayDate = oDate;
		
		var year  = this.displayDate.getFullYear();
		var month = this.displayDate.getMonth();
		
		var hours  = this.displayDate.getHours();
		var minutes = this.displayDate.getMinutes();
		var seconds = this.displayDate.getSeconds();
		
		var text = '';
		
		// Шапка календаря (месяц, год, кнопки смены года, кнопка закрытия)
		text += '	<table class="header">';
		text += '		<tr>';
		text += '			<td rowspan="2" align="center">';
		text += '				<select class="month" onchange="Calendar.setMonth( this )">';
		for ( i = 0; i < this.monthNames.length; i++ )
			text += '					<option value="' + i + '"' + ( ( i == month ) ? ' selected="selected"' : '' ) + '>' + this.monthNames[i] + '</option>';
		text += '				</select>';
		text += '			</td>';
		text += '			<td rowspan="2" align="right">';
		text += '				<input type="text" class="year" value="' + year + '" onchange="Calendar.setYear( this.value )"/>';
		text += '			</td>';
		text += '			<td class="year-up" onmousedown="Calendar.changeYear(1)"/>';
		text += '			<td rowspan="2" class="close" onmousedown="Calendar.hide()"/>';
		text += '		</tr>';
		text += '		<tr>';
		text += '			<td class="year-down" onmousedown="Calendar.changeYear(-1)"/>';
		text += '		</tr>';
		text += '	</table>';
		
		// Тело календаря (дни недели, числа текущегно месяца)
		text += '	<table class="date">';
		text += '		<tr>';
		for ( i = 0; i < this.weekNames.length; i++ )
			text += '			<td class="weekdays" style="width: 14%">' + this.weekNames[i] + '</td>';
		text += '		</tr>';
		
		// Определение дня недели первого числа месяца
		var firstDayInstance = new Date( year, month, 1 )
		var firstDay = firstDayInstance.getDay();
		if (firstDay == 0) firstDay = 7;
		
		// Определение числа дней в текущем месяце
		var lastDateInstance = new Date( year, month + 1, 0 );
		var lastDate = lastDateInstance.getDate();
		
		var day = 1; var curCell = 1; 
		var displayDay = ''; var tDate = null;
		
		for ( row = 0; row < Math.ceil( ( lastDate + firstDay - 1 ) / 7 ); row++ )
		{
			text += '		<tr>';
			for ( col = 0; col < 7; col++ )
			{
				// Пропускаем дни до первого числа месяца
				if ( curCell < firstDay )
				{
					text += '			<td>&nbsp;</td>'; curCell++;
				}
				// Пропускаем дни после последнего числа месяца
				else if ( day > lastDate )
				{
					text += '			<td>&nbsp;</td>';
				}
				else 
				{
					sLink = 'javascript:Calendar.writeDate(' + day + ')';
					
					// Установленная дата
					if ( this.isEqualDate( this.currentDate, new Date( year, month, day ) ) )
						text += '			<td class="today"><a class="today" href="' + sLink + '">' + day + '</a></td>';
					// Выходные дни
					else if ( col > 4 )
						text += '			<td class="weekend"><a class="weekend" href="' + sLink + '">' + day + '</a></td>';
					// Обычные дни
					else
						text += '			<td><a href="' + sLink + '">' + day + '</a></td>';
					
					day++;
				}
			}
			text += '		</tr>';
		}
		text += '	</table>';
		
		// Подвал календаря (время)
		if ( this.mode == 'long' || this.mode == 'full' )
		{
			// Часы и минуты
			text += '	<table class="footer">';
			text += '		<tr>';
			text += '			<td align="center">';
			
			text += '				<table class="time">';
			text += '					<tr>';
			text += '						<td class="time_select">';
			text += '							<select class="time" onchange="Calendar.setHours(this.value)">';
			for ( i = 0; i < 24; i++ )
				text += '								<option value="' + i + '"' + ( ( i == hours ) ? ' selected="selected"' : '' ) + '>' + lpad( i, 2, '0' ) + '</option>';
			text += '							</select>';
			text += '						</td>';
			text += '						<td class="time_separator"/>';
			text += '						<td class="time_select">';
			text += '							<select class="time" onchange="Calendar.setMinutes(this.value)">';
			for ( i = 0; i < 60; i++ )
				text += '								<option value="' + i + '"' + ( ( i == minutes ) ? ' selected="selected"' : '' ) + '>' + lpad( i, 2, '0' ) + '</option>';
			text += '							</select>';
			text += '						</td>';
			
			// Секунды
			if ( this.mode == 'full' )
			{
				text += '						<td class="time_separator"/>';
				text += '						<td class="time_select">';
				text += '							<select class="time" onchange="Calendar.setSeconds(this.value)">';
				for ( i = 0; i < 60; i++ )
					text += '								<option value="' + i + '"' + ( ( i == seconds ) ? ' selected="selected"' : '' ) + '>' + lpad( i, 2, '0' ) + '</option>';
				text += '							</select>';
				text += '						</td>';
			}
			
			text += '					</tr>';
			text += '				</table>';
			
			text += '			</td>';
			text += '		</tr>';
			text += '	</table>';
		}
		
		this.divCalendar.innerHTML = text;
	}
}

// Объект для работы с датами формата DD.MM.YY (режим 'short', по умолчанию)
function DateShort()
{
	// Метод преобразуем строку в объект типа Date
	this.toDate = function( sDate )
	{
		if ( !sDate ) return new Date();
		
		var aMatch = sDate.match( /^(\d{2})\.(\d{2})\.(\d{4})/ );
		if ( !aMatch )
			throw 'Неверный формат даты (DD.MM.YYYY)!';
		
		return new Date( aMatch[3], aMatch[2] - 1, aMatch[1] );
	}
	
	// Метод преобразуем объект типа Date в строку
	this.toString = function( oDate )
	{
		return '' +
			lpad( oDate.getDate(), 2, '0' ) + '.' +
			lpad( oDate.getMonth() + 1, 2, '0' ) + '.' +
			lpad( oDate.getFullYear(), 4, '0' );
	}
}

// Объект для работы с датами формата DD.MM.YY HH:MM (режим 'long')
function DateLong()
{
	// Метод преобразуем строку в объект типа Date
	this.toDate = function( sDate )
	{
		if ( !sDate ) return new Date();
		
		var aMatch = sDate.match( /^(\d{2})\.(\d{2})\.(\d{4})\s+(\d{2})\:(\d{2})/ );
		
		if ( !aMatch )
			throw 'Неверный формат даты/времени (DD.MM.YYYY HH:MM)!';
		
		return new Date( aMatch[3], aMatch[2] - 1, aMatch[1], aMatch[4], aMatch[5] );
	}
	
	// Метод преобразуем объект типа Date в строку
	this.toString = function( oDate )
	{
		return '' +
			lpad( oDate.getDate(), 2, '0' ) + '.' +
			lpad( oDate.getMonth() + 1, 2, '0' ) + '.' +
			lpad( oDate.getFullYear(), 4, '0' ) + ' ' +
			lpad( oDate.getHours(), 2, '0' ) + ':' +
			lpad( oDate.getMinutes(), 2, '0' );
	}
}

// Объект для работы с датами формата DD.MM.YY HH:MM:SS (режим 'full')
function DateFull()
{
	// Метод преобразуем строку в объект типа Date
	this.toDate = function( sDate )
	{
		if ( !sDate ) return new Date();
		
		var aMatch = sDate.match( /^(\d{2})\.(\d{2})\.(\d{4})\s+(\d{2})\:(\d{2})\:(\d{2})/ );
		if ( !aMatch )
			throw 'Неверный формат даты/времени (DD.MM.YYYY HH:MM:SS)!';
		
		return new Date( aMatch[3], aMatch[2] - 1, aMatch[1], aMatch[4], aMatch[5], aMatch[6] );
	}
	
	// Метод преобразуем объект типа Date в строку
	this.toString = function( oDate )
	{
		return '' +
			lpad( oDate.getDate(), 2, '0' ) + '.' +
			lpad( oDate.getMonth() + 1, 2, '0' ) + '.' +
			lpad( oDate.getFullYear(), 4, '0' ) + ' ' +
			lpad( oDate.getHours(), 2, '0' ) + ':' +
			lpad( oDate.getMinutes(), 2, '0' ) + ':' +
			lpad( oDate.getSeconds(), 2, '0' );
	}
}

// Метод дополняет строку другой строкой до заданной длины слева
function lpad( sText, iLength, sSpace )
{
	var sResult = sText;
	for ( var i = 0; i < iLength - sText.toString().length; i++ )
		sResult = sSpace + sResult;
    return sResult;
}
