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

    private $templateDir;

    public function __construct($targetDir, $templateDir)
    {
        $this->targetDir = $targetDir;
        $this->templateDir = $templateDir;
    }

    public function publishFromTemplate(DocumentTemplate $template, array $dict, $prefix)
    {
        $processor = new TemplateProcessor($this->templateDir . $template->getPath());

        // Replace every variable
        foreach ($dict as $key => $value) {
            $processor->setValue($key, $value);
        }

        // Save file at default path
        $path = $this->targetDir . $prefix . $template->getLabel() . '.docx';
        $processor->saveAs($path);

        // Create the file response
        $response = new BinaryFileResponse($path);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
    }
}