**RAJAONGKIR PHP Library**
=====================


> **PayPal**: [![](https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=dony_cavalera_md%40yahoo%2ecom&lc=US&item_name=Dony%20Wahyu%20Isp&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest)
> 
> **Rekening Mandiri**: 113-000-6944-858, **Atas Nama**: Dony Wahyu Isprananda

#**RajaOngkir**#
RajaOngkir merupakan sebuah situs dan web service (API) yang menyediakan informasi ongkos kirim dari berbagai kurir di Indonesia seperti POS Indonesia, JNE, TIKI, PCP, ESL, dan RPX. Secara umum, RajaOngkir ditujukan kepada pengguna yang ingin mengetahui dan membandingkan ongkos kirim dari berbagai kurir dan secara khusus bagi pemilik toko online, maupun bagi orang yang sering berbelanja online.
[http://www.rajaongkir.com](http://rajaongkir.com)

#**RajaOngkir PHP Library**#
Library/pustaka ini digunakan untuk mempermudah kita dalam menggunakan fasilitas API yang disediakan oleh RajaOngkir.

Donasi sangat diperlukan karena pengembang hanya bisa menggunakan tipe akun starter yang gratisan dan tidak memiliki tipe akun basic ataupun pro, jadi donasi akan digunakan untuk membeli akun basic/pro sehingga pengembang dapat melakukan testing code API pada tipe akun basic/pro.

#**Cara Penggunaan**#

##**Province**##
Method "province" digunakan untuk mendapatkan daftar propinsi yang ada di Indonesia.
Ada 4 cara penulisan Code, kamu bisa menggunakan salah satu yang menurut kamu lebih mudah.

**Cara Pertama**
Cara ini sangat direkomendasi, selain mempermudah dalam pembacaan code, juga baik dalam penanganan error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$id = 33;
$RO->province($id)
   ->success(function($data) {
        print_r($data);
   })
   ->error(function($msg) {
        echo $msg;
   });
```
**Cara Kedua**
Cara ini hampir sama dengan cara pertama cuma dibuat lebih simple, cuma pembacaan code terkadang menjadi membingungkan, parameter callback yang pertama untuk success, dan callback parameter kedua untuk error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id = 33;
$RO = new RajaOngkir($api_key);
$RO->province($id, function($data) {
    print_r(data);
}, function($msg) {
    echo $msg;
});
```
**Cara Ketiga**
Cara ini merupakan model lama, dan masih yang paling banyak digunakan, karena dari pembacaan code lebih mudah dibaca, cuma untuk penangan error harus ditangani secara manual, jadi jika hasilnya tidak sama dengan **`false`** berarti tidak error, sedangkan jika hasilnya sama dengan **`false`** berarti error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id = 33;
$RO = new RajaOngkir($api_key);
$res = $RO->province($id)->get();
if ($res)
    print_r($res);
else
    echo 'Error: '.$res
```

**Cara Keempat**
Cara ini digunakan untuk penanganan langsung pada pembacaan data perbaris, jadi setiap baris dari hasil pembacaan data akan langsung di kirim callback, anda juga bisa menggunakan fungsi error untuk menangani error. 
```php
each($callback);
each($field, $callback);
```
$field bisa dihilangkan untuk membaca seluruh data, atau bisa menggunakan paramater field untuk membaca data tertentu saja.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id = 33;
$RO = new RajaOngkir($api_key);
$RO->province($id)
   ->each(function('results', $row) {
       print_r($row);
   })
   ->error(function($msg) {
       echo $msg;
   });
```

> **Catatan:** paramater $id dapat dihilangkan untuk mendapatkan semua informasi daftar provinsi

##**City**##
Method "city" digunakan untuk mendapatkan daftar kota/kabupaten yang ada di Indonesia.
Ada 4 cara penulisan Code, kamu bisa menggunakan salah satu yang menurut kamu lebih mudah.

**Cara Pertama**
Cara ini sangat direkomendasi, selain mempermudah dalam pembacaan code, juga baik dalam penanganan error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$id_province = 5;
$id = 39;
$RO->city($id_province, $id)
   ->success(function($data) {
        print_r($data);
   })
   ->error(function($msg) {
        echo $msg;
   });
```
**Cara Kedua**
Cara ini hampir sama dengan cara pertama cuma dibuat lebih simple, cuma pembacaan code terkadang menjadi membingungkan, parameter callback yang pertama untuk success, dan callback parameter kedua untuk error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id_province = 5;
$id = 39;
$RO = new RajaOngkir($api_key);
$RO->city($id_province, $id, function($data) {
    print_r(data);
}, function($msg) {
    echo $msg;
});
```
**Cara Ketiga**
Cara ini merupakan model lama, dan masih yang paling banyak digunakan, karena dari pembacaan code lebih mudah dibaca, cuma untuk penangan error harus ditangani secara manual, jadi jika hasilnya tidak sama dengan **`false`** berarti tidak error, sedangkan jika hasilnya sama dengan **`false`** berarti error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id_province = 5;
$id = 39;
$RO = new RajaOngkir($api_key);
$res = $RO->city($id_province, $id)->get();
if ($res)
    print_r($res);
else
    echo 'Error: '.$res
```

**Cara Keempat**
Cara ini digunakan untuk penanganan langsung pada pembacaan data perbaris, jadi setiap baris dari hasil pembacaan data akan langsung di kirim callback, anda juga bisa menggunakan fungsi error untuk menangani error. 
```php
each($callback);
each($field, $callback);
```
$field bisa dihilangkan untuk membaca seluruh data, atau bisa menggunakan paramater field untuk membaca data tertentu saja.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id_province = 5;
$id = 39;
$RO = new RajaOngkir($api_key);
$RO->city($id_province, $id)
   ->each(function('results', $row) {
       print_r($row);
   })
   ->error(function($msg) {
       echo $msg;
   });
```

> **Catatan:** paramater $id dapat dihilangkan untuk mendapatkan semua informasi daftar provinsi

##**Cost**##
Method “cost” digunakan untuk mengetahui tarif pengiriman (ongkos kirim) dari dan ke kota tujuan tertentu dengan berat tertentu pula.
Ada 4 cara penulisan Code, kamu bisa menggunakan salah satu yang menurut kamu lebih mudah.

**Cara Pertama**
Cara ini sangat direkomendasi, selain mempermudah dalam pembacaan code, juga baik dalam penanganan error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'origin'         => 501,
    'destination'    => 114,
    'weight'         => 1700,
    'courier'        => 'jne'
);
$RO->cost($params)
   ->success(function($data) {
        print_r($data);
   })
   ->error(function($msg) {
        echo $msg;
   });
```
**Cara Kedua**
Cara ini hampir sama dengan cara pertama cuma dibuat lebih simple, cuma pembacaan code terkadang menjadi membingungkan, parameter callback yang pertama untuk success, dan callback parameter kedua untuk error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'origin'         => 501,
    'destination'    => 114,
    'weight'         => 1700,
    'courier'        => 'jne'
);
$RO->cost($params, function($data) {
    print_r(data);
}, function($msg) {
    echo $msg;
});
```
**Cara Ketiga**
Cara ini merupakan model lama, dan masih yang paling banyak digunakan, karena dari pembacaan code lebih mudah dibaca, cuma untuk penangan error harus ditangani secara manual, jadi jika hasilnya tidak sama dengan **`false`** berarti tidak error, sedangkan jika hasilnya sama dengan **`false`** berarti error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'origin'         => 501,
    'destination'    => 114,
    'weight'         => 1700,
    'courier'        => 'jne'
);
$res = $RO->cost($params)->get();
if ($res)
    print_r($res);
