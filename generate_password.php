<?php
/* =========================================================
   GENERATE PASSWORD HASH
   Tumia faili hii MARA MOJA TU kupata password hash sahihi,
   kisha uweke hash hiyo kwenye jedwali la admins (badala ya
   ile ya mfano kwenye database.sql).

   Jinsi ya kutumia:
   1) Fungua faili hii kwenye browser: http://localhost/eastcso/php/generate_password.php
   2) Itaonyesha hash mpya kwa neno la siri "eastcso2026"
   3) Nakili hash hiyo, ibandike kwenye safu ya 'password' ya admin wako kwenye phpMyAdmin
   4) Futa au lock faili hii baada ya kuitumia (kwa usalama)
   ========================================================= */

$password = 'eastcso2026'; // badilisha kama unataka neno la siri tofauti
echo "Hash kwa neno la siri '$password':<br><br>";
echo password_hash($password, PASSWORD_DEFAULT);
