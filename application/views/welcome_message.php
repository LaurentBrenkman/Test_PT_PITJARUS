<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
	rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

<div class="container">
	<div class="row mt-4">
		<div class="col-12">
		<?php echo form_open(base_url('welcome/filterdata')); ?>
				<select name="select_area" id="area">
					<option value="">SELECT AREA</option>
					<?php foreach ($area as $key => $value) { ?>
          			<option value="<?php echo $value->area_id ?>"><?php echo $value->area_name ?></option>
        			<?php } ?>
				</select>
			<input type=date name="start_date"></input>
			<input type=date name="end_date"></input>
			<button type="submit">View</button>
			<?php echo form_close(); ?>
		</div>
		<canvas id="bar" height="100"></canvas>

		<div class="table">
			<table class="table">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Brand Name</th>
						<th>Area Name</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; foreach ($data as $key => $value) { ?>
					<tr>
						<td><?php echo $no++ ?></td>
						<td><?php echo $value->tanggal ?></td>
						<td><?php echo $value->brand_name ?></td>
						<td><?php echo $value->area_name ?></td>
						<td><?php echo $value->jumlah ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>

	const baseUrl = "<?php echo base_url();?>";
	var area_id = "<?php echo $area_id?>";
	var start_date = "<?php echo $start_date?>";
	var end_date = "<?php echo $end_date?>";
	console.log(area_id);

	const myChart = (chartType) => {
		$.ajax({
		url: baseUrl +'index.php/welcome/chart_data',
		data: {area_id : area_id, start_date: start_date, end_date:end_date},
		dataType: 'json',
		method: 'POST',
		success: data => {
			console.log (data)
			let chartX = []
			let chartY = []
			data.map( data => {
					chartX.push(data.area_name)
					chartY.push(data.jumlah)
			})
			const chartData = {
				labels: chartX,
				datasets: [
					{
						label: 'Product',
						data: chartY,
						backgroundColor: ['skyblue'],
						borderColor: ['skyblue'],
						borderWidth: 4
					}
				]
			}
			const ctx = document.getElementById(chartType).getContext('2d')
			const config = {
				type: chartType,
				data: chartData
			}
			const chart = new Chart(ctx, config)
		}
	})
	}

	myChart('bar')

</script>
</body>
</html>