else
    echo 'Error: '.$res
```

**Cara Keempat**
Cara ini digunakan untuk penanganan langsung pada pembacaan data perbaris, jadi setiap baris dari hasil pembacaan data akan langsung di kirim callback, anda juga bisa menggunakan fungsi error untuk menangani error. 
```php
each($callback);
each($field, $callback);
```
$field bisa dihilangkan untuk membaca seluruh data, atau bisa menggunakan paramater field untuk membaca data tertentu saja.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'origin'         => 501,
    'destination'    => 114,
    'weight'         => 1700,
    'courier'        => 'jne'
);
$RO->cost($params)
   ->each(function('results', $row) {
       print_r($row);
   })
   ->error(function($msg) {
       echo $msg;
   });
```

##**InternationalOrigin**##
Method "internationalOrigin" digunakan untuk mendapatkan daftar/nama kota yang mendukung pengiriman internasional.
Ada 4 cara penulisan Code, kamu bisa menggunakan salah satu yang menurut kamu lebih mudah.

**Cara Pertama**
Cara ini sangat direkomendasi, selain mempermudah dalam pembacaan code, juga baik dalam penanganan error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$id_province = 6;
$id = 152;
$RO->internationalOrigin($id_province, $id)
   ->success(function($data) {
        print_r($data);
   })
   ->error(function($msg) {
        echo $msg;
   });
