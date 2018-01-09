//<?php
//$json_str = file_get_contents('php://input');//接收Request的Body
//$json_obj = json_decode($json_str);//轉json格式
//$myfile=fopen("log.txt","w+") or die("Unable to open file!");//設定一個log.txt用來印訊息
//fwrite($myfile,"\xEF\xBB\xBF".$json_str);//在字串前加入\xEF\xBB\xBF轉成utf8格式
//fclose($myfile);
//?>

//<?php
// $json_str = file_get_contents('php://input'); //接收REQUEST的BODY
// $json_obj = json_decode($json_str); //轉JSON格式
// //產生回傳給line server的格式
// $sender_userid = $json_obj->events[0]->source->userId;
// $sender_txt = $json_obj->events[0]->message->text;
// $sender_replyToken = $json_obj->events[0]->replyToken;
//$response = array (
//				//"to" => $sender_userid,
//	 			"replyToken" => $sender_replyToken,
//				"messages" => array (
//					array (
//						"type" => "text",
//						"text" => "Hello, YOU SAY ".$sender_txt
//					)
//				)
//		);
// $myfile = fopen("log.txt","w+") or die("Unable to open file!"); //設定一個log.txt 用來印訊息
// fwrite($myfile, "\xEF\xBB\xBF".json_decode($response)); //在字串前加入\xEF\xBB\xBF轉成utf8格式
// fclose($myfile);
// //回傳給line server
// $header[] = "Content-Type: application/json";
// $header[] = "Authorization: Bearer 6EYmw4KdaVmfZzfyFuTLbiNoSGvereNnvODaypsR62/h0/Sws49gvmBoEzSq7MMdsZontZUXgIwFSt9LXSVNvMunF6Rhor1NAdisXJCgO3RBAk9P81REOpZrlw8g+QJOxkKkUedSzRUnLGi3jo1f7wdB04t89/1O/w1cDnyilFU=";
// //$ch = curl_init("https://api.line.me/v2/bot/message/push");                                                                      
// $ch = curl_init("https://api.line.me/v2/bot/message/reply");                                                                      
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
// curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
// $result = curl_exec($ch);
// curl_close($ch); 
//?>*/
<?php
 $json_str = file_get_contents('php://input'); //接收REQUEST的BODY
 $json_obj = json_decode($json_str); //轉JSON格式
 //產生回傳給line server的格式
 $sender_userid = $json_obj->events[0]->source->userId;
 $sender_txt = $json_obj->events[0]->message->text;
 $sender_replyToken = $json_obj->events[0]->replyToken;
 $line_server_url = 'https://api.line.me/v2/bot/message/push';
 //用sender_txt來分辨要發何種訊息
 switch ($sender_txt) {
    		case "push":
        		$response = array (
				"to" => $sender_userid,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "Hello, YOU SAY ".$sender_txt
					)
				)
			);
        		break;
    		case "reply":
			$line_server_url = 'https://api.line.me/v2/bot/message/reply';
        		$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "Hello, YOU SAY ".$sender_txt
					)
				)
			);
        		break;
		case "image":
			$line_server_url = 'https://api.line.me/v2/bot/message/reply';
        		$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "image",
						"originalContentUrl" => "https://www.w3schools.com/css/paris.jpg",
						"previewImageUrl" => "https://www.nasa.gov/sites/default/themes/NASAPortal/images/feed.png"
					)
				)
			);
        		break;
		 case "location":
			$line_server_url = 'https://api.line.me/v2/bot/message/reply';
        		$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "location",
						"title" => "my location",
						"address" => "〒150-0002 東京都渋谷区渋谷２丁目２１−１",
            					"latitude" => 35.65910807942215,
						"longitude" => 139.70372892916203
					)
				)
			);
        		break;
		case "sticker":
			$line_server_url = 'https://api.line.me/v2/bot/message/reply';
        		$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "sticker",
						"packageId" => "1",
						"stickerId" => "1"
					)
				)
			);
        		break;
 }
 $myfile = fopen("log.txt","w+") or die("Unable to open file!"); //設定一個log.txt 用來印訊息
 fwrite($myfile, "\xEF\xBB\xBF".json_encode($response)); //在字串前加入\xEF\xBB\xBF轉成utf8格式
 fclose($myfile);
 //回傳給line server
 $header[] = "Content-Type: application/json";
 $header[] = "Authorization: Bearer 6EYmw4KdaVmfZzfyFuTLbiNoSGvereNnvODaypsR62/h0/Sws49gvmBoEzSq7MMdsZontZUXgIwFSt9LXSVNvMunF6Rhor1NAdisXJCgO3RBAk9P81REOpZrlw8g+QJOxkKkUedSzRUnLGi3jo1f7wdB04t89/1O/w1cDnyilFU=";
 $ch = curl_init($line_server_url);                                                                      
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
 $result = curl_exec($ch);
 curl_close($ch); 
?>

