<?php

namespace App\Exports;

use App\Models\Produto;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProdutosExport
{
    public function export($format)
    {
        $produtos = Produto::all()->map(function ($produto) {
            return [
                'nome' => $produto->nome,
                'sku' => $produto->sku,
                'preco' => number_format($produto->preco, 2, ',', '.'),
                'estoque' => $produto->estoque,
                'estoque_minimo' => $produto->estoque_minimo
            ];
        });

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($produtos->toArray(), null, 'A2');

        // Adicionar cabeçalho
        $sheet->fromArray(['Nome', 'SKU', 'Preço', 'Estoque', 'Estoque Mínimo'], null, 'A1');

        // Estilo do cabeçalho
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4CAF50'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

        // Ajustar largura das colunas
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = $format === 'csv' ? new Csv($spreadsheet) : new Xlsx($spreadsheet);

        $response = new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', $format === 'csv' ? 'text/csv' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="produtos.' . $format . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