```
**Cara Kedua**
Cara ini hampir sama dengan cara pertama cuma dibuat lebih simple, cuma pembacaan code terkadang menjadi membingungkan, parameter callback yang pertama untuk success, dan callback parameter kedua untuk error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id_province = 6;
$id = 152;
$RO = new RajaOngkir($api_key);
$RO->internationalOrigin($id_province, $id, function($data) {
    print_r(data);
}, function($msg) {
    echo $msg;
});
```
**Cara Ketiga**
Cara ini merupakan model lama, dan masih yang paling banyak digunakan, karena dari pembacaan code lebih mudah dibaca, cuma untuk penangan error harus ditangani secara manual, jadi jika hasilnya tidak sama dengan **`false`** berarti tidak error, sedangkan jika hasilnya sama dengan **`false`** berarti error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id_province = 6;
$id = 152;
$RO = new RajaOngkir($api_key);
$res = $RO->internationalOrigin($id_province, $id)->get();
if ($res)
    print_r($res);
else
    echo 'Error: '.$res
```

**Cara Keempat**
Cara ini digunakan untuk penanganan langsung pada pembacaan data perbaris, jadi setiap baris dari hasil pembacaan data akan langsung di kirim callback, anda juga bisa menggunakan fungsi error untuk menangani error. 
```php
each($callback);
each($field, $callback);
```
$field bisa dihilangkan untuk membaca seluruh data, atau bisa menggunakan paramater field untuk membaca data tertentu saja.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id_province = 6;
$id = 152;
$RO = new RajaOngkir($api_key);
$RO->internationalOrigin($id_province, $id)
   ->each(function('results', $row) {
       print_r($row);
   })
   ->error(function($msg) {
       echo $msg;
   });
```

> **Catatan:** paramater $id dapat dihilangkan untuk mendapatkan semua informasi daftar provinsi

##**InternationalDestination**##
Method "internationalDestination" digunakan untuk mendapatkan daftar/nama negara tujuan pengiriman internasional.
Ada 4 cara penulisan Code, kamu bisa menggunakan salah satu yang menurut kamu lebih mudah.

**Cara Pertama**
Cara ini sangat direkomendasi, selain mempermudah dalam pembacaan code, juga baik dalam penanganan error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$id = 108;
$RO->internationalDestination($id)
   ->success(function($data) {
        print_r($data);
   })
   ->error(function($msg) {
        echo $msg;
   });
```
**Cara Kedua**
Cara ini hampir sama dengan cara pertama cuma dibuat lebih simple, cuma pembacaan code terkadang menjadi membingungkan, parameter callback yang pertama untuk success, dan callback parameter kedua untuk error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id = 108;
$RO = new RajaOngkir($api_key);
$RO->internationalDestination($id, function($data) {
    print_r(data);
}, function($msg) {
    echo $msg;
});
```
**Cara Ketiga**
Cara ini merupakan model lama, dan masih yang paling banyak digunakan, karena dari pembacaan code lebih mudah dibaca, cuma untuk penangan error harus ditangani secara manual, jadi jika hasilnya tidak sama dengan **`false`** berarti tidak error, sedangkan jika hasilnya sama dengan **`false`** berarti error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id = 108;
$RO = new RajaOngkir($api_key);
$res = $RO->internationalDestination($id)->get();
if ($res)
    print_r($res);
else
    echo 'Error: '.$res
```

**Cara Keempat**
Cara ini digunakan untuk penanganan langsung pada pembacaan data perbaris, jadi setiap baris dari hasil pembacaan data akan langsung di kirim callback, anda juga bisa menggunakan fungsi error untuk menangani error. 
```php
each($callback);
each($field, $callback);
```
$field bisa dihilangkan untuk membaca seluruh data, atau bisa menggunakan paramater field untuk membaca data tertentu saja.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$id = 108;
$RO = new RajaOngkir($api_key);
$RO->internationalDestination($id)
   ->each(function('results', $row) {
       print_r($row);
   })
   ->error(function($msg) {
       echo $msg;
   });
```

