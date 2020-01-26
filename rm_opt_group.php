 <?
/**
 * Script: form_opt_group
 * Author: Ray Messina
 * Copyright: 2020 Ray Messina Design;
 * GNU General Public License
**/
	
class rm_tag_group{
	protected $selected 	 = 	'';
	
	protected $value_str	 =  '';	
	protected $value_qt	 	 =  '"';	
	protected $value_eq	 	 =  ' = ';	
	protected $value_frag	 =  '';	
 		
  	protected $tag 	 		 =  false ;	
	protected $tag_type_attr =  '' ;	
	protected $tag_name_attr =  '' ;	
	protected $tag_attrs 	 =  '' ;
	protected $tag_text	 	 =  '' ;
	protected $close_tag 	 =	true;	
  	protected $value_tag 	 =	'';
	protected $tag_row		 =	'';
	protected $bef		 	 =  '' ;	
	protected $aft 	 		 =  '' ;	
	
	protected $has_wrap 	 =  false ;	
	protected $has_text 	 =  false ;	

	protected $the_group 	 =  false;
	protected $data 	 	 =  false;
	
	protected $rep_keys		 =  array();
	protected $onlyByVal	 =  true;
	protected $skip_foo	 	 =  false;
	protected $skip_index	 =  array();
	protected $skip_val 	 =  array();
	protected $attr_list 	 =  array();
	protected $global_attrs	 =  array( 'dir','lang','style','id','class','tabindex','accesskey','title' ,'onblur','onfocus', 'onmousemove', 'onmouseout', 'onmousedown', 'onmouseup', 'onmouseover', 'onclick','ondblclik');
	
	protected $actions = array('omit'=>array(),  'sel'=>array(),'dis'=>array());
		
	function __construct($data, $val_str='', $text_str='', array $args =array()){
		$def = array('eq'=>$this->value_eq	 , 'qt'=>$this->value_qt, 'row'=>false, 'bef'=>'',  'aft'=>'', 'att'=>array(), 'datt'=>array());

		$def = array_merge($def, $args);
		$this->value_tag = is_string($val_str) ? $val_str : '';
		if ($this->has_wrap){
			if (is_string($def['bef'])){ $this->bef = $def['bef'];}
			if (is_string($def['aft'])){ $this->aft = $def['aft'];}
		}
		if ($this->has_text){
			if (is_scalar($text_str)){ $this->tag_text = $text_str;}
 		}
		
		if ($this->tag_name_attr){// allows for a default name to be set, when required
			$this->global_attrs[]='name';
			if (isset($def['name']) &&  is_string($def['name'])){ 
				$this->tag_name_attr = $def['name']; 
			}elseif( isset($def['att']['name'])){
				$this->tag_name_attr = $def['att']['name'];
			}
			$def['att']['name'] = $this->tag_name_attr; 
		} 
		if ($this->tag_type_attr){
			$this->tag_attrs.=' type = "'.$this->tag_type_attr.'" '; // adds type attr; but  prevents it from being user accesible
		} 
		if (is_array($def['att'])){ 
 			foreach ($this->attr_list + $this->global_attrs as $attr){
				if(isset($def['att'][$attr])) { $this->tag_attrs.=' '.$attr.' = "'.$def['att'][$attr].'" ';}
			}
		}
		if (is_array($def['datt'])){ 
 			foreach ($def['datt'] as $key=>$val){
				if(isset($def['att'][$attr])) { $this->tag_attrs.=' data-'.$key.' = "'.$val.'" ';}
			}
		}
  		$this->value_str($def['eq'],$def['qt']);
  		
  		if (is_string($data) &&  is_string($def['row'])){$this->tag_row	= $def['row']; }
  		else{
	  		$this->build_element();
	  		//set skip options
	  		if (isset($def['skf']) &&  is_string($def['skf'])){ $this->skip_foo = $def['skf']; }
	  		if (isset($def['ski'])) { 
		  		$this->skip_index = is_array($def['ski']) ? $def['ski'] : array($def['ski']); 
		  		$this->skip_index = array_flip($this->skip_index);
 		  	}
	  		if (isset($def['skv']) &&  is_array($def['skv']) ) { $this->skip_val =   $def['skv'] ; }
  		}
  		$this->gather_rep_keys();
   		$this->generate_group($data);
	}
	
