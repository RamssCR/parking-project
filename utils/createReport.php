<?php
require_once('../../fpdf/fpdf.php');

class Report extends FPDF
{
    private $headerColor = [0, 121, 255];
    private $tableHeaderColor = [100, 149, 237];
    private $tableRowColor = [240, 248, 255];

    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor($this->headerColor[0], $this->headerColor[1], $this->headerColor[2]);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 15, 'REPORTE DE PAGOS - PARKING PENTA', 0, 1, 'C', true);
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    function PaymentTable($data)
    {
        $this->SetLeftMargin(10);
        $this->SetRightMargin(10);
        $this->SetAutoPageBreak(true, 20);

        $columnWidths = [
            20, // ID
            50, // Tarifa
            50, // Horas
            60  // Total
        ];
        $totalWidth = array_sum($columnWidths);

        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor($this->tableHeaderColor[0], $this->tableHeaderColor[1], $this->tableHeaderColor[2]);
        $this->SetTextColor(255, 255, 255);

        $this->Cell($columnWidths[0], 10, 'ID', 1, 0, 'C', true);
        $this->Cell($columnWidths[1], 10, 'Tarifa', 1, 0, 'C', true);
        $this->Cell($columnWidths[2], 10, 'Horas', 1, 0, 'C', true);
        $this->Cell($columnWidths[3], 10, 'Total', 1, 0, 'C', true);
        $this->Ln();

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $fill = false;

        foreach ($data as $row) {
            $this->SetFillColor($fill ? $this->tableRowColor[0] : 255, $fill ? $this->tableRowColor[1] : 255, $fill ? $this->tableRowColor[2] : 255);
            $this->Cell($columnWidths[0], 10, $row['id_pago'], 1, 0, 'C', $fill);
            $this->Cell($columnWidths[1], 10, $row['tarifa'], 1, 0, 'C', $fill);
            $this->Cell($columnWidths[2], 10, $row['tiempo'], 1, 0, 'C', $fill);
            $this->Cell($columnWidths[3], 10, $row['total'], 1, 0, 'C', $fill);
            $this->Ln();
            $fill = !$fill;
        }
    }
}

function generateReport($mysqli_data) {
    $pdf = new Report();
    $pdf->AddPage();
    $pdf->PaymentTable($mysqli_data);
    $pdf->Output();
}