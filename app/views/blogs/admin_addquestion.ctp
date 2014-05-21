
<?php $javascript->link(array('jquery-1.3.2.min', 'formvalidation'), false); 
echo $javascript->link(array('behaviour.js','textarea_maxlen'));?>
<?php
echo $javascript->link(array('validation/jquery.validate',
                            'validation/jquery.validation.functions',
                            'validation/jquery.maskedinput'
                        )
                    );

 
?>

<script type="text/javascript">

$(document).ready(function(){
 var CSSrules = {
    'textarea' : function(element){
	     doKeyUp(element);
    }
 }
Behaviour.register(CSSrules);

});



function removeSpaces(string) {
	return string.split(' ').join('');
}

function userregisteration(){
 
	 jQuery(function(){
		 
			jQuery("#BlogQuestionQuestion").validate({
			   expression: "if (removeSpaces(VAL)) return true; else return false;",
			   message: "Please enter a question"
		   }); 
			 
           jQuery("#answer1").validate({
                    expression: "if (removeSpaces(VAL)) return true; else return false;",
                    message: "Please enter answer 1 "
                });
	   
	    jQuery("#answer2").validate({
                    expression: "if (removeSpaces(VAL)) return true; else return false;",
                    message: "Please enter answer 2 "
                });
	    
	     
	      jQuery("#answer3").validate({
                    expression: "if (removeSpaces(VAL)) return true; else return false;",
                    message: "Please enter answer 3 "
                });
	      
	       jQuery("#answer4").validate({
                    expression: "if (removeSpaces(VAL)) return true; else return false;",
                    message: "Please enter answer 4 "
                });
	       
	        jQuery("#answer5").validate({
                    expression: "if (removeSpaces(VAL)) return true; else return false;",
                    message: "Please enter answer 5 "
                });
		
		  jQuery("#choose_correct_answer").validate({
                    expression: "if (removeSpaces(VAL)) return true; else return false;",
                    message: "Please chosse a correct answer"
                });
			
		 
        }); 
}
</script>
<style type="text/css">
 .ValidationErrors{
  color: red;
    font-family: Arial;
    font-size: 9px;
    font-weight: bold;
    margin-left: 3px;
    margin-top: 3px;
 }
</style>

<?php echo  $form->create('Blog',array('action'=>'addquestion','method'=>'POST','name'=>'frmBlog','id'=>'frmBlogComment','enctype'=>'multipart/form-data'));
 //echo $javascript->link('fckeditor');
 if(!empty($id) ) { 
	echo $form->hidden('BlogQuestion.id',array('class'=>'textbox','label'=>false,'div'=>false,'value'=>$id));
	//echo $form->hidden('BlogQuestionAnswer.question_id',array('class'=>'textbox','label'=>false,'div'=>false,'value'=>$id));
	
 }
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td height="25" align="right"> 
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellspacing="1" cellpadding="3" > 
				<tr height="20px" colspan="2">
					<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				
				<tr>
					<td align="right"><span class="error_msg">*</span>Question: 
					</td><td>
					
					<?php echo $form->input('BlogQuestion.question',array('class'=>'textbox','cols'=>'50','rows'=>'4','showremain'=>'limitOne','label'=>false,'div'=>false,'maxlength'=>500));?>
					      <span id ="limitOne">500</span> characters left.
					</td>
				</tr>
				
				<tr>
					<td align="right"><span class="error_msg">*</span>Answer1: 
					</td><td>
					
					<?php echo $form->input('BlogQuestionAnswer.0.answer',array('class'=>'textbox','cols'=>'50','rows'=>'4','showremain'=>'limittwo','id'=>'answer1','label'=>false,'div'=>false,'maxlength'=>500));?>
					
					<span id ="limittwo">500</span> characters left.
						
					</td>
				</tr>
				
				
				<tr>
					<td align="right"><span class="error_msg">*</span>Answer2: 
					</td><td>
					
					<?php echo $form->input('BlogQuestionAnswer.1.answer',array('class'=>'textbox','cols'=>'50','rows'=>'4','showremain'=>'limitThree','id'=>'answer2','label'=>false,'div'=>false,'maxlength'=>500));?>
					
					<span id ="limitThree">500</span> characters left.
						
					</td>
				</tr>
				
				<tr>
					<td align="right"><span class="error_msg">*</span>Answer3: 
					</td><td>
					
					<?php echo $form->input('BlogQuestionAnswer.2.answer',array('class'=>'textbox','cols'=>'50','rows'=>'4','showremain'=>'limitFour','id'=>'answer3','label'=>false,'div'=>false,'maxlength'=>500));?>
					
					<span id ="limitFour">500</span> characters left.
						
					</td>
				</tr>
				
				<tr>
					<td align="right"><span class="error_msg">*</span>Answer 4: 
					</td><td>
					
					<?php echo $form->input('BlogQuestionAnswer.3.answer',array('class'=>'textbox','cols'=>'50','rows'=>'4','showremain'=>'limitFive','id'=>'answer4','label'=>false,'div'=>false,'maxlength'=>500));?>
					
					<span id ="limitFive">500</span> characters left.
						
					</td>
				</tr>
				
				<tr>
					<td align="right"><span class="error_msg">*</span>Answer 5: 
					</td><td>
					
					<?php echo $form->input('BlogQuestionAnswer.4.answer',array('class'=>'textbox','cols'=>'50','rows'=>'4','showremain'=>'limitSix','id'=>'answer5','label'=>false,'div'=>false,'maxlength'=>500));?>
					
					<span id ="limitSix">500</span> characters left.
						
					</td>
				</tr>
				
				
				
				<tr>
					<td align="right"><span class="error_msg">*</span>Correct Answer: 
					</td><td>
					
					
				       <?php
				echo $form->select('BlogQuestion.correct_answer',array('1'=>'Answer1','2'=>'Answer2','3'=>'Answer3','4'=>'Answer4','5'=>'Answer5'), null, array('class'=> 'textbox', 'id'=>'choose_correct_answer','div'=>false,'label'=>false,'empty'=>null), 'Select Correct Answer');

 echo $form->hidden('BlogQuestion.number_of_answers',array('class'=>'textbox','label'=>false,'div'=>false,'value'=>5));?>
 <?php if(isset($errors['correct_answer']) && !empty($errors['correct_answer'])) {
  
  echo '<div class="error-message">'.$errors['correct_answer'].'</div>';
 }
 ?>
					</td>
				</tr>
				
				<tr>
					<td align="center"></td>
					<td align="left">
						<?php 
						if(empty($this->data['BlogQuestion']['id']))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";

						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false,'onclick'=>'return userregisteration();'));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/blogs/reviewquestions')"));?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php

echo $form->end();

?>