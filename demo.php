<style>
	input[disabled]+label{ color:#777;}
	h4{ margin-bottom:0;}
</style>
<?
/**
 * Script: form_opt_group---DEMO
 * Author: Ray Messina
 * Copyright: 2020 Ray Messina Design;
 * GNU General Public License
**/
require_once 'rm_opt_group.php';


//SAMPLE DATA
$opts_string=<<<EOT

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
$opts_string_dl=<<<EOT

	<option value = "o-1" >
	<option value = "o-2" >
	<option value = "o-3" >
	<option value = "o-4" >
	<option value = "o-5" >
	<option value = "o-6" >
	<option value = "o-7" >
	<option value = "o-8" >
	<option value = "o-9" >
	<option value = "o-10" >
	<option value = "o-11" >
	<option value = "o-12" >
	<option value = "o-13" >
	<option value = "o-14" >
	<option value = "o-15" >

EOT;
$opts_string_ch=<<<EOT

	<input  type = "checkbox"  name="chk_1" id = "id-0"  value = "o-first" > <label for = "id-0">first</label> 
	<input  type = "checkbox"  name="chk_2" id = "id-2"  value = "o-third" > <label for = "id-2">third</label> 
	<input  type = "checkbox"  name="chk_3" id = "id-3"  value = "o-fourth" > <label for = "id-3">fourth</label> 
	<input  type = "checkbox"  name="chk_4" id = "id-4"  value = "o-fifth" > <label for = "id-4">fifth</label> 
	<input  type = "checkbox"  name="chk_5" id = "id-5"  value = "o-sixth" > <label for = "id-5">sixth</label> 
	<input  type = "checkbox"  name="chk_6" id = "id-6"  value = "o-seven" > <label for = "id-6">seven</label> 
	<input  type = "checkbox"  name="chk_7" id = "id-7"  value = "o-eight" > <label for = "id-7">eight</label> 
	<input  type = "checkbox"  name="chk_8" id = "id-8"  value = "o-nine" > <label for = "id-8">nine</label> 
	<input  type = "checkbox"  name="chk_9" id = "id-9"  value = "o-ten" > <label for = "id-9">ten</label> 
	<input  type = "checkbox"  name="chk_10" id = "id-10"  value = "o-eleven" > <label for = "id-10">eleven</label> 
	<input  type = "checkbox"  name="chk_11" id = "id-11"  value = "o-twelve" > <label for = "id-11">twelve</label>

EOT;
$opts_string_rd=<<<EOT

	<input  type = "radio"  name ="rad_set" id = "id-0"  value = "o-first" > <label for = "id-0">first</label> 
	<input  type = "radio"  name ="rad_set" id = "id-2"  value = "o-third" > <label for = "id-2">third</label> 
	<input  type = "radio"  name ="rad_set" id = "id-3"  value = "o-fourth" > <label for = "id-3">fourth</label> 
	<input  type = "radio"  name ="rad_set" id = "id-4"  value = "o-fifth" > <label for = "id-4">fifth</label> 
	<input  type = "radio"  name ="rad_set" id = "id-5"  value = "o-sixth" > <label for = "id-5">sixth</label> 
	<input  type = "radio"  name ="rad_set" id = "id-6"  value = "o-seven" > <label for = "id-6">seven</label> 
	<input  type = "radio"  name ="rad_set" id = "id-7"  value = "o-eight" > <label for = "id-7">eight</label> 
	<input  type = "radio"  name ="rad_set" id = "id-8"  value = "o-nine" > <label for = "id-8">nine</label> 
	<input  type = "radio"  name ="rad_set" id = "id-9"  value = "o-ten" > <label for = "id-9">ten</label> 
	<input  type = "radio"  name ="rad_set" id = "id-10"  value = "o-eleven" > <label for = "id-10">eleven</label> 
	<input  type = "radio"  name ="rad_set" id = "id-11"  value = "o-twelve" > <label for = "id-11">twelve</label>

EOT;

$opts_array=array();
$opts_array[]=array("a"=>"first","b"=>"start","c"=>"test","d"=>"run","e"=>"luck");
$opts_array[]=array("a"=>"second","b"=>"continue","c"=>"test","d"=>"operate","e"=>"love");
$opts_array[]=array("a"=>"third","b"=>"waste","c"=>"test","d"=>"engage","e"=>"success");
$opts_array[]=array("a"=>"fourth","b"=>"end","c"=>"test","d"=>"deploy","e"=>"exit");
$opts_array[]=array("a"=>"fifth","b"=>"new end","c"=>"test","d"=>"test","e"=>"win");
$opts_array[]=array("a"=>"sixth","b"=>"newer end","c"=>"test","d"=>"test2","e"=>"winner");
$opts_array[]=array("a"=>"seven","b"=>"end end","c"=>"test","d"=>"test7","e"=>"health");
$opts_array[]=array("a"=>"eight","b"=>"end under  end","c"=>"test","d"=>"test7","e"=>"health");
$opts_array[]=array("a"=>"nine","b"=>"end over end","c"=>"test","d"=>"test7","e"=>"health");
$opts_array[]=array("a"=>"ten","b"=>"ten end","c"=>"test","d"=>"test7","e"=>"health");
$opts_array[]=array("a"=>"eleven","b"=>"strange end","c"=>"test","d"=>"test11","e"=>"better");
$opts_array[]=array("a"=>"twelve","b"=>"sure end","c"=>"test","d"=>"quiz","e"=>"best");
?>

<h4>SELECT   demos:</h4>
<label>Array/By Value</label>
<? $sample= new rm_fg_select ($opts_array,'o-{{a}}','am option {{##}}', array('aft'=>' <label for = "id-{{##}}">{{a}}</label> ', 'ski'=>array(1),'att'=>array('id'=>"id-{{##}}"))); ?>
<select><?
	echo $sample->output(true, array('sel'=>array('o-fifth','fifth', 'o-sixth','o-ten'), 'dis'=>array('o-twelve','nine','text string #9','text string #6'), 'sellim'=>3 , 'omit'=>array('eight','o-eight')  ))  ;
?></select><br>
<label>Array/By Text</label>
<select><?
	echo $sample->output(false, array('sel'=>array('am option 5','am option 10','am option 13'), 'dis'=>array('am option 8','am option 7'), 'sellim'=>2 , 'omit'=>array('am option 6','am option 9')  ))  ;
?></select>

<? $sample= new rm_fg_select ($opts_string, 'o-{{a}}','am option {{a}}', array('aft'=>' <label for = "id-{{##}}">{{a}}</label> ', 'ski'=>array(1),'att'=>array('id'=>"id-{{##}}"))); ?>

<br><label>String/By Value</label>

<select><?
	echo $sample->output(true, array('sel'=>array('o-5',  'o-10','o-13'), 'dis'=>array('o-6','o-9' ), 'sellim'=>2 , 'omit'=>array('o-1','o-2')  ))  ;
?></select><br>
<label>String/By Text</label>
<select><?
	echo $sample->output(false, array('sel'=>array('am option 5','am option 10','am option 13'), 'dis'=>array('am option 8','am option 7'), 'sellim'=>2 , 'omit'=>array('am option 6','am option 9')  ))  ;
?></select>

 
<h4>DATALIST   demos:</h4>
<label>Array/By Value</label>

<input list="testone" id="test-one" name="test-one" />


<? $sample= new rm_fg_datalist ($opts_array,'o-{{a}}','am option {{##}}', array('aft'=>' <label for = "id-{{##}}">{{a}}</label> ', 'ski'=>array(1),'att'=>array('id'=>"id-{{##}}"))); ?>
<datalist id="testone"><?
	echo $sample->output(true, array('sel'=>array('o-fifth','fifth', 'o-sixth','o-ten'), 'dis'=>array('o-twelve','nine','text string #9','text string #6'), 'sellim'=>3 , 'omit'=>array('o-first')  ))  ;
?></datalist><br>

<label>Array/By Text</label>
<input list="testtwo" id="test-two" name="test-two" />

<datalist id="testtwo"><?
	echo $sample->output(false, array('sel'=>array('am option 5','am option 10','am option 13'), 'dis'=>array('am option 8','am option 7'), 'sellim'=>2 , 'omit'=>array('am option 6','am option 9')  ))  ;
?></datalist>

<? $sample= new rm_fg_datalist ($opts_string_dl, 'o-{{a}}','am option {{a}}', array('aft'=>' <label for = "id-{{##}}">{{a}}</label> ', 'ski'=>array(1),'att'=>array('id'=>"id-{{##}}"))); ?>

<br><label>String/By Value</label>
<input list="testthree" id="test-three" name="test-three" />

<datalist id="testthree"><?
	echo $sample->output(true, array('sel'=>array('o-5',  'o-10','o-13'), 'dis'=>array('o-6','o-9' ), 'sellim'=>2 , 'omit'=>array('o-1','o-2')  ))  ;
?></datalist><br>


<label>String/By Text</label>
<datalist id="testfour"><?
	echo $sample->output(false, array('sel'=>array('am option 5','am option 10','am option 13'), 'dis'=>array('am option 8','am option 7'), 'sellim'=>2 , 'omit'=>array('am option 6','am option 9')  ))  ;
?></datalist>
<input list="testfour" id="test-four" name="test-four" />





<h4>CHECKBOX   demos:</h4>
<p>Array/By Value</p>
<? $sample= new rm_fg_checkbox ($opts_array,'o-{{a}}','text string #{{##}}', array('aft'=>' <label for = "id-{{##}}">{{a}}</label> ', 'ski'=>array(1),'att'=>array('id'=>"id-{{##}}"))); ?>
<div><? echo $sample->output(true, array('sel'=>array('o-fifth', 'o-seven','o-ten'), 'dis'=>array('o-nine'), 'sellim'=>3, 'omit'=>array('o-sixth','o-eight')     ))  ;
?></div>
<p>Array/By Text</p>
<div><? echo $sample->output(false, array('sel'=>array('fourth', 'seven','ten'), 'dis'=>array('nine'), 'sellim'=>2, 'omit'=>array('sixth','eight')     ))  ;
?></div>


<? $sample= new rm_fg_checkbox ($opts_string_ch,'o-{{a}}','text string #{{##}}', array('aft'=>' <label for = "id-{{##}}">{{a}}</label> ', 'ski'=>array(1),'att'=>array('id'=>"id-{{##}}"))); ?>
<p>String/By Value</p>
<div><? echo $sample->output(true, array('sel'=>array('o-fifth', 'o-seven','o-ten'), 'dis'=>array('o-nine'), 'sellim'=>3, 'omit'=>array('o-sixth','o-eight')     ))  ;
?></div>
<p>String/By Text</p>
<div><? echo $sample->output(false, array('sel'=>array('fourth', 'seven','ten'), 'dis'=>array('nine'), 'sellim'=>2, 'omit'=>array('sixth','eight')     ))  ;
?></div>



<h4>RADIO BUTTON   demos:</h4>
<p>Array/By Value</p>
<? $sample= new rm_fg_radiobutton ($opts_array,'o-{{a}}','text string #{{##}}', array('name'=>'luckradio', 'aft'=>' <label for = "id-{{##}}">{{a}}</label> ', 'ski'=>array(1),'att'=>array('id'=>"id-{{##}}"))); ?>
<div><? echo $sample->output(true, array('sel'=>array('o-fifth', 'o-seven','o-ten'), 'dis'=>array('o-nine'), 'sellim'=>3, 'omit'=>array('o-sixth','o-eight')     ))  ;
?></div>
<p>Array/By Text</p>
<div><? echo $sample->output(false, array('name'=>'loveradio', 'sel'=>array('fourth', 'seven','ten'), 'dis'=>array('nine'), 'sellim'=>2, 'omit'=>array('sixth','eight')     ))  ;
?></div>


<? $sample= new rm_fg_radiobutton ($opts_string_rd,'o-{{a}}','text string #{{##}}', array('name'=>'rad_set','aft'=>' <label for = "id-{{##}}">{{a}}</label> ', 'ski'=>array(1),'att'=>array('id'=>"id-{{##}}"))); ?>
<p>String/By Value</p>
<div><? echo $sample->output(true, array('name'=>'healthradio', 'sel'=>array('o-fifth', 'o-seven','o-ten'), 'dis'=>array('o-nine'), 'sellim'=>3, 'omit'=>array('o-sixth','o-eight')     ))  ;
?></div>
<p>String/By Text</p>
<div><? echo $sample->output(false, array('name_'=>'aftOOO','sel'=>array('fourth', 'seven','ten'), 'dis'=>array('nine'), 'sellim'=>2, 'omit'=>array('sixth','eight')     ))  ;
?></div>
