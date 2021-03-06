<?php

function getJson($goods_list,$i){
	$tmpjson = "";
	$tmpjson="{name:'".$goods_list[0][0]."',value:".$goods_list[$i][0]."},";
	$tmpjson.="{name:'".$goods_list[0][1]."',value:".$goods_list[$i][1]."},";
	$tmpjson.="{name:'".$goods_list[0][2]."',value:".$goods_list[$i][2]."},";
	$tmpjson.="{name:'".$goods_list[0][3]."',value:".$goods_list[$i][3]."},";
	$tmpjson.="{name:'".$goods_list[0][4]."',value:".$goods_list[$i][4]."},";
	return $tmpjson;
}


$file_name="clustecenters_2010.csv";
$file = fopen($file_name,'r'); 
while ($data = fgetcsv($file)) { //Ã¿´Î¶ÁÈ¡CSVÀïÃæµÄÒ»ÐÐÄÚÈÝ
	$goods_list[] = $data;
 }
fclose($file);
$all=array();
//如果$goods_list一共5个
for($i=1;$i<=5;$i++){
	$tmp = getJson($goods_list,$i);
 	array_push($all,$tmp);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="gbk">
	
	<script src="echarts.min.js"></script>
	<script src="http://gallery.echartsjs.com/dep/echarts/map/js/world.js"></script>
<title>PieCharts</title>
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
<p align="center"><h1>2010 Year Food Consumption Result</h1></p>
</div>
	<?php
	 for($i=0;$i<sizeof($all);$i++){
	 	//容器
	 	echo "<div id='main".$i."' style='width: 500px;height:400px; float : left;'></div>\n";
	 	}
	 for($i=0;$i<sizeof($all);$i++){
	 	//参数
if($i == 0) {
	 	echo "<script>
	
	var myChart = echarts.init(document.getElementById('main".$i."'));
	option = {
    title : {
        text: 'cluster1',
        subtext: 'different food per captia',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: '{a} <br/>{b} : {c} ({d}%)'
    },
    legend: {
        orient: 'vertical',
        left: 'left',
      
    },
    series : [
        {
            name: 'cluster1',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[".$all[$i]."],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
	
	 myChart.setOption(option);

	</script>";
}	 
if($i == 1) {
	 	echo "<script>
	
	var myChart = echarts.init(document.getElementById('main".$i."'));
	option = {
    title : {
        text: 'cluster2',
        subtext: 'different food per captia',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: '{a} <br/>{b} : {c} ({d}%)'
    },
    legend: {
        orient: 'vertical',
        left: 'left',
      
    },
    series : [
        {
            name: 'cluster2',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[".$all[$i]."],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
	
	 myChart.setOption(option);

	</script>";
}	
if($i == 2) {
	 	echo "<script>
	
	var myChart = echarts.init(document.getElementById('main".$i."'));
	option = {
    title : {
        text: 'cluster3',
        subtext: 'different food per captia',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: '{a} <br/>{b} : {c} ({d}%)'
    },
    legend: {
        orient: 'vertical',
        left: 'left',
      
    },
    series : [
        {
            name: 'cluster3',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[".$all[$i]."],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
	
	 myChart.setOption(option);

	</script>";
}
if($i == 3) {
	 	echo "<script>
	
	var myChart = echarts.init(document.getElementById('main".$i."'));
	option = {
    title : {
        text: 'cluster4',
        subtext: 'different food per captia',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: '{a} <br/>{b} : {c} ({d}%)'
    },
    legend: {
        orient: 'vertical',
        left: 'left',
      
    },
    series : [
        {
            name: 'cluster4',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[".$all[$i]."],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
	
	 myChart.setOption(option);

	</script>";
}	
if($i == 4) {
	 	echo "<script>
	
	var myChart = echarts.init(document.getElementById('main".$i."'));
	option = {
    title : {
        text: 'cluster5',
        subtext: 'different food per captia',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: '{a} <br/>{b} : {c} ({d}%)'
    },
    legend: {
        orient: 'vertical',
        left: 'left',
      
    },
    series : [
        {
            name: 'cluster5',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[".$all[$i]."],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
	
	 myChart.setOption(option);

	</script>";
}	 
  
	 }
	?>
	<div id="pic" style='width: 500px;height:400px; float : right;'>
	<div id ="title" style = 'height: 100'><p align="center"><h1>GDP & different clusters</h1></p></div>
	<div id ="title" style = 'height: 100'></div>
	<div id="test" style = 'height: 200'>
	<img  src="images/gdb3.png" />
	</div>
	</div>
	 
	<!-- <input type="hidden" id="data" value="<?php echo $json?>" />-->

	


<!--footerstart-->
<div id = "footer"  style=" width :100%; float :left"> 
<div class="copy-right">
	<div class="container">
		
			<p class="grid1" >
       <a href="bing2.php"> <button type="button" class="btn btn-lg btn-info" >previous year</button></a>
        <a href="index.html"><button type="button" class="btn btn-lg btn-info" >next year</button></a>
      </p>
		</div>
	</div>
</div>


</div>
<!--footer end here-->


</body>
</html>
