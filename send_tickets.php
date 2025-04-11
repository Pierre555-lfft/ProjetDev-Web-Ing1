<?php
session_start();
require_once('includes/config.php');
require_once('vendor/autoload.php'); // Nécessite l'installation de TCPDF via Composer

use TCPDF;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['reservation_id'])) {
    try {
        // Récupérer les informations de la réservation
        $stmt = $conn->prepare("
            SELECT r.*, v.* 
            FROM reservations r 
            LEFT JOIN visiteurs v ON r.id = v.reservation_id 
            WHERE r.id = ? AND r.user_id = ?
        ");
        $stmt->bind_param("ii", $_POST['reservation_id'], $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $visitors = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($visitors)) {
            // Créer le PDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
            $pdf->SetCreator('Parc d\'attractions');
            $pdf->SetAuthor('Parc d\'attractions');
            $pdf->SetTitle('Vos billets');

            // Ajouter une page
            $pdf->AddPage();

            // En-tête
            $pdf->SetFont('helvetica', 'B', 20);
            $pdf->Cell(0, 10, 'Vos billets pour le parc d\'attractions', 0, 1, 'C');
            $pdf->Ln(10);

            foreach ($visitors as $visitor) {
                $pdf->SetFont('helvetica', 'B', 14);
                $pdf->Cell(0, 10, ucfirst($visitor['type']) . ' - ' . $visitor['prenom'] . ' ' . $visitor['nom'], 0, 1);
                
                // Ajouter le QR code
                $qr_data = json_encode([
                    'visitor_id' => $visitor['id'],
                    'type' => $visitor['type'],
                    'nom' => $visitor['nom'],
                    'prenom' => $visitor['prenom'],
                    'date' => $visitor['date_visite']
                ]);
                
                // Générer le QR code
                $qr_image = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($qr_data);
                $pdf->Image($qr_image, 15, $pdf->GetY(), 50);
                
                $pdf->Ln(60); // Espace pour le prochain billet
            }

            // Sauvegarder le PDF
            $pdf_content = $pdf->Output('', 'S');

            // Envoyer l'email
            $to = $_POST['email'];
            $subject = 'Vos billets pour le parc d\'attractions';
            
            // Headers pour l'email avec pièce jointe
            $boundary = md5(time());
            $headers = "From: Parc d'attractions <noreply@parc-attractions.com>\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n";

            // Corps du message
            $message = "--" . $boundary . "\r\n";
            $message .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
            $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $message .= "Veuillez trouver ci-joint vos billets pour le parc d'attractions.\r\n\r\n";
            
            // Pièce jointe
            $message .= "--" . $boundary . "\r\n";
            $message .= "Content-Type: application/pdf; name=\"billets.pdf\"\r\n";
            $message .= "Content-Transfer-Encoding: base64\r\n";
            $message .= "Content-Disposition: attachment; filename=\"billets.pdf\"\r\n\r\n";
            $message .= chunk_split(base64_encode($pdf_content));
            $message .= "--" . $boundary . "--";

            // Envoyer l'email
            if(mail($to, $subject, $message, $headers)) {
                $_SESSION['email_success'] = true;
                header('Location: confirmation.php?email_sent=1');
            } else {
                throw new Exception("Erreur lors de l'envoi de l'email");
            }
        }
    } catch (Exception $e) {
        $_SESSION['email_error'] = $e->getMessage();
        header('Location: confirmation.php?email_error=1');
    }
    exit();
} 