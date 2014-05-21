<?php
App::import('Vendor','jpgraph' ,array('file'=>'jpgraph/src/jpgraph.php'));
App::import('Vendor','jpgraph_pie' ,array('file'=>'jpgraph/src/jpgraph_pie.php'));
App::import('Vendor','jpgraph_pie3d' ,array('file'=>'jpgraph/src/jpgraph_pie3d.php'));
App::import('Vendor','jpgraph_bar' ,array('file'=>'jpgraph/src/jpgraph_bar.php'));
App::import('Vendor','jpgraph_line' ,array('file'=>'jpgraph/src/jpgraph_line.php'));
App::import('Vendor','jpgraph_plotline' ,array('file'=>'jpgraph/src/jpgraph_plotline.php'));


class JpgraphComponent extends Object{

	function displayPieGraph($valArr = null,$user_id = null){
// 	  pr($valArr);
		$data = $valArr;
		$graph = new PieGraph(250,210);
		$graph->SetShadow(false);
		$graph->img->SetMargin(0,0,0,0);
		$p1 = new PiePlot3D($data);
		$p1->SetAngle(70);
		$p1->SetCenter(0.38,0.55,4.55,0.35);
		$p1->SetStartAngle(90);
		$theme_class= new VividTheme;
		$graph->SetTheme($theme_class);
		$graph->Add($p1);
// 		array(
// 		'Books' => '#3d6bab',
// 		'Music' => '#767776',
// 		'Movies' => '#008200',
// 		'Games' => '#1998FF',
// 		'Electronics' => '#cf5538',
// 		'Office & Computing' => '#81007f',
// 		'Mobile' => '#000000',
// 		'Home & Garden' => '#97413a',
// 		'Health & Beauty' => '#ff804a',
// 		);
		$p1->SetSliceColors(array('#3d6bab','#767776','#008200','#1998FF','#cf5538','#81007f','#000000','#97413a','#ff804a'));
		$graph->Stroke( WWW_ROOT.PATH_GRAPH."order-history-graph_".$user_id.".png");
	}


