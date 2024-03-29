<?php
require('utils/fpdf185/fpdf.php'); //inclusion de la librairie


class Facture extends FPDF
{
    static $payementType = [
        "creditCard" => "carte bancaire",
        "moneyCheck" => "chèque",
        "paypal" => "paypal",
    ];


    private function __construct()
    {
        parent::__construct();
    }
    // En-tête
    function Header()
    {
        // Logo
        $this->Image('assets/public/images/Web4ShopHeader.png', 10, 6, 30);
        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 15);
        // Décalage à droite
        $this->Cell(80);
        // Titre
        $this->Cell(50, 10, 'Facture règlement', 1, 0, 'C');
        // Saut de ligne
        $this->Ln(20);
    }

    // Tableau des achats
    function PurchaseTable($header, Order $data)
    {
        // Largeurs des colonnes
        $width = array(80, 40, 40);
        // En-tête du tableau
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($width[$i], 7, $header[$i], 1, 0, 'C');
        $this->Ln();

        // Données du panier

        foreach ($data->getOrderItems() as $item) {
            $this->Cell($width[0], 6, $item->getProduct()->getName(), 'LR');
            $this->Cell($width[1], 6, $item->getQuantity(), 'LR');
            $this->Cell($width[2], 6, $item->getProduct()->getPrice(), 'LR');
            $this->Ln();
        }
        // Trait de terminaison du tableau
        $this->Cell(array_sum($width), 0, '', 'T');
    }
    // Pied de page
    function Footer()
    {
        // Positionnement à 1,0 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        //Remarque
        $this->SetFont('Times', '', 8);
        $this->Text(10, 275, "Clause de réserve de propriété (loi 80.335 du 12 mai 1980) : Les marchandises vendues demeurent notre propriété jusqu'au paiement intégral de celles-ci.", 0, 0, 'C');
        //Données de l'entreprise
        $this->Text(80, 280, 'IsiWeb4Shop SARL au capital de 10 000€');
        $this->Text(80, 283, '15 Bd André Latarjet, 69100 Villeurbanne');
        $this->Text(80, 286, 'Tel: 0689552842 // N° SIRET:427868427 ');
        $this->Text(60, 289, 'Mail: isiweb4shop@gmail.com // Accueil site Web: http://localhost/');
        // Numéro de page
        $this->Cell(0, 20, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    static function generateFacture(Order $order)
    {
        // Instanciation de la classe dérivée
        $pdf = new self();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 10, 'Date :' . date_format($order->getStatus()->getDate(), 'Y-m-d H:i:s'), 0, 1);
        $pdf->Cell(0, 10, 'Objet : Votre commande n°' . $order->getID(), 0, 1);
        $pdf->Cell(0, 10, 'Nom :' . $order->getDeliveryAddress()->getForeName() . " " . $order->getDeliveryAddress()->getSurName(), 0, 1);
        $pdf->Cell(0, 10, 'Adresse :' . $order->getDeliveryAddress()->getAdd1() . $order->getDeliveryAddress()->getCity() . $order->getDeliveryAddress()->getPostCode(), 0, 1);
        $pdf->Cell(0, 10, 'Mode de règlement :' . Facture::$payementType[$order->getPaymentType()], 0, 1);
        // Titres des colonnes
        $header = array('Description', 'Quantité', 'Montant (en €)');
        //Tableau des commandes effectuées
        $pdf->PurchaseTable($header, $order);
        $pdf->Output("F", "assets/factures/" . $order->getID() . ".pdf");
    }
}
