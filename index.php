<?php
//echo uniqid();
if(isset($_POST["donate"])){
   $name = htmlspecialchars($_POST["name"]);
   $email = htmlspecialchars($_POST["email"]);
   $phone_number = htmlspecialchars($_POST["phone"]);
   $amount = htmlspecialchars($_POST["amount"]);

//Integrate Rave pament
$endpoint = "https://api.flutterwave.com/v3/payments";

//Required Data
$postdata = array(
    "tx_ref" => uniqid().uniqid(),
    "currency" => "NGN",
    "amount" => $amount,
    "customer" =>array(
        "name" => $name,
        "email" => $email,
        "phone_number" => $phone_number
    ),
    "customizations" =>array(
        "title" => "Donate to the less previledged!",
        "description" => "A page for the collection of donatios to the needy"
    ),

    "meta" =>array(
        "reason" => "To help the poor!",
        "address" => "2b, UNN Road Nsukka"
    ),
    "redirect_url" => "http://localhost/flutterwave/verify.php"
);

//Init cURL handler
$ch = curl_init();

//Turn of SSL checking
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

//Set the endpoint
curl_setopt($ch, CURLOPT_URL, $endpoint);

//Turn on the cURL post method
curl_setopt($ch, CURLOPT_POST, 1);

//Encode the post field
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));

//Make it reurn data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set the waiting timeout
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 200);
curl_setopt($ch, CURLOPT_TIMEOUT, 200);

//Set the headers from endpoint
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   "Authorization: Bearer FLWSECK_TEST-7a1ab997e04eb83e5fbd254ce0fba870-X",
   "Content-Type: Application/json",
   "Cache-Control: no-cahe"
));

//Execute the cURL session
$request = curl_exec($ch);

$result = json_decode($request);
header("Location: ".$result->data->link);
//var_dump($result);
//Close the cURL session
curl_close($ch);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rave or Flutterwave Integration in PHP and cURL</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <h1>Rave Integration!</h1>
   <hr>
   <div class="container">
    <form action="" method="post">
     <label>Full Name:</label>
     <input type="text" name="name" placeholder="Enter full name here...">
     <label>Email:</label>
     <input type="email" name="email" placeholder="Enter your email here...">
     <label>Phone Number:</label>
     <input type="text" name="phone" placeholder="Enter your phone number here...">

    <label>Amount:</label>
     <input type="text" name="amount" placeholder="Enter amount..">
     <input type="submit" name="donate" value="Donate">
    </form>
   </div> 
</body>
</html>