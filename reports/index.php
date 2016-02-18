<?php
	include_once('../inc/config.php');
	include_once('../inc/header.php');
	$startdate=new DateTime('first day of this month'); 
	$enddate=new DateTime('last day of this month'); 
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<div id="content" class="large-8 large-push-2 columns">
	<div class="title">
		<div class="inlineDiv clickAble" data-type="gourl" data-url="index.php">
			Reports
		</div>
		<i class="icon-icons_thickrightarrow smalli"></i> <span class="subSubTitle">Dashboard</span>
	</div>
	<div class="row contentFill">
		<div class="medium-12 columns leftnp rightnp">
			<div class="callout panel white">
				<div class="tableReports">
					<div class="tableReportsHead tableColumn-3 clickAble white" data-type="gourl" data-url="index.php">
						Dashboard
					</div>
					<div class="tableReportsHead tableColumn-3 clickAble" data-type="gourl" data-url="nomination.php">
						Nomination
					</div>
					<div class="tableReportsHead tableColumn-3 clickAble" data-type="gourl" data-url="redemption.php">
						Redemption
					</div>
					<div class="tableColumn-3">
					</div>
				</div>
			</div>
		</div>
		<div id="subHome" class="callout panel dashboard white">
			<div class="tableColumn-6">
				<div class="dashboardGraphs">
					<p>Awards this month:
						<?=getTotalReport($startdate->format('Y-m-d 00:00:00'),$enddate->format('Y-m-d 23:59:59'))?>
					</p>
					<script type="text/javascript">
						google.load("visualization", "1", {packages:["corechart"]});
						google.setOnLoadCallback(drawChart);
						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								['Task', 'Total Nominations'],
								['Pending', <?=getTotalPendingReport($startdate->format('Y-m-d 00:00:00'),$enddate->format('Y-m-d 23:59:59'))?>],
								['Approved', <?=getTotalApprovedReport($startdate->format('Y-m-d 00:00:00'),$enddate->format('Y-m-d 23:59:59'))?>],
								['Declined', <?=getTotalDeclinedReport($startdate->format('Y-m-d 00:00:00'),$enddate->format('Y-m-d 23:59:59'))?>]
							]);
							var options = {
								backgroundColor: 'none',
								pieHole: 0.8,
								chartArea: {top: 20, height: 160 },
								legend: {position: 'none'},
								pieSliceTextStyle: { color: '#000000', fontSize: 12},
								slices: [{color: '#00b6ed'}, {color: '#ec008c'}, {color: '#5833a2'}]
							};
							var chart = new google.visualization.PieChart(document.getElementById('donutchart1'));
							chart.draw(data, options);
						}
					</script>
					<div id="donutchart1" style="width: 300px; height:220px;">
					</div>
					<div class="pieLegend piePending">
						<i>-</i>Pending -
						<?=getTotalPendingReport($startdate->format('Y-m-d 00:00:00'),$enddate->format('Y-m-d 23:59:59'))?>
					</div>
					<div class="pieLegend pieApproved">
						<i>-</i>Approved -
						<?=getTotalApprovedReport($startdate->format('Y-m-d 00:00:00'),$enddate->format('Y-m-d 23:59:59'))?>
					</div>
					<div class="pieLegend pieDeclined">
						<i>-</i>Declined -
						<?=getTotalDeclinedReport($startdate->format('Y-m-d 00:00:00'),$enddate->format('Y-m-d 23:59:59'))?>
					</div>
				</div>
			</div>
			<div class="tableColumn-6">
				<div class="dashboardGraphs">
					<p>Total Awards:
						<?=getTotalReport()?>
					</p>
					<script type="text/javascript">
						google.load("visualization", "1", {packages:["corechart"]});
						google.setOnLoadCallback(drawChart);
						function drawChart() {
							var data = google.visualization.arrayToDataTable([
								['Task', 'Total Nominations'],
								['Pending', <?=getTotalPendingReport()?>],
								['Approved', <?=getTotalApprovedReport()?>],
								['Declined', <?=getTotalDeclinedReport()?>]
							]);
							var options = {
								backgroundColor: 'none',
								pieHole: 0.8,
								chartArea: {top: 20, height: 160 },
								legend: {position: 'none'},
								pieSliceTextStyle: { color: '#000000', fontSize: 12},
								slices: [{color: '#00b6ed'}, {color: '#ec008c'}, {color: '#5833a2'}]
							};
							var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
							chart.draw(data, options);
						}
					</script>
					<div id="donutchart2" style="width: 300px; height:220px;">
					</div>
					<div class="pieLegend piePending">
						<i>-</i>Pending -
						<?=getTotalPendingReport()?>
					</div>
					<div class="pieLegend pieApproved">
						<i>-</i>Approved -
						<?=getTotalApprovedReport()?>
					</div>
					<div class="pieLegend pieDeclined">
						<i>-</i>Declined -
						<?=getTotalDeclinedReport()?>
					</div>
				</div>
			</div>
			<p>&nbsp;</p>
		</div>
		<div class="row">
			<div class="medium-4 columns leftnp">
				<div class="callout panel reportLikes">
					<div class="likeHead">
						Likes
					</div>
					<i class="icon-icons_mail"></i> <?php echo getTotalLikes() ?>
				</div>
			</div>
			<div class="medium-8 columns leftnp rightnp" id="reportTop10">
				<div class="callout panel">
					<div class="tableTitle">
						Top 10 nominees
					</div>
					<div class="medium-6 columns leftnp rightnp borderRight">
						<?php
				// get top 5 nominees
				$nominees = getTopTen(0);
				$x = 0;
				foreach ($nominees as $list){
					$x ++;
				?>
						<div class="tableRow">
							<div class="tableColumn-2">
								<?php
						switch ($x) {
							case 1:
								echo $x.'<sup>st</sup>';
								break;
							case 2:
								echo $x.'<sup>nd</sup>';
								break;
							case 3:
								echo $x.'<sup>rd</sup>';
								break;
							default:
								echo $x.'<sup>th</sup>';
								break;
							}
						?>
							</div>
							<div class="tableColumn-9">
								<?php echo getName($list->NominatedEmpNum); ?>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="medium-6 columns leftnp rightnp">
						<?php
				// get top 5-10 nominees
				$nominees = getTopTen(5);
				foreach ($nominees as $list){
					$x ++;
				?>
						<div class="tableRow">
							<div class="tableColumn-2">
								<?php echo $x.'<sup>th</sup>'; ?>
							</div>
							<div class="tableColumn-9">
								<?php echo getName($list->NominatedEmpNum); ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('../inc/footer.php'); ?>
