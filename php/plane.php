<?php
	$type = $_GET["type"];
	
	//这个1是字符串
	if ($type == "1") {
		//走post
		$user = $_POST["user"];
		$score = $_POST["score"];
		insertDB($user,$score);
	} else {
		//走get
		getDB();
	}
	
	function insertDB($user,$score) {
		$mysqli = new mysqli("localhost:3306","root","","firstdb");
		
		if ($mysqli->connect_errno) {
			echo "验证";
			var_dump($mysqli->connect_errno);
			die($mysqli->connect_errno);
		}
		
		$sql = "SELECT*FROM plane";
    		$mysqli->query("set names utf-8");
    		$result = $mysqli->query($sql);
    		$str = $result->fetch_all(MYSQLI_ASSOC);
    		$find = 0;
    		for($i = 0; $i<count($str);$i++){
    			foreach($str[$i] as $key=>$value){
    				if($user == $str[$i]["name"] && $find == 0){
    					if($score > $str[$i]["score"]){
    						$sqlUpDate = "UPDATE plane SET score={$score} WHERE name='{$user}'";
    						$mysqli->query("set names utf-8");
    						$result = $mysqli->query($sqlUpDate);
    						$mysqli->close();
    					}
    					$find = 1;
    				}
    			}
    		}
		
		if ($find == 0) {
			$mysqli->query("set names utf8");
			
			$sql = "INSERT INTO plane(name,score) VALUES ('{$user}','{$score}')";
			
			$result = $mysqli->query($sql);
			
			echo $result;
			
			$mysqli->close();
		}
	}
	
	function getDB() {
		$mysqli = new mysqli("localhost:3306","root","","firstdb");
		if($mysqli->connect_errno) {
			echo "验证";
			var_dump($mysqli->connect_errno);
			die($mysqli->connect_errno);
		}
		$mysqli->query("set names utf8");
		$sql = "SELECT * FROM plane";
		$result = $mysqli->query($sql);
		$row = $result->fetch_all(MYSQLI_ASSOC);//得到关联数组
		$str = json_encode($row);//转成字符串
		echo $str;
		$mysqli->close();
	}
?>