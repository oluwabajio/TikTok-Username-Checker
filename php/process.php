<?php
    header('Content-Type: application/text');
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $_POST = json_decode(file_get_contents('php://input'), true);
    $username = $_POST['username'];
    if (empty($username)) {
      echo "Name is empty";
    } else {
     // echo $username;


     //Get a random user agent
     $userAgentList = array();
     $fh = fopen(__DIR__ . '/user.txt','r');
     while ($line = fgets($fh)) {
       array_push($userAgentList, ''.$line);
     }
    


      $homeUrl = "https://www.tiktok.com/@";

      $totalUrl = $homeUrl.$username;
   

       // create curl resource
       $ch = curl_init();

       // set url
       curl_setopt($ch, CURLOPT_URL, $totalUrl);

       curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers

       //return the transfer as a string
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
       $agent = rtrim($userAgentList[array_rand($userAgentList)], "\r\n"); //this is our user agent

      curl_setopt($ch, CURLOPT_USERAGENT, $agent); //add our user agent

       curl_setopt($ch, CURLOPT_HTTPGET, 1);

      
       $output = curl_exec($ch);

  //   echo $output;

       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

       if ($httpcode == '400' || $httpcode == '401' || $httpcode == '402' || $httpcode == '403' || $httpcode == '404') {
         echo "false";
       } else {

              if(strpos($output, 'verify.snssdk.com') !== false){
                echo "false";
              } else{
                echo "true";
              }
        
       }
       fclose($fh);

     curl_close($ch); 

  
  }

}




?>