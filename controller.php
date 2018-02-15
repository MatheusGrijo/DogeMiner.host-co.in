<?php


function httpPost($url, $data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function anti_injection($sql)
{
	// remove palavras que contenham sintaxe sql
	$sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
	$sql = trim($sql);//limpa espaços vazio
	$sql = strip_tags($sql);//tira tags html e php
	$sql = addslashes($sql);//Adiciona barras invertidas a uma string
	return $sql;
}

function calculateDogeCoin($valueHash)
{
		$valueHash = [YOUR CALCULATE];
		return number_format($valueHash,8);
}

try

{
   
	//definições de host, database, usuário e senha
	$host = "localhost";
	$db   = "YOUR_DB";
	$user = "YOURUSER";
	$pass = "PASSWORD";		
	$conn = mysqli_connect($host, $user, $pass,$db); 		

	$secret = "YOUR_SECRET_COINHIVE";
	$o = anti_injection($_GET["o"]);
	$u = anti_injection($_GET["u"]);

	if($o == "balance")
	{
		$json = file_get_contents("https://api.coinhive.com/user/balance?secret=" . $secret . "&name=" . $u);
		$json = json_decode($json);
		echo calculateDogeCoin($json->balance);		
	}
	else if($o == "start")
	{
		$html = "";			
		$sql = "select nom_wallet from users where nom_wallet = '". $u ."' order by cod_user desc";
		$result = $conn->query($sql);
		if ($result->num_rows <= 0) 
		{    
    		$result = $conn->query("insert into users (nom_wallet) values ('". $u ."'); ");
	  	} 
	}
	else if($o =="last")
	{
		$html = "";			
		$sql = "select dta_create,nom_wallet from users order by cod_user desc limit 10";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) 
		{    
    		while($row = $result->fetch_assoc()) 
    		{
        		echo  $row["dta_create"] . " | " . $row["nom_wallet"] . "<br>";
    		}
	  	} 
		echo $html;
	}
	else if($o == "top")
	{
		$json = file_get_contents("https://api.coinhive.com/user/top?secret=" . $secret);				

		$obj = json_decode($json);
		$html = "";
		$i = 0;

	    foreach ( $obj->users as $valor){
    			$html = $html . "<a href='https://dogechain.info/address/".$valor->name."'>" . $valor->name . "</a> | BALANCE: " . calculateDogeCoin($valor->balance) . " | TOTAL: " . calculateDogeCoin($valor->total) . " <br/>";    			
    			$i = $i + 1;
    			if($i >= 10)
    				break;
		}

		echo $html;

	}
	else if($o == "withdrawal")
	{
		$html = "";			
		$sql = "select * from withdrawal order by cod_withdrawal desc limit 10";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) 
		{    
    		while($row = $result->fetch_assoc()) 
    		{
        		echo   $row["dta_date"] . " | <a href='https://dogechain.info/address/" . $row["nom_wallet"] . "'>" . $row["nom_wallet"] . "</a> | <a href='https://dogechain.info/tx/".$row["nom_txid"]."'>" .  $row["nom_txid"] . "</a><br>";
    		}
	  	} 
		echo $html;

	}
	
	else if($o == "pay")
	{
		$json = file_get_contents("https://api.coinhive.com/user/list?secret=" . $secret);				

		$obj = json_decode($json);
		$html = "";
		$i = 0;

	    foreach ( $obj->users as $valor){



		$sql = "select nom_wallet from users where nom_wallet = '". $valor->name ."' order by cod_user desc";
		$result = $conn->query($sql);
		if ($result->num_rows <= 0) 
		{    
    		$result = $conn->query("insert into users (nom_wallet) values ('". $valor->name ."'); ");
	  	} 








	    	if(calculateDogeCoin($valor->balance) > 5)
	    	{
    			$html = $html .  $valor->name . " | BALANCE HASH : " . ($valor->balance) . " | BALANCE DOGE : " . calculateDogeCoin($valor->balance) . " | TOTAL DOGE: " . calculateDogeCoin($valor->total) . " <br/>";    


    			$txid = file_get_contents("https://block.io/api/v2/withdraw/?api_key=YOURPAIKEYBLOCK&amounts=" . calculateDogeCoin($valor->balance) . "&to_addresses=".$valor->name."&pin=YOURPIN");

				$obj = json_decode($txid);

    			str_replace("'","",$txid);
    			str_replace("\"","",$txid);

    			echo "TXID: " . $txid . "<br/>";								

				$data = array(
			 		'secret' => $secret,
    				'name' => $valor->name,
    				'amount' => $valor->balance
				);

				$json = httpPost("https://api.coinhive.com/user/withdraw?secret=" . $secret . "&name=" . $u . "&amount=" . $valor->balance , $data);

				
    			
				echo "JSON: " . $json . "<br/>";    			
				
				
    			$conn->query("insert into withdrawal (nom_wallet, num_total,nom_txid) values ('".$valor->name."', '".calculateDogeCoin($obj->balance)."', '".$obj->data->txid."'  ); ");
				echo "<br/>";
    			
    		}
		}

		echo $html;

	}

}
catch (Exception $e) {
    echo   $e->getMessage();
}

$conn->close();

?>