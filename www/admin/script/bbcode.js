function BBcode( name )
{
	var self = this;
	
	this.name = name;
	
	this.iconPath = '/admin/image/editor/';
	
	this.tags = {
		'bold': { 'open': 'b', 'close': 'b', 'key': 66 },
		'italic': { 'open': 'i', 'close': 'i', 'key': 73 },
		'underline': { 'open': 'u', 'close': 'u', 'key': 85 },
		'strike': { 'open': 's', 'close': 's', 'key': 83 },
		'sub': { 'open': 'sub', 'close': 'sub', 'key': 38 },
		'sup': { 'open': 'sup', 'close': 'sup', 'key': 40 },
		
		'email': { 'open': 'email', 'close': 'email', 'key': 69 },
		'link': { 'open': 'url', 'close': 'url', 'key': 76 },
		'image': { 'open': 'img', 'close': 'img', 'key': 80 },
	
		'left': { 'open': 'align=left', 'close': 'align' },
		'right': { 'open': 'align=right', 'close': 'align' },
		'center': { 'open': 'align=center', 'close': 'align' },
		'full': { 'open': 'align=justify', 'close': 'align' },
		
		'color': { 'open': 'color=', 'close': 'color' },
		'size': { 'open': 'size=', 'close': 'size' },
		'font': { 'open': 'font=', 'close': 'font' },
		'header': { 'open': 'h', 'close': 'h' }
	};
	
	this.create = function( id )
	{
		this.textarea = document.getElementById( id );
		
		var divBBCodeBar = document.createElement( 'div' );
		divBBCodeBar.className = 'bbcode';
		
		divBBCodeBar.innerHTML = '' +
			'<table>' +
			'	<tr>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'bold\' )"><img src="' + this.iconPath + '/bold.gif"/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'italic\' )"><img src="' + this.iconPath + '/italic.gif"/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'underline\' )"><img src="' + this.iconPath + '/underline.gif"/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'strike\' )"><img src="' + this.iconPath + '/strike.gif"/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'sub\' )"><img src="' + this.iconPath + '/sub.gif"/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'sup\' )"><img src="' + this.iconPath + '/sup.gif"/></td>' +
			'		<td class="separator"><div/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'email\' )"><img src="' + this.iconPath + '/email.gif"/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'link\' )"><img src="' + this.iconPath + '/link.gif"/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'image\' )"><img src="' + this.iconPath + '/image.gif"/></td>' +
			'		<td class="separator"><div/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'left\' )"><img src="' + this.iconPath + '/justify_left.gif"/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'center\' )"><img src="' + this.iconPath + '/justify_center.gif"/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'right\' )"><img src="' + this.iconPath + '/justify_right.gif"/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'full\' )"><img src="' + this.iconPath + '/justify_full.gif"/></td>' +
			'		<td class="separator"><div/></td>' +
			'		<td onmouseover="this.className = \'over\'" onmouseout="this.className = \'\'" onmousedown="this.className = \'down\'" onmouseup="this.className = \'over\'" onclick="' + this.name + '.doCmd( \'color\' )"><img src="' + this.iconPath + '/fgcolor.gif"/></td>' +
			'		<td><select onchange="' + this.name + '.doCmd( \'size\', this.options[this.selectedIndex].value ); this.selectedIndex = 0">' +
			'			<option value="">размер</option>' +
			'			<option value="8px">8</option>' +
			'			<option value="10px">10</option>' +
			'			<option value="12px">12</option>' +
			'			<option value="14px">14</option>' +
			'			<option value="16px">16</option>' +
			'			<option value="20px">20</option>' +
			'			<option value="24px">24</option>' +
			'		</select></td>' +
			'		<td><select onchange="' + this.name + '.doCmd( \'font\', this.options[this.selectedIndex].value ); this.selectedIndex = 0">' +
			'			<option value="">шрифт</option>' +
			'			<option value="Verdana, Arial, Helvetica">Verdana</option>' +
			'			<option value="Times New Roman, Times, Serif">Times</option>' +
			'			<option value="Comic Sans MS">Comic Sans</option>' +
			'			<option value="MS Sans Serif, sans-serif">Sans Serif</option>' +
			'			<option value="Courier New, Courier, Monospace">Courier</option>' +
			'			<option value="Trebuchet MS, Arial, Helvetica">Trebuchet</option>' +
			'		</select></td>' +
			'		<td><select onchange="' + this.name + '.doCmd( \'header\', this.options[this.selectedIndex].value, this.options[this.selectedIndex].value ); this.selectedIndex = 0">' +
			'			<option value="">заголовок</option>' +
			'			<option value="1">H1</option>' +
			'			<option value="2">H2</option>' +
			'			<option value="3">H3</option>' +
			'			<option value="4">H4</option>' +
			'			<option value="5">H5</option>' +
			'			<option value="6">H6</option>' +
			'		</select></td>' +
			'	</tr>' +
			'</table>';
		
		this.textarea.parentNode.insertBefore( divBBCodeBar, this.textarea );
		
		addListener( this.textarea, 'keydown', this.onkeydown );
	}
	
	this.doCmd = function( sTagName, sOpenParam, sCloseParam )
	{
		if ( !this.tags[sTagName] ) return;
		
		if ( !sOpenParam ) sOpenParam = ''; if ( !sCloseParam ) sCloseParam = '';
	
		var sTagOpen = '[' + this.tags[sTagName].open + sOpenParam + ']';
		var sTagClose = '[/' + this.tags[sTagName].close + sCloseParam + ']';
		
		this.textarea.focus();
		
		if ( document.selection )
		{
			var oSelection = document.selection.createRange();
			if ( oSelection.text )
				oSelection.text = sTagOpen + oSelection.text + sTagClose;
		}
		else
		{
			var selLength = this.textarea.textLength;
			var selStart = this.textarea.selectionStart;
			var selEnd = this.textarea.selectionEnd;
			
			if ( selEnd > selStart )
			{
				this.textarea.value = this.textarea.value.substring( 0, selStart ) + sTagOpen +
					this.textarea.value.substring( selStart, selEnd ) + sTagClose + this.textarea.value.substring( selEnd, selLength );
				
				this.textarea.selectionStart = selStart;
				this.textarea.selectionEnd = selEnd + ( sTagOpen + sTagClose ).length;
			}
		}
	}
	
	this.onkeydown = function( oEvent )
	{
		if ( oEvent.ctrlKey )
		{
			for ( var tagName in self.tags )
			{
				if ( self.tags[tagName].key && self.tags[tagName].key == oEvent.keyCode )
				{
					self.doCmd( tagName ); stopEventCascade( oEvent );
				}
			}
		}
	}
}

function addListener( oObj, sEvent, oFunc )
{
	if ( document.attachEvent )
		oObj.attachEvent( 'on' + sEvent, oFunc );
	else if ( document.addEventListener )
		oObj.addEventListener( sEvent, oFunc, true );
	else
		eval( oObj + '.on' + sEvent + '=' + oFunc );
}

function stopEventCascade( oEvent )
{
	if ( oEvent.preventDefault )
		oEvent.preventDefault();
	else
		oEvent.returnValue = false;
}
