<?php
/**
 * Fungsi untuk membentuk isi email admin (plaintext)
 * @param string $order_id
 * @param array $customer
 * @param array $products
 * @param float $subtotal
 * @param float $shipping
 * @param float $total
 * @param string $method
 * @param string $ip
 * @param string $referrer
 * @return string
 */
function generateAdminEmailBody($order_id, $customer, $products, $subtotal, $shipping, $total, $method, $ip, $referrer): string {
    global $CONFIG;

    $lines = [];
    $lines[] = "🧾 Número de pedido: $order_id";
    $lines[] = str_repeat('-', 50);
    $lines[] = "👤 Datos del cliente:";
    foreach ($customer as $k => $v) {
        $label = ucfirst(str_replace('_', ' ', $k));
        $lines[] = "$label: $v";
    }
    $lines[] = "";
    $lines[] = "🧵 Productos:";
    foreach ($products as $code => $qty) {
        if (intval($qty) > 0) {
            $line = "- $code x $qty → €" . number_format($qty * $CONFIG['price_per_unit'], 2);
            $lines[] = $line;
        }
    }
    $lines[] = "";
    $lines[] = "Subtotal: €" . number_format($subtotal, 2);
    $lines[] = "Envío: €" . number_format($shipping, 2);
    $lines[] = "TOTAL: €" . number_format($total, 2);
    $lines[] = "";
    $lines[] = "💳 Método de pago: " . ucfirst($method);
    $lines[] = str_repeat('-', 50);
    $lines[] = "🕒 Fecha: " . date("d/m/Y H:i:s");
    $lines[] = "📍 IP: $ip";
    $lines[] = "🔗 Referrer: $referrer";
    $lines[] = "";
    $lines[] = "NOTA:";
    $lines[] = "Puedes responder a este email o contactar al cliente según los datos anteriores.";

    return implode("\n", $lines);
}
