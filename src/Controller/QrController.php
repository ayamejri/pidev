<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrController extends AbstractController
{
    #[Route('/qr-code/post/{postId}', name: 'app_qr_codes_post', methods: ['GET'])]
    public function generateQrCodeForPost(int $postId): Response
    {
        // Retrieve the post from the database
        $post = $this->getDoctrine()->getRepository(Post::class)->find($postId);

        // If the post is not found, return a 404 response
        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        // Generate the text to be encoded in the QR code (e.g., post title and description)
        $qrCodeText = sprintf("Title: %s\nDescription: %s", $post->getTitle(), $post->getDescription());

        // Create a QR code with the post details as text
        $qrCode = QrCode::create($qrCodeText)
            ->setSize(300)
            ->setMargin(10)
            
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        // Write the QR code to PNG format
        $writer = new PngWriter();
        $qrCodeDataUri = $writer->write($qrCode)->getDataUri();

        // Pass the QR code data URI and the post to the template for rendering
        return $this->render('qr_code/post_qr_code.html.twig', [
            'qrCodeDataUri' => $qrCodeDataUri,
            'post' => $post,
        ]);
    }
}