	function displayBarGraph($valArr = null,$x_axis=null,$user_id = null){
		$total_value = 0;$avg_val = 0;
		//$valArr = array(2000,4000,6000,3000,1000,4500,2345,5678);
		$datay = $valArr;
		if(!empty($datay)){
			foreach($datay as $val_data){
				$total_value = $val_data + $total_value;
			}
		}
		$total_Count = count($datay);
		if(empty($total_Count)){
			$total_Count = 1;
		}
		
		$avg_val = round(($total_value/$total_Count),2);
		
		// Set up the graph
		
		$graph = new Graph(230,230,"auto");
		$avg_valArr = array();

		if(!empty($x_axis)){
			foreach($x_axis as $x_ax){
				$x_ax = explode('-',$x_ax);
				if($x_ax[0] == '01'){
					$x_ax[0] = 'Jan';
				} else if($x_ax[0] == '02'){
					$x_ax[0] = 'Feb';
				} else if($x_ax[0] == '02'){
					$x_ax[0] = 'Feb';
				} else if($x_ax[0] == '03'){
					$x_ax[0] = 'Mar';
				} else if($x_ax[0] == '04'){
					$x_ax[0] = 'Apr';
				} else if($x_ax[0] == '05'){
					$x_ax[0] = 'May';
				} else if($x_ax[0] == '06'){
					$x_ax[0] = 'Jun';
				} else if($x_ax[0] == '07'){
					$x_ax[0] = 'Jul';
				} else if($x_ax[0] == '08'){
					$x_ax[0] = 'Aug';
				} else if($x_ax[0] == '09'){
					$x_ax[0] = 'Sep';
				} else if($x_ax[0] == '10'){
					$x_ax[0] = 'Oct';
				} else if($x_ax[0] == '11'){
					$x_ax[0] = 'Nov';
				} else if($x_ax[0] == '12'){
					$x_ax[0] = 'Dec';
				}
				$new_x_axis[] = $x_ax[0]."\n".$x_ax[1];
// 				$avg_valArr[] = $avg_val;
			}
		}

		

		$graph->img->SetMargin(40,0,10,40);
		
		$graph->SetScale("textlin");
		$graph->SetMarginColor("teal");
		
		$graph->SetShadow();

		$graph->SetBox(false);

		// Create the bar pot
		
		$bplot = new BarPlot($datay);
		
		$bplot->SetWidth(0.6);
		
		//$bplot->SetFillColor("orange");

		$graph->xaxis->SetTickLabels($new_x_axis);
		$graph->xaxis->SetFont(FF_FONT0);
		$graph->yaxis->scale->SetGrace(5);
		$graph->ygrid->SetFill(false);
		$graph->ygrid->Show(false);
		//$graph->yaxis->SetTickPositions(array($avg_val),$aMinTickPos=NULL,'Avg');
		// Create the line
// 		$avg_amount = new LinePlot($avg_valArr);

		$avg_amount = new PlotLine(HORIZONTAL,$avg_val,'#FE8C43',2);
		//$avg_amount->SetLegend("Average Spend");//Added by Gyan

		$t = new Text("Average Spend",105,155);
		//$t->SetPos(($avg_val/100),($avg_val/100));
		//$t->SetScalePos(600,20);
		$t->SetFont(FF_ARIAL,FS_NORMAL,7);
		$t->SetColor('#000000');
		
		$graph->Add($t);
		$graph->Add($avg_amount);

		$graph->Add($bplot);
		
		
		$bplot_colors = array();
		if(!empty($x_axis)){
			$i = 0; $j = 0;
			$cu_year = date('y');
			foreach($x_axis as $x_ax){
				$x_a = explode('-',$x_ax);
				//pr($x_a[1]);
				if($x_a[1] == $cu_year){
					$i = $i+1;
					$bplot_colors[] = '#ff804a';
					$border_color[] = '#FE8C43';
				} else {
					$j = $j+1;
					$bplot_colors[] = '#767776';
					$border_color[] = '#D8D8D8';
				}
			}
		}
		
		$bplot->SetFillColor($bplot_colors);
		$bplot->SetColor($border_color);
		$bplot->SetWeight(2);
		$graph->yaxis->SetTickLabels(array('£0'));
		$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,7);
		$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7);
		//$graph->yaxis->title->Set("Amount in ponds");
		//$graph->xaxis->title->Set("Months");
		@chmod(WWW_ROOT.PATH_GRAPH,0777);
		$graph->Stroke(WWW_ROOT.PATH_GRAPH."order-history-bar-graph_".$user_id.".png");
	}


	function sales_graph($year_sales = null,$seller_id = null,$values = null){

		//$data3y = $year_sales[date('Y')];
		//$data2y = $year_sales[date('Y')-1];
		//$data1y = $year_sales[date('Y')-2];

		$data3y = $values[date('Y')];
		$data2y = $values[date('Y')-1];
		$data1y = $values[date('Y')-2];

		//$value_data3y = $values[date('Y')];
		//$value_data2y = $values[date('Y')-1];
		//$value_data1y = $values[date('Y')-2];
		// Create the graph. These two calls are always required
		$graph = new Graph(927,368,"auto");
		$graph->SetScale("textlin");
		//$graph->yscale->SetAutoTicks();
		$graph->SetShadow();
		$graph->img->SetMargin(40,60,40,40);
		$graph->SetShadow();
		$graph->SetBox(false);
		$b1plot = new BarPlot($data1y);
		$b2plot = new BarPlot($data2y);
		$b3plot = new BarPlot($data3y);
		// Create the accumulated bar plots
		$ab1plot = new AccBarPlot(array($b1plot,$b2plot,$b3plot));
		$graph->legend->SetAbsPos(-8,90,'right','top');
		$graph->legend->SetColumns(1);
		$graph->legend->SetVColMargin(5);
		$graph->ygrid->SetFill(false);
		//$graph->ygrid->Show(false);
		$graph->xaxis->SetTickLabels(array('January','February','March','April','May','June','July','August','September','October','November','December'));

		$graph->yaxis->SetTickLabels(array('£0'));
		$b1plot->SetLegend(date('Y')-2);
		$b2plot->SetLegend(date('Y')-1);
		$b3plot->SetLegend(date('Y'));
		// ...and add it to the graph
		$graph->Add($ab1plot);
		
		$b1plot->SetFillColor("#4F81BE");
		$b1plot->SetWeight(0);
		$b2plot->SetFillColor("#C1504D");
		$b2plot->SetWeight(0);
		$b3plot->SetFillColor("#9CBC59");
		$b3plot->SetWeight(0);
		$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$b1plot->value->show();
		$b1plot->SetValuePos('center');
		$b1plot->value->SetFormat("%01.1f");
		$b1plot->value->SetFont(FF_ARIAL,FS_NORMAL,6);
		$b1plot->value->SetColor('#000000');
		//$b1plot->SetCSIMTargets($targ1,'nakul');
// 		$b1plot->value->SetSuperFont('arial','normal','6');
		$b2plot->value->show();
		$b2plot->value->SetFormat("%01.1f");
		$b2plot->SetValuePos('center');
		$b2plot->value->SetFont(FF_ARIAL,FS_NORMAL,6);
		//$b2plot->SetCSIMTargets($targ,'nakul1');

		$b2plot->value->SetColor('#000000');
		$b3plot->SetValuePos('center');
		$b3plot->value->show();
		$b3plot->value->SetFormat("%01.1f");
		$b3plot->value->SetFont(FF_ARIAL,FS_NORMAL,6);
		//$b3plot->SetCSIMTargets($targ2,'nakul2');
		$b3plot->value->SetColor('#000000');
		// Display the graph
		$graph->Stroke(WWW_ROOT.PATH_GRAPH."seller/sales-order-graph_".$seller_id.".png");
	}
}
?>