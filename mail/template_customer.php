<?php
// Asumsikan semua variabel tersedia dari send_customer.php
$nombre = $customer['nombre'] ?? '';
$apellido = $customer['apellido'] ?? '';
$full_name = trim("$nombre $apellido");
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $TEXT['customer_email_subject'] ?? 'Gracias por tu pedido' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f5f0; padding: 30px; color: #333;">

  <!-- Wrapper -->
  <div style="max-width: 600px; margin: auto; background-color: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.08);">

    <!-- Header -->
    <div style="background-color: #4e342e; padding: 20px; text-align: center;">
      <img src="https://compra.hilosrosace.es/logo.png" alt="Hilos Rosace" style="height: 50px;">
    </div>

    <!-- Body -->
    <div style="padding: 30px;">
      <h2 style="color: #c2185b; margin-bottom: 10px;">
        <?= $TEXT['hello'] ?? 'Hola' ?> <?= htmlspecialchars($full_name) ?>,
      </h2>

      <p style="margin-bottom: 15px;">
        <?= $TEXT['email_customer_intro'] ?? 'Gracias por tu pedido. Este es un resumen de tu compra:' ?>
      </p>

      <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
          <tr style="background-color: #fce4ec; color: #880e4f;">
            <th style="padding: 8px; border: 1px solid #ddd;">#</th>
            <th style="padding: 8px; border: 1px solid #ddd;"><?= $TEXT['product'] ?? 'Producto' ?></th>
            <th style="padding: 8px; border: 1px solid #ddd;"><?= $TEXT['qty'] ?? 'Cantidad' ?></th>
            <th style="padding: 8px; border: 1px solid #ddd;"><?= $TEXT['price'] ?? 'Precio' ?></th>
            <th style="padding: 8px; border: 1px solid #ddd;"><?= $TEXT['subtotal'] ?? 'Subtotal' ?></th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($products as $code => $qty): if ($qty > 0): ?>
          <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><?= $i++ ?></td>
            <td style="padding: 8px; border: 1px solid #ddd;"><?= htmlspecialchars($code) ?></td>
            <td style="padding: 8px; border: 1px solid #ddd;"><?= $qty ?></td>
            <td style="padding: 8px; border: 1px solid #ddd;">€<?= number_format($CONFIG['price_per_unit'], 2) ?></td>
            <td style="padding: 8px; border: 1px solid #ddd;">€<?= number_format($qty * $CONFIG['price_per_unit'], 2) ?></td>
          </tr>
          <?php endif; endforeach; ?>
        </tbody>
      </table>

      <!-- Ringkasan harga -->
      <p><strong><?= $TEXT['subtotal'] ?? 'Subtotal' ?>:</strong> €<?= number_format($subtotal, 2) ?></p>
      <p><strong><?= $TEXT['shipping'] ?? 'Envío' ?>:</strong> €<?= number_format($shipping, 2) ?></p>
      <p style="font-size: 1.2em; font-weight: bold; color: #4e342e; margin-top: 10px;">
        <?= $TEXT['total'] ?? 'Total' ?>: €<?= number_format($total, 2) ?>
      </p>

      <p style="margin-top: 20px;">
        <strong><?= $TEXT['payment_method'] ?? 'Método de pago' ?>:</strong> <?= ucfirst($method) ?>
      </p>
      <!-- Tambahan khusus jika bank transfer -->
      <?php if ($method === 'transferencia'): ?>
        <h3 style="margin-top:20px">
          <?= $lang === 'en' ? 'Bank Transfer Details (Account Holder: Maria Dolores Martin)' : 'Detalles para Transferencia Bancaria (Titular: Maria Dolores Martin)' ?>
        </h3>
        <ul>
          <?php foreach ($CONFIG['iban'] as $bank => $iban): ?>
            <li><strong><?= ucfirst($bank) ?>:</strong> <?= $iban ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <!-- Info lanjutan -->
      <p style="margin-top: 25px;">
        <?= $TEXT['email_customer_footer'] ?? 'Procesaremos tu pedido tan pronto como recibamos el pago. Si tienes alguna duda, puedes contactarnos:' ?>
      </p>

      <p style="font-weight: bold; margin-bottom: 0;">
        WhatsApp: +34 696 78 46 48
      </p>
    </div>

    <!-- Footer -->
    <div style="background-color: #4e342e; color: #fff; text-align: center; padding: 15px; font-size: 12px;">
      <?= $TEXT['maintained_by'] ?? 'Created & Maintained by' ?> <a href="<?= $CONFIG['brand']['maintainer_url'] ?>" target="_blank" style="color: #ffcc80; text-decoration: none;">KutaWeb</a>
    </div>
  </div>
</body>
</html>
