<?php
date_default_timezone_set('Asia/Jakarta');
include "function.php";
echo color("green","# # # # # # # # WAROENGINTERNET # # # # # # # \n");
echo color("yellow","[•]  Time  : ".date('[d-m-Y] [H:i:s]')."   \n");
echo color("yellow","[•]              waiting proses.....           \n");
echo color("yellow","[•] cara menulis nomor pakai 62xxxxxxxxxx \n");
echo color("green","# # # # # # # # # # # # # # # # # # # # # # # \n");
function change(){
        $nama = nama();
        $email = str_replace(" ", "", $nama) . mt_rand(100, 999);
        ulang:
        echo color("yellow","(•) Nomor : ");
        $no = trim(fgets(STDIN));
        $data = '{"email":"'.$email.'@gmail.com","name":"'.$nama.'","phone":"+'.$no.'","signed_up_country":"ID"}';
        $register = request("/v5/customers", null, $data);
        if(strpos($register, '"otp_token"')){
        $otptoken = getStr('"otp_token":"','"',$register);
        echo color("green","+] Kode verifikasi sudah di kirim!")."\n";
        otp:
        echo color("yellow","?] OTP : ");
        $otp = trim(fgets(STDIN));
        $data1 = '{"client_name":"gojek:cons:android","data":{"otp":"' . $otp . '","otp_token":"' . $otptoken . '"},"client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e"}';
        $verif = request("/v5/customers/phone/verify", null, $data1);
        if(strpos($verif, '"access_token"')){
        echo color("green","+] Berhasil mendaftar!");
        $token = getStr('"access_token":"','"',$verif);
        $uuid = getStr('"resource_owner_id":',',',$verif);
        echo "\n".color("yellow","+] Your access token : ".$token."\n\n");
        save("token.txt",$token);
        echo "\n".color("nevy","?] Mau Redeem Voucher?: y/n ");
        $pilihan = trim(fgets(STDIN));
        if($pilihan == "y" || $pilihan == "Y"){
        echo color("red","===========(REDEEM VOUCHER)===========");
        echo "\n".color("yellow","[WRG] Claim Voucher GoFood 50%");
        echo "\n".color("yellow","[WRG] Please wait");
        for($a=1;$a<=3;$a++){
        echo color("yellow",".");
        sleep(1);
        }
        $code1 = request('/go-promotions/v1/promotions/enrollments', $token, '{" Promo_code":"COBAGORIDEPAY"}');
        $message = fetch_value($code1,'"message":"','"');
        if(strpos($code1, 'Promo kamu sudah bisa dipakai')){
        echo "\n".color("green","+] Message: ".$message);
        goto gocar;
        }else{
        echo "\n".color("green","-] Message: ".$message);
        gocar:
        echo "\n".color("yellow","!] Claim Voucher GoRide!");
        echo "\n".color("yellow","!] Please wait");
        for($a=1;$a<=3;$a++){
        echo color("yellow",".");
        sleep(2);
        }
        $code1 = request('/go-promotions/v1/promotions/enrollments', $token, '{" Promo_code":"COBAGOFOOD090320A"}');
        $message = fetch_value($code1,'"message":"','"');
        if(strpos($code1, 'Promo kamu sudah bisa dipakai')){
        echo "\n".color("green","+] Message: ".$message);
        goto gofood;
        }else{
        echo "\n".color("red","-] Message: ".$message);
        reff:
        $data = '{"referral_code":"G-75SR565"}';    
        $claim = request("/customer_referrals/v1/campaign/enrolment", $token, $data);
        $message = fetch_value($claim,'"message":"','"');
        if(strpos($claim, 'Promo kamu sudah bisa dipakai')){
        echo "\n".color("green","+] Message: ".$message);
        goto gofood;
        }else{
        echo "\n".color("red","-] Message: ".$message);
        }
        gofood:
        echo "\n".color("yellow","!] Claim Voucher GoSend!");
        echo "\n".color("yellow","!] Please wait");
        for($a=1;$a<=3;$a++){
        echo color("yellow",".");
        sleep(2);
        }
        $code1 = request('/go-promotions/v1/promotions/enrollments', $token, '{" Promo_code":"COBAGOCAR14"}');
        $message = fetch_value($code1,'"message":"','"');
        if(strpos($code1, 'Promo kamu sudah bisa dipakai')){
        echo "\n".color("green","+] Message: ".$message);
        sleep(1);
        sleep(3);
         setpin:
         echo "\n".color("nevy","?] Mau set pin?: y/n ");
         $pilih1 = trim(fgets(STDIN));
         if($pilih1 == "y" || $pilih1 == "Y"){
         //if($pilih1 == "y" && strpos($no, "628")){
         echo color("red","========( PIN ANDA = 080808 )========")."\n";
         $data2 = '{"pin":"080808"}';
         $getotpsetpin = request("/wallet/pin", $token, $data2, null, null, $uuid);
         echo "Otp set pin: ";
         $otpsetpin = trim(fgets(STDIN));
         $verifotpsetpin = request("/wallet/pin", $token, $data2, null, $otpsetpin, $uuid);
         echo $verifotpsetpin;
         }else if($pilih1 == "n" || $pilih1 == "N"){
         die();
         }else{
         echo color("red","-] GAGAL!\n");
         }
         }
         }
         }
         }else{
         goto setpin;
         }
         }else{
         echo color("red","-] Otp yang anda input salah");
         echo"\n==================================\n\n";
         echo color("yellow","!] Silahkan input kembali\n");
         goto otp;
         }
         }else{
         echo color("red","NOMOR SUDAH TERDAFTAR/SALAH !");
         echo "\nMau coba ulang? (y/n): ";
         $pilih = trim(fgets(STDIN));
         if($pilih == "y" || $pilih == "Y"){
         echo "\n==============DAFTAR ULANG==============\n";
         goto ulang;
         }else{
         echo "\n==============DAFTAR ULANG==============\n";
         goto ulang;
  }
 }
}
echo change()."\n"; ?>