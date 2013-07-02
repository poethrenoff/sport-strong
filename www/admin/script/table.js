function checkAllBoxes( checked )
{
	for ( var i = 0; i < document.forms['table'].elements.length; i++ )
		if ( document.forms['table'].elements[i].type == 'checkbox' )
			document.forms['table'].elements[i].checked = checked;
}
