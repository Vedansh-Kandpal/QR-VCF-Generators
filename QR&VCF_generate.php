<?php

include('libs/phpqrcode/qrlib.php'); 



function getUsernameFromEmail($email) {
	$find = '@';
	$pos = strpos($email, $find);
	$username = substr($email, 0, $pos);
	return $username;
}

if(isset($_POST['submit']) ) {
	$tempDir = 'temp/'; 
	$name = $_POST['name'];
	$email = $_POST['mail'];
	$Company =  $_POST['Company'];
	$filename = getUsernameFromEmail($email);
	$phone =  $_POST['phone'];
	$website =  $_POST['website'];
	$codeContents = $website; 
	// $codeContents = 'website:'.$website.'?Company='.urlencode($Company).'&body='.urlencode($phone); 
	QRcode::png($codeContents, $tempDir.''.$filename.'.png', QR_ECLEVEL_L, 5);

$vcf='BEGIN:VCARD
VERSION:3.0
FN;CHARSET=UTF-8:'.$name.'
N;CHARSET=UTF-8:'.$name.';;;
EMAIL;CHARSET=UTF-8;type=HOME,INTERNET:'.$email.'
TEL;TYPE=HOME,VOICE:'.$phone.'
ORG;CHARSET=UTF-8:'.$Company.'
URL;type=WORK;CHARSET=UTF-8:'.$website.'

END:VCARD';

    $file = fopen('vcf/'.$filename.'.vcf','w');
    fwrite($file, $vcf);
    fclose($file);

}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	<link rel="stylesheet" href="libs/newstyle.css">
</head>
<body>
    
    <div class="container">
        <div class="sessions session2">
            <div class="heading">
                <h2 class="stap">QR & VCF Generator</h2>
            </div>
            <div class="flexBox">
                <div class="formBox">
                    <div class="form_container">
                        <div class="form">
                            <h2>Please Enter Details</h2>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                                
                                <input type="text" name="name" placeholder="Full Name" required />
                                <input type="email" name="mail" placeholder="Email" required/>
                                <input type="text" name="Company" placeholder="Company Name" required/>
                                <input type="tel" name="phone" placeholder="Mobile" required/>
                                <input type="text" name="website" placeholder="Website URL" required/>
                                
                                <button type="submit" name="submit">Generate</button>
                            </form>
                        </div>
                    </div>
                </div>
                 <?php
                    if(!isset($filename)){
                        $filename = "vedanshkandpal";
                    }
                ?>
                <div class="qr">
                    <div class="qr_img">
                         <?php echo '<img src="temp/'.@$filename.'.png" alt="your  QR "style="width:200px; height:200px;"><br>';  ?>
                        <button><a href="temp/<?php echo $filename; ?>.png " target=_blank>Download QR Code</a></button>
                        <button><a href="vcf/<?php echo $filename; ?>.vcf " target=_blank>Download VCF File</a></button>
                     </div>
                </div>
            </div>
        </div>
        

    </div>

</body>
</html>