	function value_str($eq = " = ", $qt='"'){
 		$this->value_qt = $qt ? '"'  : "'";
		$this->value_eq = $eq;
 		$this->value_frag = ' value'.$this->value_eq.$this->value_qt;
 		$this->value_str = $this->value_frag.$this->value_tag.$this->value_qt;
   	}
	
	protected function generate_group($data){//
 		if (!$this->tag) { return;}  
		$this->data =(is_array($data) || is_string($data)) ? $data : false;
		if (is_string($this->data)) { $this->the_group = $this->data; return;}
		if (is_array($this->data)) { 
			$this->the_group = '';
			foreach ($this->data as $key=>$row){
 				if ($this->skip_build($row,$key)) { continue; }
				$this->the_group .= $this->key_replace($row,$key);
			}
 		}
		return;
	}

	function skip_build($row,$index){
 		if (isset($this->skip_index[$index])){return true;}
 		foreach ($this->skip_val as $col=>$skip_vals){
	 		if (isset($skip_vals[$row[$col]])) {return true;}
 		}
 		if ($this->skip_foo && function_exists($this->skip_foo)){ 
	 		return  $this->{skip_foo}($row,$index,$this->skip_val,$this->skip_index);
	 	}
	 	return false;	
	}

 	function gather_rep_keys(){
		$str = $this->value_tag;
		if ($this->has_wrap ){ $str.=$this->bef.$this->aft; }
		$str .= $this->tag_attrs;
		preg_match_all('#{{(\w+)}}#',$str ,$m);
		$this->rep_keys =isset($m[1]) ? $m[1] : array();
	}
 	
	function build_element(){
		$this->tag_row='<'.$this->tag.' '.$this->tag_attrs.$this->value_str.' >'.$this->tag_text;
 		if( $this->close_tag){$this->tag_row.='</'.$this->tag.'>';}
		if ($this->has_wrap) {$this->tag_row= $this->bef.$this->tag_row.$this->aft;}
  		$this->tag_row.="\n";
	}
	
	function key_replace($data,$key){
		$str= str_replace('{{##}}', $key, $this->tag_row);
		foreach ($this->rep_keys as $col){
			$str= str_replace('{{'.$col.'}}', $data[$col], $str); 
		}
		return $str;
	}

  	function output($byVal=true , array $args=array()){
	 		
	 		$byVal = $this->onlyByVal ? true : $byVal;
	 		$actions = $this->actions;
	 		$acts 	=array('omit'=>false,  'sel'=>$this->selected,'dis'=>' DISABLED ');
	 		
	 		foreach ($actions as $setup=>$junk){
		 		 if (isset($args[$setup])){ 
			 		 $actions[$setup] = is_array($args[$setup]) ? $args[$setup] : array($args[$setup]); 
			 	}
 		 	}
	 		$fooBypas = (isset($args['omitf']) && is_string($args['omitf']) && function_exists($args['omitf'])) ? $args['omitf'] : false;
 		 	$search_root_l 	= $byVal ? $this->value_frag :  '>'   ;
 		 	$search_root_r 	= $byVal ? $this->value_qt : ($this->close_tag  ? '</'.$this->tag.'>' : '<');
 		 	$new_group =$this->the_group;
 	 		foreach ($actions as $action=>$targets){
 				$do_lim =  ($action && (isset($args[$action.'lim']) && @($args[$action.'lim']+0) > 0))  ?
 						    $args[$action.'lim']+0 : false ; //setlim
 				$act=$acts[$action];
 		 		foreach ($targets as $key=>$target){
 		 			$rep_array = false;
					if ( $act  && (!$this->close_tag && $this->has_wrap)){  // operates only on single tag elements  with wraps
						$rep_array= $this->preg_rep($byVal, $target, $new_group, $act);
						$replace_this= is_array($rep_array) ? $rep_array[0] : $rep_array;
						 
					}else{
						$replace_this= $search_root_l.$target.$search_root_r ;
					}
					
					   ///????
					
					if(!$act){//performs omit!!!!!!!! 
						// fooBypass / else:
						if ($fooBypas){
							$replace_this = $fooBypas($target,$byVal,$this->tag, $this->value_str,$this->tag_text, $rgxShell,$replace_this);
							$replace_this = is_string($replace_this) ? $replace_this : '';  // sanitizes bypass foo results
						}else{
						 	// if target is array then  fill in {{vars}}
						 	if (is_array($target)){  $replace_this = $this->key_replace($target, $key);}
						 	else{
 						 		$new_group = $this->preg_rep($byVal, $target, $new_group);// do pregmatch text replace 
						 		continue; 
						 	}
 					    }

 					    $new_group = str_replace($replace_this, '', $new_group); 		//do text replace
			 		}
 			 		else{// performs disables and selects
				 		$use_lim = -1;
				 		$array_flag = is_array($rep_array);
				 		$replace_group = $array_flag ? $rep_array[0] : array($replace_this) ; // if a replament array has been set take the first (arrray to be relace index);
				 		
				 		foreach ($replace_group  as $index=> $replace_this ){
							if ($do_lim > 0 ){
								$sub = substr_count ($new_group, $replace_this);  // get a count of the number of intances of the str to be replaced
	  							$use_lim = ($sub > $do_lim) ? $do_lim :  $sub; // if the count is more than the remaining limit...
								$do_lim =  $do_lim - $sub;  
	 						}
					 		if (!$array_flag ) {$replace_with = $byVal  ?  $replace_this.$act : $act.$replace_this;}
					 		else{ $replace_with = $rep_array[1][$index]; }
	     				 	$new_group = str_replace($replace_this, $replace_with, $new_group ,$use_lim);
	 						if ($do_lim !== false &&  $do_lim  <= 0 ){    break 2;}// replac ct limit	
	 					}
			 		}
			 	}	 		 
  		 	}
 		 	return $new_group;
 		 	
 	}
 	
