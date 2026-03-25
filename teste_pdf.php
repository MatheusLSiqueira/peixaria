<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Barryvdh\DomPDF\Facade\Pdf;

try {
    $pdf = Pdf::loadHTML('<h1>Teste PDF</h1><p>Funcionando!</p>');
    $pdf->save(public_path('teste.pdf'));
    echo "PDF gerado com sucesso!\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
