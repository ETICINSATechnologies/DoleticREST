<?php

namespace UABundle\Service;

use Doctrine\ORM\EntityManager;
use KernelBundle\Entity\User;
use UABundle\Entity\Consultant;
use UABundle\Entity\Delivery;
use UABundle\Entity\Project;
use UABundle\Entity\ProjectContact;
use UABundle\Entity\ProjectManager;

class DocumentService
{

    private $entityManager;

    private $TVARate;

    private $consultantTax;

    public function __construct(EntityManager $entityManager, $TVARate, $consultantTax)
    {
        $this->entityManager = $entityManager;
        $this->TVARate = $TVARate;
        $this->consultantTax = $consultantTax;
    }

    public function buildProjectDictionary(
        Project $project,
        ProjectManager $manager,
        ProjectContact $contact,
        Consultant $consultant,
        User $president
    )
    {
        $auditor = $project->getAuditor();
        if (!isset($manager) || !isset($contact) || !isset($auditor)) {
            return false;
        }

        $totalJEH = 0;
        $totalPrice = $project->getApplicationFee() + $project->getManagementFee() + $project->getRebilledFee();
        foreach ($project->getTasks() as $task) {
            $totalJEH += $task->getJehAmount();
            $totalPrice += $task->getJehAmount() * $task->getJehCost();
        }

        $signDate = $project->getSignDate();
        $endDate = $project->getEndDate();

        $duration = $project->getExpectedDuration();

        $dict = [
            'NOMENTREPRISE' => $project->getFirm()->getName(),
            'ADRESSEENTREPRISE' => $project->getFirm()->getAddress(),
            'CPENTREPRISE' => $project->getFirm()->getPostalCode(),
            'VILLEENTREPRISE' => $project->getFirm()->getCity(),
            'SIRETENTREPRISE' => $project->getFirm()->getSiret(),

            'TITREETUDE' => $project->getNumber(),
            'DESCRIPTIONETUDE' => $project->getName(),

            'CIVILITEUSER' => $manager->getManager()->getGender()->getLabel(),
            'NOMUSER' => $manager->getManager()->getFirstname() . ' ' . mb_strtoupper($manager->getManager()->getLastname()),

            'CIVILITEINTERVENANT' => isset($consultant) ?
                $consultant->getUser()->getGender()->getLabel()
                : 'CivConsultant',
            'NOMINTERVENANT' => isset($consultant) ?
                ($consultant->getUser()->getFirstname() . ' ' . mb_strtoupper($consultant->getUser()->getLastname(), 'UTF-8'))
                : 'NomConsultant',
            'CIVILITEINTERVENANT1' => isset($consultant) ?
                $consultant->getUser()->getGender()->getLabel()
                : 'CivConsultant',
            'NOMINTERVENANT1' => isset($consultant) ?
                ($consultant->getUser()->getFirstname() . ' ' . mb_strtoupper($consultant->getUser()->getLastname(), 'UTF-8'))
                : 'NomConsultant',

            'CIVILITECORRESPONDANTQUALITE' => $auditor->getGender()->getLabel(),
            'NOMCORRESPONDANTQUALITE' => $auditor->getFirstname() . ' ' . mb_strtoupper($auditor->getLastname(), 'UTF-8'),

            'CIVILITECONTACT' => $contact->getContact()->getGender()->getLabel(),
            'NOMCONTACT' => mb_strtoupper($contact->getContact()->getLastName(), 'UTF-8'),
            'PRENOMCONTACT' => $contact->getContact()->getFirstName(),
            'FCTCONTACT' => $contact->getContact()->getRole(),

            'CIVPREZ' => isset($president) ? $president->getGender()->getLabel() : 'CivPresident',
            'CIVPRESIDENT' => isset($president) ? $president->getGender()->getLabel() : 'CivPresident',
            'NOMPRESIDENT' => isset($president) ?
                $president->getFirstname() . ' ' . mb_strtoupper($president->getLastname(), 'UTF-8')
                : 'NomPresident',

            'DUREEETUDE' => isset($duration) ? $duration : 'DureeEtude',
            'NBJOURSJEH' => $totalJEH,
            'FRAISETUDE' => $project->getManagementFee(),
            'FRAISENTREPRISE' => $project->getApplicationFee(),
            'TOTALENTREPRISE' => $totalPrice,
            'MONTANTTVAENT' => $totalPrice * $this->TVARate / 100,
            'TOTALENTREPRISETTC' => $totalPrice * (1 + $this->TVARate) / 100,

            'DATESIGCV' => isset($signDate) ? date('d/m/Y', strtotime($signDate)) : 'DateSignature',

            'TAUXTVA' => $this->TVARate,

            'DJOUR' => date('d/m/Y')
        ];

        return $dict;
    }