 	 	protected function preg_rep($byVal,  $needle,$haystack, $replacement = false){
  	 		$needle = preg_quote($needle); 					// escape string and add to regex
  	 		$rgx  	=  $byVal ? '/^.*<'.$this->tag.' .*'.trim($this->value_frag.$needle.$this->value_qt).'.*>.*$/m'  : '/^.*<.*>'.$needle.'<.*>.*$/m' ; 					// select regex shell  
  	 		
   	 		if (!$replacement) { return preg_replace($rgx, '', $haystack);} //returns  original with lines containing needle deleted
  	 		preg_match_all($rgx, $haystack,$matches);
  	 		$matches  = $matches  ? $matches[0] : array();
  	 		$matches =  array_keys(array_flip($matches));
  	 		$replacements=array();
  	 		foreach ($matches as $match){
	  	 		$replacements[] = str_replace('<'.$this->tag.' ', '<'.$this->tag.' '.$replacement, $match);
  	 		}
  	 		return array($matches,$replacements); //returns an array of matches  of lines containing $needle
  	}

 	
 }
 
 class rm_fg_datalist extends rm_tag_group{
	
	protected $selected 	= ' SELECTED ';	//vestigial
	protected $tag 	 		= 'option';	
	protected $close_tag	= false;
	protected $attr_list 	=  array('label');
	protected $actions = array('omit'=>array(), 'dis'=>array());
}

 class rm_fg_select extends rm_tag_group{
	
	protected $selected 	= ' SELECTED ';	
	protected $tag 	 		= 'option';	
	protected $onlyByVal	= false;
	protected $has_text		= true;
	protected $attr_list 	=  array('label');
}

 class rm_fg_radiobutton extends rm_tag_group{
	
	protected $selected 	= ' CHECKED ';	
	protected $tag 	 		= 'input';	
	protected $onlyByVal	= false;
	protected $tag_type_attr= 'radio' ;
	protected $tag_name_attr= 'radio_set' ;
	protected $close_tag 	=	false;
	protected $has_wrap	= true;
	
  }

 class rm_fg_checkbox extends rm_tag_group{
	
	protected $selected 	= ' CHECKED ';	
	protected $tag 	 		= 'input';	
	protected $onlyByVal	= false;
	protected $tag_type_attr= 'checkbox' ;
	protected $close_tag 	=	false;
	protected $has_wrap	= true;
  }
