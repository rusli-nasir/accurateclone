<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Invoice Rocketjaket</title>

  <style>
    .invoice-box {
      max-width: 800px;
      margin: auto;
      padding: 30px;
      border: 1px solid #eee;
      box-shadow: 0 0 10px rgba(0, 0, 0, .15);
      font-size: 16px;
      line-height: 24px;
      font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
      color: #555;
    }

    .invoice-box table {
      width: 100%;
      line-height: inherit;
      text-align: left;
    }

    .invoice-box table td {
      padding: 5px;
      vertical-align: top;
    }

    .top {
      padding-bottom: 20px;
    }

    .top td.title {
      font-size: 45px;
      line-height: 45px;
      color: #333;
    }

    .top td.right {
      text-align: right;
    }

    .information td {
      margin-bottom: 40px;
    }

    .information td.right {
      text-align: right;
    }

    .information .toko {
      text-align: left;
      max-width: 400px;
      display: block;
    }

    tr.heading td {
      background: #eee;
      border-bottom: 1px solid #ddd;
      font-weight: bold;
    }

    tr.details td {
      padding-bottom: 20px;
    }

    tr.item td {
      border-bottom: 1px solid #eee;
    }

    tr.item.last td {
      border-bottom: none;
      padding-bottom: 15px;
    }

    td.barang {
      width: 40%;
    }

    td.qty {
      width: 10%;
      text-align: center;
    }

    td.harga {
      width: 25%;
      text-align: center;
    }

    tr.total td.hr {
      border-top: 2px solid #eee;
    }

    .footer {
      display: block;
      text-align: center;
      font-weight: bold;
      padding-top: 40px;
    }

    @media only screen and (max-width: 800px) {
      .invoice-box .top td {
        width: 100%;
        display: block;
        text-align: center;
      }

      .invoice-box .information td.toko {
        max-width: 100%;
        width: 100%;
        display: block;
        text-align: center;
        margin-bottom: 1.2rem;
      }

      .invoice-box .information td.right {
        max-width: 100%;
        width: 100%;
        display: block;
        text-align: center;
      }
    }
  </style>

</head>

<body>
  <div class="invoice-box">

    <table cellpadding="0" cellspacing="0" class="top">
      <tr>
        <td class="title">
          <img style="width:100%; max-width:300px;" src="https://rocketjaket.com/assets/img/logo.png">
        </td>

        <td class="right">
          <div style="margin-bottom:10px;"><span style="font-weight:bold;display:block;">Invoice</span><?= $invoice['kode_invoice']; ?></div>
          <span style="font-weight:bold;display:block;">Dibuat</span><?= $invoice['tanggal']; ?><br>
        </td>
      </tr>
    </table>

    <table cellpadding="0" cellspacing="0" class="information">
      <tr>
        <td class="toko">
          <div style="font-size:1.5rem;font-weight:bold;margin-bottom: 1rem;"><?= $invoice['t_nama']; ?></div>
          <?= $invoice['t_alamat']; ?>
        </td>

        <td class="right">
          <div style="margin-bottom:10px;display:block;">
            <span style="font-weight:bold;">Nama Customer</span><br>
            <?= $invoice['c_nama']; ?>
          </div>
          <div>
            <span style="font-weight:bold;">Karyawan Yang Memproses</span><br>
            <?= $invoice['k_nama']; ?>
          </div>
        </td>
      </tr>
    </table>

    <table cellpadding="0" cellspacing="0" class="metode">
      <tr class="heading">
        <td>Metode Pembayaran</td>
      </tr>
      <tr class="details">
        <td>Cash</td>
      </tr>
    </table>

    <table cellpadding="0" cellspacing="0" class="item-dtl">
      <tr class="heading">
        <td class="barang">
          Barang
        </td>

        <td class="qty">
          Qty
        </td>

        <td class="harga">
          Diskon
        </td>

        <td class="harga">
          Subtotal
        </td>
      </tr>
      <?php
      $i = 0;
      $len = count($items);
      foreach ($items as $x) { ?>
        <tr class="item <?php if ($i == $len - 1) echo 'last'; ?>">
          <td class="barang">
            <?= $x['sku'] . ' - ' . $x['nama_pdk']; ?>
          </td>

          <td class="qty">
            <?= $x['qty']; ?>
          </td>

          <td class="harga">
            <?= 'Rp ' . number_format($x['diskon'], 0, ",", "."); ?>
          </td>

          <td class="harga">
            <?= 'Rp ' . number_format($x['subtotal'], 0, ",", "."); ?>
          </td>
        </tr>
      <?php
        $i++;
      } ?>
      <tr class="total">
        <td colspan="2"></td>
        <td class="hr"></td>
        <td class="harga hr">
          <span style="font-weight:bold;display:block;">Total</span>
          <?= 'Rp ' . number_format($invoice['grand_total'], 0, ",", "."); ?>
        </td>
      </tr>
    </table>

    <div class="footer">
      Terima kasih sudah berbelanja di Rocketjaket!
    </div>

  </div>
</body>

</html>