    public function buildConsultantDictionary(
        ProjectContact $contact,
        Consultant $consultant,
        User $president,
        User $treasurer
    )
    {

        if (!isset($consultant) || !isset($contact)) {
            return false;
        }

        $project = $consultant->getProject();

        $totalPay = $consultant->getJehAssigned() * $consultant->getPayByJeh();
        $totalNetPay = $consultant->getJehAssigned() * ($consultant->getPayByJeh() - $this->consultantTax);

        $consultantMembership = $consultant->getUser()->getConsultantMembership();

        $fmt = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);

        $dict = [
            'NOMENTREPRISE' => $project->getFirm()->getName(),
            'TITREETUDE' => $project->getNumber(),

            'NUMINTER' => $consultant->getNumber(),
            'CIVILITEINTERVENANT' => $consultant->getUser()->getGender()->getLabel(),
            'NOMINTERVENANT' => mb_strtoupper($consultant->getUser()->getLastname()),
            'PRENOMINTERVENANT' => $consultant->getUser()->getFirstname(),
            'ADRESSEINTERVENANT' => $consultant->getUser()->getAddress(),
            'CPINTERVENANT' => $consultant->getUser()->getPostalCode(),
            'VILLEINTERVENANT' => $consultant->getUser()->getCity(),
            'SECUINTERVENANT' => isset($consultantMembership) ? $consultantMembership->getSocialNumber() : 'NumSecu',
            'NBJOURSINTER' => $consultant->getJehAssigned(),
            'TOTALINTERVENANT_L' => $totalPay,
            'TOTALINTERVENANT' => $fmt->format($totalPay),
            'TARIFINTERV' => $consultant->getPayByJeh(),
            'TOTALINTERVENANTTTC_L' => $totalNetPay,
            'TOTALINTERVENANTTTC' => $fmt->format($totalNetPay),

            'CIVTRESORIER' => isset($treasurer) ? $treasurer->getGender()->getLabel() : 'CivTreso',
            'NOMTRESORIER' => isset($treasurer) ? $treasurer->getLastname() : 'NomTreso',
            'PRENOMTRESORIER' => isset($treasurer) ? $treasurer->getFirstname() : 'PrenomTreso',

            'NOMPRESIDENT' => isset($president) ?
                $president->getFirstname() . ' ' . mb_strtoupper($president->getLastname(), 'UTF-8')
                : 'NomPresident',

            'DJOUR' => date('d/m/Y')
        ];

        return $dict;
    }

    public function buildDeliveryDictionary(
        ProjectContact $contact,
        Delivery $delivery,
        User $president
    )
    {

        if (!isset($delivery) || !isset($contact)) {
            return false;
        }

        $project = $delivery->getTask()->getProject();

        $dict = [
            'NOMENTREPRISE' => $project->getFirm()->getName(),
            'TITREETUDE' => $project->getNumber(),
            'DESCRIPTIONETUDE' => $project->getName(),

            'CIVILITECONTACT' => $contact->getContact()->getGender()->getLabel(),
            'NOMCONTACT' => mb_strtoupper($contact->getContact()->getLastName(), 'UTF-8'),
            'PRENOMCONTACT' => $contact->getContact()->getFirstName(),
            'FCTCONTACT' => $contact->getContact()->getRole(),

            'NOMPRESIDENT' => isset($president) ?
                $president->getFirstname() . ' ' . mb_strtoupper($president->getLastname(), 'UTF-8')
                : 'NomPresident',

            'DJOUR' => date('d/m/Y'),
            'DATESIGCV' => isset($signDate) ? date('d/m/Y', strtotime($signDate)) : 'DateSignature'
        ];

        return $dict;
    }

}