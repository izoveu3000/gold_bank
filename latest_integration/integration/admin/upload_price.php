<?php
    date_default_timezone_set("Asia/Yangon");
    // DB connection
    $conn = new mysqli("localhost","root","","goldbank");

    $data = json_decode(file_get_contents('php://input'), true);
    if ($data) {
        $upload_gold_price = $data['gold'];
        $upload_dollar_price = $data['dollar'];

        if(isset($upload_dollar_price)){
            // 🔑 Replace with your ExchangeRate-API key
            $apiKey = "317f19fc01bd77fb5d0eef40";
            $url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/USD";
            $response = file_get_contents($url);
            $data = json_decode($response,true);

            if (!isset($data['conversion_rates']['MMK'])) {
                echo json_encode(["error"=>"API fetch failed"]);
                exit;
            }

            $usd_mmk = (float)$data['conversion_rates']['MMK'];
            $timestamp = date("Y-m-d H:i:s");

            // Get currency_id for dollar
            $res = $conn->query("SELECT currency_id FROM currency WHERE currency_name='dollar' LIMIT 1");
            $currency_id = ($res->num_rows > 0) ? $res->fetch_assoc()['currency_id'] : 2;

            // Get last stored price
            $res = $conn->query("SELECT price FROM currency_price WHERE currency_id=$currency_id ORDER BY changed_at DESC LIMIT 1");
            $last_price = ($res && $res->num_rows>0) ? (float)$res->fetch_assoc()['price'] : null;

            // Round to two decimals for comparison
            $rounded_new  = round($usd_mmk,2);
            $rounded_last = $last_price !== null ? round($last_price,2) : null;

            // Insert only if changed
            if ($rounded_last === null || $rounded_last != $rounded_new) {
                $stmt = $conn->prepare("INSERT INTO currency_price (currency_id,price,changed_at) VALUES (?,?,?)");
                $stmt->bind_param("ids",$currency_id,$usd_mmk,$timestamp);
                $stmt->execute();
                $status = "inserted";
            } else {
                $status = "unchanged";
            }
        }

        if(isset($upload_gold_price)){
            // Fetch gold price
            $apiKey = "W8kOiO7GUcoEdq_KisZxI_Heiw5aPpPB"; // put your polygon.io API key
            $symbol = "XAU/USD"; // XAU = Gold ounce, quoted in USD
            $url = "https://api.polygon.io/v2/aggs/ticker/C:XAUUSD/prev?apiKey=$apiKey";
            $data = json_decode(file_get_contents($url), true);
            if (!isset($data['results'][0]['c'])) {
                echo json_encode(["error"=>"API fetch failed"]);
                exit;
            }
            $gold_price = (float)$data['results'][0]['c'];
            $timestamp = date("Y-m-d H:i:s");

            // Get currency_id for gold
            $res = $conn->query("SELECT currency_id FROM currency WHERE currency_name='gold' LIMIT 1");
            $currency_id = ($res->num_rows > 0) ? $res->fetch_assoc()['currency_id'] : 1;

            // Get last stored price
            $res = $conn->query("SELECT price FROM currency_price WHERE currency_id=$currency_id ORDER BY changed_at DESC LIMIT 1");
            $last_price = ($res && $res->num_rows>0) ? (float)$res->fetch_assoc()['price'] : null;

            // Round to two decimals for comparison
            $rounded_new  = round($gold_price,2);
            $rounded_last = $last_price !== null ? round($last_price,2) : null;

            // Insert only if changed
            if ($rounded_last === null || $rounded_last != $rounded_new) {
                $stmt = $conn->prepare("INSERT INTO currency_price (currency_id,price,changed_at) VALUES (?,?,?)");
                $stmt->bind_param("ids",$currency_id,$gold_price,$timestamp);
                $stmt->execute();
                $status = "inserted";
            } else {
                $status = "unchanged";
            }
        }
        
    }
    // Close the connection when you're done
    $conn->close();
            

    
    

    


    
    

?>