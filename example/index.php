<?php

require __DIR__ . '/../vendor/autoload.php';

use AAD\Fatura\Service;

$service = new Service(['username' => 'GIB Kullanıcı Adı', 'password' => "GIB Kullanıcı Parolası"]);

$invoice_details = [
    'date' => "08/02/2020",
    'time' => "15:03:00",
    'taxIDOrTRID' => "11111111111",
    'taxOffice' => "Cankaya",
    'title' => "ADEM ALI'DEN FKA'YA SELAMLAR",
    'name' => "",
    'surname' => "",
    'fullAddress' => "X Sok. Y Cad. No: 3 Z T",
    'items' => [
        [
            'name' => "Ornek",
            'quantity' => 1,
            'unitPrice' => 0.01,
            'price' => 0.01,
            'VATRate' => 18,
            'VATAmount' => 0.0
        ]
    ],
    'totalVAT' => 0.0,
    'grandTotal' => 0.01,
    'grandTotalInclVAT' => 0.01,
    'paymentTotal' => 0.01
];

echo "<pre>";

echo "Olusturulacak olan faturanin detaylari:\n";
print_r($invoice_details);

echo "Taslak olarak olusturulan fatura detaylari:\n";
$created_draft = $service->createDraftInvoice($invoice_details);
print_r($created_draft);

echo "Olusturulmus olan taslak faturanin detaylarinin tekrar okunmasi:\n";
$founded_draft = $service->findDraftInvoice($created_draft);
print_r($founded_draft);

echo "Imzalanmis fatura detaylari:\n";
$signed_invoice = $service->signDraftInvoice($founded_draft);
print_r($signed_invoice);

echo "Imzalanmis fatura HTML ciktisi / ciktiyi dosya olarak kaydetme islemi:\n";
$ivoice_export = $service->getInvoiceHTML($created_draft['uuid'], true);
file_put_contents(__DIR__ . "/{$created_draft['uuid']}.html", $ivoice_export); // olusan faturayi example dizinine kaydetmek icin kullanabilirsiniz.
print_r($ivoice_export);

echo "Imzalanmis fatura indirme baglantisi:\n";
$ivoice_url = $service->getDownloadURL($created_draft['uuid'], true);
print_r($ivoice_url);

echo "Fatura olusturma ve imzalama:\n";
$invoice = $service->createInvoice($invoice_details, true);
print_r($invoice);

echo "Fatura olusturma, imzalama ve indirme baglantisi hazirlama:\n";
$invoice_download_url = $service->createInvoiceAndGetDownloadURL(['invoice_details' => $invoice_details, 'sing' => true]);
print_r($invoice_download_url);

echo "Fatura olusturma, imzalama ve HTML cikti hazirlama:\n";
$invoice_html_export = $service->createInvoiceAndGetHTML(['invoice_details' => $invoice_details, 'sing' => true]);
print_r($invoice_html_export);
