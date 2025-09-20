<?php
session_start();
require_once __DIR__ . '.../../../vendor/autoload.php'; // mpdf library (composer require mpdf/mpdf)

include "db_connect.php"; // your database connection
use Dompdf\Dompdf;
// Get receipt data (for example by ID passed in URL)
$user = $_SESSION['user_id'];
$Receipt_no = isset($_GET['id']) ? $_GET['id'] : '';
$stmt = $con->prepare("SELECT * FROM payment_history WHERE Receipt_no = ? AND user_unid = ?");
$stmt->bind_param("ss", $Receipt_no,$user);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if(!$data){
    die("Receipt not found!".$Receipt_no);
}

// // Create receipt HTML
$html = "
    <div style='font-family:Arial;'>
        <h2 style='text-align:center;'>Gym Subscription Receipt</h2>
        <hr>
        <p><b>Receipt ID:</b> {$data['Receipt_no']}</p>
        <p><b>Customer:</b> {$data['subscription']}</p>
        <p><b>Item:</b> {$data['amount']}</p>
        <p><b>Amount:</b> KES {$data['paymentMode']}</p>
        <p><b>Date:</b> {$data['dateAdded']}</p>
        <hr>
        <p style='text-align:center;'>✅ Thank you for your subscription!</p>
    </div>
";


// Initialize Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) setup paper size
$dompdf->setPaper('A4', 'portrait');

// Render the PDF
$dompdf->render();

// Output file as download
$dompdf->stream("receipt_{$data['id']}.pdf", ["Attachment" => true]);
