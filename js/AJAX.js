
/* 
	* 这是函数 用来请求网络数据

	* type 请求类型 GET/POST 大写的

	* url 服务器地址/网络请求地址

	* data 是个对象 用来存放参数信息

	data = {
		key1:value1,
		key2:value2
	}

	* isAsync 是否异步请求

	* fnSuccess 是个函数 用来执行成功回调

	* fnFailure 是个函数 用来执行错误回调
	
	* ajax 是个对象 用来执行请求
*/



function AJAX(type,url,data,isAsync,fnSuccess,fnFailure) {

	//type转大写
	type = type.toUpperCase();
	//拼接data
	var arr = [];
	for (var key in data) {
		var row = key + "=" + data[key];
		arr.push(row);
	}

	var deTail = arr.join("&");



	//1.创建
	var ajax = null;
	if (window.ActiveXObject) {
		ajax = new ActiveXObject();//ie
	} else {
		ajax = new XMLHttpRequest();
	}
	//2.分析是GET还是POST
	if (type === "GET") {
		//GET 请求
		var requestURL = url + "?" + deTail;
		ajax.open("GET",requestURL,isAsync);
		deTail = null;
	} else {
		//POST 请求
		ajax.open("POST",url,isAsync);
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	}

	//3.监听 并 回调
	ajax.onreadystatechange = function() {
		var numSta = ajax.status;
		var result = ajax.responseText;
		if (numSta == 200) {
			//成功
			fnSuccess(result);
		} else {
			//失败
			fnFailure(result);
		}
	}

	//4.发送
	ajax.send(deTail);
}







