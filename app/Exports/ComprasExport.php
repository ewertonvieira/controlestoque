<?php

namespace App\Exports;

use App\Models\Compra;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ComprasExport
{
    public function export($format)
    {
        $compras = Compra::with('itens.produto')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Adicionar cabeçalho
        $sheet->fromArray(['Data', 'Fornecedor', 'Total', 'Produto', 'Quantidade', 'Preço Unitário'], null, 'A1');

        // Adicionar dados
        $row = 2;
        foreach ($compras as $compra) {
            foreach ($compra->itens as $item) {
                $sheet->setCellValue('A' . $row, \Carbon\Carbon::parse($compra->data)->format('d/m/Y'));
                $sheet->setCellValue('B' . $row, $compra->fornecedor->nome);
                $sheet->setCellValue('C' . $row, number_format($compra->total, 2, ',', '.'));
                $sheet->setCellValue('D' . $row, $item->produto->nome);
                $sheet->setCellValue('E' . $row, $item->quantidade);
                $sheet->setCellValue('F' . $row, number_format($item->preco, 2, ',', '.'));
                $row++;
            }
        }

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

        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

        // Ajustar largura das colunas
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = $format === 'csv' ? new Csv($spreadsheet) : new Xlsx($spreadsheet);

        $response = new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', $format === 'csv' ? 'text/csv' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="compras.' . $format . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
