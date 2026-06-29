<?php

namespace App\Libraries;

use TCPDF;

class MY_TCPDF extends TCPDF
{



    // Page footer
    public function Footer()
    {
        // Set the font
        $this->SetFont('helvetica', 'I', 8);

        // Get the current page number and total pages
        $pageNumber = $this->getAliasNumPage();
        $totalPages = $this->getAliasNbPages();

        // Set Y position for footer text
        $yFooterText = $this->GetY() - 5; // Adjust the value as needed

        // Print "LPMPP-UMRAH" at the left side
        $this->SetXY(25, $yFooterText);
        $this->Cell(0, 5, 'LPMPP-UMRAH', 0, false, 'L', 0, '', 0, false, 'T', 'M');

        // Set Y position for the line
        $yLine = $yFooterText - 3; // Adjust the value as needed

        // Draw a line below the footer
        $this->SetY($yLine);
        $this->SetDrawColor(0, 0, 0); // Set line color to black
        $this->SetLineWidth(0.1); // Set line width
        $this->Line(25, $this->GetY(), 210 - 25, $this->GetY()); // Draw a line from left to right (25 mm margin on both sides)

        // Print "Page X/Y" at the right side
        $this->SetFont('helvetica', '', 8); // Set font style to normal
        $this->SetXY(190, $yFooterText); // Adjust the value as needed
        $this->Cell(2, 5, $pageNumber . ' |', 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}