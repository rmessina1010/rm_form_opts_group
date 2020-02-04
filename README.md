# rm_form_opts_group
a PHP class to assist in the creation and management of sets of form elements; specifically OPTIONs, RADIO buttons, and CHECKBOXES

Replacement Patterns :
           {{##}} row index ( for array data);
           {{key}} where 'key' is a named key in the data array row
           	
           	
Construct Method:(
           $data: formatted HTML string | Named Key Array
           $val_str: string pattern for  value attributes
		   //optional//
           $text_str= a sting pattern for text (applies to tags with text content only)
           $args: An argument array(
	           'eq'=>  equals string;  allows for contr of spacing ; default is ' = ' ,
	           'qt'=>  quote mark charcter truthy: uses double qoutes (") , While falsy uses single quotes (')
	           'row'=>  for use with String data input this deines a pattern for a single row of elements, 
	           'bef'=> string pattern defining text before the tag, such as a LABEL; 
	                   will be considered when byVal is set to false. ,  
	           'aft'=>string  pattern defining text after the tag, such as a LABEL;
	                   will be considered when byVal is set to false. ,  
	           'att'=> an array of global tag attributes, as key value pairs.  
	           		   value string can be a replacement pattern
	           		   Excludes DATA-, SELECTED, DISABLED , VALUE  and NAME
	           'datt'=> an array of DATA- attributes,
	           'name'=> NAME attribute string, 
	           'ski'=> an array ,skip these indexes in the data array; eliminates the info from ALL outputs
	           'skv'=> an array ,skip any indexes in the data array that contain the values ; eliminates the info from ALL outputs
	           'skf'=> string ,functions as a user filter callback(data row and index is passed); eliminates the info from ALL outputs
           )
)

Output Method:( 
		    $byVal = apply selection using VALUE ATTRIBUTE(when true) or TEXT CONTENT (when false) ; Boolean evaluated; 
		   //optional//
           $args: An argument array(
	           'omit'=> an array  of  values  that will be omitted IN THIS OUPUT, 
	           'sel'=>an array  of  values  that will be SELECTED/CHECKED IN THIS OUPUT,
	           'dis'=>an array  of  values  that will be DISABLED IN THIS OUPUT,
	           'omitlim'=> integer to use as a MAXIMUM number of OMITTED elements, 
	           'sellim'=>integer to use as a MAXIMUM number of SELECTED/CHECKED elements,
	           'dislim'=>integer to use as a MAXIMUM number of DISABLED elements,
	           'name' => overrides name attribute; this function is invoked  AFTER placeholders are replaced,
	           '_name' => prepends the string to the name attribute; this function is invoked  AFTER 'Name',
	           'name_' => appends the string to the name attribute; this function is invoked  AFTER 'Name'
	       )
)
