var CheckForm =
{
	// Массив обработчиков полей по умолчанию
	aCheckHandlers: {
		'require': { 'method': 'validate_nonempty', 'message': 'Не заполнено обязательное поле!' },
		'int': { 'method': 'validate_int', 'message': 'Неверный формат целого числа!' },
		'float': { 'method': 'validate_float', 'message': 'Неверный формат числа с плавающей точкой!' },
		'email': { 'method': 'validate_email', 'message': 'Неверный формат e-mail!' },
		'alpha': { 'method': 'validate_login', 'message': 'Неверный формат поля (строка из цифр или латинских букв без пробелов)!' },
		'dirname': { 'method': 'validate_dirname', 'message': 'Неверный формат названия директории!' },
		'date': { 'method': 'validate_date', 'message': 'Неверный формат даты (DD.MM.YYYY)!' },
		'time': { 'method': 'validate_time', 'message': 'Неверный формат времени (HH:MM)!' },
		'datetime': { 'method': 'validate_datetime', 'message': 'Неверный формат даты/времени (DD.MM.YYYY HH:MM)!' },
		'radio': { 'method': 'validate_radio', 'message': 'Не выбран ни один из вариантов!' },
		'radioalt': { 'method': 'validate_radioalt', 'message': 'Не выбран ни один из вариантов!' },
		'checkboxgroup': { 'method': 'validate_checkboxgroup', 'message': 'Не выбран ни один из вариантов!' },
		'checkboxgroupalt': { 'method': 'validate_checkboxgroupalt', 'message': 'Не выбран ни один из вариантов!' } },

	// Ссылка на объект текущей формы
	oForm: null,

	// Метод проверки правильности заполнения полей
	validate: function( oForm )
	{
		if ( !oForm ) return false;
		
		this.oForm = oForm;
		
		for ( var i = 0; i < this.oForm.elements.length; i++ )
		{
			var oItem = this.oForm.elements[i];
			var sErrors = oItem.getAttribute( 'errors' );
			if ( !sErrors ) continue;
			
			var aErrors = sErrors.split( '|' );
			if ( !aErrors.length ) continue;
			
			for ( var index in aErrors )
			{
				if ( !this.aCheckHandlers[aErrors[index]] ) continue;
				
				var sMethod = this.aCheckHandlers[aErrors[index]]['method'];
				if ( this[ sMethod ] && !this[ sMethod ]( oItem ) )
				{
					alert( this.aCheckHandlers[aErrors[index]]['message'] );
					try { oItem.focus() } catch (e) {};
					return false;
				}
			}
		}
		
		return this.validate_ext();
	},

	// Проверка на заполнение обязательного поля
	validate_nonempty: function( oItem )
	{
		if ( oItem.type == 'checkbox' )
			return oItem.checked;
		else
			return oItem.value.replace( /(^\s*)|(\s*$)/g, '' ) != '';
	},

	// Проверка на целое число
	validate_int: function( oItem )
	{
		return ( oItem.value == '' ) || /^\-?\+?\d+$/.test( oItem.value );
	},

	// Проверка на число с плавающей точкой
	validate_float: function( oItem )
	{
		return ( oItem.value == '' ) || /^\-?\+?\d+[\.,]?\d*$/.test( oItem.value );
	},

	// Проверка на e-mail
	validate_email: function( oItem )
	{
		return ( oItem.value == '' ) || /^[\w\.-]+@[\w\.-]+\.\w\w+$/.test( oItem.value );
	},

	// Проверка на логин
	validate_login: function( oItem )
	{
		return ( oItem.value == '' ) || /^\w+$/.test( oItem.value );
	},

	// Проверка на название директории
	validate_dirname: function( oItem )
	{
		return ( oItem.value == '' ) || /^[\w\.\[\]-]+$/.test( oItem.value );
	},

	// Проверка на дату
	validate_date: function( oItem )
	{
		if ( oItem.value == '' ) return true;
		
		var aMatches = oItem.value.match( /^(\d{2})\.(\d{2})\.(\d{4})$/ );
		if ( !aMatches ) return false;
		
		return this.check_date( aMatches[3], aMatches[2] - 1, aMatches[1] );
	},

	// Проверка на время
	validate_time: function( oItem )
	{
		if ( oItem.value == '' ) return true;
		
		var aMatches = oItem.value.match( /^(\d{2})\:(\d{2})$/ );
		if ( !aMatches ) return false;
		
		return this.check_time( aMatches[1], aMatches[2] );
	},

	// Проверка на дату/время
	validate_datetime: function( oItem )
	{
		if ( oItem.value == '' ) return true;
		
		var aMatches = oItem.value.match( /^(\d{2})\.(\d{2})\.(\d{4}) (\d{2})\:(\d{2})$/ );
		if ( !aMatches ) return false;
		
		return this.check_date( aMatches[3], aMatches[2] - 1, aMatches[1] ) && this.check_time( aMatches[4], aMatches[5] );
	},

	// Вспомогательный метод проверки корректности даты
	check_date: function( sYear, sMonth, sDate )
	{
		var dTempDate = new Date( sYear, sMonth, sDate );
		var bValid =
			( dTempDate.getFullYear() == sYear ) &&
			( dTempDate.getMonth() == sMonth ) &&
			( dTempDate.getDate() == sDate );
		return bValid;
	},

	// Вспомогательный метод проверки корректности времени
	check_time: function( sHour, sMinutes )
	{
		var bValid =
			( sHour >= 0 && sHour <= 23 ) &&
			( sMinutes >= 0 && sMinutes <= 59 );
		return bValid;
	},

	// Проверка чека группы радио-баттонов
	validate_radio: function( oItem )
	{
		var aItems = this.oForm[oItem.name].length ?
			this.oForm[oItem.name] : [ this.oForm[oItem.name] ];
		for ( var i = 0; i < aItems.length; i++ )
			if ( aItems[i].checked )
				return true;
		return false;
	},

	// Проверка чека группы радио-баттонов с альтернативой
	validate_radioalt: function( oItem )
	{
		var aItems = this.oForm[oItem.name].length ?
			this.oForm[oItem.name] : [ this.oForm[oItem.name] ];
		for ( var i = 0; i < aItems.length; i++ )
			if ( aItems[i].checked ) {
				if ( aItems[i].value != '_alt_' )
					return true;
				else if ( this.oForm['alt_' + oItem.name].value.replace( /(^\s*)|(\s*$)/g, '' ) != '' )
					return true;
			}
		return false;
	},

	// Проверка чека группы чекбоксов
	validate_checkboxgroup: function( oItem )
	{
		var aItems = this.oForm[oItem.name].length ?
			this.oForm[oItem.name] : [ this.oForm[oItem.name] ];
		for ( var i = 0; i < aItems.length; i++ )
			if ( aItems[i].checked )
				return true;
		return false;
	},

	// Проверка чека группы чекбоксов с альтернативой
	validate_checkboxgroupalt: function( oItem )
	{
		var aItems = this.oForm[oItem.name].length ?
			this.oForm[oItem.name] : [ this.oForm[oItem.name] ];
		for ( var i = 0; i < aItems.length; i++ )
			if ( aItems[i].checked ) {
				if ( aItems[i].value != '_alt_' )
					return true;
				else if ( this.oForm['alt_' + oItem.name].value.replace( /(^\s*)|(\s*$)/g, '' ) != '' )
					return true;
			}
		return false;
	},

	// Дополнительный метод, переопределямый для расширения функционала
	validate_ext: function()
	{
		return true;
	}
};

/*
	Пример добавления нового обработчика:

	Dictionary.aWords['lang_check_prefix'] = 'Сообщение при ошибке';

	CheckForm.aCheckHandlers[ '_prefix_' ] =
	{
		'method': 'validate_method',
		'message': Dictionary.translate( 'lang_check_prefix' )
	};

	CheckForm[ 'validate_method' ] = function( oItem )
	{
		[code]
	};
*/