##**InternationalCost**##
Method “internationalCost” digunakan untuk mengetahui tarif pengiriman (ongkos kirim) internasional dari kota-kota di Indonesia ke negara tujuan di seluruh dunia.
Ada 4 cara penulisan Code, kamu bisa menggunakan salah satu yang menurut kamu lebih mudah.

**Cara Pertama**
Cara ini sangat direkomendasi, selain mempermudah dalam pembacaan code, juga baik dalam penanganan error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'origin'         => 152,
    'destination'    => 108,
    'weight'         => 1400,
    'courier'        => 'pos'
);
$RO->internationalCost($params)
   ->success(function($data) {
        print_r($data);
   })
   ->error(function($msg) {
        echo $msg;
   });
```
**Cara Kedua**
Cara ini hampir sama dengan cara pertama cuma dibuat lebih simple, cuma pembacaan code terkadang menjadi membingungkan, parameter callback yang pertama untuk success, dan callback parameter kedua untuk error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'origin'         => 152,
    'destination'    => 108,
    'weight'         => 1400,
    'courier'        => 'pos'
);
$RO->internationalCost($params, function($data) {
    print_r(data);
}, function($msg) {
    echo $msg;
});
```
**Cara Ketiga**
Cara ini merupakan model lama, dan masih yang paling banyak digunakan, karena dari pembacaan code lebih mudah dibaca, cuma untuk penangan error harus ditangani secara manual, jadi jika hasilnya tidak sama dengan **`false`** berarti tidak error, sedangkan jika hasilnya sama dengan **`false`** berarti error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'origin'         => 152,
    'destination'    => 108,
    'weight'         => 1400,
    'courier'        => 'pos'
);
$res = $RO->internationalCost($params)->get();
if ($res)
    print_r($res);
else
    echo 'Error: '.$res
```

**Cara Keempat**
Cara ini digunakan untuk penanganan langsung pada pembacaan data perbaris, jadi setiap baris dari hasil pembacaan data akan langsung di kirim callback, anda juga bisa menggunakan fungsi error untuk menangani error. 
```php
each($callback);
each($field, $callback);
```
$field bisa dihilangkan untuk membaca seluruh data, atau bisa menggunakan paramater field untuk membaca data tertentu saja.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'origin'         => 152,
    'destination'    => 108,
    'weight'         => 1400,
    'courier'        => 'pos'
);
$RO->internationalCost($params)
   ->each(function('results', $row) {
       print_r($row);
   })
   ->error(function($msg) {
       echo $msg;
   });
```

##**Currency**##
Method "currency" digunakan untuk mendapatkan informasi nilai tukar rupiah terhadap US dollar.
Ada 4 cara penulisan Code, kamu bisa menggunakan salah satu yang menurut kamu lebih mudah.

**Cara Pertama**
Cara ini sangat direkomendasi, selain mempermudah dalam pembacaan code, juga baik dalam penanganan error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$RO->currency()
   ->success(function($data) {
        print_r($data);
   })
   ->error(function($msg) {
        echo $msg;
   });
```
**Cara Kedua**
Cara ini hampir sama dengan cara pertama cuma dibuat lebih simple, cuma pembacaan code terkadang menjadi membingungkan, parameter callback yang pertama untuk success, dan callback parameter kedua untuk error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$RO->currency(function($data) {
    print_r(data);
}, function($msg) {
    echo $msg;
});
```
**Cara Ketiga**
Cara ini merupakan model lama, dan masih yang paling banyak digunakan, karena dari pembacaan code lebih mudah dibaca, cuma untuk penangan error harus ditangani secara manual, jadi jika hasilnya tidak sama dengan **`false`** berarti tidak error, sedangkan jika hasilnya sama dengan **`false`** berarti error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$res = $RO->currency()->get();
if ($res)
    print_r($res);
else
    echo 'Error: '.$res
```

**Cara Keempat**
Cara ini digunakan untuk penanganan langsung pada pembacaan data perbaris, jadi setiap baris dari hasil pembacaan data akan langsung di kirim callback, anda juga bisa menggunakan fungsi error untuk menangani error. 
```php
each($callback);
each($field, $callback);
```
$field bisa dihilangkan untuk membaca seluruh data, atau bisa menggunakan paramater field untuk membaca data tertentu saja.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$RO->currency()
   ->each(function('results', $row) {
       print_r($row);
   })
   ->error(function($msg) {
       echo $msg;
   });
```

