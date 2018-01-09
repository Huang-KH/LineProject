//<?php
//$json_str = file_get_contents('php://input');//接收Request的Body
//$json_obj = json_decode($json_str);//轉json格式
//$myfile=fopen("log.txt","w+") or die("Unable to open file!");//設定一個log.txt用來印訊息
//fwrite($myfile,"\xEF\xBB\xBF".$json_str);//在字串前加入\xEF\xBB\xBF轉成utf8格式
//fclose($myfile);
//?>
<?php
 $json_str = file_get_contents('php://input'); //接收REQUEST的BODY
 $json_obj = json_decode($json_str); //轉JSON格式
 //產生回傳給line server的格式
 $sender_userid = $json_obj->events[0]->source->userId;
 $sender_txt = $json_obj->events[0]->message->text;
 $sender_replyToken = $json_obj->events[0]->message->replyToken;
 $response = array (
				//"to" => $sender_userid,
	 			"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "Hello, YOU SAY ".$sender_txt
					)
				)
		);
 $myfile = fopen("log.txt","w+") or die("Unable to open file!"); //設定一個log.txt 用來印訊息
 fwrite($myfile, "\xEF\xBB\xBF".json_decode($response)); //在字串前加入\xEF\xBB\xBF轉成utf8格式
 fclose($myfile);
 //回傳給line server
 $header[] = "Content-Type: application/json";
 $header[] = "Authorization: Bearer Gv/ce02dbXSTWnWwL19/lQpQ7ok4uwgcFg92k/NmeU1bE6IEvRwZpnY3chqbZic3sZontZUXgIwFSt9LXSVNvMunF6Rhor1NAdisXJCgO3QltMkCrujgOPdqy/3GYDPJtBPR9EGHK7OEhEiDNZdCQAdB04t89/1O/w1cDnyilFU=";
 //$ch = curl_init("https://api.line.me/v2/bot/message/push");                                                                      
 $ch = curl_init("https://api.line.me/v2/bot/message/reply");                                                                      
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
 $result = curl_exec($ch);
 curl_close($ch); 
?>


