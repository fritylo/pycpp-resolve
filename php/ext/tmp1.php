<?php
require '../db.php';
require '../api.php';

php_root('..');

if (compare_str('Язык С++. Известно, что размер int равен 4 байта, double - 8 байт, char - 1 байт.
union {
    int i;
    double d;
    char c;
} myVar;
Чему будет равен размер переменной myVar?', 'Язык С++. Известно, что размер int равен 4 байта, double - 8 байт, char - 1 байт.
union {
    int i;
    double d;
    char c;
} myVar;
Чему будет равен размер переменной myVar?

A) 4 байт

B) 24 байт

C) 8 байт

D) 13 байт

E) 16 байт'))
   echo 'true';
else echo 'false';

function compare_str(string $s1, string $s2)
{
   $i1 = 0;
   $i2 = 0;

   $len_s1 = mb_strlen($s1);
   $len_s2 = mb_strlen($s2);

   $ch1 = null;
   $ch2 = null;

   $chars1 = mb_str_split($s1);
   $chars2 = mb_str_split($s2);

   while ($i1 < $len_s1 && $i2 < $len_s2) {
      $ch1 = $chars1[$i1];
      $ch2 = $chars2[$i2];

      switch ($ch1) {
         case " ":
         case "\n":
         case "\r":
         case "\t":
            $i1++;
            break;
         default: // any char
            if (ord($ch1) == 194) {
               $i1++;
               break;
            }
            switch ($ch2) {
               case " ":
               case "\n":
               case "\r":
               case "\t":
                  $i2++;
                  break;
               default: // ch1 && ch2 are chars
                  if (ord($ch2) == 194) {
                     $i1++;
                     break;
                  }
                  if ($ch1 != $ch2) return false;
                  else {
                     $i1++;
                     $i2++;
                  }
            }
      }
   }

   return true;
}