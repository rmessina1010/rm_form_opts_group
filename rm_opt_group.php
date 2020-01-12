<?
/**
 * Author: Ray Messina
 * Copyright: 2020 Ray Messina Design; 
 * GNU General Public License
**/
	
	class rm_tag_group{
	protected $selected 	 = 	'';
	
	protected $value_str	 =  '';	
	protected $value_qt	 	 =  '"';	
 		
  	protected $tag 	 		 =  false ;	
	protected $tag_type_attr =  '' ;	
	protected $tag_name_attr =  '' ;	
	protected $tag_attrs 	 =  '' ;
	protected $tag_txt	 	 =  '' ;
	protected $close_tag 	 =	true;	
  	protected $value_tag 	 =	'';
	protected $tag_row		 =	'';
	protected $bef		 	 =  '' ;	
	protected $aft 	 		 =  '' ;	
	
	protected $has_wrap 	 =  false ;	
	protected $has_text 	 =  false ;	
	protected $has_attrs 	 =  false ;	

	protected $the_group 	 =  false;
	protected $data 	 	 =  false;
	
	protected $rep_keys		 =  array();
	protected $onlyByVal	 =  true;
	protected $skip_foo	 	 =  false;
	protected $skip_index	 =  array();
	protected $skip_val 	 =  array();
	protected $attr_list 	 =  array();
	
		
	function __construct($data, $val_str='', $text_str='', array $args =array()){
		$def = array('eq'=>$this->value_eq	 , 'qt'=>$this->value_qt, 'row'=>false, 'bef'=>'',  'aft'=>'', 'att'=>array());
		
		$def = array_merge($def, $args);
		$this->value_tag = is_string($val_str) ? $val_str : '';
		if ($this->has_wrap){
			if (is_string($def['bef'])){ $this->bef = $def['bef'];}
			if (is_string($def['aft'])){ $this->aft = $def['aft'];}
		}
		if ($this->has_text){
			if (is_string($text_str)){ $this->tag_text = $text_str;}
 		}
		
		if ($this->tag_name_attr){// allows for a default name to be set, when required
			if (isset($def['name']) &&  is_string($def['name'])){ 
				$this->tag_name_attr = $def['name']; 
			}elseif( isset($def['att']['name'])){
				$this->tag_name_attr = $def['att']['name'];
			}
			$def['att']['name'] = $this->tag_name_attr; 
		} 
		if ($this->tag_type_attr){
			$def['att']['type'] = $this->tag_type_attr; 
		} 
		if (is_array($def['att'])){ 
 			foreach ($this->attr_list as $attr){
				$this->tag_attrs.=' '.$attr.' = "'.$def['att'][$attr].'" ';
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
		if (!is_string($str)){return;}
		$this->value_qt = $qt ? '"'  : "'";
		$this->value_eq = $eq;
 		$this->value_str=' value'.$this->value_eq.$this->value_tag.$this->qt;
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
		$this->tag_row='<'.$this->tag.' '.$this->tag_attrs.$this->value_tag.' >'.$this->tag_text;
 		if( $this->close_tag){$this->tag_row.='</'.$this->tag.'>';}
		if ($this->has_wrap) {$this->tag_row= $this->bef.$this->tag_row.$this->aft;}
  		$this->tag_row.="\n";
  		 echo $this->tag_row;
		
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
	 		$actions =array('omit'=>array(), 'sel'=>array(),'dis'=>array());
	 		$acts 	=array('omit'=>false,'sel'=>$this->selected,'dis'=>' DISABLED ');
	 		$setups =array( 'sel', 'dis', 'del');
	 		foreach ($setups as $setup){
		 		 if (isset($args[$setup])){ 
			 		 $actions[$setup] = is_array($args[$setup]) ? $args[$setup] : array($args[$setup]); 
			 	}
 		 	}
	 		
 		 	$search_root_l 	= $byVal ? $this->value_str : '>';
 		 	$search_root_r 	= $byVal ? $this->value_qt : '</'.$this->tag.'>' ;
   		 	
 		 	$new_group =$this->the_group;
	 		foreach ($actions as $action=>$targets){
 				$do_lim =  ($action && (isset($args[$action.'lim']) && @($args[$action.'lim']+0) > 0))  ?
 						    $args[$action.'lim']+0 : 0 ; //setlim
 				$act=$acts[$action];
 		 		foreach ($targets as $target){
				 	$replace_this= $search_root_l.$target.$search_root_r;
				 	if(!$act){//does omit!!!!!!!!
				 		// for loop
				 		$replace_this= $this->generate(tag);
				 		$new_group = str_replace($replace_this, '', $new_group);
				 		//add omit foo
				 		//
			 		}
			 		else{// performs disables and selects
				 		$use_lim =-1;
						if ($do_lim > 0 ){
							$sub = substr_count ($new_group, $replace_this);  // get a count of the number of intances of the str to be replaced
  							$use_lim = $sub > $do_lim ? $do_lim :  $sub; // if the count is more than the remaining limit...
							$do_lim =  $do_lim - $sub;  
 						}
				 		$replace_with = $byVal  ?  $replace_this.$act : $act.$replace_this;
				 		$new_group = str_replace($replace_this, $replace_with, $new_group, $use_lim);
						if ($do_lim < 1 ){    break;}	
				 		//add replace ct limit
			 		}
			 	}	 		 
  		 	}
 		 	return $new_group;
 		 	
 	}
 	
 }
 
 class rm_fg_datalist extends rm_tag_group{
	
	protected $selected 	= ' SELECTED ';	
	protected $tag 	 		= 'option';	
	protected $close_tag	= false;
	
}

 class rm_fg_select extends rm_tag_group{
	
	protected $selected 	= ' SELECTED ';	
	protected $tag 	 		= 'option';	
	protected $onlyByVal	= false;
	protected $has_text		= true;
}


$opts=<<<EOT

	<option value = "o-1">am option 1</option>
	<option value = "o-2">am option 2</option>
	<option value = "o-3">am option 3</option>
	<option value = "o-4">am option 4</option>
	<option value = "o-5">am option 5</option>
	<option value = "o-6">am option 6</option>
	<option value = "o-7">am option 7</option>
	<option value = "o-8">am option 8</option>
	<option value = "o-9">am option 9</option>
	<option value = "o-10">am option 10</option>
	<option value = "o-11">am option 11</option>
	<option value = "o-12">am option 12</option>
	<option value = "o-13">am option 13</option>
	<option value = "o-14">am option 14</option>
	<option value = "o-15">am option 15</option>

EOT;

$opts=array();
$opts[]=array("a"=>"first","b"=>"start","c"=>"test","d"=>"run","e"=>"luck");
$opts[]=array("a"=>"second","b"=>"continue","c"=>"test","d"=>"operate","e"=>"love");
$opts[]=array("a"=>"third","b"=>"waste","c"=>"test","d"=>"engage","e"=>"success");
$opts[]=array("a"=>"fourth","b"=>"end","c"=>"test","d"=>"deploy","e"=>"exit");
$opts[]=array("a"=>"fifth","b"=>"new end","c"=>"test","d"=>"test","e"=>"win");
$opts[]=array("a"=>"sixth","b"=>"newer end","c"=>"test","d"=>"test2","e"=>"winner");
$opts[]=array("a"=>"seven","b"=>"end end","c"=>"test","d"=>"test7","e"=>"health");
$opts[]=array("a"=>"eight","b"=>"end under  end","c"=>"test","d"=>"test7","e"=>"health");
$opts[]=array("a"=>"nine","b"=>"end over end","c"=>"test","d"=>"test7","e"=>"health");
$opts[]=array("a"=>"ten","b"=>"ten end","c"=>"test","d"=>"test7","e"=>"health");
$opts[]=array("a"=>"eleven","b"=>"strange end","c"=>"test","d"=>"test11","e"=>"better");
$opts[]=array("a"=>"twelve","b"=>"sure end","c"=>"test","d"=>"quiz","e"=>"best");

$a= new rm_fg_select($opts,'{{a}}-{{c}}-{{##}}','text string #{{##}}', array('ski'=>array(1)));

echo '<select>'.$a->output(false, array('sel'=>array('text string #3','text string #5','text string #10'), 'dis'=>array('text string #4','text string #8','text string #9','text string #6'), 'dislim'=>2)).'</select>';


