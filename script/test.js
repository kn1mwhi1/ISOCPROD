function testReplace( value )
{
	var tmp = value.replace(/;+\s*|,,+|\s\s+/g,',');
	return tmp;
}

