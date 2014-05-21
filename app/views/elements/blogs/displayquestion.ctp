<?php if(!empty($questions) && count($questions) >0) {
			
			?>
 <span class="line_break_new graytext"><?php
 
 echo $questions['BlogQuestion']['question'];?> <?php if($count<=2) { echo $html->link("Show me a different question","javascript:",array("escape"=>false,"title"=>"Show me a different question","id"=>"diff_question","onclick"=>"showDifferentQuestion();",'class'=>'queslink')); }?></span>
					    <section class="select_ans_widget" >
					    <section class="leftoptions">						
						<?php
						foreach ($questions['BlogQuestionAnswer'] as $key=>$data)
						{?>
						<section class="sel_ans">
						      <span class="rdo_opt"><input type="radio" name="data[BlogQuestionAnswer][correct_answer]" value="<?php echo $data['answer'];?>" ></span>
						<span class="anstxt"> <?php echo $data['answer'];?> </span>
						</section>
						<?php } ?>
						
					   </section>
					<section class="choose_ans"><?php echo $this->Html->image('/img/choose_answer.png', array('alt' => 'Choose Answer','title'=>'Choose Answer'))?></section>
					
					</section>
					    
			<section class="clear"></section>
			
		     <?php
		  echo $form->hidden('BlogQuestion.newid',array('class'=>'textbox','label'=>false,'div'=>false,'value'=>$questions['BlogQuestion']['id']));
		    } ?>
                                	
                                
                              