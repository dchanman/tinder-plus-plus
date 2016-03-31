var remoteserver = 

function init(){
	var ngScope = angular.element(document.getElementById("ngWrapper")).scope();
}

//angularjs module init
var mainModule = angular.module('user_profile_module', []);
mainModule.controller('user_profile_controller', ['$scope', '$interval', function($scope, $interval){
	$scope.sampleVariable = 'patrick';

	$scope.requestCount = function(msg, xhrBuffer){
		console.log("Sending request to server: " + remoteServer);

		var count = 0;

		

		return function(){
			var xhr = new XMLHttpRequest();
			xhr.open("GET", remoteServer);
			xhr.timeout = 5000;
			xhr.onload = function(){
				if(xhr.status == 200){
					numTries = 0;
					console.log(xhr.getResponseHeader("Content-type"));
					if(xhr.getResponseHeader("Content-type") == 'application/json; charset=utf-8'){
						$scope.products = JSON.parse(xhr.responseText);
						compareCartWithProducts();
						$scope.XMLSendFinished = true;
						if(!isEmpty($scope.cart)){
							$scope.showCashTotal();
						}
						$scope.startCountdown();
					}else{
						console.log("responseText is not of type JSON: " + xhr.responseText);
					}
				}else{
					if(numTries > maxTries){
						console.log("Connection failed too many times. Try refreshing the page.")
						return;
					}
					console.log("error code: " + xhr.status + ", sending another request");
					xhr.open("GET", remoteServer);
					numTries++;
					xhr.send();
				}
				var index = xhrBuffer.indexOf(xhr);
				xhrBuffer.splice(index, 1);
			}
			xhr.ontimeout = function(){
				if(numTries > maxTries){
					console.log("Connection failed too many times. Try refreshing the page.")
					return;
				}
				console.log("Timeout Exceeded, sending another request");
				xhr.open("GET", remoteServer);
				numTries++;
				xhr.send();
			}
			xhr.onabort = function(){
				numTries = 0;
				console.log("aborted")
				var index = xhrBuffer.indexOf(xhr);
				xhrBuffer.splice(index, 1);
			}
			xhr.onerror = function(){
				if(numTries > maxTries){
					console.log("Connection failed too many times. Try refreshing the page.")
					return;
				}
				console.log("error: " + xhr.status );
				xhr.open("GET", remoteServer);
				numTries++;
				xhr.send();
			}
			xhrBuffer.push(xhr);
			$scope.XMLSendFinished = false;
			xhr.send();
		}
	}


}]);

$(document).ready(function(){ init();  }) 
