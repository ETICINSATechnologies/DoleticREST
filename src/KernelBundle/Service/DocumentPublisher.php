<?php

namespace KernelBundle\Service;


use KernelBundle\Entity\DocumentTemplate;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DocumentPublisher
{

    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function publishFromTemplate(DocumentTemplate $template, array $dict, $prefix)
    {
        $processor = new TemplateProcessor($template->getPath());

        // Replace every variable
        foreach ($dict as $key => $value) {
            $processor->setValue($key, $value);
        }

        // Save file at default path
        $path = $this->targetDir . $prefix . $template->getLabel();
        $processor->saveAs($path);

        // Create the file response
        $response = new BinaryFileResponse($path);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
    }
}