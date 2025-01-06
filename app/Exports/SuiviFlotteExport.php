<?php

namespace App\Exports;

use App\Services\FlotteService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuiviFlotteExport implements FromArray, WithHeadings, WithTitle, WithColumnWidths, WithStyles, WithColumnFormatting
{
    private $annee;
    private $flotteService;

    public function __construct(int $annee, FlotteService $flotteService)
    {
        $this->annee = $annee;
        $this->flotteService = $flotteService;
    }

    /**
     * Récupère les données formatées pour l'export.
     */
    public function array(): array
    {
        return $this->flotteService->getSuiviFlotteData($this->annee);
    }

    /**
     * Définit les en-têtes du fichier Excel.
     */
    public function headings(): array
    {
        $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

        return array_merge(
            ['Numéro', 'Statut', 'Login', 'Nom et Prénom(s)', 'Fonction', 'Localisation', 'Forfait'],
            $mois,
            ['Total Annuel']
        );
    }

    /**
     * Applique les styles à la feuille Excel.
     */
    public function styles(Worksheet $sheet)
    {
        // En-têtes grisées
        $sheet->getStyle('A1:T1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D3D3D3'], // Gris clair
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'], // Texte noir
            ],
        ]);

        // Alignement à gauche pour les en-têtes
        $sheet->getStyle('A1:T1')->getAlignment()->setHorizontal('left');
    }

    /**
     * Définir les largeurs des colonnes.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 15, 'B' => 12, 'C' => 15, 'D' => 40, 'E' => 40, 'F' => 50,
            'G' => 25, 'H' => 12, 'I' => 12, 'J' => 12, 'K' => 12, 'L' => 12,
            'M' => 12, 'N' => 12, 'O' => 12, 'P' => 12, 'Q' => 12, 'R' => 12,
            'S' => 12, 'T' => 15,
        ];
    }

    /**
     * Définir les formats des colonnes (par exemple, texte pour les numéros).
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Numéro en texte
        ];
    }

    /**
     * Définit le titre de l'onglet Excel.
     */
    public function title(): string
    {
        return $this->annee;
    }
}
