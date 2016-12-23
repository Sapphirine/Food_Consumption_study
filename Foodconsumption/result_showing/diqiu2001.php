
<?php

$arr = Array();

$file_name="fbs_cluster_2001.csv";
$file = fopen($file_name,'r'); 
while ($data = fgetcsv($file)) { //Ã¿´Î¶ÁÈ¡CSVÀïÃæµÄÒ»ÐÐÄÚÈÝ
	array_push($arr,$data);
 }
fclose($file);
$json ="";
foreach ($arr as $v=>$a) 
{  
	
	
	$name = $a[1];
	$name = str_replace("'","",$name);
	$json=$json."{name: '".$name."', value: ".$a['2']."},";
	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	
	<script src="echarts.min.js"></script>
	<script src="http://gallery.echartsjs.com/dep/echarts/map/js/world.js"></script>

<title>FoodMap</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.0.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--Google Fonts-->
<link href='http://fonts.googleapis.com/css?family=Hind:400,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Aladin' rel='stylesheet' type='text/css'>
<!--google fonts-->
<!-- animated-css -->
		<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
		<script src="js/wow.min.js"></script>
		<script>
		 new WOW().init();
		</script>
<!-- animated-css -->
<script src="js/bootstrap.min.js"></script>
</head>

<body>
<!--header-top start here-->
<div class="top-header">
	<div class="container">
		<div class="top-header-main">
			<div class="col-md-4 top-social wow bounceInLeft" data-wow-delay="0.3s">
			    <ul>
			    	<li><h5>Group info :</h5></li>
			 	    	<li><a href="https://www.ee.columbia.edu/~cylin/course/bigdata/getgroupinfo.html">Group 91</a></li>
			    </ul>
			</div>
			<div class="col-md-8 header-address wow bounceInRight" data-wow-delay="0.3s">
				<ul>
					
					<li><span class="email"> </span><h6><a href="mailto:info@example.com">zk2202@cloumbia.edu</a></h6></li>
				</ul>
			</div>
		  <div class="clearfix"> </div>
		</div>
	</div>
</div>
<!--header-top end here-->
<!--header start here-->
	<!-- NAVBAR
		================================================== -->
<div class="header">
	<div class="fixed-header">	

		    <div class="navbar-wrapper">
		      <div class="container">
		        <nav class="navbar navbar-inverse navbar-static-top">
		             <div class="navbar-header">
			              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			                <span class="sr-only">Toggle navigation</span>
			                <span class="icon-bar"></span>
			                <span class="icon-bar"></span>
			                <span class="icon-bar"></span>
			              </button>
			             
		            <div id="navbar" class="navbar-collapse collapse">
		            <nav class="cl-effect-16" id="cl-effect-16">
		              <ul class="nav navbar-nav">
		               <li><a class="active" href="index.html" data-hover="Home">Home</a></li>
		                <li><a href="diqiu.php" data-hover="FoodMap">FoodMap</a></li>
						<li><a href="obbing.php" data-hover="Obesity">Obesity</a></li>
						<li><a href="countries.html" data-hover="Countries">Countries</a></li>
						<li><a href="bing.php" data-hover="GDP&Cluster">GDP&Cluster</a></li>
						<li><a href="http://www.fao.org/faostat/en/#home" data-hover="Source">Source</a></li>						
		              </ul>
		            </nav>

		            </div>
		            <div class="clearfix"> </div>
		             </nav>
		          </div>
		           <div class="clearfix"> </div>
		    </div>
	 </div>
</div>
<!--header end here-->
<div class="header" align ="center" style="height:100px;" >
<p align="center"><h1>2001 Year Food Consumption Result</h1></p>
</div>
	 <div id="main" style="width: 1600px;height:900px;"></div>
	 <input type="hidden" id="data" value="<?php echo $json?>" />
	<script>
	
	 var myChart = echarts.init(document.getElementById('main'));
		option = {
    title: {
      
      
        sublink: 'http://esa.un.org/wpp/Excel-Data/population.htm',
        left: 'center',
        top: 'top'
    },
   /*tooltip: {
        trigger: 'item',
        formatter: function (params) {
            var value = (params.value + '').split('.');
            value = value[0].replace(/(\d{1,3})(?=(?:\d{3})+(?!\d))/g, '$1,')
                    + '.' + value[1];
            return params.seriesName + '<br/>' + params.name + ' : ' + value;
        }
    },*/
   
    visualMap: {
        min: 0,
        max: 5,
        text:['Cluster5','Cluster1'],
        realtime: false,
        calculable: true,
        color: ['orangered','yellow','lightskyblue']
    },
    series: [
        {
            name: 'World Population (2010)',
            type: 'map',
            mapType: 'world',
            roam: true,
            itemStyle:{
                emphasis:{label:{show:true}}
            },
            data:[
            <?php echo $json?>
			  
            ]
        }
    ]
};
 myChart.setOption(option);
 

	</script>
	<div class="copy-right">
	
      <p class="grid1" >
       <a href="diqiu.php"> <button type="button" class="btn btn-lg btn-info" >previous year</button></a>
        <a href="diqiu2002.php"><button type="button" class="btn btn-lg btn-info" >next year</button></a>
      </p>
  
      <!--//button-->
   
</div>
	

<!--footer end here-->
</body>
</html>