##**Waybill**##
Method “waybill” untuk digunakan melacak/mengetahui status pengiriman berdasarkan nomor resi.
Ada 4 cara penulisan Code, kamu bisa menggunakan salah satu yang menurut kamu lebih mudah.

**Cara Pertama**
Cara ini sangat direkomendasi, selain mempermudah dalam pembacaan code, juga baik dalam penanganan error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'waybill'        => 'SOCAG00183235715',
    'courier'        => 'jne'
);
$RO->waybill($params)
   ->success(function($data) {
        print_r($data);
   })
   ->error(function($msg) {
        echo $msg;
   });
```
**Cara Kedua**
Cara ini hampir sama dengan cara pertama cuma dibuat lebih simple, cuma pembacaan code terkadang menjadi membingungkan, parameter callback yang pertama untuk success, dan callback parameter kedua untuk error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'waybill'        => 'SOCAG00183235715',
    'courier'        => 'jne'
);
$RO->waybill($params, function($data) {
    print_r(data);
}, function($msg) {
    echo $msg;
});
```
**Cara Ketiga**
Cara ini merupakan model lama, dan masih yang paling banyak digunakan, karena dari pembacaan code lebih mudah dibaca, cuma untuk penangan error harus ditangani secara manual, jadi jika hasilnya tidak sama dengan **`false`** berarti tidak error, sedangkan jika hasilnya sama dengan **`false`** berarti error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'waybill'        => 'SOCAG00183235715',
    'courier'        => 'jne'
);
$res = $RO->waybill($params)->get();
if ($res)
    print_r($res);
else
    echo 'Error: '.$res
```

**Cara Keempat**
Cara ini digunakan untuk penanganan langsung pada pembacaan data perbaris, jadi setiap baris dari hasil pembacaan data akan langsung di kirim callback, anda juga bisa menggunakan fungsi error untuk menangani error. 
```php
each($callback);
each($field, $callback);
```
$field bisa dihilangkan untuk membaca seluruh data, atau bisa menggunakan paramater field untuk membaca data tertentu saja.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$params = array(
    'waybill'        => 'SOCAG00183235715',
    'courier'        => 'jne'
);
$RO->waybill($params)
   ->each(function('results', $row) {
       print_r($row);
   })
   ->error(function($msg) {
       echo $msg;
   });
```

##**Subdistrict**##
Method "subdistrict" digunakan untuk mendapatkan daftar kecamatan yang ada di Indonesia.
Ada 4 cara penulisan Code, kamu bisa menggunakan salah satu yang menurut kamu lebih mudah.

**Cara Pertama**
Cara ini sangat direkomendasi, selain mempermudah dalam pembacaan code, juga baik dalam penanganan error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$city = 39;
$RO->subdistrict($city)
   ->success(function($data) {
        print_r($data);
   })
   ->error(function($msg) {
        echo $msg;
   });
```
**Cara Kedua**
Cara ini hampir sama dengan cara pertama cuma dibuat lebih simple, cuma pembacaan code terkadang menjadi membingungkan, parameter callback yang pertama untuk success, dan callback parameter kedua untuk error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$city = 39;
$RO->subdistrict($city, function($data) {
    print_r(data);
}, function($msg) {
    echo $msg;
});
```
**Cara Ketiga**
Cara ini merupakan model lama, dan masih yang paling banyak digunakan, karena dari pembacaan code lebih mudah dibaca, cuma untuk penangan error harus ditangani secara manual, jadi jika hasilnya tidak sama dengan **`false`** berarti tidak error, sedangkan jika hasilnya sama dengan **`false`** berarti error.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$city = 39;
$res = $RO->subdistrict($city)->get();
if ($res)
    print_r($res);
else
    echo 'Error: '.$res
```

**Cara Keempat**
Cara ini digunakan untuk penanganan langsung pada pembacaan data perbaris, jadi setiap baris dari hasil pembacaan data akan langsung di kirim callback, anda juga bisa menggunakan fungsi error untuk menangani error. 
```php
each($callback);
each($field, $callback);
```
$field bisa dihilangkan untuk membaca seluruh data, atau bisa menggunakan paramater field untuk membaca data tertentu saja.
```php
<?php
include("RajaOngkir.php");

$api_key = "756359f53dbc303e438218878060902a";
$RO = new RajaOngkir($api_key);
$city = 39;
$RO->subdistrict($city)
   ->each(function('results', $row) {
       print_r($row);
   })
   ->error(function($msg) {
       echo $msg;
   });
```
