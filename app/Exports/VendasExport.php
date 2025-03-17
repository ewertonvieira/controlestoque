<?php

namespace App\Exports;

use App\Models\Venda;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VendasExport
{
    public function export($format)
    {
        $vendas = Venda::with('itens.produto')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Adicionar cabeçalho
        $sheet->fromArray(['Data', 'Total', 'Produto', 'Quantidade', 'Preço Unitário'], null, 'A1');

        // Adicionar dados
        $row = 2;
        foreach ($vendas as $venda) {
            foreach ($venda->itens as $item) {
                $sheet->setCellValue('A' . $row, \Carbon\Carbon::parse($venda->data)->format('d/m/Y'));
                $sheet->setCellValue('B' . $row, number_format($venda->total, 2, ',', '.'));
                $sheet->setCellValue('C' . $row, $item->produto->nome);
                $sheet->setCellValue('D' . $row, $item->quantidade);
                $sheet->setCellValue('E' . $row, number_format($item->preco, 2, ',', '.'));
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
        $response->headers->set('Content-Disposition', 'attachment;filename="vendas.' . $format . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
