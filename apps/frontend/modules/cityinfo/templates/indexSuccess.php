<pre>
	<?php 
		// echo $results->get('total'); 
		// print_r(get_class_methods($results)); 
		// var_dump($results);
		$res = $sf_data->getRaw('results')['DeFactoSF1Part1ByNameStateResult'];
		echo 'There is '.$res['Total'].' people in the '.$res['NAME'];
		
		// foreach($results->getRaw() as $result)
		// {
		// 	print_r($result);
		// }
	?>
</pre>